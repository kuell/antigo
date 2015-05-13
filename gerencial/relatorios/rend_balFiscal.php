<?php
require ('../../Connections/conect_mysqli.php');
require ('../../class/Corretor.class.php');
require ("../../bibliotecas/fpdf/fpdf.php");

define("datai", date('Y-m-d', strtotime($_REQUEST['data1'])));
define("dataf", date('Y-m-d', strtotime($_REQUEST['data2'])));

class PDF extends FPDF {

	function Header() {

		$this->Image("../../logo/Logo.jpg", 13, 13, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(240, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(240, 11, utf8_decode("Relatorio de Balanço Fiscal / Corretor Periodo: ".$_GET['data1']." a ".$_GET['data2']), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} de Processado em ".date('d/m/Y H:i:s'), 0, 0, "C");
	}

	function Dados() {
		$datai = implode('-', array_reverse(explode('/', $_GET['data1'])));
		$dataf = implode('-', array_reverse(explode('/', $_GET['data2'])));

		$corretors = new Corretor(null, $datai, $dataf);
		//$rend = mysql_fetch_assoc($qr);
		//Formatação dos titulos da tabela
		$this->SetFont('Arial', 'I', 8);

		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10, 60, 40, 35, 30, 30, 30, 30);

		$this->Cell($w[1], 5, "Cod/Corretor", 1, 0, "C", 1);
		$this->Cell($w[2], 5, utf8_decode("Romaneio de Expedição (KG)"), 1, 0, "C", 1);
		$this->Cell($w[3], 5, "Romaneio Fiscal (KG)", 1, 0, "C", 1);
		$this->Cell($w[4], 5, "ICMS", 1, 0, "C", 1);
		$this->Cell($w[5], 5, "Pauta Fiscal (KG)", 1, 0, "C", 1);
		$this->Cell($w[6], 5, "Saldo (KG)", 1, 0, "C", 1);
		$this->Cell($w[7], 5, "Corte (%)", 1, 0, "C", 1);

		$this->Ln();
		$fundo = 0;

		$this->SetDrawColor(200);

		foreach ($corretors->lista() as $cor) {
			$exped = $corretors->expedicao($cor->cor_id);
			if (!empty($exped->pesoFiscal) && !empty($exped->exped)) {

				$this->SetFont('Arial', '', 7);
				$this->SetFillColor(230);

				$this->Cell($w[1], 5, $cor->cor_cod.' - '.$cor->cor_nome, 'LBT', 0, "L", $fundo);
				$this->Cell($w[2], 5, number_format($exped->exped, 2, ',', '.'), 'BT', 0, "R", $fundo);
				$this->Cell($w[3], 5, number_format($exped->pesoFiscal, 2, ',', '.'), 'BT', 0, "R", $fundo);
				$this->Cell($w[4], 5, 'R$ '.number_format($exped->valorFiscal, 2, ',', '.'), 'BT', 0, "R", $fundo);
				$this->Cell($w[5], 5, number_format(($exped->valorFiscal/$exped->pesoFiscal), 2, ',', '.'), 'BT', 0, "R", $fundo);
				$this->Cell($w[6], 5, number_format(($exped->pesoFiscal-$exped->exped), 2, ',', '.'), 'BT', 0, "R", $fundo);
				$this->Cell($w[6], 5, number_format((($exped->pesoFiscal-$exped->exped)/$exped->exped*100), 2, ',', '.').' %', 'BTR', 0, "R", $fundo);

				$fundo = !$fundo;

				$totalExp  = $exped->exped+$totalExp;
				$totalFisc = $exped->pesoFiscal+$totalFisc;
				$totalIcms = $exped->valorFiscal+$totalIcms;

				$this->Ln();
			}
		}
		$fundo = 1;

		$this->SetFillColor(190);

		$this->Cell($w[1], 4, 'TOTAL', 0, 0, "L", $fundo);
		$this->Cell($w[2], 4, number_format($totalExp, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[3], 4, number_format($totalFisc, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[4], 4, 'R$ '.number_format($totalIcms, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[5], 4, number_format(($totalIcms/$totalExp), 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[6], 4, number_format(($totalFisc-$totalExp), 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[7], 4, number_format((($totalFisc-$totalExp)/$totalExp)*100, 2, ',', '.').' %', 0, 0, "R", $fundo);
	}
}
$pdf = new PDF("L", "mm", "A4");
//$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

