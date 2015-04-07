<?php
include "../../../Connections/conn.php";
require ("../../../bibliotecas/fpdf/fpdf.php");

mysql_select_db($database_conn, $conn);

class PDF extends FPDF {

	function Header() {
		//$this->Image("../../logo/Logo.JPG", 6, 5, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(160, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(160, 11, utf8_decode("CONTROLE DO QUADRO DE FUNCIONÁRIOS - ").date('M/Y', strtotime($_REQUEST['data1'])), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function getFiltro($data, $tipo) {
		$d = explode('/', $data);

		switch ($tipo) {
			case 'mes':
				return $d[1];
				break;
			case 'ano':
				return $d[2];
				break;
		}

	}
	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 4, 'Processado', 0, 0, "C");
	}
	function getDados($mes, $ano) {

		$sql = sprintf("Select
						a.id_setor,
						a.setor,
						(Select valor from rh_balanco where setor = a.id_setor and ano = 2013 and mes = 12 and item = 8) as interno_inicial,
						(Select sum(valor) from rh_balanco where setor = a.id_setor and item = 16 and
								date(concat(ano,'-',mes,'-','01')) between '2013-12-01' and date(concat(%s, '-', %s, '-','01'))) as interno_demitidos,
						(Select sum(valor) from rh_balanco where setor = a.id_setor and ano = %s and mes = %s and item = 8) as interno_atual,

						(Select valor from rh_balanco where setor = a.id_setor and ano = 2013 and mes = 12 and item = 7) as inicial,

						coalesce((Select sum(valor) from rh_balanco where setor = a.id_setor and item = 11 and date(concat(ano,'-',mes,'-','01')) between '2013-12-01' and date(concat(%s,'-',%s ,'-','01'))),0) as demitidos,

						(Select valor from rh_balanco where setor = a.id_setor and ano = %s and mes = %s and item = 7) as atual
					from
						setor a ", $ano, $mes, $ano, $mes, $ano, $mes, $ano, $mes, $ano, $mes);
		$qr = mysql_query($sql) or die(mysql_error());

		while ($res = mysql_fetch_assoc($qr)) {
			if ($res['interno_atual'] == 0 or $res['interno_demitidos'] == 0 or $res['interno_inicial'] == 0) {
				$internoAdmitidos = 0;
			} else {
				$internoAdmitidos = $res['interno_atual']+$res['interno_demitidos']-$res['interno_inicial'];
			}

			if (($res['interno_atual']-$res['interno_inicial']) == 0 or $res['interno_inicial'] == 0) {
				$internoEvolucao = 0;
			} else {
				$internoEvolucao = ($res['interno_atual']-$res['interno_inicial'])/$res['interno_inicial']*100;
			}

			if (($res['atual']-$res['inicial']) == 0 or $res['inicial'] == 0) {
				$evolucao = 0;
			} else {
				$evolucao = ($res['atual']-$res['inicial'])/$res['inicial']*100;
			}

			$result[$res['id_setor']] = array(
				'interno_inicial'   => number_format($res['interno_inicial'], 0),
				'interno_demitidos' => number_format($res['interno_demitidos'], 0),
				'interno_atual'     => number_format($res['interno_atual'], 0),
				'interno_admitidos' => number_format($internoAdmitidos, 0),
				'interno_evolucao'  => number_format($internoEvolucao, 0, ',', '.'),
				'inicial'           => number_format($res['inicial'], 0),
				'demitidos'         => number_format($res['demitidos'], 0),
				'atual'             => number_format($res['atual'], 0),
				'admitidos'         => number_format($res['atual']+$res['demitidos']-$res['inicial'], 0),
				'evolucao'          => number_format($evolucao, 0, ',', '.'),
			);
		}

		return $result;
	}

	function Dados() {
		$w = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100);
		$this->SetFont("Arial", "", 9);
		$this->SetTextColor(0);
		$this->SetDrawColor(1);
		$this->SetFillColor(170);

		$mes = $this->getFiltro($_REQUEST['data1'], 'mes');
		$ano = $this->getFiltro($_REQUEST['data1'], 'ano');

		$dados = $this->getDados($mes, $ano);

		$sql = "select * from setor where rh = 'SIM'";
		$qr  = mysql_query($sql) or die("Erro na consulta dos setores: ".mysql_error());

		$this->Cell(200, 5, utf8_decode('DISTRIBUIÇÃO DE INTERNOS - ').$ano, "TLR", 0, "C");
		$this->Ln();
		$this->Cell($w[4], 5, 'SETORES', "TLR", 0, "C", 1);
		$this->cell($w[2], 5, 'INICIAL', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'ADMITIDOS', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'DEMITIDOS', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'QUADRO ATUAL', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, utf8_decode('EVOLUÇÃO'), 'TRL', 0, 'C', 1);
		$this->Ln();

		$totalInternoInicial   = 0;
		$totalInternoDemitidos = 0;
		$totalInternoDemitidos = 0;
		$totalInternoAtual     = 0;

		while ($setor = mysql_fetch_assoc($qr)) {
			if ($dados[$setor['id_setor']]['interno_inicial'] != 0) {
				$this->Cell($w[4], 4, $setor['setor'], "TLR", 0, "L");
				$this->cell($w[2], 4, $dados[$setor['id_setor']]['interno_inicial'], 'TRL', 0, 'R');
				$this->cell($w[2], 4, $dados[$setor['id_setor']]['interno_admitidos'], 'TRL', 0, 'R');
				$this->cell($w[2], 4, $dados[$setor['id_setor']]['interno_demitidos'], 'TRL', 0, 'R');
				$this->cell($w[2], 4, $dados[$setor['id_setor']]['interno_atual'], 'TRL', 0, 'R');
				$this->cell($w[2], 4, $dados[$setor['id_setor']]['interno_evolucao'].' %', 'TRL', 0, 'R');
				$this->Ln();

				$totalInternoInicial   = $totalInternoInicial+$dados[$setor['id_setor']]['interno_inicial'];
				$totalInternoAdmitidos = $totalInternoAdmitidos+$dados[$setor['id_setor']]['interno_admitidos'];
				$totalInternoDemitidos = $totalInternoDemitidos+$dados[$setor['id_setor']]['interno_demitidos'];
				$totalInternoAtual     = $totalInternoAtual+$dados[$setor['id_setor']]['interno_atual'];
			}

		}
		$this->Cell($w[4], 4, 'TOTAL', "TLRB", 0, "L", 1);
		$this->cell($w[2], 4, $totalInternoInicial, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalInternoAdmitidos, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalInternoDemitidos, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalInternoAtual, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, number_format((($totalInternoAtual-$totalInternoInicial)/$totalInternoInicial)*100, 0, ',', '.')." %", 'TRLB', 0, 'R', 1);

		//$this->cell($w[2], 4, $dados[$setor['id_setor']]['interno_evolucao'].' %', 'TRL', 0, 'C');

		$this->Ln(8);
		mysql_data_seek($qr, 0);

		$this->Cell(200, 5, utf8_decode('DISTRIBUIÇÃO REGISTRADOS ATIVOS'), "TLR", 0, "C");
		$this->Ln();
		$this->Cell($w[4], 5, 'SETORES', "TLR", 0, "C", 1);
		$this->cell($w[2], 5, 'INICIAL', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'ADMITIDOS', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'DEMITIDOS', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'QUADRO ATUAL', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, utf8_decode('EVOLUÇÃO'), 'TRL', 0, 'C', 1);
		$this->Ln();

		while ($setor = mysql_fetch_assoc($qr)) {
			$this->Cell($w[4], 4, $setor['setor'], "TLR", 0, "L");
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['inicial'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['admitidos'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['demitidos'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['atual'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['evolucao'].' %', 'TRL', 0, 'R');
			$this->Ln();

			$totalInicial   = $totalInicial+$dados[$setor['id_setor']]['inicial'];
			$totalAdmitidos = $totalAdmitidos+$dados[$setor['id_setor']]['admitidos'];
			$totalDemitidos = $totalDemitidos+$dados[$setor['id_setor']]['demitidos'];
			$totalAtual     = $totalAtual+$dados[$setor['id_setor']]['atual'];
		}

		$this->Cell($w[4], 4, 'TOTAL', "TLRB", 0, "L", 1);
		$this->cell($w[2], 4, $totalInicial, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalAdmitidos, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalDemitidos, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalAtual, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, number_format((($totalAtual-$totalInicial)/$totalInicial)*100, 0, ',', '.')." %", 'TRLB', 0, 'R', 1);

		$this->AddPage();
		$this->Ln(8);

		mysql_data_seek($qr, 0);

		$this->Cell(200, 5, utf8_decode('DISTRIBUIÇÃO GERAL'), "TLR", 0, "C");
		$this->Ln();
		$this->Cell($w[4], 5, 'SETORES', "TLR", 0, "C", 1);
		$this->cell($w[2], 5, 'INICIAL', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'ADMITIDOS', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'DEMITIDOS', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, 'QUADRO ATUAL', 'TRL', 0, 'C', 1);
		$this->cell($w[2], 5, utf8_decode('EVOLUÇÃO'), 'TRL', 0, 'C', 1);
		$this->Ln();

		while ($setor = mysql_fetch_assoc($qr)) {
			$this->Cell($w[4], 4, $setor['setor'], "TLR", 0, "L");
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['inicial']+$dados[$setor['id_setor']]['interno_inicial'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['admitidos']+$dados[$setor['id_setor']]['interno_admitidos'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['demitidos']+$dados[$setor['id_setor']]['interno_demitidos'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['atual']+$dados[$setor['id_setor']]['interno_atual'], 'TRL', 0, 'R');
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['evolucao']+$dados[$setor['id_setor']]['interno_evolucao'].' %', 'TRL', 0, 'R');
			$this->Ln();

			$totalGeralInicial   = $totalGeralInicial+($dados[$setor['id_setor']]['inicial']+$dados[$setor['id_setor']]['interno_inicial']);
			$totalGeralAdmitidos = $totalGeralAdmitidos+($dados[$setor['id_setor']]['admitidos']+$dados[$setor['id_setor']]['interno_admitidos']);
			$totalGeralDemitidos = $totalGeralDemitidos+($dados[$setor['id_setor']]['demitidos']+$dados[$setor['id_setor']]['interno_demitidos']);
			$totalGeralAtual     = $totalGeralAtual+($dados[$setor['id_setor']]['atual']+$dados[$setor['id_setor']]['interno_atual']);
		}

		$this->Cell($w[4], 4, 'TOTAL', "TLRB", 0, "L", 1);
		$this->cell($w[2], 4, $totalGeralInicial, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalGeralAdmitidos, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalGeralDemitidos, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, $totalGeralAtual, 'TRLB', 0, 'R', 1);
		$this->cell($w[2], 4, number_format((($totalGeralAtual-$totalGeralInicial)/$totalGeralInicial)*100, 0, ',', '.')." %", 'TRLB', 0, 'R', 1);
		$this->Ln(8);

		$this->Cell($w[4], 5, 'REGISTRADOS ATIVOS', "TLRB", 0, "L", 1);
		$this->cell($w[2], 5, $totalAtual, 'TRLB', 0, 'R');
		$this->Ln();

		$this->Cell($w[4], 5, 'INTERNOS', "TLRB", 0, "L", 1);
		$this->cell($w[2], 5, $totalInternoAtual, 'TRLB', 0, 'R');
		$this->Ln();

		$this->Cell($w[4], 5, 'TOTAL', "TLRB", 0, "L", 1);
		$this->cell($w[2], 5, $totalGeralAtual, 'TRLB', 0, 'R');

	}
}
$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

