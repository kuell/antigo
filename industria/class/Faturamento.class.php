<?php

/**
 *
 */
class Faturamento {
	private $conn;
	private $datai;
	private $dataf;

	public $custoVenda;

	function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;
		$this->conn  = new Connect();
	}

	public function getCustoComercial() {
		$sql = sprintf("select `CustoComercial`('%s', '%s') as res", $this->datai, $this->dataf);

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}
	public function faturamentoTotalDia() {
		$sql = "";
	}

	public function getCustoVendaDia() {
		$sql = sprintf("Select
							a.data,
							(sum(a.frete)+sum(a.seguro)+sum(a.imposto)+sum(comissao)) as custoVenda,
							sum(a.total_venda) as totalVendas
						from
							`faturamento` a
						WHERE
							month(a.`data`) = month('%s') and
							year(a.data) = year('%s')
						group by
							a.data", $this->datai, $this->datai);
		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$this->custoVenda[$val->data] = $val->custoVenda/$val->totalVendas;
		}

		return $this->custoVenda;
	}

}

?>