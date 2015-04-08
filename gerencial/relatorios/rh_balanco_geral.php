<?php

require "../../Connections/conect_mysqli.php";
require "../../bibliotecas/fpdf/fpdf.php";
require "../../Connections/connect_pgsql.php";
require "../../class/Setor.class.php";
require "../../class/Interno.class.php";
require "../../rh/class/Balanco.class.php";

class PDF extends FPDF {

	function Header() {

		$data = explode('/', $_GET['data1']);

		$this->image("../../logo/Logo.jpg", 6, 6, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(149, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(149, 11, utf8_decode("Relatorio Geral do Balanço RH Ref: ".$data[1].'/'.$data[2]), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->SetDrawColor(200);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y h:i'), 0, 0, "C");
	}
	function Dados() {

		$datai = implode('-', array_reverse(explode('/', $_GET['data1'])));
		$dataf = implode('-', array_reverse(explode('/', $_GET['data2'])));

		$bal     = new Balanco($datai, $dataf);
		$balanco = $bal->getBalanco();

		$fundo = 0;
		$w     = array(170, 20);

		$this->SetFont('Arial', 'I', 9);
		$this->SetFillColor(180);
		$this->SetDrawColor(210);
		$this->SetFillColor(200);
		$this->Cell(190, 5, 'RESUMO GERAL', 1, 0, 'C', 1);
		$this->Ln(7);

		$this->SetFont("Arial", "B", 9);
		$this->SetFillColor(230);

		$this->Cell(190, 4, utf8_decode('INDICADORES GERAIS'), 1, 0, 'C', 1);
		$this->Ln();

		$this->Cell($w[0], 5, 'Qtd. Abate', 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format($balanco->info->qtd, 0, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, 'Peso Abate', 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format($balanco->info->peso, 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, 'Faturamento Bruto', 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format($balanco->info->fat, 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();

		$this->SetFont("Arial", "I", 9);

		$this->Cell($w[0], 5, utf8_decode("HORAS TRABALHADAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->horas_trabalhadas['c'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("HORAS TRABALHADAS INTERNOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->horas_trabalhadas['i'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TOTAL HORAS TRABALHADAS"), 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format($balanco->horas_trabalhadas['i']+$balanco->horas_trabalhadas['c'], 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("HORAS POTENCIAIS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->horas_potenciais['c'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("HORAS POTENCIAIS INTERNOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->horas_potenciais['i'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TOTAL HORAS POTENCIAIS"), 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format($balanco->horas_potenciais['i']+$balanco->horas_potenciais['c'], 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("HORAS SUPLEMENTARES"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->horas_suplementares['c'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("HORAS SUPLEMENTARES INTERNOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->horas_suplementares['i'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TOTAL HORAS SUPLEMENTARES"), 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format($balanco->horas_suplementares['i']+$balanco->horas_suplementares['c'], 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("FALTAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->falta, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("FERIAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->ferias, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("ACIDENTES E AFASTAMENTO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->acidenteAfastamento, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("QTDE. FUNCIONARIOS REGISTRADOS ATIVOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->qtdFuncRegistradoAtivo, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("QTDE. FUNCIONARIOS TEMPORARIOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->qtdFuncTemporarios, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("PRESTADORES DE SERVIÇO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->pestadoresServico, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("ADMITIDOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->admitidos, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("DEMITIDOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->demitidos, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("REMUNERAÇÃO BRUTA"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->remBruta, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("QUANTIDADE DE FUNCIONARIOS TEMPORARIOS DESLIGADOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->qtdFuncTemporariosDesligados, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln(7);

		$this->Cell(190, 4, utf8_decode('INDICADORES GERAIS'), 1, 0, 'C', 1);
		$this->Ln();

		$this->Cell($w[0], 5, utf8_decode("TAXA DE OCUPAÇÃO HORAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaOcupacaoHora, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TAXA DE DESOCUPAÇÃO HORAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaDesocupacaoHora, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("FALTAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaFaltas, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("ACIDENTES E AFASTAMENTOS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaAcidenteAfastamentos, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("FÉRIAS"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaFerias, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("ABSENTEÍSMO TOTAL"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaAbsenteismoTotal, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TAXA DE SUBSTITUIÇÃO DO ABSENTEÍSMO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format('0', 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TAXA REMUNERAÇÃO HORA"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, 'R$ '.number_format($balanco->taxaRemHora, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TAXA DE HORAS EXTRA"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaHoraSuplementar, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln(7);

		$this->Cell(190, 4, utf8_decode('INDICADORES DIMENSIONAIS'), 1, 0, 'C', 1);
		$this->Ln();

		$this->Cell($w[0], 5, utf8_decode("TAXA DE ADMISSÃO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaAdmissao, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TAXA DE DEMISSÃO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaDemissao, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("TAXA DE REPOSIÇÃO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaReposicao, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln(7);

		$this->Cell(190, 4, utf8_decode('INDICADORES DE PRODUTIVIDADE'), 1, 0, 'C', 1);
		$this->Ln();

		$this->Cell($w[0], 5, utf8_decode("TAXA FOLHA / FATURAMENTO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($balanco->taxaTotalFolhaFat, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("SALARIO POR PESO"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, 'R$ '.number_format($balanco->taxaSalarioPorPeso, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode("SALARIO MÉDIO POR SETOR"), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, 'R$ '.number_format($balanco->taxaSalarioMedioSetor, 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();

	}
}

$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>