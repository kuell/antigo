<?php
error_reporting(0);
require_once ("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
$cData = strftime("%d/%m/%Y");
require ("../../bibliotecas/fpdf/fpdf.php");

define("mes", date('m', strtotime($_REQUEST['data'])));
define('ano', date('Y', strtotime($_REQUEST['data'])));

class PDF extends FPDF {

	function Header() {
		date_default_timezone_set("Brazil/East");
		define('hora', date("H")-1);
		//      $this->Image("../../logo/Logo.JPG",13,13,35,15,"JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(149, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(149, 11, utf8_decode("Relatorio Geral do Balanço RH Ref: ".mes.'/'.ano), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->SetDrawColor(200);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'), 0, 0, "C");
	}

	function Dados() {
		$sqlAbate = "select sum(qtd) as qtd,
							sum(peso) as peso,
							sum(fat) as fat
					from rh_info
					where mes = '".mes."' and
						  ano = '".ano."'";

		$qrAbate = mysql_query($sqlAbate) or die(mysql_error());
		$Abate   = mysql_fetch_assoc($qrAbate);

		define("qtdAbate", $Abate['qtd']);
		define("pesoAbate", $Abate['peso']);
		define("faturamento", $Abate['fat']);

		// SETOR
		$fundo = 0;

		$this->SetFont('Arial', 'I', 9);
		$this->SetFillColor(180);
		$this->SetDrawColor(230);
		$this->SetFillColor(200);
		$this->Cell(190, 5, 'RESUMO GERAL', 1, 0, 'C', 1);
		$this->Ln(7);

		$sqlItem = "select * from rh_item where por_setor = 1";
		$qrItem  = mysql_query($sqlItem) or die(mysql_error());
		$w       = array(120, 20);
		$this->SetFont("Arial", "B", 9);
		//ITEM

		//Informações Gerais
		$this->SetFillColor(230);
		$this->Cell(190, 4, utf8_decode('INDICADORES GERAIS'), 1, 0, 'C', 1);
		$this->Ln();
		$this->SetFillColor(249);
		$this->Cell($w[0], 5, 'Qtd. Abate', 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format(qtdAbate, 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, 'Peso Abate', 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format(pesoAbate, 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		$this->Cell($w[0], 5, 'Faturamento Bruto', 'LBT', 0, 'L', 1);
		$this->Cell($w[1], 5, number_format(faturamento, 2, ',', '.'), 'RBT', 0, 'R', 1);
		$this->Ln();
		while ($item = mysql_fetch_assoc($qrItem)) {
			$this->SetFont("Arial", "I", 9);
			$this->Cell($w[0], 5, utf8_decode($item['descricao']), 'LBT', 0, 'L', 0);

			$sqlValor = "
						Select
							sum(valor) as valor
						from
							rh_balanco
						where
							mes = '".mes."' and
							ano = '".ano."' and
							item = '".$item['id']."'
				";

			$qrValor = mysql_query($sqlValor) or die('Erro 01'.mysql_error());
			//VALOR
			$valor = mysql_fetch_assoc($qrValor);
			if ($valor['valor'] == "") {
				$this->Cell($w[1], 5, "0,00", 'RBT', 0, 'R', 0);
			} else {
				$this->Cell($w[1], 5, number_format($valor['valor'], 2, ',', '.'), 'RBT', 0, 'R', 0);
			}
			$this->Ln();
		}
		$this->Ln(5);

		$sqlConta = "
						Select
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '1') as htrab,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '2') as hpot,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '3') as hsup,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '4') as falta,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '5') as acid_afast,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '6') as ferias,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '7') as fun_reg,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '8') as fun_reg_temp,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '9') as prest_serv,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '10') as admitido,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '11') as demitido,
							(select sum(valor) from rh_balanco where mes = '".mes."' and ano = '".ano."'  and item = '12') as rem_br
						from
								rh_balanco	";

		$qrConta = mysql_query($sqlConta) or die('Erro 02 '.$sqlConta.'<br><br><br><br>'.mysql_error());
		############# -----Indicadores Temporais -----#############
		$this->SetFont("Arial", "B", 9);
		$this->SetFillColor(230);
		$this->Cell(190, 5, utf8_decode('INDICADORES TEMPORAIS'), 1, 0, 'C', 1);
		$this->SetFont("Arial", "I", 9);
		$this->SetFillColor(249);
		$val = mysql_fetch_assoc($qrConta);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE OCUPAÇÃO DE HORAS'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($val['htrab']/$val['hpot']*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TX. DE DESOCUPAÇÃO DE HRAS'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format((($val['hpot']-$val['htrab'])/$val['hpot'])*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('FALTAS'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format(($val['falta']/$val['htrab'])*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$falta = ($val['falta']/$val['htrab'])*100;

		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('ACIDENTENTES E AFASTAMENTOS'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($val['acid_afast']/$val['hpot']*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$acid_afast = $val['acid_afast']/$val['hpot']*100;
		$this->Ln();

		$this->Cell($w[0], 5, utf8_decode('FÉRIAS'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($val['ferias']/$val['hpot']*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$ferias = $val['ferias']/$val['hpot']*100;
		$this->Ln(5);
		$this->Cell($w[0], 5, utf8_decode('ABSENTEISMO TOTAL'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format(($ferias+$falta+$acid_afast), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE SUBSTITUIÇÃO DO ABSENTEISMO'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format(('à fazer'), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE REMUNERAÇÂO HORA'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, 'R$ '.number_format($val['rem_br']/$val['htrab'], 2, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE HORAS SUPLEMENTARES'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format(($val['hsup']/$val['htrab'])*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln(10);

		############# -----Indicadores dimensionais -----#############
		$this->SetFont("Arial", "B", 9);
		$this->SetFillColor(230);
		$this->Cell(190, 5, utf8_decode('INDICADORES DIMENSIONAIS'), 1, 0, 'C', 1);
		$this->SetFont("Arial", "I", 9);
		$this->SetFillColor(249);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE ADMISSÂO'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format($val['admitido']*100/$val['fun_reg'], 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE DEMISSÃO'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format(($val['demitido']*100/$val['fun_reg']), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA DE REPOSIÇÃO'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format((($val['admitido']-$val['demitido'])*100/$val['fun_reg']), 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln(10);

		############# -----Indicadores de produtividade -----#############
		$this->SetFont("Arial", "B", 9);
		$this->SetFillColor(230);
		$this->Cell(190, 5, utf8_decode('INDICADORES DE PRODUTIVIDADE'), 1, 0, 'C', 1);
		$this->SetFillColor(249);
		$this->SetFont("Arial", "I", 9);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('TAXA FOLHA/FATURAMENTO'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, number_format(($val['rem_br']/faturamento)*100, 2, ',', '.').' %', 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('SALARIO POR KG'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, 'R$ '.number_format(($val['rem_br']/pesoAbate), 5, ',', '.'), 'RBT', 0, 'R', 0);
		$this->Ln();
		$this->Cell($w[0], 5, utf8_decode('SALARIO MEDIO POR SETOR'), 'LBT', 0, 'L', 0);
		$this->Cell($w[1], 5, 'R$ '.number_format($val['rem_br']/($val['fun_reg']+$val['fun_reg_temp']+$val['prest_serv']), 2, ',', '.'), 'RBT', 0, 'R', 0);

		$this->Ln();

	}
}
$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>
