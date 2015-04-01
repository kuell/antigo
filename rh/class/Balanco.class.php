<?php
/**
 *
 */
class Balanco {
	private $conn;
	private $datai;
	private $dataf;
	private $remBruta;

	public $custo;
	public $setor;

	public function __construct($datai, $dataf) {
		$this->conn     = new Connect();
		$this->connPsql = new ConnectPgsql();
		$this->datai    = $datai;
		$this->dataf    = $dataf;
	}

	public function getCustoRhDia() {
		$sql = sprintf("Select
					b.data,
					a.id_setor,
					a.setor,
					a.interno_setor,
					sum(b.horas_trabalhadas) as hTrab
				from
					setor a
					left join rh_produtividade b on a.id_setor = b.setor
				where
					month(b.data) = month('%s') and
					year(b.data) = year('%s')
				group by
					b.data, b.setor", $this->datai, $this->datai);
		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			if (empty($custoHora[$val->id_setor])) {
				$custoHora[$val->id_setor] = $this->getCustoHora($val->id_setor, $val->interno_setor);
			}

			if (empty($return[$val->data])) {
				$return[$val->data] = $val->hTrab*$custoHora[$val->id_setor];
			} else {
				$return[$val->data] = ($val->hTrab*$custoHora[$val->id_setor])+$return[$val->data];
			}
			
		}

		return $return;
	}

	public function getCustoHora($setor, $interno_setor = null) {
		$i = new Interno();
		
		$hrTrab        = $this->getItem($setor, 1);
		$remBruta      = $this->getItem($setor, 12);
		$hrTrabInterno = doubleval($i->getHorasTrabalhadasBalanco($interno_setor, $this->datai, $this->dataf));

		$totalHorasTrabalhadas = $hrTrab+$hrTrabInterno;
				
		if ($totalHorasTrabalhadas) {
			return $remBruta/$totalHorasTrabalhadas;
		} else {
			return 0;
		}

	}

	public function getItem($setor, $item) {
		$sql = sprintf("SELECT sum(valor) as res
						FROM rh_balanco
						WHERE 	ano BETWEEN year('%s' - interval 1 month) and year('%s' - interval 1 month) and
								mes BETWEEN month('%s' - interval - 1 month) and month('%s' - interval - 1 month) and
								item = %s and setor = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item, $setor);
		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}
	
	public function getSetor($id){
		$sql = sprintf("Select * from setor where id_setor = %s", $id);

		return $this->setor = $this->conn->executeSql($sql)->fetch_object();
	}


}

?>
