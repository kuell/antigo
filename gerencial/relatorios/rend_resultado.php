<?php
  include  "../../Connections/Connection.php";

  require("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {
	
	function Header() {
    //  $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(1);
	  $this->Cell(40,11,"","TLR",0,"C");
      $this->Cell(250,11,"Frizelo Frigorificos Ltda. ","TLR",0,"C");
      $this->Ln(10);
      $this->Cell(1);
	  $this->SetFont("Arial","B",12);
  	  $this->Cell(40,11,"","BLR",0,"C");
      $this->Cell(250,11,utf8_decode("Relatorio de Rendimentos / Corretor Periodo: ".mesi."/".anoi." a ".mesf."/".anof),"RLB",0,"C");
	  $this->Ln(15);
      $fill=0;
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",7);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'),0,0,"C");
    }

    function Dados() {
    	$datai = date('Y-m-d', strtotime($_GET["data1"]));
    	$dataf = date('Y-m-d', strtotime($_GET["data2"]));


		// Pega os itens
		$instrucao = "SELECT 
						a.cor_id,
						a.cor_cod,
						a.cor_nome,
						f_cor_pagar('$datai','$dataf', a.cor_id) as a_pagar,
						f_cor_receber('$datai','$dataf',a.cor_id) as a_receber,
						coalesce(f_cor_pesoAbate('$datai','$dataf', a.cor_id),0) as kg_abatido
					FROM
						corretor a
					WHERE
						f_cor_pagar(	'2013-01-01',	'2013-01-31', 		a.cor_id) is not null or
						f_cor_receber(	'2013-01-01',	'2013-01-31',		a.cor_id) is not null or
						f_cor_pesoAbate(	'2013-01-01',	'2013-01-31', 		a.cor_id) is not null
					ORDER BY
						a.cor_cod";

		$sql = sprintf($instrucao, $datai, $dataf);
		$conn = new Conecction();

		$res = $conn->RunSelect($sql);

		//Formatação dos titulos da tabela
		$this->SetFont('Arial','I',9);
		
		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10,60,30,30,30,40,40,40);
		
			$this->Cell($w[0],5,"",0,0);
			$this->Cell($w[1],5,"Cod/Corretor",1,0,"C",1);
			$this->Cell($w[2],5,"A Pagar",1,0,"C",1);
			$this->Cell($w[3],5,"A Pagar por (KG)",1,0,"C",1);
			$this->Cell($w[4],5,"A Receber",1,0,"C",1);
			$this->Cell($w[5],5,"A Receber por (KG)",1,0,"C",1);
			$this->Cell($w[6],5,"Saldo",1,0,"C",1);
			$this->Cell($w[7],5,"Saldo por (KG)",1,0,"C",1);
			
			$this->Ln();
			$fundo = 0;

		foreach($res as $val){
			$this->SetFont('Arial','',8);
			$this->SetFillColor(230);

			$this->Cell($w[0],5,"",0,0);
			$this->Cell($w[1],4,$val['cor_cod'].' -    '.$val['cor_nome'],0,0,"L",$fundo);
			$this->Cell($w[2],4,'R$ '.number_format($val['a_pagar'],2,',','.'),0,0,"R",$fundo);
				if($val['kg_abatido'] == 0){
					$this->Cell($w[3],4,'R$ '.number_format(0,2,',','.'),0,0,"R",$fundo);
				}
				else{
					$this->Cell($w[3],4,'R$ '.number_format(($val['a_pagar']/$val['kg_abatido']),2,',','.'),0,0,"R",$fundo);
				}
			
			$this->Cell($w[4],4,'R$ '.number_format($val['a_receber'],2,',','.'),0,0,"R",$fundo);
				if($val['kg_abatido'] == 0){
					$this->Cell($w[5],4,'R$ '.number_format(0,2,',','.'),0,0,"R",$fundo);
				}
				else{
					$this->Cell($w[5],4,'R$ '.number_format(($val['a_receber']/$val['kg_abatido']),2,',','.'),0,0,"R",$fundo);
					}
			$this->Cell($w[6],4,'R$ '.number_format(($val['a_receber']-$val['a_pagar']),2,',','.'),0,0,"R",$fundo);
			if($val['kg_abatido'] == 0){
					$this->Cell($w[7],4,'R$ '.number_format(0,2,',','.'),0,0,"R",$fundo);
				}
				else{
					$this->Cell($w[7],4,'R$ '.number_format(($val['a_receber']/$val['kg_abatido'])-($val['a_pagar']/$val['kg_abatido']),2,',','.'),0,0,"R",$fundo);
				}
				
			$fundo = !$fundo;
			
			$aPagar 	= $val['a_pagar'] + $aPagar;
			$aReceber  	= $val['a_receber'] + $aReceber;
			$kgAbatido = $val['kg_abatido'] + $kgAbatido;
			
		$this->Ln(5);
  }
	$fundo = 1;
			$this->Cell($w[0],5,"",0,0);
			$this->Cell($w[1],4,'TOTAL',0,0,"L",$fundo);
			$this->Cell($w[2],4,'R$ '.number_format($aPagar,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[3],4,'R$ '.number_format($aPagar/$kgAbatido,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[4],4,'R$ '.number_format($aReceber,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[5],4,'R$ '.number_format($aReceber/$kgAbatido,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[6],4,'R$ '.number_format($aReceber-$aPagar,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[7],4,'R$ '.number_format(($aReceber/$kgAbatido)-($aPagar/$kgAbatido),2,',','.'),0,0,"R",$fundo);
  }
  }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetMargins(3, 2, 3, 1);
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

