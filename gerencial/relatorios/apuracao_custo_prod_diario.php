<?php
error_reporting(0);
require_once ("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
require ("../../bibliotecas/fpdf/fpdf.php");
class PDF extends FPDF {

	function Header() {
		//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(250, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(250, 11, utf8_decode("Relatorio de ApuraÃ§Ã£o de custos de produÃ§Ã£o ref: ".$_GET['data1']), "RLB", 0, "C");
		$this->Ln(15);
		$fill = 0;
	}

	function calcHora($mes = "", $ano = "") {
		$mes = $mes-1;

		if ($mes == 0) {
			$mes = 12;
			$ano = $ano-1;
		}

		$sql = "select
                `a`.`id_setor` AS `id_setor`,
                `b`.`mes` AS `mes`,
                `b`.`ano` AS `ano`,
                (select sum(valor) from rh_balanco where setor = a.id_setor and mes = b.mes and ano = b.ano and item = 1) AS `horaTrab`,
                (select sum(valor) from rh_balanco where setor = a.id_setor and mes = b.mes and ano = b.ano and item = 12) as custo
              from
                `setor` `a`
                inner join `rh_balanco` `b` on(`a`.`id_setor` = `b`.`setor`)
              where
                b.mes = '$mes' and b.ano = '$ano'
              group by
                `a`.`id_setor`,`b`.`mes`,`b`.`ano`";

		$query = mysql_query($sql) or die("Erro no mysql calcHora(Custo da hora): ".mysql_error());

		while ($r = mysql_fetch_object($query)) {
			$custoHora[$r->id_setor] = $r->custo/$r->horaTrab;
		}

		//Verifica se a data é igual a 12
		if ($mes == 12) {
			$mes = 1;
			$ano = $ano+1;
		} else {
			$mes = $mes+1;
		}
		//

		$sql = "Select
                sum(a.`horas_trabalhadas`) as hrTrab,
                a.setor,
                a.data
            from
                    `rh_produtividade` a
            where
               month(a.data) = $mes and year(a.data) = $ano
            group by
                    a.`data`, a.`setor`";

		$query = mysql_query($sql) or die("Erro no mysql calcHora(Horas trabalhadas Produtividade): ".mysql_error());

		while ($rs = mysql_fetch_object($query)) {
			$custo[$rs->data] = $custo[$rs->data]+$rs->hrTrab*$custoHora[$rs->setor];
		}
		return $custo;
	}
	function energia($mes = "", $ano = "") {
		$sql = "Select
                    sum(a.valor) as valor,
                    a.data
                from
                        mov_almox a
                where
                    month(a.data) = $mes and
                    year(a.data) = $ano and
                    grupo = 25
                group by
                        a.data";
		$query = mysql_query($sql);

		while ($r = mysql_fetch_object($query)) {
			$result[$r->data] = $r->valor;
		}
		return $result;

	}

	function taxa($datai, $dataf) {
		$sql   = "select Taxa('%s', '%s') as taxa";
		$query = mysql_query(sprintf($sql, $datai, $dataf));

		$r = mysql_fetch_object($query);

		return $r->taxa;

	}

	function Footer() {
		$this->SetY(-15);
		$this->SetFont("Arial", "I", 8);
		$this->Cell(0, 3, utf8_decode("PÃ¡gina ").$this->PageNo()."/{nb} \ Processado em ", 0, 0, "C");
	}

	function Dados() {
		########		RESULTADOS INDUSTRIAIS		########
		$mes = date("m", strtotime($_GET['data1']));
		$ano = date("Y", strtotime($_GET['data1']));

		$sql = "Select
              distinct(a.data),
              sum(b.qtd) as qtdAbate,
              sum(b.peso) as pesoAbate,
              (select sum(`peso`) from `ind_producao` where `data_producao` = a.data) as producao,
              `FatTotal`(a.data, a.data) as fatTotal,
              `CustoComercial`(a.data, a.data) as custoComercial,
              `calcAlmoxDiario`(a.`data`, 25) as energia,
              `calcAlmoxDiario`(a.`data`, 24) as oleoDiesel,
              `calcAlmoxDiario`(a.`data`, 23) as servicos,
              (Select sum(`valor`) from mov_almox where `tipo` = 'SAIDA' and data = a.data) as almox
            from
              taxa a
              inner join taxaitens b on(a.id = b.idTaxa)
              inner join taxa_item c on(b.idItem = c.id)
            where
              month(a.data) = $mes and
              year(a.data) = $ano and
              c.grupo = 1
            group by
              a.`data`";

		$qr      = mysql_query($sql) or die("Erro Sql Dados".mysql_error());
		$custoRH = $this->calcHora($mes, $ano);
		$energia = $this->energia($mes, $ano);

		while ($res = mysql_fetch_object($qr)) {
			$result[$res->data]['pesoAbate']      = $res->pesoAbate;
			$result[$res->data]['qtdAbate']       = $res->qtdAbate;
			$result[$res->data]['producao']       = $res->producao;
			$result[$res->data]['rendimento']     = ($res->producao/$res->pesoAbate)*100;
			$result[$res->data]['precoMedio']     = $res->fatTotal/$res->producao;
			$result[$res->data]['kgAnimal']       = $res->pesoAbate/$res->qtdAbate;
			$result[$res->data]['kgProdAnimal']   = ($result[$res->data]['kgAnimal']*$result[$res->data]['rendimento'])/100;
			$result[$res->data]['valAnimal']      = $result[$res->data]['kgProdAnimal']*$result[$res->data]['precoMedio'];
			$result[$res->data]['fatTotal']       = $res->fatTotal;
			$result[$res->data]['custoComercial'] = $res->custoComercial;
			$result[$res->data]['oleo']           = $res->oleoDiesel;
			$result[$res->data]['rh']             = $custoRH[$res->data];
			$result[$res->data]['almox']          = $res->almox-$res->energia-$res->oleoDiesel-$res->servicos;
			$result[$res->data]['servico']        = $res->servicos;
		}

		$this->SetFont("Arial", "", 7);
		$this->SetFillColor(100);
		$this->SetTextColor(250);
		$this->SetDrawColor(230);

		$col = array(10, 17, 20, 22, 30);
		$ln  = array(4);

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

		$ultimoDia = date('t', date("t", mktime(0, 0, 0, date('m'), '01', date('Y'))));
		$d         = explode('-', $_GET['data1']);

		for ($i = 1; $i <= $ultimoDia; $i++) {
			$data = date('Y-m-d', strtotime($d[2].'-'.$d[1].'-'.$i));

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
		}
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
	}
}
$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();
?>

