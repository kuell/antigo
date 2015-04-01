<?php

require ("../../bibliotecas/fpdf/fpdf.php");
require ('../../Connections/conect_mysqli.php');
require ('../../Connections/connect_pgsql.php');
require ('../../class/Interno.class.php');
require ('../class/Produtividade.class.php');
require ('../class/Balanco.class.php');
require ('../../class/Setor.class.php');

class PDF extends FPDF {

	function Header() {
		//$this->Image("/logo/Logo.JPG", 6, 5, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(164, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(164, 11, utf8_decode("Relatorio de Custo RH ef: ".$_GET['data1'].' à '.$_GET['data2']), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->SetDrawColor(200);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y H:i'), 0, 0, "C");
	}

	function getData($data) {
		$d = explode('-', $data);
		return $d[2].'-'.$d[1].'-'.$d[0];
	}

	function Dados($datai, $dataf) {
		$datai = implode('-', array_reverse(explode('-', $datai)));
		$dataf = implode('-', array_reverse(explode('-', $dataf)));

		$produtividade = new Produtividade($datai, $dataf);
		$balanco       = new Balanco($datai, $dataf);
		$i             = new Interno();
		$setors        = new Setor();

		$sqlAbate = sprintf("Select
						abateQtd('%s', '%s') as qtd,
						abatePeso('%s', '%s') as peso
	", $datai, $dataf, $datai, $dataf);

		$conn  = new Connect();
		$Abate = $conn->executeSql($sqlAbate);
		$info  = $Abate->fetch_object();

		$fundo = 0;

		$this->SetFont('Arial', 'I', 7);
		$this->SetFillColor(180);
		$this->SetDrawColor(230);
		$this->SetFillColor(200);
		$this->Cell(204, 5, 'Custo RH', 1, 0, 'C', 1);
		$this->Ln(7);

		$w = array(60, 30, 30, 30, 15);

		$this->Cell($w[0], 4, 'Qtd de Animais Abatidos', 1, 0, 'L', 0);
		$this->Cell($w[0], 4, number_format($info->qtd, 0, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 4, 'Peso de Animais Abatidos', 1, 0, 'L', 0);
		$this->Cell($w[0], 4, number_format($info->peso, 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln(5);
		$this->Cell($w[0], 4, 'SETOR', 1, 0, 'C', 1);
		$this->Cell($w[1], 4, 'HRS TRABALHADAS', 1, 0, 'C', 1);
		$this->Cell($w[1], 4, 'HRS TRAB. INTERNOS', 1, 0, 'C', 1);
		//	$this->Cell($w[4], 4, 'REM. BRUTA ', 1, 0, 'C', 1);
		//	$this->Cell($w[4], 4, 'H. Trab ', 1, 0, 'C', 1);
		$this->Cell($w[1], 4, 'CUSTO PADRAO HORA ', 1, 0, 'C', 1);
		$this->Cell($w[1], 4, 'TOTAL', 1, 0, 'C', 1);
		$this->Ln();

		$this->SetFillColor(230);

		foreach ($setors->lista('where rh = 1') as $setor) {
			$hTrab        = $produtividade->getHorasTrabalhadas($setor['id_setor']);
			$hTrabInterno = doubleval($i->getHorasTrabalhadas($setor['interno_setor'], $this->getData($datai), $this->getData($dataf)));
			$custoHora    = $balanco->getCustoHora($setor['id_setor']);

			$this->Cell($w[0], 4, $setor['setor'], 1, 0, 'L', $fill);

			$this->Cell($w[1], 4, number_format($hTrab, 2, ',', '.'), 1, 0, 'R', $fill);
			$this->Cell($w[1], 4, number_format($hTrabInterno, 2, ',', '.'), 1, 0, 'R', $fill);

			//		$this->Cell($w[4], 4, 'R$ '.number_format($balanco->getItem($setor['id_setor'], 12), 2, ',', '.'), 1, 0, 'R', $fill);
			//		$this->Cell($w[4], 4, 'R$ '.number_format($balanco->getItem($setor['id_setor'], 1), 2, ',', '.'), 1, 0, 'R', $fill);
			$this->Cell($w[1], 4, 'R$ '.number_format($custoHora, 2, ',', '.'), 1, 0, 'R', $fill);

			$this->Cell($w[1], 4, 'R$ '.number_format($custoHora*$hTrab, 2, ',', '.'), 1, 0, 'R', $fill);
			$this->Ln();

			$totalHorasTrab         = $totalHorasTrab+$hTrab;
			$totalHorasTrabInternos = $totalHorasTrabInternos+$hTrabInterno;
			$total                  = $total+($custoHora*$hTrab);
		}

		$this->SetFillColor(200);
		$this->Cell($w[0], 4, "TOTAIS", 0, 0, 'L', 1);
		$this->Cell($w[1], 4, number_format($totalHorasTrab, 2, ',', '.'), 0, 0, 'R', 1);
		$this->Cell($w[1], 4, number_format($totalHorasTrabInternos, 2, ',', '.'), 0, 0, 'R', 1);
		$this->Cell($w[1], 4, ' - ', 0, 0, 'C', 1);
		$this->Cell($w[1], 4, 'R$ '.number_format($total, 2, ',', '.'), 0, 0, 'R', 1);

	}
}
$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();

$pdf->Dados($_GET['data1'], $_GET['data2']);
$pdf->Output();
?>



