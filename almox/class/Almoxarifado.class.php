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
	public $consumo;

	function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;
		$this->conn  = new Connect();
	}

	public function getEnergia() {
		return $this->energia = $this->getItem(25);
	}
	public function getOleoDiesel() {
		return $this->oleoDiesel = $this->getItem(24);
	}
	public function getServicos() {
		return $this->servicos = $this->getItem(23);
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
							year(a.data) = year('%s') and
							a.tipo = 'Saida'
						group by
							a.data", $this->datai, $this->datai);

		$res = $this->conn->executeSql($sql);

		while ($val = $res->fetch_object()) {
			$result[$val->data] = $val->valor;
		}

		return $result;
	}

	public function getItem($item) {
		$sql = sprintf("Select
							sum(a.valor) as valor
						from
							mov_almox a
						where
							a.grupo = %s and
							a.data between '%s' and '%s' and
							a.tipo = 'Saida'
						", $item, $this->datai, $this->datai);
		$res = $this->conn->executeSql($sql)->fetch_object();

		return $res->valor;
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
							year(a.data) = year('%s') and
							a.tipo = 'Saida'
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
							a.tipo = 'Saida' and
							a.grupo = 25 and
							a.data between '%s' and '%s'", $item, $this->datai, $this->dataf);

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}

	public function getCustoAlmoxPorTipo() {
		$sql = sprintf("Select
						b.descricao,
						b.tipo_custo,
						sum(a.valor) as valor
					from
						mov_almox a
						inner join grupo b on a.grupo = b.id
					where
						a.tipo = 'Saida' and
						a.data between '%s' and '%s'
					group by
						b.id, b.tipo_custo", $this->datai, $this->dataf);
		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$this->consumo[$val->tipo_custo][$val->descricao] = $val->valor;
		}

		return $this->consumo;
	}
}

?>