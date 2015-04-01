<?php

class CustoProducao {
	private $conn;
	public $abate;
	public $producao;
	public $faturamento;
	public $rh;

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

	public $almox;
	public $subTotalDireto;
	public $subTotalIndireto;

	public function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;

		$this->conn = new Connect();
	}
	/*
	public function getValores() {
	$sql = "select
	`AbateQtd`('$this->datai', '$this->dataf') as qtdAbate,
	`AbatePeso`('$this->datai', '$this->dataf') as pesoAbate,
	`ProdKg`('$this->datai', '$this->dataf') as KgProd,
	`Taxa`('$this->datai', '$this->dataf') as taxa,
	`CustoComercial`('$this->datai', '$this->dataf') as custoComercial";

	$this->dados = $this->conn->executeSql($sql)->fetch_object();
	$this->rh    = $this->getValoresRh();
	$this->almox = $this->getValoresAlmox();

	$this->abateQtd              = $this->dados->qtdAbate;
	$this->abatePeso             = $this->dados->pesoAbate;
	$this->kgProduzido           = $this->dados->KgProd;
	$this->taxas                 = $this->dados->taxa;
	$this->valorProducaoCorrente = $this->getValorProducaoCorrente($this->datai, $this->dataf);

	$this->rendimento                = round(($this->kgProduzido*100)/$this->abatePeso, 2);
	$this->kgMedioPorCabeca          = round($this->abatePeso/$this->abateQtd, 2);
	$this->kgMedioProduzidoPorCabeca = round(($this->kgMedioPorCabeca*$this->rendimento/100), 2);
	//	$this->precoMedio                   = round($this->valorProducaoCorrente/$this->kgProduzido, 2);
	$this->valorMedioProduzidoPorCabeca = round($this->kgMedioProduzidoPorCabeca*$this->precoMedio, 2);

	$this->custoComercial    = $this->dados->custoComercial;
	$this->maoDeObraDireta   = array_sum($this->rh['DIRETO']);
	$this->maoDeObraIndireta = array_sum($this->rh['INDIRETO']);

	$this->energia        = !empty($this->almox['DIRETO']['ENERGIA'])?$this->almox['DIRETO']['ENERGIA']:0;
	$this->oleoDiesel     = $this->almox['INDIRETO']['OLEO DIESEL'];
	$this->servicosGerais = $this->almox['INDIRETO']['SERVICOS'];

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
	return $this;
	}
	 */

	public function apuracaoDiaria() {
		$abate       = new Abate($this->datai, $this->dataf);
		$producao    = new IndProducao($this->datai, $this->dataf);
		$faturamento = new Faturamento($this->datai, $this->data);
		$taxa        = new Taxa($this->datai, $this->dataf);
		$almox       = new Almoxarifado($this->datai, $this->dataf);
		$rh          = new Balanco($this->datai, $this->dataf);

		$this->abate = $abate->getAbateDia();

		$this->producao->pesoProduzido               = $producao->getPesoProduzidoDia();
		$this->producao->rendimento                  = $this->getRendimentoDia();
		$this->producao->vpc                         = $producao->getVpcDia();
		$this->producao->valorMedio                  = $this->getPrecoMedioDia();
		$this->producao->pesoMedioPorAnimal          = $this->getPesoMedioPorAnimalDia();
		$this->producao->pesoMedioProduzidoPorAnimal = $this->getPesoMedioProduzidoPorAnimalDia();
		$this->producao->valorMedioPorAnimal         = $this->getValorMedioPorAnimalDia();

		$this->faturamento->custoComercial = $this->getCustoComercialDia();
		$this->taxa->taxa                  = $taxa->getTaxaDia();

		$this->almox->energia    = $almox->getEnergiaDia();
		$this->almox->oleoDiesel = $almox->getOleoDieselDia();
		$this->almox->servicos   = $almox->getServicosDia();
		$this->almox->custo      = $almox->getCustoAlmoxDia();

		$this->rh->rh = $rh->getCustoRhDia();

		return $this;

	}

	public function getCustoComercialDia() {
		$fat        = new Faturamento($this->datai, $this->datai);
		$custoVenda = $fat->getCustoVendaDia();

		foreach ($custoVenda as $key => $value) {
			$this->custoComercial[$key] = $custoVenda[$key]*$this->producao->vpc[$key];
		}

		return $this->custoComercial;
	}

	public function getValorMedioPorAnimalDia() {

		//Repetição com rendimento, pois quando não tem rendimento não tem valor por animal //

		foreach ($this->producao->rendimento as $key => $value) {
			$return[$key] = $this->producao->pesoMedioProduzidoPorAnimal[$key]*$this->producao->valorMedio[$key];
		}
		return $return;
	}

	public function getPesoMedioProduzidoPorAnimalDia() {
		foreach ($this->producao->rendimento as $key => $value) {
			$return[$key] = ($this->producao->pesoMedioPorAnimal[$key]*$this->producao->rendimento[$key])/100;
		}
		return $return;
	}

	public function getRendimentoDia() {
		if (is_object($this->producao) && is_object($this->abate)) {
			foreach ($this->producao->pesoProduzido as $key => $producao) {
				$return[$key] = ($this->producao->pesoProduzido[$key]*100)/$this->abate->peso[$key];
			}
		}
		return $return;
	}

	public function getPrecoMedioDia() {
		foreach ($this->producao->vpc as $key => $vpc) {
			$return[$key] = $this->producao->vpc[$key]/$this->producao->pesoProduzido[$key];
		}

		return $return;

	}
	public function getPesoMedioPorAnimalDia() {
		foreach ($this->abate->peso as $key => $peso) {
			$return[$key] = $this->abate->peso[$key]/$this->abate->qtd[$key];
		}

		return $return;
	}

	function getValoresRh() {
		$setors        = new Setor();
		$produtividade = new Produtividade($this->datai, $this->dataf);
		$balanco       = new Balanco($this->datai, $this->dataf);
		$i             = new Interno();

		foreach ($setors->lista('where rh = 1') as $setor) {

			$hTrab     = $produtividade->getHorasTrabalhadas($setor['id_setor']);
			$custoHora = $balanco->getCustoHora($setor['id_setor']);

			$totalHorasTrabalhadas = $hTrab+$hrsInterno;

			$return[$setor['tipo_custo']][$setor['setor']] = $custoHora*$totalHorasTrabalhadas;

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

		$qr = $this->conn->executeSql($sql);

		while ($rs = $qr->fetch_object()) {
			$result[$rs->tipo_custo][$rs->grupo] = $rs->valor;
		}

		return $result;
	}

	function getHorasInt($hora) {
		if (!$hora) {
			return 0;
		} else {
			$r = explode(':', $hora);
			return $r[0].'.'.$r[1];
		}
	}
}
?>