<?php

require_once 'class/TaxaItem.class.php';
require_once '../cadastros/core/Corretor.php';
require_once '../conf/Relatorio.class.php';

class Rel extends Relatorio {
	public function Header() {
		parent::Header();
	}

	function inf($where = "") {
		$taxa = new TaxaItem();
		$sql  = "SELECT
                    a.id as id,
                    a.`descricao` as item,
                    a.`fiscal` as fiscal,
                    b.`tipo` as tipo,
                    c.`descricao` as grupo,
                    sum(b.`qtd`) as qtd,
                    sum(b.`peso`) as peso,
                    sum(b.`valor`) as valor
                from
                    `taxa_item` a
                    inner join `taxaitens` b on(a.`id` = b.`idItem`)
                    inner join `taxa_grupo` c on(a.`grupo` = c.`id`)
                    inner join `taxa` d on(d.`id` = b.`idTaxa`)
                where
                    1=1 $where
                GROUP BY
                        a.`id`, b.tipo
                ORDER BY
                     c.id,   a.descricao";

		$res = $taxa->RunSelect($sql);

		$rs = array();

		foreach ($res as $key) {
			$rs[$key['grupo']][$key['item']][$key['tipo']] = array(
				"qtd"    => $key['qtd'],
				"peso"   => $key['peso'],
				"valor"  => $key['valor'],
				"fiscal" => $key['fiscal'],
			);
		}

		return $rs;
	}

	function data($data) {
		$d = explode("/", $data);
		return $d[2]."-".$d[1]."-".$d[0];
	}

	function Dados() {

		$corretor = new Corretor();

		if (isset($_GET['cor']) && $_GET['cor'] != 0) {
			$where  = " and cor_id = ".$_GET['cor'];
			$filtro = " and d.corretor=".$_GET['cor'];
			$cor    = $corretor->select($where);
		} else {
			$cor[0]['cor_cod']  = "";
			$cor[0]['cor_nome'] = "ACUMULADO";
			$filtro             = "";
		}

		$this->Cell(95, 5, "Corretor: ".$cor[0]['cor_cod'], 'TL', 0, "L", 0);
		$this->Cell(95, 5, "Periodo: ".$_GET['datai']." ate ".$_GET['dataf'], 'TR', 0, "L", 0);
		$this->Ln();
		$this->Cell(95, 5, "Nome: ".$cor[0]['cor_nome'], "BL", 0, "L", 0);
		$this->Cell(95, 5, "", "BR", 0, "L", 0);
		$this->Ln(8);

		$filtro .= " and d.data between '".$this->data($_GET['datai'])."' and '".$this->data($_GET['dataf'])."'";

		$res = $this->inf($filtro);

		$w = array(70, 35, 35, 50, 25);

		$totalFiscal = 0;
		$totalTaxa   = 0;

		foreach ($res as $grupo => $val) {

			$this->SetFont("helvetica", "", "10");
			$this->SetFillColor(150, 150, 150);
			$this->SetDrawColor(0, 0, 0);

			$this->Cell(0, 6, " ::: ".$grupo." ::: ", 1, 0, "C", 1);
			$this->Ln(6);

			$this->SetFillColor(200, 200, 200);

			switch ($grupo) {
				case "TAXA":
					$this->Cell($w[0], 5, "DESCRIÇÃO", 1, 0, "L", 1);
					$this->Cell($w[1], 5, "QUANTIDADE", 1, 0, "C", 1);
					$this->Cell($w[2], 5, "PESO", 1, 0, "C", 1);
					$this->Cell($w[3], 5, "VALOR", 1, 0, "C", 1);
					$this->Ln();

					$tQtd  = 0;
					$tPeso = 0;
					$tVal  = 0;

					foreach ($res[$grupo] as $item => $v) {
						$this->Cell($w[0], 5, $item, 1, 0, "L", 0);
						$qtd   = 0;
						$valor = 0;
						$peso  = 0;
						foreach ($v as $x) {
							$qtd   = $x['qtd']+$qtd;
							$peso  = $x['peso']+$peso;
							$valor = $x['valor']+$valor;
						}
						$tPeso = $peso+$tPeso;
						$tVal  = $tVal+$valor;
						$tQtd  = $qtd+$tQtd;

						$this->Cell($w[1], 5, number_format($qtd, 0, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[2], 5, number_format($peso, 2, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[3], 5, number_format($valor, 2, ',', '.'), 1, 0, "R", 0);
						$this->Ln();
					}
					$totalTaxa = $tVal;
					$this->Cell($w[0], 6, "TOTAL", 1, 0, "R", 1);
					$this->Cell($w[1], 6, number_format($tQtd, 0, ',', '.'), 1, 0, "R", 1);
					$this->Cell($w[2], 6, number_format($tPeso, 2, ',', '.'), 1, 0, "R", 1);
					$this->Cell($w[3], 6, number_format($tVal, 2, ',', '.'), 1, 0, "R", 1);
					break;

				case "ITEM":
					$this->Cell($w[0], 5, "DESCRIÇÃO", 1, 0, "L", 1);
					$this->Cell($w[1], 5, "QUANTIDADE", 1, 0, "C", 1);
					$this->Cell($w[2], 5, "PESO", 1, 0, "C", 1);
					$this->Cell($w[4], 5, "RECEBER", 1, 0, "C", 1);
					$this->Cell($w[4], 5, "PAGAR", 1, 0, "C", 1);
					$this->Ln();

					$tValor['c'] = 0;
					$tValor['d'] = 0;

					$this->SetFont('Arial', '', '8');

					foreach ($res[$grupo] as $item => $v) {
						$this->Cell($w[0], 5, $item, 1, 0, "L", 0);
						$qtd  = 0;
						$peso = 0;
						foreach ($v as $x) {
							if ($x['fiscal'] == "SIM") {
								$totalFiscal = $x['peso']+$totalFiscal;
							}
							$qtd  = $x['qtd']+$qtd;
							$peso = $x['peso']+$peso;
						}
						empty($v['c']['valor'])?$v['c']['valor'] = 0:$v['c']['valor'] = $v['c']['valor'];
						empty($v['d']['valor'])?$v['d']['valor'] = 0:$v['d']['valor'] = $v['d']['valor'];

						$tValor['c'] = $v['c']['valor']+$tValor['c'];
						$tValor['d'] = $v['d']['valor']+$tValor['d'];

						$this->Cell($w[1], 5, number_format($qtd, 0, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[2], 5, number_format($peso, 2, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[4], 5, "R$ ".number_format($v['d']['valor'], 2, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[4], 5, "R$ ".number_format($v['c']['valor'], 2, ',', '.'), 1, 0, "R", 0);
						$this->Ln();
					}

					$this->Cell(140, 5, "TOTAL", "BT", 0, "R", 1);
					$this->Cell($w[4], 5, "R$ ".number_format($tValor['d'], 2, ',', '.'), "BTLR", 0, "R", 1);
					$this->Cell($w[4], 5, "R$ ".number_format($tValor['c'], 2, ',', '.'), "BTLR", 0, "R", 1);
					break;

				case "ROMANEIO":
					$this->Cell($w[0], 5, "DESCRIÇÃO", 1, 0, "L", 1);
					$this->Cell($w[1], 5, "QUANTIDADE", 1, 0, "C", 1);
					$this->Cell($w[2], 5, "PESO", 1, 0, "C", 1);
					$this->Cell($w[3], 5, "SALDO FISCAL", 1, 0, "C", 1);
					$this->Ln();

					$tQtd  = 0;
					$tPeso = 0;

					foreach ($res[$grupo] as $item => $v) {
						$this->Cell($w[0], 5, $item, 1, 0, "L", 0);
						$qtd  = 0;
						$peso = 0;
						foreach ($v as $x) {
							$qtd  = $x['qtd']+$qtd;
							$peso = $x['peso']+$peso;
						}

						$tQtd  = $qtd+$tQtd;
						$tPeso = $peso+$tPeso;

						$this->Cell($w[1], 5, number_format($qtd, 0, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[2], 5, number_format($peso, 2, ',', '.'), 1, 0, "R", 0);
						$this->Cell($w[3], 5, "-", 1, 0, "C", 0);
						$this->Ln();
					}
					$this->Cell($w[0], 6, "TOTAL", 1, 0, "L", 1);
					$this->Cell($w[1], 6, number_format($tQtd, 2, ',', '.'), 1, 0, "R", 1);
					$this->Cell($w[2], 6, number_format($tPeso, 2, ',', '.'), 1, 0, "R", 1);
					$this->Cell($w[3], 6, number_format($totalFiscal-$tPeso, 2, ',', '.'), 1, 0, "R", 1);
					break;
			}
			$this->Ln(7);
		}
		$this->Ln();
		$this->Cell($w[0], 5, "::: RESUMO :::", "BT", 0, "C", 1);
		$this->Ln();
		$this->Cell($w[1], 5, "TOTAL A RECEBER", "BT", 0, "L", 0);
		$this->Cell($w[1], 5, "R$ ".number_format($tValor['d'], 2, ',', '.'), "BT", 0, "R", 0);
		$this->Ln();
		$this->Cell($w[1], 5, "TOTAL A PAGAR", "BT", 0, "L", 0);
		$this->Cell($w[1], 5, "R$ ".number_format($tValor['c']+$totalTaxa, 2, ',', '.'), "BT", 0, "R", 0);
		$this->Ln();
		$this->Cell($w[1], 5, "SALDO", "BT", 0, "L", 1);
		$this->Cell($w[1], 5, "R$ ".number_format(($tValor['d']-($tValor['c']+$totalTaxa)), 2, ',', '.'), "BT", 0, "R", 1);
	}

	public function Footer() {
		parent::Footer();
	}

}
$pdf = new Rel("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();

?>
