<?php

class Abate extends Connect {
	private $conn;
	private $datai;
	private $dataf;

	public $peso;
	public $qtd;

	public function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;
		$this->conn  = new Connect();
	}

	/**
	 * Gets the value of peso.
	 *
	 * @return mixed
	 */
	public function getPeso() {
		$sql = sprintf("Select
                  sum(a.`peso`) as peso
              from
                  `taxaitens` a
                  inner join `taxa_item` b on(a.`idItem` = b.`id`)
                  inner join `taxa` c on(a.`idTaxa` = c.`id`)
              where
                  c.`data` BETWEEN '%s' and '%s' and
                  b.`sexo` = 1", $this->datai, $this->dataf);
		$rs = $this->conn->executeSql($sql)->fetch_object();

		return $rs->peso;
	}

	/**
	 * Gets the value of qtd.
	 *
	 * @return mixed
	 */
	public function getQtd() {
		$sql = sprintf("Select
                  sum(a.`qtd`) as qtd
              from
                  `taxaitens` a
                  inner join `taxa_item` b on(a.`idItem` = b.`id`)
                  inner join `taxa` c on(a.`idTaxa` = c.`id`)
              where
                  c.`data` BETWEEN '%s' and '%s' and
                  b.`sexo` = 1", $this->datai, $this->dataf);
		$rs = $this->conn->executeSql($sql)->fetch_object();

		return $rs->qtd;
	}

	public function getAbateDia() {
		$sql = sprintf("Select
							c.data,
							sum(a.`qtd`) as qtd,
							sum(a.peso) as peso
						from
						  `taxaitens` a
						  inner join `taxa_item` b on(a.`idItem` = b.`id`)
						  inner join `taxa` c on(a.`idTaxa` = c.`id`)
						where
							month(c.`data`) = month('%s') and
							year(c.data) = year('%s') and
							b.sexo in(1,0)
						group by
							c.data", $this->datai, $this->datai);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$this->peso[$val->data] = $val->peso;
			$this->qtd[$val->data]  = $val->qtd;
		}

		return $this;
	}

}

?>