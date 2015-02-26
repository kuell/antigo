<?php
error_reporting(0);
require_once ("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
$cData = strftime("%d/%m/%Y");
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {

	function Header() {
		//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(163, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(163, 11, utf8_decode("Relatorio de Apuração de custos de produção ref: ").$_GET['data1']." / ".$_GET['data2'], "RLB", 0, "C");
		$this->Ln(13);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-10);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 3.5, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'), 0, 0, "C");
	}

	function getValorUnitario($datai, $dataf) {
		$sql = "Select
					a.*,
					sum(b.peso) as peso,
					coalesce(f_fat_valor_unitario('$datai','$dataf',a.cod),`f_ind_valor_unit`(b.produto, '$dataf')) as valor_unitario
				from
					ind_produtos a
					inner join ind_producao b on(a.cod = b.produto)
				where
					a.ativo = 1 and
					b.data_producao between '$datai' and '$dataf'
				group by
					a.cod
				order by
					a.descricao";

		//$sql = "Select
		//			a.*,
		//			sum(b.peso) as peso,
		//			coalesce(f_fat_valor_unitario('$datai','$dataf',a.cod),0) as valor_unitario
		//		from
		//			ind_produtos a
		//			inner join ind_producao b on(a.cod = b.produto)
		//		where
		//			a.ativo = 1 and
		//			b.data_producao between '$datai' and '$dataf'
		//		group by
		//			a.cod
		//		order by
		//			a.descricao";

		$qr    = mysql_query($sql);
		$total = 0;
		while ($rs = mysql_fetch_assoc($qr)) {
			$total = ($rs['valor_unitario']*$rs['peso'])+$total;
		}
		return $total;

	}

	function Dados() {
		########		RESULTADOS INDUSTRIAIS		########

		$dataI = date("Y-m-d", strtotime($_GET["data1"]));
		$dataF = date("Y-m-d", strtotime($_GET["data2"]));

		$col = array(70, 30);

		$sql = "select
                        `AbateQtd`('$dataI', '$dataF') as qtdAbate,
                        `AbatePeso`('$dataI', '$dataF') as pesoAbate,

                        `ProdKg`('$dataI', '$dataF') as KgProd,
                         ((`ProdKg`('$dataI', '$dataF')*100)/`AbatePeso`('$dataI', '$dataF')) as rendimento,

                        (`AbatePeso`('$dataI', '$dataF') / `AbateQtd`('$dataI', '$dataF')) as kgAnimal,
                          ((`AbatePeso`('$dataI', '$dataF') / `AbateQtd`('$dataI', '$dataF'))*
                          ((`ProdKg`('$dataI', '$dataF')*100)/`AbatePeso`('$dataI', '$dataF'))/100) as prodAnimal,

                            `Taxa`('$dataI', '$dataF') as taxa,

                            `CustoComercial`('$dataI', '$dataF') as custoComercial";

		$qr = mysql_query($sql) or die(mysql_error());

		$res = mysql_fetch_assoc($qr);
		//Gambiarra
		$res['valProd']     = $this->getValorUnitario($dataI, $dataF);
		$res['precoMedio']  = $this->getValorUnitario($dataI, $dataF)/$res['KgProd'];
		$res['valorAnimal'] = (($res['pesoAbate']/$res['qtdAbate'])*($res['KgProd']*100)/$res['pesoAbate']/100)*$res['precoMedio'];
		//Gabiarra

		$this->SetFont("times", "", 7);
		$this->SetFillColor(200);
		$this->SetDrawColor(230);

		$this->Cell($col[0], 3.5, "QTD. ABATE", 0, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['qtdAbate'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, "PESO ABATE", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['pesoAbate'], 2, ',', '.'), 1, 0, "R");
		$this->Ln(5);

		$this->Cell($col[0], 3.5, "KG PRODUZIDO", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['KgProd'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, "RENDIMENTO", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['rendimento'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("PREÇO MÉDIO"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['precoMedio'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("KG MEDIO POR CABEÇA"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['kgAnimal'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("KG MEDIO PRODUZIDO POR CABEÇA"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['prodAnimal'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("VALOR MEDIO PRODUZIDO POR CABEÇA"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['valorAnimal'], 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("VALOR DA PRODUÇÃO CORRENTE"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['valProd'], 2, ',', '.'), 1, 0, "R");
		$this->Ln(5);

		$this->Cell($col[0], 3.5, "ITENS", 1, 0, "C", 1);
		$this->Cell($col[1], 3.5, "CUSTO TOTAL", 1, 0, "C", 1);
		$this->Cell($col[1], 3.5, "CUSTO UNIT. / ABATE", 1, 0, "C", 1);
		$this->Cell($col[1], 3.5, "CUSTO UNIT. / PROD.", 1, 0, "C", 1);
		$this->Ln();
		$this->Cell($col[0], 3.5, "TAXAS", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['taxa'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($res['taxa']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($res['taxa']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();
		$this->Cell($col[0], 3.5, "CUSTO COMERCIAL (FRETE/SEGURO/ICMS)", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['custoComercial'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($res['custoComercial']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($res['custoComercial']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		///////RH PRODUTIVIDADE CUSTO DIRETO
		$sqlRh = "Select
                        a.`setor`,
                        a.tipo_custo,
                        sum(c.`horas_trabalhadas`) as horaTrab,
                        `custoHoraSetor`('$dataI', '$dataF', a.id_setor) as custoHora
                    from
                        setor a
                        inner join `rh_produtividade` c on(a.`id_setor` = c.`setor`)
                    where
                            c.`data` between '$dataI' and '$dataF'
                    group by
                            a.id_setor
                    order by
                            (`custoHoraSetor`('$dataI', '$dataF', a.id_setor) * sum(c.`horas_trabalhadas`)) desc";

		$qrRh = mysql_query($sqlRh) or die('Erro no sql RH'.mysql_error().'<br>'.$sqlRh);

		$totalRH = array();

		while ($rs = mysql_fetch_object($qrRh)) {
			$rsRh[$rs->tipo_custo][$rs->setor] = $rs->horaTrab*$rs->custoHora;

			empty($totalRH[$rs->tipo_custo])?$totalRH[$rs->tipo_custo] = 0:$totalRH[$rs->tipo_custo] = $totalRH[$rs->tipo_custo];

			$totalRH[$rs->tipo_custo] = $totalRH[$rs->tipo_custo]+($rs->horaTrab*$rs->custoHora);
		}

		$this->Cell($col[0], 3.5, "M�O DE OBRA DIRETA", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($totalRH['DIRETO'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalRH['DIRETO']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalRH['DIRETO']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		foreach ($rsRh['DIRETO'] as $key => $valor) {

			$this->Cell($col[0], 3.5, utf8_decode($key), 1, 0, "L", 0);
			$this->Cell($col[1], 3.5, number_format($valor, 2, ',', '.'), 1, 0, "R", 0);
			$this->Cell($col[1], 3.5, number_format($valor/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R");
			$this->Cell($col[1], 3.5, number_format($valor/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R");
			$this->Ln();
		}
		//////////ALMOXARIFADO CUSTO DIRETO
		$sqlAlmox = "select
                                       sum(a.`valor`) valor,
                                        b.`descricao` as grupo,
                                        b.tipo_custo
                                    from
                                       `grupo` b
                                        inner join mov_almox a on(a.`grupo` = b.`id`)
                                    where
                                            a.`data` between '$dataI' and '$dataF' and
                                            (a.tipo = 'saida' or a.tipo = 'devEntrada')
                                    group by
                                            b.id
                                    order by
                                            sum(a.valor) desc";

		$qrAlmox = mysql_query($sqlAlmox) or die('Erro sql Almoxarifado'.mysql_error().'<br>'.$sqlAlmox);

		while ($rs = mysql_fetch_object($qrAlmox)) {
			$rsAlmx[$rs->tipo_custo][$rs->grupo]                           = $rs->valor;
			empty($totalAlmx[$rs->tipo_custo])?$totalAlmx[$rs->tipo_custo] = 0:$totalAlmx[$rs->tipo_custo] = $totalAlmx[$rs->tipo_custo];
			$totalAlmx[$rs->tipo_custo]                                    = $totalAlmx[$rs->tipo_custo]+$rs->valor;
		}

		$this->Cell($col[0], 3.5, utf8_decode("CONSUMO MATERIAL PRODUTIVO"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format(($totalAlmx['DIRETO']-$rsAlmx['DIRETO']['ENERGIA']), 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format(($totalAlmx['DIRETO']-$rsAlmx['DIRETO']['ENERGIA'])/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format(($totalAlmx['DIRETO']-$rsAlmx['DIRETO']['ENERGIA'])/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		foreach ($rsAlmx['DIRETO'] as $key => $valor) {
			if ($key == "ENERGIA") {

			} else {
				$this->Cell($col[0], 3.5, utf8_decode($key), 1, 0, "L", 0);
				$this->Cell($col[1], 3.5, number_format($valor, 2, ',', '.'), 1, 0, "R", 0);
				$this->Cell($col[1], 3.5, number_format($valor/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R");
				$this->Cell($col[1], 3.5, number_format($valor/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R");
				$this->Ln();
			}
		}

		//ENERGIA,
		$this->Cell($col[0], 3.5, utf8_decode("ENERGIA"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['DIRETO']['ENERGIA'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['DIRETO']['ENERGIA']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['DIRETO']['ENERGIA']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$totalDireto = $res['taxa']+$res['custoComercial']+$totalRH['DIRETO']+$totalAlmx['DIRETO'];

		$this->Cell($col[0], 3.5, utf8_decode("SUBTOTAL CUSTO DIRETO"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($totalDireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalDireto/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalDireto/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln(5);

		//RESULTADOS CUSTO DE PRODUÇÃO INDIRETOS
		$this->Cell($col[0], 3.5, utf8_decode("MÃO DE OBRA INDIRETA"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($totalRH['INDIRETO'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalRH['INDIRETO']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalRH['INDIRETO']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		foreach ($rsRh['INDIRETO'] as $key => $valor) {
			$this->Cell($col[0], 3.5, utf8_decode($key), 1, 0, "L", 0);
			$this->Cell($col[1], 3.5, number_format($valor, 2, ',', '.'), 1, 0, "R", 0);
			$this->Cell($col[1], 3.5, number_format($valor/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R");
			$this->Cell($col[1], 3.5, number_format($valor/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R");
			$this->Ln();
		}
		//ALMOXARIFADO CUSTO INDIRETO
		$this->Cell($col[0], 3.5, utf8_decode("CONSUMO DIVERSOS"), 1, 0, "L", 1);
		$consDiverso = $totalAlmx['INDIRETO']-$rsAlmx['INDIRETO']['SERVICOS']-$rsAlmx['INDIRETO']['OLEO DIESEL'];

		$this->Cell($col[1], 3.5, number_format($consDiverso, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($consDiverso/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($consDiverso/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		foreach ($rsAlmx['INDIRETO'] as $key => $valor) {
			if ($key == "OLEO DIESEL" || $key == "SERVICOS") {

			} else {
				$this->Cell($col[0], 3.5, utf8_decode($key), 1, 0, "L", 0);
				$this->Cell($col[1], 3.5, number_format($valor, 2, ',', '.'), 1, 0, "R", 0);
				$this->Cell($col[1], 3.5, number_format($valor/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R");
				$this->Cell($col[1], 3.5, number_format($valor/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R");
				$this->Ln();
			}
		}

		$this->Cell($col[0], 3.5, "SERVI�OS GERAIS", 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['INDIRETO']['SERVICOS'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['INDIRETO']['SERVICOS']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['INDIRETO']['SERVICOS']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("OLEO DIESEL"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['INDIRETO']['OLEO DIESEL'], 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['INDIRETO']['OLEO DIESEL']/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($rsAlmx['INDIRETO']['OLEO DIESEL']/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$totalIndireto = $totalRH['INDIRETO']+$totalAlmx['INDIRETO'];

		$this->Cell($col[0], 3.5, utf8_decode("SUBTOTAL CUSTO INDIRETO"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($totalIndireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalIndireto/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($totalIndireto/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln(5);

		$custoTotal = $totalIndireto+$totalDireto;

		$this->Cell($col[0], 3.5, utf8_decode("CUSTO TOTAL"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($custoTotal, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($custoTotal/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format($custoTotal/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Ln();
		$this->Cell($col[0], 3.5, utf8_decode("MARGEM"), 1, 0, "L", 1);
		$this->Cell($col[1], 3.5, number_format($res['valProd']-$custoTotal, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format(($res['valProd']-$custoTotal)/$res['pesoAbate'], 3.5, ',', '.'), 1, 0, "R", 1);
		$this->Cell($col[1], 3.5, number_format(($res['valProd']-$custoTotal)/$res['KgProd'], 3.5, ',', '.'), 1, 0, "R", 1);
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

