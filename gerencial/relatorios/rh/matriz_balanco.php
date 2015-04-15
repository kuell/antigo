<?php
require "../../../bibliotecas/fpdf/fpdf.php";
require "../../../Connections/conect_mysqli.php";
require "../../../Connections/connect_pgsql.php";
require "../../../class/Interno.class.php";
require "../../../class/Setor.class.php";
require "../../../rh/class/Balanco.class.php";

class PDF extends FPDF {

	function Header() {
		$this->Image("../../../logo/Logo.jpg", 6, 5, 35, 15, "JPG");

		$d = explode('/', $_GET['data1']);

		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell('', 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell('', 11, utf8_decode("MATRIZ DO BALANÇO - ".$d['2']), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;

		$w = array(10, 20, 22, 40, 50, 60, 70, 80, 90, 100);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0);
		$this->SetDrawColor(1);
		$this->SetFillColor(200);

		$this->cell(50, 7, '', '', 0, 'C');
		$this->cell(110, 7, utf8_decode('Indicadores Temporais'), 'TRL', 0, 'C');
		$this->cell(66, 7, utf8_decode('Indicadores Dimensionais'), 'TRL', 0, 'C');
		$this->cell(66, 7, utf8_decode('Indicadores Produtividade'), 'TRL', 0, 'C');
		$this->Ln();

		$this->Cell($w[4], 7, 'SETORES', "TLR", 0, "C", 1);
		$this->cell($w[2], 7, utf8_decode('Tx Ocupação'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Falt./Acid.'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Ferias'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Tx Remuner.'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Tx Hora Extra'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Tx Admissao'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Tx Demissão'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Turnover'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Tx Folha/Fatur.'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Sal. p/ Kg'), 'TRLB', 0, 'C', 1);
		$this->cell($w[2], 7, utf8_decode('Sal. Medio Setor'), 'TRLB', 0, 'C', 1);

		$this->Ln();

	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 4, 'Processado em '.date('d/m/Y'), 0, 0, "C");
	}

	function Dados() {
		$datai = implode('-', array_reverse(explode('/', $_GET['data1'])));
		$dataf = implode('-', array_reverse(explode('/', $_GET['data2'])));

		$ano = date('Y', strtotime($datai));

		$matriz = new Balanco($ano.'-01-01', $ano.'-12-31');
		$setors = new Setor();

		$w = array(10, 20, 22, 40, 50, 60, 70, 80, 90, 100);
		$l = [5, 5, 4];
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0);
		$this->SetDrawColor(1);
		$this->SetFillColor(200);

		foreach ($setors->setores('where rh = 1') as $setor) {
			$atual = $matriz->matrizBalanco($setor->id_setor);

			$this->Cell($w[4], $l[2], $setor->id_setor.' - '.$setor->setor, "TLRB", 0, "L");
			$this->cell($w[2], $l[2], number_format($atual->taxaOcupacaoHora, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format(($atual->taxaFaltas+$atual->taxaAcidenteAfastamentos), 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaFerias, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaRemHora, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaHoraSuplementar, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaAdmissao, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaDemissao, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaAdmissao-$atual->taxaDemissao, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaTotalFolhaFat, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaSalarioPorPeso, 2, ',', '.').' %', 'TLBR', 0, 'R');
			$this->cell($w[2], $l[2], number_format($atual->taxaSalarioMedioSetor, 2, ',', '.').' %', 'TR', 0, 'R');

			$this->Ln();

			//Comparativos
			for ($i = ($ano-1); $i >= ($ano-$_GET['qtdAnos']); $i--) {
				$matriz->datai = $i.'-01-01';
				$matriz->dataf = $i.'-12-31';
				$this->SetFillColor(200);

				$comparativo = $matriz->matrizBalanco($setor->id_setor);

				$this->Cell($w[4], $l[2], 'Ano '.$i, "TLBRR", 0, "L", 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaOcupacaoHora, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format(($comparativo->taxaFaltas+$comparativo->taxaAcidenteAfastamentos), 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaFerias, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaRemHora, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaHoraSuplementar, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaAdmissao, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaDemissao, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaAdmissao-$comparativo->taxaDemissao, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaTotalFolhaFat, 2, ',', '.').' %', 'TLBR', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaSalarioPorPeso, 2, ',', '.').' %', 'TLBRB', 0, 'R', 1);
				$this->cell($w[2], $l[2], number_format($comparativo->taxaSalarioMedioSetor, 2, ',', '.').' %', 'TRB', 0, 'R', 1);
				$this->Ln();
			}
			//----

		}
	}
}

$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();

$pdf->Dados();
$pdf->Output();

?>