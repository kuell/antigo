<?php
error_reporting(0);
require_once ("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
require ("../../bibliotecas/fpdf/fpdf.php");

define("datai", date('Y-m-d', strtotime($_REQUEST['data1'])));
define("dataf", date('Y-m-d', strtotime($_REQUEST['data2'])));

class PDF extends FPDF {

	function Header() {
		date_default_timezone_set("Brazil/East");
		define('hora', date("H")-1);
		//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(163, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(163, 11, "Relatorio de Produção Industrial  Referente a: ".date('d/m/Y', strtotime(datai))." até ".date('d/m/Y', strtotime(dataf)), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 6);
		$this->Cell(0, 4, utf8_decode("Página ").$this->PageNo()."/{nb} - Processado em ".date('d-m-Y '.hora.':i'), 0, 0, "C");
	}
	function abate($datai, $dataf) {
		$sql = "Select
					AbateBoiQtd('".$datai."','".$dataf."') as qtdBoi,
					AbateVacaQtd('".$datai."','".$dataf."') as qtdVaca,
					AbateBoiPeso('".$datai."','".$dataf."') as pesoBoi,
					AbateVacaPeso('".$datai."','".$dataf."') as pesoVaca";

		$qr = mysql_query($sql) or die(mysql_error());

		return mysql_fetch_object($qr);
	}

	function inf($datai, $dataf) {
		$sql = "Select
					b.cod,
					b.descricao as produto,
					sum(a.peca) as peca,
					sum(a.qtd) as qtd,
					sum(a.peso) as peso,
					f_fat_valor_unitario('".$datai."', '".$dataf."', b.cod) as valor_unitario,
					b.tipo as tipo
				from
					ind_producao a
					inner join ind_produtos b on ( a.produto = b.cod )
				where
					a.data_producao between '".$datai."' and '".$dataf."' and
					b.ativo = 1
				group by
					b.id
				order by
					b.tipo, b.descricao";

		$qr = mysql_query($sql) or die(mysql_error());
		while ($r = mysql_fetch_assoc($qr)) {
			$result[$r['tipo']][] = $r;
		}
		return $result;

	}

	function Dados() {
		$info  = $this->inf(datai, dataf);
		$abate = $this->abate(datai, dataf);

		$col = array(10, 55, 20);

		foreach ($info as $res => $val) {
			$totalPeca = 0;
			$totalQtd  = 0;
			$totalPeso = 0;
			$totalFat  = 0;

			$this->SetFont('Arial', 'I', 6);
			$this->SetFillColor(170);
			$this->SetDrawColor(220);

			$this->Cell($col[0], 4, '', "C", 0);
			$this->Cell(175, 4, $res, "BTLR", 0, "C", 0);
			$this->Ln();
			$this->Cell($col[0], 4, '', "C", 0);
			$this->Cell($col[1], 4, "COD - PRODUTO", "BTLR", 0, "C", 1);
			$this->Cell($col[2], 4, "PEÇA", "BLTR", 0, "C", 1);
			$this->Cell($col[2], 4, "QUANTIDADE", "BLTR", 0, "C", 1);
			$this->Cell($col[2], 4, "PESO", "BLTR", 0, "C", 1);
			$this->Cell($col[2], 4, "RENDIMENTO", "BLTR", 0, "C", 1);
			$this->Cell($col[2], 4, "VALOR UNITARIO", "BTLR", 0, "C", 1);
			$this->Cell($col[2], 4, "VALOR TOTAL", "BLTR", 0, "C", 1);
			$this->Ln();

			$fundo = 0;

			$this->SetFillColor(225);

			foreach ($val as $res) {
				$this->Cell($col[0], 3, "", 0, "C", 0);
				$this->Cell($col[1], 3, utf8_decode($res['cod']." - ".$res['produto']), 0, 0, "L", $fundo);
				$this->Cell($col[2], 3, number_format($res['peca'], 2, ',', '.'), 0, 0, "R", $fundo);
				$this->Cell($col[2], 3, number_format($res['qtd'], 2, ',', '.'), 0, 0, "R", $fundo);
				$this->Cell($col[2], 3, number_format($res['peso'], 2, ',', '.'), 0, 0, "R", $fundo);
				$this->Cell($col[2], 3, number_format(($res['peso']*100/($abate->pesoBoi+$abate->pesoVaca)), 4, ',', '.').' %', 0, 0, "R", $fundo);
				$this->Cell($col[2], 3, $res['valor_unitario'], 0, 0, "R", $fundo);

				//$this->Cell($col[2],3,'R$ '.number_format($res['valor_unitario'],4,',','.'),0,0,"R",$fundo);
				$this->Cell($col[2], 3, 'R$ '.number_format($res['valor_unitario']*$res['peso'], 2, ',', '.'), 0, 0, "R", $fundo);
				$this->Ln();
				$fundo = !$fundo;

				$totalPeca = $res['peca']+$totalPeca;
				$totalQtd  = $res['qtd']+$totalQtd;
				$totalPeso = $res['peso']+$totalPeso;
				$totalFat  = ($res['valor_unitario']*$res['peso'])+$totalFat;
			}

			$this->SetFillColor(190);
			$this->Cell($col[0], 4, '', 0, 0, "R", 0);
			$this->Cell($col[1], 4, 'TOTAL', 0, 0, "R", 1);
			$this->Cell($col[2], 4, number_format($totalPeca, 2, ',', '.'), 0, 0, "R", 1);
			$this->Cell($col[2], 4, number_format($totalQtd, 2, ',', '.'), 0, 0, "R", 1);
			$this->Cell($col[2], 4, number_format($totalPeso, 2, ',', '.'), 0, 0, "R", 1);
			$this->Cell($col[2], 4, number_format(($totalPeso*100/($abate->pesoBoi+$abate->pesoVaca)), 4, ',', '.').' %', 0, 0, "R", 1);
			$this->Cell($col[2], 4, '', 0, 0, "R", 1);
			$this->Cell($col[2], 4, 'R$ '.number_format($totalFat, 2, ',', '.'), 0, 0, "R", 1);
			$this->Ln(9);

			$totalProduzido = $totalPeso+$totalProduzido;
			$totalFaturado  = $totalFat+$totalFaturado;

		}

		$this->SetDrawColor(150);
		$rendimento          = ($totalProduzido*100/($abate->pesoBoi+$abate->pesoVaca));
		$precoMedio          = $totalFaturado/$totalProduzido;
		$pesoMedioAnimal     = (($abate->pesoBoi+$abate->pesoVaca)/($abate->qtdBoi+$abate->qtdVaca));
		$pesoMedioProdAnimal = ($pesoMedioAnimal*$rendimento)/100;
		$rendimentoPorAnimal = ($pesoMedioProdAnimal*$precoMedio);

		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'TOTAIS', 0, 0, "C", 1);
		$this->Cell($col[2], 4, 'QUANTIDADE', 0, 0, "C", 1);
		$this->Cell($col[2], 4, 'PESO', 0, 0, "C", 1);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, "TOTAL BOI", 'LBTR', 0, "L", 0);
		$this->Cell($col[2], 4, number_format($abate->qtdBoi, 0, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Cell($col[2], 4, number_format($abate->pesoBoi, 2, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, "TOTAL VACA", 'LBTR', 0, "L", 0);
		$this->Cell($col[2], 4, number_format($abate->qtdVaca, 0, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Cell($col[2], 4, number_format($abate->pesoVaca, 2, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, "TOTAL ABATIDO", 'LBTR', 0, "L", 1);
		$this->Cell($col[2], 4, number_format($abate->qtdBoi+$abate->qtdVaca, 0, ',', '.'), 'LBTR', 0, "R", 1);
		$this->Cell($col[2], 4, number_format($abate->pesoVaca+$abate->pesoBoi, 2, ',', '.'), 'LBTR', 0, "R", 1);

		$this->Ln(7);
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'TOTAL PRODUZIDO KG', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, number_format($totalProduzido, 2, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'RENDIMENTO', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, number_format($rendimento, 4, ',', '.').' %', 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'PREÇO MEDIO', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, 'R$ '.number_format($precoMedio, 4, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'KM MEDIO POR ANIMAL', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, number_format($pesoMedioAnimal, 2, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'KG MEDIO PORDUZIDO POR ANIMAL', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, number_format($pesoMedioProdAnimal, 2, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'RENDIMENTO POR ANIMAL', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, 'R$ '.number_format($rendimentoPorAnimal, 2, ',', '.'), 'LBTR', 0, "R", 0);
		$this->Ln();
		$this->Cell($col[0], 4, '', 0, 0, "R", 0);
		$this->Cell($col[1], 4, 'FATURAMENTO TOTAL', 'LTBR', 0, "L", 1);
		$this->Cell($col[1], 4, 'R$ '.number_format($totalFaturado, 2, ',', '.'), 'LBTR', 0, "R", 0);

	}
}
$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

