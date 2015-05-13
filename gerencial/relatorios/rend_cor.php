<?php
require ("../../Connections/conect_mysqli.php");
require ('../../class/Corretor.class.php');
require ('../../industria/class/IndProducao.class.php');
require ('../../class/Abate.class.php');
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {
	function Header() {
		date_default_timezone_set("Brazil/East");
		define('hora', date("H")-1);
		$this->Image("../../logo/Logo.jpg", 6, 5, 35, 15);
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(250, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(250, 11, utf8_decode("Relatorio de Rendimentos / Corretor Periodo: ".$_GET['data1']." a ".$_GET['data2']), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'), 0, 0, "C");
	}

	function Dados() {

		$datai = implode('-', array_reverse(explode('/', $_GET['data1'])));
		$dataf = implode('-', array_reverse(explode('/', $_GET['data2'])));

		$producao  = new IndProducao($datai, $dataf);
		$abate     = new Abate($datai, $dataf);
		$corretors = new Corretor(null, $datai, $dataf);

		$kgProd = $producao->getKgProduzido();

		$abate = $abate->getAbate();

		$rendimento           = ($kgProd*100)/$abate->peso;
		$rendimentoIndustrial = $abate->peso*$rendimento/100;

		$this->SetFont('Arial', 'I', 9);

		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10, 60, 30, 30, 30, 40, 40, 40);

		$this->Cell($w[0], 5, "", 0, 0);
		$this->Cell($w[1], 5, "Cod/Corretor", 1, 0, "C", 1);
		$this->Cell($w[2], 5, "Animais Abatidos", 1, 0, "C", 1);
		$this->Cell($w[3], 5, "Peso Abatido", 1, 0, "C", 1);
		$this->Cell($w[4], 5, "Media @", 1, 0, "C", 1);
		$this->Cell($w[5], 5, utf8_decode("Rend. Industrial (KG)"), 1, 0, "C", 1);
		$this->Cell($w[6], 5, utf8_decode("Rend. Cabeça (KG)"), 1, 0, "C", 1);
		$this->Cell($w[7], 5, utf8_decode("Part. Industria (%)"), 1, 0, "C", 1);

		$this->Ln();
		$fundo = 0;

		$this->SetDrawColor(200);

		foreach ($corretors->lista('order by cor_nome') as $cor) {

			$corAbate = $corretors->abate($cor->cor_id);
			if ($corAbate->peso != 0 and $corAbate->qtd != 0) {

				$this->SetFont('Arial', '', 8);
				$this->SetFillColor(230);

				$this->Cell($w[0], 5, "", 0, 0);
				$this->Cell($w[1], 5, $cor->cor_cod.' - '.$cor->cor_nome, 'LTB', 0, "L", $fundo);
				$this->Cell($w[2], 5, number_format($corAbate->qtd, 2, ',', '.'), 'TB', 0, "R", $fundo);
				$this->Cell($w[3], 5, number_format($corAbate->peso, 2, ',', '.'), 'TB', 0, "R", $fundo);
				$this->Cell($w[4], 5, number_format($corAbate->peso/$corAbate->qtd, 2, ',', '.'), 'TB', 0, "R", $fundo);
				$this->Cell($w[5], 5, number_format((($corAbate->peso*$rendimento)/100), 2, ',', '.'), 'TB', 0, "R", $fundo);
				$this->Cell($w[6], 5, number_format((($corAbate->peso/$corAbate->qtd)*$rendimento)/100, 2, ',', '.'), 'TB', 0, "R", $fundo);
				$this->Cell($w[7], 5, number_format(($corAbate->peso*$rendimento)/$rendimentoIndustrial, 2, ',', '.'), 'TBR', 0, "R", $fundo);
				//
				$fundo = !$fundo;

				$this->Ln();
			}
		}

		$this->SetFillColor(190);

		$fundo = 1;
		$this->Cell($w[0], 5, '', 0, 0);
		$this->Cell($w[1], 5, 'TOTAL', 0, 0, "L", $fundo);
		$this->Cell($w[2], 5, number_format($abate->qtd, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[3], 5, number_format($abate->peso, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[4], 5, number_format(($abate->peso/$abate->qtd), 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[5], 5, number_format((($abate->peso*$rendimento)/100), 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[6], 5, number_format((($abate->peso*$rendimento)/100)/$abate->qtd, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[7], 5, $res['rendimento'], 0, 0, "R", $fundo);
	}
}
$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

