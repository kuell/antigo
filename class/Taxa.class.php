<?php

/**
 *
 */
class Taxa {
	private $conn;
	private $datai;
	private $dataf;
	public $taxas;

	function __construct($datai, $dataf) {
		$this->datai = $datai;
		$this->dataf = $dataf;
		$this->conn  = new Connect();
	}

	public function getTaxa() {
		$sql = sprintf("select `Taxa`('%s', '%s') as res", $this->datai, $this->dataf);

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;

	}
	public function getTaxaDia() {
		$sql = sprintf("Select
							b.data,
							a.tipo,
							sum(a.valor) as valor
						from
							taxaitens a
							inner join taxa b on(a.idTaxa = b.id)
						where
							month(b.data) = month('%s') and
							year(b.data) = year('%s')
						group by
							b.data, a.tipo", $this->datai, $this->datai);
		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$result[$val->data][$val->tipo] = $val->valor;

			if (!empty($result[$val->data]['c']) && !empty($result[$val->data]['d'])) {
				$this->taxas[$val->data] = $result[$val->data]['c']-$result[$val->data]['d'];
			}
		}
		
		return $this->taxas;
	}
}

?>
