<?php
require_once ("../../Connections/conn.php");
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {

	function Header() {
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(149, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(149, 11, utf8_decode("Relatorio Geral do Balanço RH Ref: ".date('m/Y', strtotime($_GET['data']))), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->SetDrawColor(200);
		$this->Cell(0, 5, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y h:i'), 0, 0, "C");
	}

	function getSetor($id = null) {
		if (!$id) {
			return null;
		} else {
			$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
			$sql  = sprintf("Select * from setor where id_setor = %s", $id);
			$qr   = $conn->query($sql) or die("Error: ".$sql);

			return $qr->fetch_object();
		}
	}

	function dadosInternos($mes, $ano, $setor) {
		if ($setor == '-') {
			$internos->hpotenciais      = 0;
			$internos->horastrabalhadas = 0;
			$internos->hsuplementar     = 0;

			return $internos;
		} else {

			/// --- Conexão com Postgresql ---///
			$conexao    = pg_connect("host=localhost dbname=internos port=5432 user=postgres password=aporedux");
			$setor?$s   = 'and c.id = '.$setor:$s   = '';
			!$setor?$ss = 'null':$ss = $setor;

			$sql = sprintf("
				Select
					count(distinct(b.id)) as qtdAtivos,
					count(distinct(a.data)) as diasTrab,
					(count(distinct(a.data)) * count(distinct(b.id))) * interval '7:20 hour' as hPotenciais,
					f_rh_hsuplementar_setor($ss, $mes, $ano) as hSuplementar,
					sum(a.saida - a.entrada) as horasTrabalhadas
				from
					interno_frequencias a
					inner join internos b on a.interno_id = b.id
					inner join setors c on b.setor_id = c.id
				where
					extract(month from a.data) = %s and
					extract(year from a.data) = %s %s", $mes, $ano, $s);

			$result   = pg_exec($conexao, $sql) or die("Erro na execução do SQL Internos: ".$sql);
			$internos = pg_fetch_object($result);

			pg_close();

			return $internos;
		}
	}

	function Dados() {
		$w     = [140, 30];
		$mes   = date('m', strtotime($_GET['data']));
		$ano   = date('Y', strtotime($_GET['data']));
		$setor = $this->getSetor($_GET['setor']);
		if (empty($setor)) {
			$s = "null";
		} else {
			$s = $setor->id_setor;
			if (!$setor->interno_setor) {
				$setor->interno_setor = '-';
			}
		}

		$internos = $this->dadosInternos($mes, $ano, $setor->interno_setor);

		$this->SetFont('Arial', 'I', 9);
		$this->SetFillColor(180);
		$this->SetDrawColor(200);
		$this->SetFillColor(230);

		// ---- Conexão com Mysq ---//

		$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
		//mysqli_connect($conn);
		$sql = sprintf("call p_rh_balanco(%s, %s, %s)", $mes, $ano, $s);
		$qr  = $conn->query($sql) or die("Erro na consulta: ".$sql);
		/// ---  --- ///

		while ($val = $qr->fetch_object()) {
			$this->Cell(0, 5, "Setor: ".$val->setor, "BLR", 1, "C", 1);
			$this->Ln();
			$this->SetFont('Arial', 'B', 9);
			// Informação de Abate e Faturamento do periodo //
			$this->Cell($w[0], 5, 'QTD. ABATE', 'LBT', 0, 'L', 1);
			$this->Cell($w[1], 5, number_format($val->qtdAbate, 2, ',', '.'), 'RBT', 0, 'R', 1);
			$this->Ln();
			$this->Cell($w[0], 5, 'PESO ABATE', 'LBT', 0, 'L', 1);
			$this->Cell($w[1], 5, number_format($val->pesoAbate, 2, ',', '.'), 'RBT', 0, 'R', 1);
			$this->Ln();
			$this->Cell($w[0], 5, 'FATURAMENTO BRUTO', 'LBT', 0, 'L', 1);
			$this->Cell($w[1], 5, number_format($val->faturamento, 2, ',', '.'), 'RBT', 0, 'R', 1);
			$this->Ln();
			// -- //

			$this->SetFont('Arial', 'I', 9);

			// Informações gerais //
			$this->Cell($w[0], 5, 'HORAS TRABALHADAS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->hTrab, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'HORAS TRABALHADAS INTERNOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($internos->horastrabalhadas, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->SetFont('Arial', 'B', 9);

			$this->Cell($w[0], 5, 'TOTAL HORAS TRABALHADAS', 'LBT', 0, 'L', 1);
			$this->Cell($w[1], 5, number_format(($val->hTrab+$internos->horastrabalhadas), 2, ',', '.'), 'RBT', 0, 'R', 1);
			$this->Ln();

			$this->SetFont('Arial', 'I', 9);
			$this->Cell($w[0], 5, utf8_decode('HORAS Á TRABALHAR'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->hTrabalhar, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, utf8_decode('HORAS À TRABALHADAS INTERNOS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($internos->hpotenciais, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->SetFont('Arial', 'B', 9);

			$this->Cell($w[0], 5, utf8_decode('TOTAL HORAS À TRABALHAR'), 'LBT', 0, 'L', 1);
			$this->Cell($w[1], 5, number_format(($val->hTrabalhar+$internos->hpotenciais), 2, ',', '.'), 'RBT', 0, 'R', 1);
			$this->Ln();

			$this->SetFont('Arial', 'I', 9);

			$this->Cell($w[0], 5, 'HORAS EXTRAS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->hExtra, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'HORAS EXTRAS INTERNOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($internos->hsuplementar, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->SetFont('Arial', 'B', 9);

			$this->Cell($w[0], 5, utf8_decode('TOTAL HORAS EXTRA'), 'LBT', 0, 'L', 1);
			$this->Cell($w[1], 5, number_format(($val->hExtra+$internos->hsuplementar), 2, ',', '.'), 'RBT', 0, 'R', 1);
			$this->Ln();

			$this->SetFont('Arial', 'I', 9);

			$this->Cell($w[0], 5, 'FALTAS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->faltas, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'FERIAS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->ferias, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'ACIDENTES E AFASTAMENTOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->acidAfast, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'QTDE. FUNCIONARIOS REGISTRADOS ATIVOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->regAtivo, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'QTDE. FUNCIONARIOS TEMPORARIOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->funTemp, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, utf8_decode('PRESTADORES DE SERVIÇO'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->prestServ, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'ADMITIDOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->admitidos, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, 'DEMITIDOS', 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->demitidos, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, utf8_decode('REMUNERAÇÃO BRUTA'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->remBruta, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell($w[0], 5, utf8_decode('QUANTIDADE DE FUNCIONARIOS TEMPORARIOS DESLIGADOS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($val->funcTempoDesl, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

			// --- Variaveis --- ///
			$totalHoraTrab     = $val->hTrab+$internos->horastrabalhadas;
			$totalHoraPot      = $val->hTrabalhar+$internos->hpotenciais;
			$totalHoraExtra    = $val->hExtra+$internos->hsuplementar;
			$absenteismo       = ($val->faltas/$val->hTrab*100)+($val->acidAfast/$val->hTrabalhar*100)+($val->ferias/$val->hTrabalhar*100);
			$totalFuncionarios = $val->regAtivo+$val->prestServ+$val->funTemp;
			// --- --- //

			// --- Indicadores Gerais --- //
			$this->Cell(170, 5, "INDICADORES GERAIS", "BLR", 1, "C", 1);

			$this->Cell($w[0], 5, utf8_decode('TAXA DE OCUPAÇÃO DE HORAS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($totalHoraTrab/$totalHoraPot*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('TAXA DE DESOCUPAÇÃO DE HORAS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format((($totalHoraPot-$totalHoraTrab)/$totalHoraPot)*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('FALTAS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($val->faltas/$val->hTrab*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('ACIDENTES E AFASTAMENTOS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($val->acidAfast/$val->hTrabalhar*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('FÉRIAS'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($val->ferias/$val->hTrabalhar*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('ABSENTEISMO TOTAL'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format($absenteismo, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('TAXA DE SUBSTITUIÇÃO DO ABSENTEISMO'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($val->ferias/$val->hTrabalhar*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('TAXA DE REMUNERAÇÃO HORA'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, 'R$ '.number_format(($val->remBruta/$totalHoraTrab), 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('TAXA DE HORAS EXTRA'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($totalHoraExtra/$totalHoraTrab*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell(170, 5, "INDICADORES DIMENSIONAIS", "BLR", 1, "C", 1);

			$this->Cell($w[0], 5, utf8_decode('TAXA DE ADMISSÃO'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($val->admitidos*100/$val->regAtivo), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('TAXA DE DEMISSÃO'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format(($val->demitidos*100/$val->regAtivo), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('TAXA DE REPOSIÇÃO'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format((($val->admitidos-$val->demitidos)*100/$val->regAtivo), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();

			$this->Cell(170, 5, "INDICADORES DE PRODUTIVIDADE", "BLR", 1, "C", 1);

			$this->Cell($w[0], 5, utf8_decode('TAXA FOLHA / FATURAMENTO'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, number_format((($val->remBruta/$val->faturamento)*100), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('SALARIO POR KG'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, 'R$ '.number_format(($val->remBruta/$val->pesoAbate), 5, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();
			$this->Cell($w[0], 5, utf8_decode('SALARIO MEDIO POR SETOR'), 'LBT', 0, 'L', 0);
			$this->Cell($w[1], 5, 'R$ '.number_format($val->remBruta/$totalFuncionarios, 2, ',', '.'), 'RBT', 0, 'R', 0);
			$this->Ln();

		}
	}
}
$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>



