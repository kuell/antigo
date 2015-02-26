<?php
require ('/var/www/sigAntigo/sig2/Connections/conect_mysqli.php');

class CustoProducao extends Connect {
	public $abateQtd;
	public $abatePeso;
	public $kgProduzido;
	public $rendimento;
	public $precoMedio;
	public $kgMedioPorCabeca;
	public $kgMedioProduzidoPorCabeca;
	public $valorMedioProduzidoPorCabeca;
	public $valorProducaoCorrente;
	public $taxas;
	public $custoComercial;
	public $maoDeObraDireta;
	public $consumoMaterialProdutivo;
	public $energia;
	public $maoDeObraIndireta;
	public $consumoDiversos;
	public $servicosGerais;
	public $oleoDiesel;
	public $datai, $dataf;
	public $dados;
	public $rh;
	public $almox;
	public $subTotalDireto;
	public $subTotalIndireto;

	public function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;

		$sql = "select
                        `AbateQtd`('$datai', '$dataf') as qtdAbate,
                        `AbatePeso`('$datai', '$dataf') as pesoAbate,
                        `ProdKg`('$datai', '$dataf') as KgProd,
                        `Taxa`('$datai', '$dataf') as taxa,
						`CustoComercial`('$datai', '$dataf') as custoComercial";
		//	echo $sql;
		//	die;

		$this->dados = $this->executeSql($sql)->fetch_object();
		$this->rh    = $this->getValoresRh();
		$this->almox = $this->getValoresAlmox();

		$this->abateQtd              = $this->dados->qtdAbate;
		$this->abatePeso             = $this->dados->pesoAbate;
		$this->kgProduzido           = $this->dados->KgProd;
		$this->taxas                 = $this->dados->taxa;
		$this->valorProducaoCorrente = $this->getValorProducaoCorrente($datai, $dataf);

		$this->rendimento                   = round(($this->kgProduzido*100)/$this->abatePeso, 2).' %';
		$this->kgMedioPorCabeca             = round($this->abatePeso/$this->abateQtd, 2);
		$this->kgMedioProduzidoPorCabeca    = round(($this->kgMedioPorCabeca*$this->rendimento/100), 2);
		$this->precoMedio                   = round($this->valorProducaoCorrente/$this->kgProduzido, 2);
		$this->valorMedioProduzidoPorCabeca = round($this->kgMedioProduzidoPorCabeca*$this->precoMedio, 2);

		$this->custoComercial    = $this->dados->custoComercial;
		$this->maoDeObraDireta   = array_sum($this->rh['DIRETO']);
		$this->maoDeObraIndireta = array_sum($this->rh['INDIRETO']);
		$this->energia           = $this->almox['DIRETO']['ENERGIA'];
		$this->oleoDiesel        = $this->almox['INDIRETO']['OLEO DIESEL'];
		$this->servicosGerais    = $this->almox['INDIRETO']['SERVICOS'];

		unset($this->almox['DIRETO']['ENERGIA']);
		unset($this->almox['INDIRETO']['OLEO DIESEL']);
		unset($this->almox['INDIRETO']['SERVICOS']);

		$this->consumoDiversos          = array_sum($this->almox['INDIRETO']);
		$this->consumoMaterialProdutivo = array_sum($this->almox['DIRETO']);

		$this->subTotalDireto =

		$this->taxas+
		$this->custoComercial+
		$this->maoDeObraDireta+
		$this->consumoMaterialProdutivo+
		$this->energia;

		$this->subTotalIndireto = $this->servicosGerais+$this->oleoDiesel+$this->maoDeObraIndireta+$this->consumoDiversos;
	}

	function getValorProducaoCorrente($datai, $dataf) {
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

		$qr = $this->executeSql($sql);

		//	mysql_close();

		$total = 0;
		while ($rs = $qr->fetch_array()) {
			$total = ($rs['valor_unitario']*$rs['peso'])+$total;
		}
		return $total;

	}

	function getValoresRh() {
		$sql = "Select
                    a.`setor`,
                    a.tipo_custo,
                    sum(c.`horas_trabalhadas`) as horaTrab,
                    `custoHoraSetor`('$this->datai', '$this->dataf', a.id_setor) as custoHora
                from
                    setor a
                    inner join `rh_produtividade` c on(a.`id_setor` = c.`setor`)
                where
                        c.`data` between '$this->datai' and '$this->dataf'
                group by
                        a.id_setor
                order by
                        (`custoHoraSetor`('$this->datai', '$this->dataf', a.id_setor) * sum(c.`horas_trabalhadas`)) desc";
		$qr = $this->executeSql($sql);

		while ($rs = $qr->fetch_object()) {
			$return[$rs->tipo_custo][$rs->setor] = round($rs->horaTrab*$rs->custoHora, 2);
		}

		return $return;

	}

	function getValoresAlmox() {
		$sql = "select
                   sum(a.`valor`) valor,
                    b.`descricao` as grupo,
                    b.tipo_custo
                from
                   `grupo` b
                    inner join mov_almox a on(a.`grupo` = b.`id`)
                where
                        a.`data` between '$this->datai' and '$this->dataf' and
                        (a.tipo = 'saida' or a.tipo = 'devEntrada')
                group by
                        b.id
                order by
                        sum(a.valor) desc";

		$qr = $this->executeSql($sql);

		while ($rs = $qr->fetch_object()) {
			$result[$rs->tipo_custo][$rs->grupo] = $rs->valor;
		}

		return $result;
	}

}
?>