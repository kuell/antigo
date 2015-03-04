<?php
require ("../../Connections/conn.php");
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {
	function Header() {
		date_default_timezone_set("Brazil/East");
		define('hora', date("H")-1);
		//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(250, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(250, 11, utf8_decode("Relatorio de Rendimentos / Corretor Periodo: ".date('d-m-Y', strtotime(datai))." a ".date('d-m-Y', strtotime(dataf))), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'), 0, 0, "C");
	}

	function Dados() {
		// Pega os itens
		mysql_select_db('sig');

		$sql = "	Select
						*,
						(Select rendimento from `custoproducaomensal` where	mes = month('".datai."') and  ano = year('".dataf."')) as rendimento,
						(((Select rendimento from `custoproducaomensal` where	mes = month('".datai."') and  ano = year('".dataf."'))*(select sum(kg_abatido) from rendimento_corretor where mes between month('".datai."') and month('".dataf."') and ano between year('".datai."') and year('".dataf."')))/100) as rendInd
					from
						sig.rendimento_corretor
					where
						mes between month('".datai."') and month('".dataf."') and
						ano between year('".datai."') and year('".dataf."')";
		$qr = mysql_query($sql) or die(mysql_error());
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
		while ($res = mysql_fetch_assoc($qr)) {
			$this->SetFont('Arial', '', 8);
			$this->SetFillColor(230);

			$this->Cell($w[0], 5, "", 0, 0);
			$this->Cell($w[1], 4, $res['cor_cod'].' -    '.$res['cor_nome'], 0, 0, "L", $fundo);
			$this->Cell($w[2], 4, number_format($res['qtd_abate'], 2, ',', '.'), 0, 0, "R", $fundo);
			$this->Cell($w[3], 4, number_format($res['kg_abatido'], 2, ',', '.'), 0, 0, "R", $fundo);
			$this->Cell($w[4], 4, number_format(($res['kg_abatido']/$res['qtd_abate']), 2, ',', '.'), 0, 0, "R", $fundo);
			$this->Cell($w[5], 4, number_format((($res['kg_abatido']*$res['rendimento'])/100), 2, ',', '.'), 0, 0, "R", $fundo);
			$this->Cell($w[6], 4, number_format((($res['kg_abatido']/$res['qtd_abate'])*$res['rendimento'])/100, 2, ',', '.'), 0, 0, "R", $fundo);
			$this->Cell($w[7], 4, number_format(($res['kg_abatido']*$res['rendimento'])/$res['rendInd'], 2, ',', '.'), 0, 0, "R", $fundo);

			$fundo = !$fundo;

			$totalAbatido = $res['qtd_abate']+$totalAbatido;
			$pesoAbatido  = $res['kg_abatido']+$pesoAbatido;
			$rendimento   = $res['rendimento'];

			$this->Ln(5);
		}
		$fundo = 1;
		$this->Cell($w[0], 5, '', 0, 0);
		$this->Cell($w[1], 4, 'TOTAL', 0, 0, "L", $fundo);
		$this->Cell($w[2], 4, number_format($totalAbatido, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[3], 4, number_format($pesoAbatido, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[4], 4, number_format(($pesoAbatido/$totalAbatido), 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[5], 4, number_format((($pesoAbatido*$rendimento)/100), 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[6], 4, number_format(($totalAbatido*$rendimento)/100, 2, ',', '.'), 0, 0, "R", $fundo);
		$this->Cell($w[7], 4, $res['rendimento'], 0, 0, "R", $fundo);
	}
}
$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

