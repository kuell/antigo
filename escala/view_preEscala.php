<?php

    require_once '../includes/fpdf/fpdf.php';
    require_once 'core/Escala.php';
    
  class PDF extends FPDF {

   function Header() {
      $this->Image("../logo/Logo.jpg", 15,15, 40, 20, "JPG");
      $this->Cell(60,15,"","LT",0,"L");
      $this->SetFont("Arial","B",25);
      $this->Cell(210,10,"Pré-Escala de Abate.","TR",0,"L");
      $this->Ln();
      $this->Cell(60,18,"","LB",0,"L");
      $this->SetFont("Arial","B",10);
      $this->Cell(210,18,"Data: ".$_REQUEST['data'],"BR",0,"L");
      $this->Ln();
      $fill=0;
    }

     function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()." | Gerado em: ".date("d/m/Y"),0,0,"C");
    }
    function escala($data){
        $esc = new Escala();
        
        $sql = "Select 
                    a.id,
                    a.data,
                    a.pecuarista,
                    a.qtdBoi,
                    a.qtdVaca,
                    a.qtdTouro,
                    a.qtdNov,
                    b.cor_id,
                    b.cor_cod as codCorretor,
                    b.cor_nome
                from
                    escala_pre a
                    inner join corretor b on(a.corretor = b.cor_id)
                where
                    a.data = '".$data."'";
        $rs = $esc->RunSelect($sql);
        return $rs;
    }

    function Dados() {
        $escala = new Escala();
        $data = $escala->dbData($_GET['data']);
            
        $w = array(60,20,15, 40);
        $h = array(5);
        $f = 0;
        $totalBoi = 0;
        $totalVaca = 0;
        $totalNov = 0;
        $totalTouro = 0;
        
        $this->SetDisplayMode(100);
        $this->SetFillColor(105,100,100);
        $this->SetTextColor(255,255,255);
        $this->SetFont("Arial", '', 10);        
                
        $this->Cell($w[1],$h[0],"Corretor","TB",0,'C',1);        
        $this->Cell($w[0],$h[0],"Pecuarista","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Boi","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Vaca","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Novilha","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Touro","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Total","TB",0,'C',1);
        
        $this->Ln();
        $this->SetTextColor(0);
        $this->SetFillColor(200);
        $this->SetDrawColor(100);
        
        $linha = $this->escala($data);
      
        foreach($linha as $rg){
            $this->Cell($w[1],$h[0],$rg['codCorretor'],"TBL",0,"C",$f);
            $this->Cell($w[0],$h[0], $rg['pecuarista'],"TB",0,1,$f);
            $this->Cell($w[2],$h[0],$rg['qtdBoi'],"TB",0,"C",$f);
            $this->Cell($w[2],$h[0],$rg['qtdVaca'],"TB",0,"C",$f);
            $this->Cell($w[2],$h[0],$rg['qtdNov'],"TB",0,"C",$f);
            $this->Cell($w[2],$h[0],$rg['qtdTouro'],"TB",0,"C",$f);
            $this->Cell($w[2],$h[0],($rg['qtdBoi']+$rg['qtdVaca']+$rg['qtdNov']+$rg['qtdTouro']),1,0,"C",1);

            $this->Ln();
            
            //Soma os totais
            if($hora >= "11:00" && $almoco == true){
                $hora = date("H:i", strtotime($hora." + 1 hour"));
                $almoco = false;
            }
            
            
            $hora = date("H:i", strtotime($hora." + ".$rg['duracao']." minutes"));
            $totalBoi = $rg['qtdBoi'] + $totalBoi;
            $totalVaca = $rg['qtdVaca'] + $totalVaca;
            $totalNov = $rg['qtdNov'] + $totalNov;
            $totalTouro = $rg['qtdTouro'] + $totalTouro;
            $f = !$f;
        }

        $this->SetDisplayMode(100);
        $this->SetFillColor(105,100,100);
        $this->SetTextColor(255,255,255);
        $this->SetFont("Arial", '', 10); 

        $this->Cell(80, $h[0], "TOTAIS", "TB", 0, "C", 1);
        $this->Cell($w[2], $h[0], $totalBoi, "TB", 0, 'C', 1);
        $this->Cell($w[2], $h[0], $totalVaca, "TB", 0, 'C', 1);
        $this->Cell($w[2], $h[0], $totalNov, "TB", 0, 'C', 1);
        $this->Cell($w[2], $h[0], $totalTouro, "TB", 0, 'C', 1);
        $this->SetFont("Arial", "B", 10);
        $this->SetFillColor(100,100,200);
        $this->Cell($w[2], $h[0], number_format(($totalTouro+$totalBoi+$totalNov+$totalVaca),0,',','.'),1, 0, 'C', 1);
        }

        }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>