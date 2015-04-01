<?php

/**
 *
 */
class Produtividade extends Interno {
	private $conn;
	public $id_setor;
	public $setor;
	private $datai;
	private $dataf;

	function __construct($datai, $dataf) {
		$this->conn  = new Connect();
		$this->datai = $datai;
		$this->dataf = $dataf;
	}

	public function getCustoRhDia() {

	}

	public function getCustoRh() {
		$setors  = new Setor();
		$balanco = new Balanco($this->datai, $this->dataf);
		$total   = 0;

		foreach ($setors->lista('where rh = 1') as $setor) {
			$hTrab     = $this->getHorasTrabalhadas($setor['id_setor']);
			$custoHora = $balanco->getCustoHora($setor['id_setor']);

			$custo = $hTrab*$custoHora;

			$total = $total+$custo;
		}

		return $total;

	}

	public function getHorasTrabalhadas($setor) {
		$sql = sprintf("select
							sum(horas_trabalhadas) as res
						from
							rh_produtividade
						where
							setor = %s and
							data between '%s' and '%s'", $setor, $this->datai, $this->dataf);

		$res = $this->conn->executeSql($sql)->fetch_object();

		return $res->res;
	}

	/**
	 * Sets the value of datai.
	 *
	 * @param mixed $datai the datai
	 *
	 * @return self
	 */
	public function setDatai($datai) {
		$this->datai = $datai;

		return $this;
	}

	/**
	 * Sets the value of dataf.
	 *
	 * @param mixed $dataf the dataf
	 *
	 * @return self
	 */
	public function setDataf($dataf) {
		$this->dataf = $dataf;

		return $this;
	}
}

?>