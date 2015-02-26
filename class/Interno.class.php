<?php
require_once '../../Connections/connect_pgsql.php';

class Interno extends ConnectPgsql {
	protected $banco = 'internos';

	public function horas_trabalhadas($id) {
		return false;

	}
	public function horas_trabalhadas_setor($id, $datai, $dataf) {
		$sql = sprintf("Select
					c.id,
					sum(a.saida - a.entrada) as horasTrabalhadas
				from
					interno_frequencias a
					inner join internos b on a.interno_id = b.id
					inner join setors c on b.setor_id = c.id
				where
					a.data between date('%s') - interval '1' month and date('%s') - interval '1' month
				group by
					c.id", $datai, $dataf);


		$res = $this->RunSelect($sql);

		foreach($res as $val){
			$r[$val->id] = $val->horastrabalhadas;
		}

		return $r;
	}
}

?>