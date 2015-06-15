<?php

    require_once '../includes/fpdf/fpdf.php';
    require_once 'core/Escala.php';
    
  class PDF extends FPDF {

   function Header() {
      $this->Image("../logo/Logo.jpg", 15,15, 40, 20, "JPG");
      $this->Cell(60,15,"","LT",0,"L");
      $this->SetFont("Arial","B",25);
      $this->Cell(210,10,"Frizelo Frigorificos Ltda.","TR",0,"L");
      $this->Ln();
      $this->Cell(60,18,"","LB",0,"L");
      $this->SetFont("Arial","B",10);
      $this->Cell(210,18,"Escala de Abate: ".$_REQUEST['data'],"BR",0,"L");
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
                        a.corretor,
                        a.pecuarista, 
                        a.lote,
                        a.qtdBoi,
                        a.qtdVaca,
                        a.qtdNov,
                        a.qtdTouro,
                        a.duracao,
                        b.cor_cod as codCorretor
                from
                        escala a inner join corretor b on(a.corretor = b.cor_id)
                where
                    a.data = '".$data."'
                order by a.lote";
        $rs = $esc->RunSelect($sql);
        return $rs;
    }

    function Dados() {
        $escala = new Escala();
        $data = $escala->dbData($_GET['data']);
        $almoco = true;
	$cafe = true; 
            if(empty($_GET['hora'])){
                $hora = "05:00";
            }
            else{
                $hora = $_GET['hora'];
            }
            
        $w = array(60,20,15, 40);
        $h = array(5);
        $totalBoi = 0;
        $totalVaca = 0;
        $totalNov = 0;
        $totalTouro = 0;
        
        $this->SetDisplayMode(100);
        $this->SetFillColor(105,100,100);
        $this->SetTextColor(255,255,255);
        $this->SetFont("Arial", '', 10);        
                
        $this->Cell($w[0],$h[0],"Pecuarista","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Lote","TB",0,'C',1);
        $this->Cell($w[1],$h[0],"Corretor","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Boi","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Vaca","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Novilha","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Touro","TB",0,'C',1);
        $this->Cell($w[2],$h[0],"Total","TB",0,'C',1);
        $this->Cell($w[1],$h[0],"Inicio","TB",0,'C',1);
        $this->Cell($w[1],$h[0],  "Duração","TB",0,'C',1);
        $this->Cell($w[1],$h[0],"Fim","TB",0,'C',1);
		$this->Cell($w[3],$h[0],"Curral","TB",0,'C',1);
        
        $this->Ln();
        $this->SetTextColor(0);
        $this->SetFillColor(200);
        $this->SetDrawColor(100);
        
        $linha = $this->escala($data);
      
        foreach($linha as $rg){
            $this->Cell($w[0],$h[0], $rg['pecuarista'],"TLB",0,1);
            $this->Cell($w[2],$h[0],$rg['lote'],"TB",0,"C",1);
            $this->Cell($w[1],$h[0],$rg['codCorretor'],"TB",0,"C");
            $this->Cell($w[2],$h[0],$rg['qtdBoi'],"TB",0,"C");
            $this->Cell($w[2],$h[0],$rg['qtdVaca'],"TB",0,"C");
            $this->Cell($w[2],$h[0],$rg['qtdNov'],"TB",0,"C");
            $this->Cell($w[2],$h[0],$rg['qtdTouro'],"TB",0,"C");
            $this->Cell($w[2],$h[0],($rg['qtdBoi']+$rg['qtdVaca']+$rg['qtdNov']+$rg['qtdTouro']),"TB",0,"C",1);
            $this->Cell($w[1],$h[0],$hora,"TB",0,"C");
            $this->Cell($w[1],$h[0],$rg['duracao']." min","TB",0,"C");
            $this->Cell($w[1],$h[0],date("H:i", strtotime($hora." + ".$rg['duracao']." minutes")),"TB",0,"C");
			$this->Cell($w[3],$h[0],"","TRBL",0,"C");
            $this->Ln();
           
            $hora = date("H:i", strtotime($hora." + ".$rg['duracao']." minutes"));
    

            //Soma os totais
            if($hora >= "10:25" && $almoco == true){
                $hora = date("H:i", strtotime($hora." + 1 hour + 10 minutes"));
                $almoco = false;
            }
	
	   if($hora >= "07:25" && $cafe == true){
                $hora = date("H:i", strtotime($hora." + 15 minutes"));
		$cafe = false;
           }
            

            
           //hora = date("H:i", strtotime($hora." + ".$rg['duracao']." minutes"));
            $totalBoi = $rg['qtdBoi'] + $totalBoi;
            $totalVaca = $rg['qtdVaca'] + $totalVaca;
            $totalNov = $rg['qtdNov'] + $totalNov;
            $totalTouro = $rg['qtdTouro'] + $totalTouro;
        }
        $this->Cell(95, $h[0], "TOTAIS", "TB", 0, "C", 1);
        $this->Cell($w[2], $h[0], $totalBoi, "TB", 0, 'C', 1);
        $this->Cell($w[2], $h[0], $totalVaca, "TB", 0, 'C', 1);
        $this->Cell($w[2], $h[0], $totalNov, "TB", 0, 'C', 1);
        $this->Cell($w[2], $h[0], $totalTouro, "TB", 0, 'C', 1);
        $this->SetFont("Arial", "B", 10);
        $this->SetFillColor(100,100,200);
        $this->Cell(35, $h[0], ($totalTouro+$totalBoi+$totalNov+$totalVaca),1, 0, 'C', 0);
        }
        }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>
