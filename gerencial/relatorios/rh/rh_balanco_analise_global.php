<?php
require ("../../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {

	function Header() {
		$this->SetFont("Arial", "B", 20);
		//$this->Cell(1);
		$this->Cell(43, 10, "", "TLR", 0, "C");
		$this->Cell(0, 10, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		//$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(43, 10, "", "BLR", 0, "C");
		$this->Cell(0, 10, utf8_decode("Analise Global RH Ref: ".date('Y', strtotime($_GET['data1']))), "RLB", 0, "C");
		$this->Ln(10);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->SetDrawColor(200);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} | Processado em ".date('d-m-Y h:i'), 0, 0, "C");

	}

	function info($setor, $ano) {
		$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
		$sql  = sprintf("call p_rh_balanco_analise_global(%s, %s)", $setor, $ano);

		$qr = $conn->query($sql) or die('Erro na obtensao dos dados'.$sql);

		while ($res = $qr->fetch_object()) {
			$val[$res->mes] = (object) [
				'qtdAbate'     => $res->qtdAbate,
				'pesoAbate'    => $res->pesoAbate,
				'faturamento'  => $res->faturamento,
				'hTrabalhadas' => $res->hTrab,
				'hTrabalhar'   => $res->hTrabalhar,
				'hExtra'       => $res->hExtra,
				'faltas'       => $res->faltas,
				'acidAfast'    => $res->AcidAfast,
				'ferias'       => $res->ferias,
				'regAtivo'     => $res->regAtivo,
				'funTemp'      => $res->funTemp,
				'prestServ'    => $res->prestServ,
				'admitidos'    => $res->admitidos,
				'demitidos'    => $res->demitidos,
				'remBruta'     => $res->remBruta,
				'funTempDesl'  => $res->funTempDesl,
				'hTrabTemp'    => $res->hTrabTemp];
		}
		$conn->close();
		return $val;
	}
	function getSetor($idSetor = null) {
		if ($idSetor == 'null') {
			return "Todos";
		} else {
			$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
			$sql  = sprintf("Select * from setor where id_setor = %s", $idSetor);
			$qr   = $conn->query($sql) or die('Erro na obtensao dos dados: '.$sql);
			return $qr->fetch_object()->setor;
		}
	}
	function Dados($setor = 'null', $ano = null) {
		$info = $this->info($setor, $ano);
		$mes  = array(
			'1'  => 'Janeiro',
			'2'  => 'Fevereiro',
			'3'  => 'Março',
			'4'  => 'Abril',
			'5'  => 'Maio',
			'6'  => 'Junho',
			'7'  => 'Julho',
			'8'  => 'Agosto',
			'9'  => 'Setembro',
			'10' => 'Outubro',
			'11' => 'Novembro',
			'12' => 'Dezembro',
		);

		//	print_r($info);
		//	die;

		$w = [43, 18];
		$this->SetFont('Arial', 'B', '7');
		$this->SetFillColor(200, 200, 200);

		$this->Cell($w[0], 4, 'Setor: '.$this->getSetor($setor), 1, 1, 'C', 0);
		$this->Cell($w[0], 4, 'INDICADORES GERAIS', 1, 0, 'C', 1);
		for ($i = 1; $i <= 12; $i++) {
			$this->Cell($w[1], 4, utf8_decode($mes[$i]), 1, 0, 'C', 1);
		}
		$this->Cell($w[1], 4, utf8_decode("Acumulado"), 1, 0, 'C', 1);
		$this->Ln();

		$this->SetFont('Arial', 'B', '7');

		$this->Cell($w[0], 4, 'QTDE. ABATE', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->qtdAbate, 0, ',', '.'), 1, 0, 'R', 0);
			$totalQtdAbate[] = $value->qtdAbate;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalQtdAbate), 0, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'PESO ABATE', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->pesoAbate, 2, ',', '.'), 1, 0, 'R', 0);
			$totalPesoAbate[] = $value->pesoAbate;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalPesoAbate), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'FATURAMENTO', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->faturamento, 2, ',', '.'), 1, 0, 'R', 0);
			$totalFaturamento[] = $value->faturamento;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalFaturamento), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->SetFont('Arial', 'I', '7');

		$this->Cell($w[0], 4, 'HORAS TRABALHADAS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->hTrabalhadas, 2, ',', '.'), 1, 0, 'R', 0);
			$totalHTrab[] = $value->hTrabalhadas;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalHTrab), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'HORAS POTENCIAIS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->hTrabalhar, 2, ',', '.'), 1, 0, 'R', 0);
			$totalHPot[] = $value->hTrabalhar;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalHPot), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'HORAS SUPLEMENTARES', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->hExtra, 2, ',', '.'), 1, 0, 'R', 0);
			$totalHoraSupl[] = $value->hExtra;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalHoraSupl), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'FALTAS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->faltas, 2, ',', '.'), 1, 0, 'R', 0);
			$totalFalta[] = $value->faltas;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalFalta), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'ACIDENTES E AFASTAMENTO', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->acidAfast, 2, ',', '.'), 1, 0, 'R', 0);
			$totalAcidAfast[] = $value->acidAfast;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalAcidAfast), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('FÉRIAS'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->ferias, 2, ',', '.'), 1, 0, 'R', 0);
			$totalFerias[] = $value->ferias;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalFerias), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'QTDE. FUNC. REG. ATIVOS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->regAtivo, 2, ',', '.'), 1, 0, 'R', 0);
			$totalRegAtivos = $value->regAtivo;
		}
		$this->Cell($w[1], 4, number_format($totalRegAtivos, 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'QTDE. FUNC. TEMPORARIOS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->funTemp, 2, ',', '.'), 1, 0, 'R', 0);
			$totalTemp[] = $value->funTemp;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalTemp), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('PRESTADORES DE SERVIÇO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->prestServ, 2, ',', '.'), 1, 0, 'R', 0);
			$totalPrestServ = $value->prestServ;
		}
		$this->Cell($w[1], 4, number_format($totalPrestServ, 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'ADMITIDOS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->admitidos, 2, ',', '.'), 1, 0, 'R', 0);
			$totalAdmitidos[] = $value->admitidos;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalAdmitidos), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'DEMITIDOS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->demitidos, 2, ',', '.'), 1, 0, 'R', 0);
			$totalDemitidos[] = $value->demitidos;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalDemitidos), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('REMUNERAÇÃO BRUTA'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->remBruta, 2, ',', '.'), 1, 0, 'R', 0);
			$totalRemBruta[] = $value->remBruta;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalRemBruta), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, 'QTDE. FUNC. TEMP. DESLIGADOS', 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format($value->funTempDesl, 2, ',', '.'), 1, 0, 'R', 0);
			$totalFunTempDesl[] = $value->funTempDesl;
		}
		$this->Cell($w[1], 4, number_format(array_sum($totalFunTempDesl), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->SetFont('Arial', 'B', '7');
		$this->Cell($w[0], 4, 'INDICADORES TEMPORAIS', 1, 0, 'C', 1);
		$this->Cell(234, 4, '', 1, 0, 'C', 1);
		$this->Ln();

		$this->SetFont('Arial', 'I', '7');

		$this->Cell($w[0], 4, utf8_decode('TAXA DE OCUPAÇÃO DE HORAS'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->hTrabalhadas/$value->hTrabalhar)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalHTrab)/array_sum($totalHPot))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('TAXA DE DESOCUPAÇÃO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format((($value->hTrabalhar-$value->hTrabalhadas)/$value->hTrabalhar)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalHPot)-array_sum($totalHTrab))/array_sum($totalHPot)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('FALTAS'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->faltas/$value->hTrabalhadas)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
			$faltas = (($value->faltas/$value->hTrabalhadas)*100)+$faltas;
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalFalta)/array_sum($totalHTrab))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('ACIDENTES E AFASTAMENTO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->acidAfast/$value->hTrabalhar)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
			$acidAfast = ($value->acidAfast/$value->hTrabalhar)*100;
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalAcidAfast)/array_sum($totalHPot))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('FÉRIAS'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->ferias/$value->hTrabalhar)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
			$ferias = ($value->ferias/$value->hTrabalhar)*100+$ferias;
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalFerias)/array_sum($totalHPot))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('ABSENTEISMO TOTAL'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$ferias    = ($value->ferias/$value->hTrabalhar)*100;
			$faltas    = ($value->faltas/$value->hTrabalhadas)*100;
			$acidAfast = ($value->acidAfast/$value->hTrabalhar)*100;

			$this->Cell($w[1], 4, number_format(($faltas+$ferias+$acidAfast), 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format(((array_sum($totalAcidAfast)+array_sum($totalFerias)+array_sum($totalFalta))/array_sum($totalHTrab))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('TAXA DE REMUNERAÇÃO HORA'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, 'R$ '.number_format(($value->remBruta/$value->hTrabalhadas), 2, ',', '.'), 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, 'R$ '.number_format((array_sum($totalRemBruta)/array_sum($totalHTrab)), 2, ',', '.'), 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('TAXA DE HORAS SUPLEMENTARES'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->hExtra/$value->hTrabalhadas)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalHoraSupl)/array_sum($totalHTrab))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->SetFont('Arial', 'B', '7');
		$this->Cell($w[0], 4, 'INDICADORES DIMENSIONAIS', 1, 0, 'C', 1);
		$this->Cell(234, 4, '', 1, 0, 'C', 1);
		$this->Ln();

		$this->SetFont('Arial', 'I', '7');

		$this->Cell($w[0], 4, utf8_decode('TAXA DE ADMISSÃO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->admitidos/$value->regAtivo)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalAdmitidos)/$totalRegAtivos)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('TAXA DE DEMISSÃO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->demitidos/$value->regAtivo)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalDemitidos)/$totalRegAtivos)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('TAXA DE REPOSIÇÃO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format((($value->admitidos/$value->regAtivo)*100)-(($value->demitidos/$value->regAtivo)*100), 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format(((array_sum($totalAdmitidos)-array_sum($totalDemitidos))/$totalRegAtivos)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->SetFont('Arial', 'B', '7');
		$this->Cell($w[0], 4, 'INDICADORES DE PRODUTIVIDADE', 1, 0, 'C', 1);
		$this->Cell(234, 4, '', 1, 0, 'C', 1);
		$this->Ln();

		$this->SetFont('Arial', 'I', '7');

		$this->Cell($w[0], 4, utf8_decode('TAXA FOLHA / FATURAMENTO'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, number_format(($value->remBruta/$value->faturamento)*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalRemBruta)/array_sum($totalFaturamento))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('SALARIO POR KG'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, 'R$ '.number_format(($value->remBruta/$value->pesoAbate), 2, ',', '.'), 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, number_format((array_sum($totalRemBruta)/array_sum($totalPesoAbate))*100, 2, ',', '.').' %', 1, 0, 'R', 0);
		$this->Ln();

		$this->Cell($w[0], 4, utf8_decode('SALARIO MÉDIO POR SETOR'), 1, 0, 'L', 0);
		foreach ($info as $value) {
			$this->Cell($w[1], 4, 'R$ '.number_format(($value->remBruta/($value->funTemp+$value->regAtivo+$value->prestServ)), 2, ',', '.'), 1, 0, 'R', 0);
		}
		$this->Cell($w[1], 4, '-', 1, 0, 'R', 0);
		$this->Ln();
	}
}
$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();

$pdf->AddPage();

$d = explode('/', $_GET['data1']);

if (empty($_GET['setor'])) {
	$_GET['setor'] = 'null';
}

$pdf->Dados($_GET['setor'], $d[2]);
$pdf->Output();
?>
