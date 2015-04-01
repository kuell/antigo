<?php

require "../../Connections/conect_mysqli.php";
require "../../Connections/connect_pgsql.php";
require '../../class/CustoProducao.class.php';
require '../../class/Interno.class.php';
require '../../class/Abate.class.php';
require '../../class/Setor.class.php';
require '../../rh/class/Produtividade.class.php';
require '../../rh/class/Balanco.class.php';
require '../../industria/class/IndProducao.class.php';
require '../../industria/class/Faturamento.class.php';
require '../../class/Taxa.class.php';
require '../../almox/class/Almoxarifado.class.php';

require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {
	function Header() {

		$d   = explode('/', $_GET['data1']);
		$mes = $d[1];
		$ano = $d[2];

		$this->Image("../../logo/Logo.jpg", 6, 5, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(250, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(250, 11, "Relatorio de Apuração de custos de produção ref: ".$mes.'/'.$ano, "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}
	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->Cell(0, 3, utf8_decode("PÃ¡gina ").$this->PageNo()."/{nb} \ Processado em ", 0, 0, "C");
	}

	function Dados() {

		$this->SetFont("Arial", "", 7.5);
		$this->SetFillColor(100);
		$this->SetTextColor(250);
		$this->SetDrawColor(230);

		$col = array(15, 17, 20, 22, 30);
		$ln  = array(5);

		$this->Cell($col[1], $ln[0], "Dia", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Peso Abate", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Kg Produzido", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Rendimento", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Preço Medio", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Kg medio/anim.", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Kg prod/anim.", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Rend/animal", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Prod. Corr", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Custo Comerc.", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Taxa", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Energia", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Oleo Diesel", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "RH", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Almoxarifado", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Serviços", "RLB", 0, "C", 1);
		$this->Cell($col[1], $ln[0], "Custo Total", "RLB", 0, "C", 1);
		$this->Ln();

		$this->SetFillColor(210);
		$this->SetTextColor(0);

		$dt        = explode('/', $_GET['data1']);
		$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $dt[1], $dt[2]);

		$d         = implode('-', array_reverse(explode('/', $_GET['data1'])));

		$custo = new CustoProducao($d, $d);
		$custo->apuracaoDiaria();

		for ($i = 1; $i <= $ultimoDia; $i++) {
			$d    = explode('/', $_GET['data1']);
			$data = date('Y-m-d', strtotime($d[2].'-'.$d[1].'-'.$i));

			## Verifica se dia da semana é domingo
			$diaSemana = date('w', strtotime($data));

			if ($diaSemana == 0) {
				$this->SetFillColor(210, 250, 201);
				$f = 1;
			} else {
				$this->SetFillColor(210);
				$f = 0;
			}
			##

			//print_r($custo);
			//die;

			$this->Cell($col[1], $ln[0], date('d/m/Y', strtotime($data)), "RLB", 0, "C", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->abate->peso[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->pesoProduzido[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->rendimento[$data], 4, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->valorMedio[$data], 4, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->pesoMedioPorAnimal[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->pesoMedioProduzidoPorAnimal[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->valorMedioPorAnimal[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->producao->vpc[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->faturamento->custoComercial[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->taxa->taxa[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->almox->energia[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->almox->oleoDiesel[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->rh->rh[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->almox->custo[$data], 2, ',', '.'), "RLB", 0, "R", $f);
			$this->Cell($col[1], $ln[0], number_format($custo->almox->servicos[$data], 2, ',', '.'), "RLB", 0, "R", $f);

			$custoTotal = $custo->almox->servicos[$data]+$custo->almox->custo[$data]+$custo->rh->rh[$data]+$custo->almox->oleoDiesel[$data]+$custo->almox->energia[$data]+$custo->taxa->taxa[$data];

			$this->Cell($col[1], $ln[0], number_format($custoTotal, 2, ',', '.'), "RLB", 0, "R", $f);

			$this->Ln();
		}

		/*
		$diaSemana = date('w', strtotime($data));
		if ($diaSemana == 0) {
		$this->SetFillColor(210, 250);
		$f = 1;
		} else {
		$this->SetFillColor(210);
		$f = 0;
		}


		$this->Cell($col[1], $ln[0], date('d/m/Y', strtotime($data)), "RLB", 0, "C", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['pesoAbate'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['producao'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['rendimento'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['precoMedio'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['kgAnimal'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['kgProdAnimal'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['valAnimal'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['fatTotal'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['custoComercial'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($this->taxa($data, $data), 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($energia[$data], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['oleo'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($custoRH[$data], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['almox'], 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Cell($col[1], $ln[0], number_format($result[$data]['servico'], 2, ',', '.'), "RLB", 0, "R", $f);
		$totalDia = $result[$data]['servico']+$result[$data]['almox']+$custoRH[$data]+$result[$data]['oleo']+$energia[$data]+$this->taxa($data, $data);
		$this->Cell($col[1], $ln[0], number_format($totalDia, 2, ',', '.'), "RLB", 0, "R", $f);
		$this->Ln();
		$qtdAbate  = $result[$data]['qtdAbate']+$qtdAbate;
		$pesoAbate = $result[$data]['pesoAbate']+$pesoAbate;
		$producao  = $result[$data]['producao']+$producao;
		$fatTotal  = $result[$data]['fatTotal']+$fatTotal;
		$custoC    = $custoC+$result[$data]['custoComercial'];
		$taxa      = $taxa+$this->taxa($data, $data);
		$energ     = $energ+$energia[$data];
		$oleo      = $oleo+$result[$data]['oleo'];
		$rh        = $rh+$custoRH[$data];
		$almx      = $almx+$result[$data]['almox'];
		$servico   = $servico+$result[$data]['servico'];
		$total     = $total+$totalDia;
		 */

		/*
	$this->SetFillColor(200, 200, 200);
	$f = 1;
	$this->Cell($col[1], $ln[0], "TOTAIS", "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format($pesoAbate, 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format($producao, 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format(($producao/$pesoAbate)*100, 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format(($fatTotal/$producao), 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format(($pesoAbate/$qtdAbate), 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format((($pesoAbate/$qtdAbate)*($producao/$pesoAbate)), 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format((($pesoAbate/$qtdAbate)*($producao/$pesoAbate))*($fatTotal/$producao), 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format($fatTotal, 2, ',', '.'), "RLB", 0, "C", $f);
	$this->Cell($col[1], $ln[0], number_format($custoC, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($taxa, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($energ, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($oleo, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($rh, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($almx, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($servico, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Cell($col[1], $ln[0], number_format($total, 2, ',', '.'), "RLB", 0, "R", $f);
	$this->Ln(3);
	 */
	}
}
$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();

?>

