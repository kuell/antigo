<?php

class Interno {
	public $connPgsql;

	public function __construct() {
		$this->connPgsql = new ConnectPgsql();
	}

	public function fechamentoBalanco($mes, $ano) {
		$ultimoDia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

		$datai = $ano.'-'.$mes.'-01';
		$dataf = $ano.'-'.$mes.'-'.$ultimoDia;

		$s      = new Setor();
		$setors = $s->lista(' where interno_setor is not null');

		while ($setor = $setors->fetch_object()) {
			$res[] = [
				'setor'     => $setor->id_setor,
				'setorNome' => $setor->setor,
				'mes'       => $mes,
				'ano'       => $ano,
				'item'      => [
					1          => (double) $this->getHorasTrabalhadas($setor->interno_setor, $datai, $dataf),
					2          => (double) $this->getQtdInternos($setor->interno_setor, $datai, $dataf)*25*7.20,
					3          => (double) $this->getHoraSuplementar($setor->interno_setor, $datai, $dataf)

				]
			];
		}

		return $res;

	}

	public function horas_trabalhadas_produtividade($datai, $dataf) {
		$sql = sprintf("Select
							c.id,
							sum(a.saida - a.entrada) as horasTrabalhadas
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
							inner join setors c on b.setor_id = c.id
						where
							a.data between date('%s') and date('%s')
						group by
							c.id", $datai, $dataf);

		$res = $this->connPgsql->RunSelect($sql);

		foreach ($res as $val) {
			$r[$val->id] = $val->horastrabalhadas;
		}

		return $r;

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
							extract(month from a.data)
								between extract(month from date('%s') - interval '1' month) and
									extract(month from date('%s') - interval '1' month) and
							extract(year from a.data)
								between extract(year from date('%s') - interval '1' month) and
										extract(year from date('%s') - interval '1' month)
						group by
							c.id", $datai, $dataf, $datai, $dataf);

		$res = $this->connPgsql->RunSelect($sql);
		$r   = [];
		foreach ($res as $val) {
			$r[$val->id] = $val->horastrabalhadas;
		}
		return $r;
	}

	public function getHorasTrabalhadas($setor, $datai, $dataf) {
		if (empty($setor)) {
			return 0;
		} elseif ($setor == 'all') {
			$sql = sprintf("Select
							coalesce(sum(a.saida - a.entrada), interval '00:00:00' minute) as res
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
						where
							a.data between '%s' and '%s'
						", $datai, $dataf);

			$rs = $this->connPgsql->RunSelect($sql);

			return $rs[0]->res;
		} else {
			$sql = sprintf("Select
							coalesce(sum(a.saida - a.entrada), interval '00:00:00' minute) as res
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
						where
							a.data between '%s' and '%s' and
							b.setor_id = %s
						", $datai, $dataf, $setor);

			$rs = $this->connPgsql->RunSelect($sql);

			return $rs[0]->res;
		}
	}

	public function getHorasTrabalhadasBalanco($setor, $datai, $dataf) {
		$sql = sprintf("Select
							coalesce(sum(a.saida - a.entrada), interval '00:00:00' minute) as res
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
						where
							extract(month from a.data)
								between extract(month from date('%s') - interval '1' month) and
									extract(month from date('%s') - interval '1' month) and
							extract(year from a.data)
								between extract(year from date('%s') - interval '1' month) and
										extract(year from date('%s') - interval '1' month) and
							b.setor_id = %s
						", $datai, $datai, $dataf, $dataf, $setor);

		$rs = $this->connPgsql->RunSelect($sql);

		if (!empty($rs[0]->res)) {
			return $rs[0]->res;
		} else {
			return 0;
		}
	}

	public function getQtdInternos($setor = null, $datai, $dataf) {
		if (empty($setor)) {
			$sql = sprintf("Select
							coalesce(count(distinct(b.nome)), 0) as res
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
						where
							a.data between '%s' and '%s' and
							b.situacao = true", $datai, $dataf);
		} else {
			$sql = sprintf("Select
							coalesce(count(distinct(b.nome)), 0) as res
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
						where
							a.data between '%s' and '%s' and
							b.situacao = true and
							b.setor_id = %s", $datai, $dataf, $setor);
		}

		$rs = $this->connPgsql->RunSelect($sql);

		return $rs[0]->res;
	}
	public function getHoraSuplementar($setor = null, $datai, $dataf) {

		if (empty($setor)) {
			$sql = sprintf("select
							coalesce(sum((a.saida - a.entrada) - interval '7:20:00'),interval '0') as res
						from
							interno_frequencias a
						where
							(a.saida - a.entrada) - interval '7:20:00' > interval '00:00:00' and
							a.data between '%s' and '%s'", $datai, $dataf);

		} else {

			$sql = sprintf("select
							coalesce(sum((a.saida - a.entrada) - interval '7:20:00'),interval '0') as res
						from
							interno_frequencias a
							inner join internos b on a.interno_id = b.id
						where
							(a.saida - a.entrada) - interval '7:20:00' > interval '00:00:00' and
							a.data between '%s' and '%s' and
							b.setor_id = %s", $datai, $dataf, $setor);

		}

		$rs = $this->connPgsql->RunSelect($sql);

		return $rs[0]->res;
	}

}

?>
