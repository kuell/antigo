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
		$this->Cell('', 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell('', 11, utf8_decode("MATRIZ DO BALANÇO - "), "RLB", 0, "C");
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
	function getDados($mes = 7, $ano = 2014) {
		$sql = "Select
					a.id_setor,
					a.setor,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 1) as hTrabSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 2) as hPotSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes = 6 and setor = a.id_setor and item = 7) as regAtivoSem1,
					(select sum(peso) from rh_info where ano = 2014 and mes <= 6) as abatePesoSem1,
					(select sum(fat) from rh_info where ano = 2014 and mes <= 6) as faturamentoSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <=6 and setor = a.id_setor and item in (5,4) ) as faltaAcidenteSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 6) as feriasSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 12) as remunSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 3) as hSupSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 10) as admitidoSem1,
					(select sum(valor) from rh_balanco where ano = 2014 and mes <= 6 and setor = a.id_setor and item = 10) as demitidoSem1,


					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6 and setor = a.id_setor and item = 1) as hTrabSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6 and setor = a.id_setor and item = 2) as hPotSem2,
					(select	valor from rh_balanco where	valor <> 0 and setor = a.id_setor and item = 7 and ano = 2014 order by id desc limit 1) as regAtivoSem2,
					(select sum(peso) from rh_info where ano = 2014 and mes > 6) as abatePesoSem2,
					(select sum(fat) from rh_info where ano = 2014 and mes > 6) as faturamentoSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6 and setor = a.id_setor and item in (5,4) ) as faltaAcidenteSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6 and setor = a.id_setor and item = 6) as feriasSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6 and setor = a.id_setor and item = 12) as remunSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6 and setor = a.id_setor and item = 3) as hSupSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6  and setor = a.id_setor and item = 10) as admitidoSem2,
					(select sum(valor) from rh_balanco where ano = 2014 and mes > 6  and setor = a.id_setor and item = 11) as demitidoSem2

				from
					setor a
				where
					a.rh = 1";
					
		$qr = mysql_query($sql) or die(mysql_error()."<br /> ".$sql);

		$this->SetFillColor(150);

		while ($res = mysql_fetch_assoc($qr)) {
			$result[$res['id_setor']] = array(
				'taxa_ocupacao_sem1' => number_format($res['hTrabSem1']/$res['hPotSem1']*100, 2, ',', '.')." %",
				'taxa_ocupacao_sem2' => number_format($res['hTrabSem2']/$res['hPotSem2']*100, 2, ',', '.')." %",

				'faltasAcidente_sem1' => number_format(($res['faltaAcidenteSem1']/$res['hTrabSem1']*100), 2, ',', '.').' %',
				'faltasAcidente_sem2' => number_format(($res['faltaAcidenteSem2']/$res['hTrabSem2']*100), 2, ',', '.').' %',

				'ferias_sem1' => number_format(($res['feriasSem1']/$res['hPotSem1']*100), 2, ',', '.').' %',
				'ferias_sem2' => number_format(($res['feriasSem2']/$res['hPotSem2']*100), 2, ',', '.').' %',

				'remuneracao_sem1' => number_format(($res['remunSem1']/$res['hTrabSem1']), 2, ',', '.').' %',
				'remuneracao_sem2' => number_format(($res['remunSem2']/$res['hTrabSem2']), 2, ',', '.').' %',

				'horaExtra_sem1' => number_format(($res['hSupSem1']/$res['hTrabSem1'])*100, 2, ',', '.').' %',
				'horaExtra_sem2' => number_format(($res['hSupSem2']/$res['hTrabSem2'])*100, 2, ',', '.').' %',

				'admissao_sem1' => number_format($res['admitidoSem1']/$res['regAtivoSem1']*100, 2, ',', '.').' %',
				'admissao_sem2' => number_format($res['admitidoSem2']/$res['regAtivoSem2']*100, 2, ',', '.').' %',

				'demissao_sem1' => number_format($res['demitidoSem1']/$res['regAtivoSem1']*100, 2, ',', '.').' %',
				'demissao_sem2' => number_format($res['demitidoSem2']/$res['regAtivoSem2']*100, 2, ',', '.').' %',

				'turnover_sem1' => number_format(($res['admitidoSem1']/$res['regAtivoSem1']*100)-($res['demitidoSem1']/$res['regAtivoSem1']*100), 2, ',', '.').' %',
				'turnover_sem2' => number_format(($res['admitidoSem2']/$res['regAtivoSem2']*100)-($res['demitidoSem2']/$res['regAtivoSem2']*100), 2, ',', '.').' %',

				'folhaFat_sem1' => number_format($res['remunSem1']/$res['faturamentoSem1']*100, 2, ',', '.').' %',
				'folhaFat_sem2' => number_format($res['remunSem2']/$res['faturamentoSem2']*100, 2, ',', '.').' %',

				'salario_sem1' => 'R$ '.number_format($res['remunSem1']/$res['abatePesoSem1'], 4, ',', '.'),
				'salario_sem2' => 'R$ '.number_format($res['remunSem2']/$res['abatePesoSem2'], 4, ',', '.'),

				'salarioSetor_sem1' => number_format($res['remunSem1']/$res['regAtivoSem1']/6, 2, ',', '.'),
				'salarioSetor_sem2' => number_format($res['remunSem2']/$res['regAtivoSem2']/(8-6), 2, ',', '.'),

			);
		}

		return $result;
	}

	function Dados() {
		$w = array(10, 20, 22, 40, 50, 60, 70, 80, 90, 100);
		$this->SetFont("Arial", "", 8);
		$this->SetTextColor(0);
		$this->SetDrawColor(1);
		$this->SetFillColor(200);

		$dados = $this->getDados();

		$sql = "select * from setor where rh = 'SIM' order by setor";
		$qr  = mysql_query($sql) or die("Erro na consulta dos setores: ".mysql_error());

		while ($setor = mysql_fetch_assoc($qr)) {
			$this->Cell($w[4], 5, $setor['setor'], "TLR", 0, "L");
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['taxa_ocupacao_sem2'], 'TL', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['faltasAcidente_sem2'], 'T', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['ferias_sem2'], 'T', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['remuneracao_sem2'], 'T', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['horaExtra_sem2'], 'TR', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['admissao_sem2'], 'TL', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['demissao_sem2'], 'T', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['turnover_sem2'], 'TR', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['folhaFat_sem2'], 'TL', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['salario_sem2'], 'T', 0, 'R');
			$this->cell($w[2], 5, $dados[$setor['id_setor']]['salarioSetor_sem2'], 'TR', 0, 'R');
			$this->Ln();

			$this->Cell($w[4], 4, utf8_decode('1º SEMESTRE 2014'), "LBR", 0, "L", 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['taxa_ocupacao_sem1'], 'LB', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['faltasAcidente_sem1'], 'B', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['ferias_sem1'], 'RB', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['remuneracao_sem1'], 'B', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['horaExtra_sem1'], 'RB', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['admissao_sem1'], 'LB', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['demissao_sem1'], 'B', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['turnover_sem1'], 'RB', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['folhaFat_sem1'], 'LB', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['salario_sem1'], 'B', 0, 'R', 1);
			$this->cell($w[2], 4, $dados[$setor['id_setor']]['salarioSetor_sem1'], 'BR', 0, 'R', 1);

			$this->Ln();
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