<?php

/**
 *
 */
class Almoxarifado {
	private $conn;
	private $datai;
	private $dataf;

	public $energia;
	public $oleoDiesel;
	public $servicos;

	function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;
		$this->conn  = new Connect();
	}

	public function getEnergiaDia() {

		return $this->energia = $this->getItemDia(25);
	}

	public function getOleoDieselDia() {
		return $this->oleoDiesel = $this->getItemDia(24);
	}

	public function getServicosDia() {
		return $this->servicos = $this->getItemDia(23);
	}

	public function getCustoAlmoxDia() {
		$sql = sprintf("Select
							a.data as data,
							sum(a.valor) as valor
						from
							mov_almox a
						where
							a.grupo not in(25, 24, 23) and
							month(a.data) = month('%s') and
							year(a.data) = year('%s')
						group by
							a.data", $this->datai, $this->datai);

		$res = $this->conn->executeSql($sql);

		while ($val = $res->fetch_object()) {
			$result[$val->data] = $val->valor;
		}

		return $result;
	}

	public function getItemDia($item) {
		$sql = sprintf("Select
							a.data as data,
							sum(a.valor) as valor
						from
							mov_almox a
						where
							a.grupo = %s and
							month(a.data) = month('%s') and
							year(a.data) = year('%s')
						group by
							a.data", $item, $this->datai, $this->datai);
		$res = $this->conn->executeSql($sql);

		while ($val = $res->fetch_object()) {
			$result[$val->data] = $val->valor;
		}

		return $result;
	}
	public function getCustoAlmox() {
		$sql = sprintf("Select
							sum(a.valor) as res
						from
							mov_almox a
						where
							a.grupo = 25 and
							a.data between '%s' and '%s'", $item, $this->datai, $this->dataf);

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}
}

?>