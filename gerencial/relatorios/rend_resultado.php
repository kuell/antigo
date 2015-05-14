<?php
include "../../Connections/conect_mysqli.php";
require "../../class/Corretor.class.php";
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {

	function Header() {
		$this->Image("../../logo/Logo.jpg", 6, 5, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(250, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(250, 11, utf8_decode("Relatorio de Rendimentos / Corretor Periodo: "), "RLB", 0, "C");
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

		$corretors = new Corretor(null, $datai, $dataf);

		//Formatação dos titulos da tabela
		$this->SetFont('Arial', 'I', 9);

		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10, 60, 30, 30, 30, 40, 40, 40);

		$this->Cell($w[0], 5, "", 0, 0);
		$this->Cell($w[1], 5, "Cod/Corretor", 1, 0, "C", 1);
		$this->Cell($w[2], 5, "A Pagar", 1, 0, "C", 1);
		$this->Cell($w[3], 5, "A Pagar por (KG)", 1, 0, "C", 1);
		$this->Cell($w[4], 5, "A Receber", 1, 0, "C", 1);
		$this->Cell($w[5], 5, "A Receber por (KG)", 1, 0, "C", 1);
		$this->Cell($w[6], 5, "Saldo", 1, 0, "C", 1);
		$this->Cell($w[7], 5, "Saldo por (KG)", 1, 0, "C", 1);

		$this->Ln();
		$fundo = 0;

		$this->SetFont('Arial', '', 8);
		$this->SetFillColor(230);

		foreach ($corretors->lista('order by cor_nome') as $cor) {

			$item  = $corretors->item($cor->cor_id);
			$abate = $corretors->abate($cor->cor_id);
			if (!empty($item['c']) || !empty($item['d'])) {

				$this->Cell($w[0], 5, "", 0, 0);
				$this->Cell($w[1], 5, $cor->cor_cod.' -    '.$cor->cor_nome, 0, 0, "L", $fundo);
				$this->Cell($w[2], 5, 'R$ '.number_format($item['c'], 2, ',', '.'), 0, 0, "R", $fundo);
				!empty($item['c'])?$pagarKg = $item['c']/$abate->peso:$pagarKg = 0;
				$this->Cell($w[3], 5, 'R$ '.number_format($pagarKg, 4, ',', '.'), 0, 0, "R", $fundo);

				$this->Cell($w[4], 5, 'R$ '.number_format($item['d'], 2, ',', '.'), 0, 0, "R", $fundo);
				!empty($item['d'])?$receberKg = $item['d']/$abate->peso:$receberKg = 0;
				$this->Cell($w[5], 5, 'R$ '.number_format($receberKg, 4, ',', '.'), 0, 0, "R", $fundo);

				$this->Cell($w[6], 5, 'R$ '.number_format(($item['d']-$item['c']), 2, ',', '.'), 0, 0, "R", $fundo);
				!empty($abate->peso)?$saldoKg = ($item['d']-$item['c'])/$abate->peso:$saldoKg = 0;
				$this->Cell($w[7], 5, 'R$ '.number_format($saldoKg, 4, ',', '.'), 0, 0, "R", $fundo);

				$fundo = !$fundo;

				$aPagar    = $item['c']+$aPagar;
				$aReceber  = $item['d']+$aReceber;
				$kgAbatido = $abate->peso+$kgAbatido;

				$this->Ln();
			}

		}
		$fundo = 1;
		$this->Cell($w[0], 5, "", 0, 0);
		$this->Cell($w[1], 5, 'TOTAL', 0, 0, "L", $fundo);
		$this->Cell($w[2], 5, 'R$ '.number_format($aPagar, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[3], 5, 'R$ '.number_format($aPagar/$kgAbatido, 4, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[4], 5, 'R$ '.number_format($aReceber, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[5], 5, 'R$ '.number_format($aReceber/$kgAbatido, 4, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[6], 5, 'R$ '.number_format($aReceber-$aPagar, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[7], 5, 'R$ '.number_format(($aReceber/$kgAbatido)-($aPagar/$kgAbatido), 4, ',', '.'), 0, 0, "R", $fundo);
	}
}
$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

