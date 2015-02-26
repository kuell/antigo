<?php

    require_once '../include/fpdf/fpdf.php';
    require_once '../core/Corretor.php';
    require_once '../core/PreEscala.php';
    
  class PDF extends FPDF {
      
   function select($where="", $group=""){
       $pe = new PreEscala();
       $sql = "Select 
                    a.`data`,
                    b.*,
                    sum(a.`qtdBoi`) as qtdBoi,
                    sum(a.`qtdVaca`) as qtdVaca,
                    sum(a.`qtdNov`) as qtdNov,
                    sum(a.`qtdTouro`) as qtdTouro
                from
                        escala_pre a
                    inner join cad_corretor b on(a.corretor = b.`id`)
                where 
                    1 = 1 %s 
                group by a.data %s";
       $result = sprintf($sql, $where, $group);

       return $pe->RunSelect($result);
       
   }

   function Header() {
      $this->Image("../view/img/Logo.jpg", 15,15, 40, 20, "JPG");
      $this->Cell(60,15,"","LT",0,"L");
      $this->SetFont("Arial","B",25);
      $this->Cell(210,10,"Peri Alimentos Ltda Ltda.","TR",0,"L");
      $this->Ln();
      $this->Cell(60,18,"","LB",0,"L");
      $this->SetFont("Arial","B",10);
      $this->Cell(210,18,utf8_decode("Pré-Escala de Abate: "),"BR",0,"L");
      $this->Ln();
      $fill=0;
    }

     function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()." | Gerado em: ".date("d/m/Y"),0,0,"C");
    }

    function Dados() {

        $pe = new PreEscala();
        $data = $pe->dataBd($_GET['data']);
        
        $rs = $this->select("and a.data >= '".$data."'");
        $w = array(60,20);
        $h = array(5,8);
        
        $this->Ln(3);
        
        $this->SetDisplayMode(100);
        $this->SetFont("Arial", '', 10);     
        
        foreach ($rs as $row){
                    $this->SetFillColor(105,100,100);
                    $this->SetTextColor(255,255,255);
            $this->Cell(270,7,$pe->dataView($row['data']).' - '. $pe->semana(date("w", strtotime($row['data']))),"TB",0,"C",1); 
            
            $rs2 = $this->select("and a.data='".$row['data']."'",", a.corretor");
            $f = 0;
            
            $this->Ln();
            
            $this->Cell($w[0],6,"Corretor","TB",0,"C",1);  
            $this->Cell($w[1],6,"Qtd. Boi","TB",0,"C",1);  
            $this->Cell($w[1],6,"Qtd. Vaca","TB",0,"C",1);
            $this->Cell($w[1],6,"Qtd. Nov","TB",0,"C",1);
            $this->Cell($w[1],6,"Qtd. Touro","TB",0,"C",1);
            $this->Cell($w[1],6,"Qtd. Total","TB",0,"C",1);
            
            $this->Ln();
            $this->SetTextColor(0);
            
            $tBoi = 0;
            $tVaca = 0;
            $tNov = 0;
            $tTouro = 0;
            
                foreach ($rs2 as $row2){
                            $this->SetFillColor(205,200,200);
                    $this->Cell($w[0],$h[0],$row2['nome']." - ".$row2['cod_interno'],0,0,"C",$f);
                    $this->Cell($w[1],$h[0],$row2['qtdBoi'],0,0,"C",$f);
                    $this->Cell($w[1],$h[0],$row2['qtdVaca'],0,0,"C",$f);
                    $this->Cell($w[1],$h[0],$row2['qtdNov'],0,0,"C",$f);
                    $this->Cell($w[1],$h[0],$row2['qtdTouro'],0,0,"C",$f);
                    $this->Cell($w[1],$h[0],($row2['qtdBoi']+$row2['qtdTouro']+$row2['qtdNov']+$row2['qtdVaca']),0,0,"C",$f);
                    
            $tBoi = $row2['qtdBoi'] + $tBoi;
            $tVaca = $row2['qtdVaca'] + $tVaca;
            $tNov = $row2['qtdNov'] + $tNov;
            $tTouro = $row2['qtdTouro'] + $tTouro;
                    $this->Ln();
                    $f = !$f;
                }
                    $this->Cell($w[0],$h[1],"Totais:","TBL",0,"R",1);
                    $this->Cell($w[1],$h[1],$tBoi,"TB",0,"C",1);
                    $this->Cell($w[1],$h[1],$tVaca,"TB",0,"C",1);
                    $this->Cell($w[1],$h[1],$tNov,"TB",0,"C",1);
                    $this->Cell($w[1],$h[1],$tTouro,"TB",0,"C",1);
                    $this->Cell($w[1],$h[1],($tBoi+$tVaca+$tTouro+$tNov),"TBR",0,"C",1);
                    $this->Ln();
                    $this->AddPage();
        } 
        
    }
        }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>