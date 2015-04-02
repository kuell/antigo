<?php

class CustoProducao {
	private $conn;
	public $abate;
	public $producao;
	public $faturamento;
	public $rh;
	public $almox;

	public function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;

		$this->conn        = new Connect();
		$this->abate       = new Abate($this->datai, $this->dataf);
		$this->producao    = new IndProducao($this->datai, $this->dataf);
		$this->faturamento = new Faturamento($this->datai, $this->datai);
		$this->taxa        = new Taxa($this->datai, $this->dataf);
		$this->almox       = new Almoxarifado($this->datai, $this->dataf);
		$this->rh          = new Balanco($this->datai, $this->dataf);
	}
	public function apuracaoPorData() {
		$this->abate = $this->abate->getAbate();

		$this->producao->pesoProduzido               = $this->producao->getKgProduzido();
		$this->producao->rendimento                  = ($this->producao->pesoProduzido*100)/$this->abate->peso;
		$this->producao->vpc                         = $this->producao->getVpc();
		$this->producao->valorMedio                  = $this->producao->vpc/$this->producao->pesoProduzido;
		$this->producao->pesoMedioPorAnimal          = !($this->abate->peso/$this->abate->qtd)?0:($this->abate->peso/$this->abate->qtd);
		$this->producao->pesoMedioProduzidoPorAnimal = $this->producao->pesoMedioPorAnimal*$this->producao->rendimento/100;
		$this->producao->valorMedioPorAnimal         = $this->producao->pesoMedioProduzidoPorAnimal*$this->producao->valorMedio;

		$this->taxa->taxas                 = $this->taxa->getTaxas();
		$this->faturamento->custoComercial = $this->faturamento->getCustoComercial();

		$rh = $this->rh->getCustoRhPorTipoCusto();

		$this->rh->direto          = $rh['DIRETO'];
		$this->rh->maoDeObraDireta = array_sum($rh['DIRETO']);

		$this->rh->indireto          = $rh['INDIRETO'];
		$this->rh->maoDeObraIndireta = array_sum($rh['INDIRETO']);

		$almox = $this->almox->getCustoAlmoxPorTipo();

		$this->almox->energia    = $almox['DIRETO']['ENERGIA'];
		$this->almox->servicos   = $almox['INDIRETO']['SERVICOS'];
		$this->almox->oleoDiesel = $almox['INDIRETO']['OLEO DIESEL'];

		unset($almox['DIRETO']['ENERGIA']);
		unset($almox['INDIRETO']['SERVICOS']);
		unset($almox['INDIRETO']['OLEO DIESEL']);

		$this->almox->consumoMaterialProdutivo = array_sum($almox['DIRETO']);
		$this->almox->produtivo                = $almox['DIRETO'];

		$this->almox->consumoDiversos = array_sum($almox['INDIRETO']);
		$this->almox->diversos        = $almox['INDIRETO'];

		$this->subTotalDireto = $this->taxa->taxas+$this->faturamento->custoComercial+$this->rh->maoDeObraDireta+$this->almox->consumoMaterialProdutivo+$this->almox->energia;

		$this->subTotalIndireto = $this->maoDeObraIndireta+$this->consumoDiversos+$this->almox->servicos+$this->almox->oleoDiesel;

		return $this;
	}

	public function apuracaoDiaria() {
		$this->abate = $this->abate->getAbateDia();

		$this->producao->pesoProduzido               = $this->producao->getPesoProduzidoDia();
		$this->producao->rendimento                  = $this->getRendimentoDia();
		$this->producao->vpc                         = $this->producao->getVpcDia();
		$this->producao->valorMedio                  = $this->getPrecoMedioDia();
		$this->producao->pesoMedioPorAnimal          = $this->getPesoMedioPorAnimalDia();
		$this->producao->pesoMedioProduzidoPorAnimal = $this->getPesoMedioProduzidoPorAnimalDia();
		$this->producao->valorMedioPorAnimal         = $this->getValorMedioPorAnimalDia();

		$this->faturamento->custoComercial = $this->getCustoComercialDia();
		$this->taxa->taxa                  = $this->taxa->getTaxaDia();
		$this->almox->energia              = $this->almox->getEnergiaDia();
		$this->almox->oleoDiesel           = $this->almox->getOleoDieselDia();
		$this->almox->servicos             = $this->almox->getServicosDia();
		$this->almox->custo                = $this->almox->getCustoAlmoxDia();

		$this->rh->rh = $this->rh->getCustoRhDia();

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
