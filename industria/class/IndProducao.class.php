<?php

/**
 *
 */
class IndProducao {
	protected $conn;
	private $datai;
	private $dataf;
	private $id;
	private $peso;
	public $pesoProduzido;
	public $vpc;
	private $valo_unitario;

	function __construct($datai, $dataf) {
		$this->conn  = new Connect();
		$this->datai = $datai;
		$this->dataf = $dataf;
	}

	public function getKgProduzido() {
		$sql = sprintf("select
                    sum(a.peso) as peso
                from
                    `ind_producao` a
                where
                    a.`data_producao` between '%s' and '%s'", $this->datai, $this->dataf);
		$rs = $this->conn->executeSql($sql)->fetch_object();

		return $rs->peso;
	}

	public function getVpcDia() {
		$sql = sprintf("CALL `p_vpc_dia`('%s')", $this->datai);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {

			$valor = $val->peso*$val->valor_unitario;

			if (!$this->vpc[$val->data]) {
				$this->vpc[$val->data] = $valor;
			} else {
				$this->vpc[$val->data] = $this->vpc[$val->data]+$valor;
			}
		}

		return $this->vpc;
	}

	public function getValorProducaoCorrente() {
		$total         = 0;
		$valorUnitario = $this->getFatValorUnitario();
		$pesoProduzido = $this->getPesoProduzido();

		foreach ($this->lista(' where ativo = 1') as $produto) {

			if (!$valorUnitario[$produto->cod]) {

				$valorUnitario[$produto->cod] = $this->getValorUnitarioAnterior($produto->cod);
			}

			$valor = $valorUnitario[$produto->cod]*$pesoProduzido[$produto->cod];

			//echo $produto->cod.' - '.$produto->descricao.' - 	'.$valorUnitario[$produto->cod].' - '.$pesoProduzido[$produto->cod].' = '.$valor."<br />";
			$total = $valor+$total;
		}

		return $total;

	}

	public function getPesoProduzido() {
		$sql = sprintf("Select
							a.produto,
							sum(a.peso) as peso
						from
							ind_producao a inner join
							ind_produtos b on a.produto = b.cod
						where
							a.data_producao between '%s' and '%s'
						group by
							a.produto", $this->datai, $this->dataf);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$result[$val->produto] = $val->peso;
		}
		return $result;

	}

	public function getPesoProduzidoDia() {
		$sql = sprintf("Select
							a.data_producao as data,
							sum(a.peso) as peso
						from
							ind_producao a inner join
							ind_produtos b on a.produto = b.cod
						where
							month(a.data_producao ) = month('%s') 	and
							year(a.data_producao) = year('%s')
						group by
							a.data_producao", $this->datai, $this->datai);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$this->pesoProduzido[$val->data] = $val->peso;
		}

		return $this->pesoProduzido;

	}

	public function getFatValorUnitario() {
		$sql = sprintf("Select
							a.cod,
							a.descricao,
							(sum(c.total_venda) / sum(c.peso)) as preco
						from
							ind_produtos a
							left join fat_produto b on a.cod = b.cod_prod
							left join faturamento c on b.cod_fat = c.produto
						where
							a.ativo = 1 and
							c.data between '%s' and '%s'
						group by
							a.id", $this->datai, $this->dataf);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$result[$val->cod] = $val->preco;
		}
		return $result;
	}

	public function getValorUnitarioAnterior($produto) {
		//Pesquisa ultimo mes de faturamento do produto
		$sql = sprintf("Select
							max(c.data) as data
						from
							ind_produtos a
							left join fat_produto b on a.cod = b.cod_prod
							left join faturamento c on b.cod_fat = c.produto
						where
							a.cod = %s and
							c.data < '%s'", $produto, $this->datai);

		$rs = $this->conn->executeSql($sql)->fetch_object();

		$sql = sprintf("Select
							a.cod,
							a.descricao,
							(sum(c.total_venda) / sum(c.peso)) as preco
						from
							ind_produtos a
							left join fat_produto b on a.cod = b.cod_prod
							left join faturamento c on b.cod_fat = c.produto
						where
							a.cod = %s and
							month(c.data) = month('%s') and
							year(c.data) = year('%s')
						group
							by a.id", $produto, $rs->data, $rs->data);

		$r = $this->conn->executeSql($sql)->fetch_object();

		return $r->preco;
	}

	public function lista($param = null) {
		$sql = "Select * from ind_produtos ".$param."";

		$rs = $this->conn->executeSql($sql);

		while ($produto = $rs->fetch_object()) {
			$return[] = (object) $produto;
		}

		return $return;

	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

}

?>