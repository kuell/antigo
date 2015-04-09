<?php
/**
 *
 */
class Balanco {
	private $conn;
	private $datai;
	private $dataf;
	public $mes;
	public $ano;
	public $item;
	public $valor;
	public $usuario;

	public $custo;
	public $setor;
	public $info;
	public $horas_trabalhadas;
	public $horas_potenciais;
	public $horas_suplementares;
	public $falta;
	public $ferias;
	public $acidenteAfastamento;
	public $qtdFuncRegistradoAtivo;
	public $qtdFuncTemporarios;
	public $pestadoresServico;
	public $admitidos;
	public $demitidos;
	public $remBruta;
	public $qtdFuncTemporariosDesligados;
	public $taxaOcupacaoHora;
	public $taxaDesocupacaoHora;
	public $taxaFaltas;
	public $taxaAcidenteAfastamentos;
	public $taxaFerias;
	public $taxaAbsenteismoTotal;
	public $taxaRemHora;
	public $taxaHoraSuplementar;
	public $taxaAdmissao;
	public $taxaDemissao;
	public $taxaReposicao;
	public $taxaTotalFolhaFat;
	public $taxaSalarioPorPeso;
	public $taxaSalarioMedioSetor;

	public function __construct($datai, $dataf) {
		$this->conn     = new Connect();
		$this->connPsql = new ConnectPgsql();
		$this->datai    = $datai;
		$this->dataf    = $dataf;
	}

	public function getAnaliseGlobal($ano) {
		$sql = sprintf('call p_rh_balanco_analise_global(%s, %s)', $this->setor->id_setor, $$ano);

	}

	public function getBalanco($setor = null) {
		if (empty($setor)) {

			$i = new Interno();

			$this->info                         = $this->getInfo();
			$this->horas_trabalhadas['c']       = $this->getItemAtual(1);
			$this->horas_trabalhadas['i']       = $this->getItemAtualInterno(1);
			$this->horas_potenciais['c']        = $this->getItemAtual(2);
			$this->horas_potenciais['i']        = $this->getItemAtualInterno(2);
			$this->horas_suplementares['c']     = $this->getItemAtual(3);
			$this->horas_suplementares['i']     = $this->getItemAtualInterno(3);
			$this->falta                        = $this->getItemAtual(4);
			$this->ferias                       = $this->getItemAtual(6);
			$this->acidenteAfastamento          = $this->getItemAtual(5);
			$this->qtdFuncRegistradoAtivo       = $this->getItemAtual(7);
			$this->qtdFuncTemporarios           = $this->getItemAtual(8);
			$this->pestadoresServico            = $this->getItemAtual(9);
			$this->admitidos                    = $this->getItemAtual(10);
			$this->demitidos                    = $this->getItemAtual(11);
			$this->remBruta                     = $this->getItemAtual(12);
			$this->qtdFuncTemporariosDesligados = $this->getItemAtual(16);
		} else {
			$setors      = new Setor();
			$this->setor = $setors->getSetor($setor);

			$this->info                         = $this->getInfo();
			$this->horas_trabalhadas['c']       = $this->getItemAtual(1, $this->setor->id_setor);
			$this->horas_trabalhadas['i']       = $this->getItemAtualInterno(1, $this->setor->id_setor);
			$this->horas_potenciais['c']        = $this->getItemAtual(2, $this->setor->id_setor);
			$this->horas_potenciais['i']        = $this->getItemAtualInterno(2, $this->setor->id_setor);
			$this->horas_suplementares['c']     = $this->getItemAtual(3, $this->setor->id_setor);
			$this->horas_suplementares['i']     = $this->getItemAtualInterno(3, $this->setor->id_setor);
			$this->falta                        = $this->getItemAtual(4, $this->setor->id_setor);
			$this->ferias                       = $this->getItemAtual(6, $this->setor->id_setor);
			$this->acidenteAfastamento          = $this->getItemAtual(5, $this->setor->id_setor);
			$this->qtdFuncRegistradoAtivo       = $this->getItemAtual(7, $this->setor->id_setor);
			$this->qtdFuncTemporarios           = $this->getItemAtual(8, $this->setor->id_setor);
			$this->pestadoresServico            = $this->getItemAtual(9, $this->setor->id_setor);
			$this->admitidos                    = $this->getItemAtual(10, $this->setor->id_setor);
			$this->demitidos                    = $this->getItemAtual(11, $this->setor->id_setor);
			$this->remBruta                     = $this->getItemAtual(12, $this->setor->id_setor);
			$this->qtdFuncTemporariosDesligados = $this->getItemAtual(16, $this->setor->id_setor);

		}

		$this->taxaOcupacaoHora         = array_sum($this->horas_trabalhadas)/array_sum($this->horas_potenciais)*100;
		$this->taxaDesocupacaoHora      = (array_sum($this->horas_potenciais)-array_sum($this->horas_trabalhadas))/array_sum($this->horas_potenciais)*100;
		$this->taxaFaltas               = $this->falta/array_sum($this->horas_trabalhadas)*100;
		$this->taxaAcidenteAfastamentos = $this->acidenteAfastamento/array_sum($this->horas_potenciais)*100;
		$this->taxaFerias               = $this->ferias/array_sum($this->horas_potenciais)*100;
		$this->taxaAbsenteismoTotal     = $this->taxaFerias+$this->taxaFaltas+$this->taxaAcidenteAfastamentos;
		$this->taxaRemHora              = $this->remBruta/array_sum($this->horas_trabalhadas);
		$this->taxaHoraSuplementar      = array_sum($this->horas_suplementares)/array_sum($this->horas_trabalhadas)*100;
		$this->taxaAdmissao             = ($this->admitidos*100)/$this->qtdFuncRegistradoAtivo;
		$this->taxaDemissao             = ($this->demitidos*100)/$this->qtdFuncRegistradoAtivo;
		$this->taxaReposicao            = (($this->admitidos-$this->demitidos)*100)/$this->qtdFuncRegistradoAtivo;
		$this->taxaTotalFolhaFat        = $this->remBruta/$this->info->fat*100;
		$this->taxaSalarioPorPeso       = $this->remBruta/$this->info->peso;
		$this->taxaSalarioMedioSetor    = $this->remBruta/($this->qtdFuncRegistradoAtivo+$this->qtdFuncTemporarios+$this->pestadoresServico);

		return $this;
	}

	public function getCustoRhPorTipoCusto() {

		$sql = sprintf("Select
						a.id_setor,
						a.tipo_custo,
						a.setor,
						a.interno_setor,
						sum(b.horas_trabalhadas) as hTrab
					from
						setor a
						left join rh_produtividade b on a.id_setor = b.setor
					where
						b.data between '%s' and '%s'
					group by
						b.setor", $this->datai, $this->dataf);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$custo = $this->getCustoHora($val->id_setor, $val->interno_setor)*$val->hTrab;

			$this->setor[$val->tipo_custo][$val->setor] = $custo;
		}

		arsort($this->setor);

		return $this->setor;
	}

	public function getCustoRhDia() {
		$this->dataf = $this->datai;

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

		$hrTrab   = $this->getItem(1, $setor);
		$remBruta = $this->getItem(12, $setor);

		if (!empty($interno_setor)) {
			$hrTrabInterno = doubleval($i->getHorasTrabalhadasBalanco($interno_setor, $this->datai, $this->dataf));
		} else {
			$hrTrabInterno = 0;
		}

		$totalHorasTrabalhadas = $hrTrab+$hrTrabInterno;

		if ($totalHorasTrabalhadas) {
			return $remBruta/$totalHorasTrabalhadas;
		} else {
			return 0;
		}

	}

	public function getItem($item, $setor = null) {
		if ($setor == null) {
			$sql = sprintf("SELECT sum(valor) as res
							FROM rh_balanco
							WHERE 	ano BETWEEN year('%s' - interval 1 month) and year('%s' - interval 1 month) and
									mes BETWEEN month('%s' - interval 1 month) and month('%s' - interval 1 month) and
									item = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item);
		} else {
			$sql = sprintf("SELECT sum(valor) as res
							FROM rh_balanco
							WHERE 	ano BETWEEN year('%s' - interval 1 month) and year('%s' - interval 1 month) and
									mes BETWEEN month('%s' - interval 1 month) and month('%s' - interval 1 month) and
									item = %s and setor = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item, $setor);
		}

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}

	public function getItemAtual($item, $setor = null) {
		if ($setor == null) {
			$sql = sprintf("SELECT sum(valor) as res
							FROM rh_balanco
							WHERE 	ano BETWEEN year('%s') and year('%s') and
									mes BETWEEN month('%s') and month('%s') and
									item = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item);
		} else {
			$sql = sprintf("SELECT sum(valor) as res
							FROM rh_balanco
							WHERE 	ano BETWEEN year('%s') and year('%s') and
									mes BETWEEN month('%s') and month('%s') and
									item = %s and setor = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item, $setor);
		}

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}

	public function getItemAtualInterno($item, $setor = null) {
		if ($setor == null) {
			$sql = sprintf("SELECT sum(valor) as res
							FROM rh_balanco_internos
							WHERE 	ano BETWEEN year('%s') and year('%s') and
									mes BETWEEN month('%s') and month('%s') and
									item = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item);
		} else {
			$sql = sprintf("SELECT sum(valor) as res
							FROM rh_balanco_internos
							WHERE 	ano BETWEEN year('%s') and year('%s') and
									mes BETWEEN month('%s') and month('%s') and
									item = %s and setor = %s", $this->datai, $this->dataf, $this->datai, $this->dataf, $item, $setor);
		}

		$res = $this->conn->executeSql($sql)->fetch_object();
		return $res->res;
	}

	public function getSetor($id) {
		$sql = sprintf("Select * from setor where id_setor = %s", $id);

		return $this->setor = $this->conn->executeSql($sql)->fetch_object();
	}

	/**
	 * Gets the value of info.
	 *
	 * @return mixed
	 */
	public function getInfo() {
		$sql = sprintf("Select qtd, peso, fat from rh_info where mes between month('%s') and month('%s') and ano between year('%s') and year('%s')", $this->datai, $this->dataf, $this->datai, $this->dataf);
		$rs  = $this->conn->executeSql($sql);

		return $rs->fetch_object();
	}

	public function saveBalancoInterno() {

		$sql = sprintf("Select count(*) as res from rh_balanco_internos where mes = %s and ano = %s and setor = %s and item = %s", $this->mes, $this->ano, $this->setor, $this->item);
		$res = $this->conn->executeSql($sql)->fetch_object();

		if ($res->res == 0) {
			$sql = sprintf("insert into rh_balanco_internos(mes, ano, setor, item, valor, usuario, data_hora_atualizacao) values(%s, %s, %s, %s, %s, '%s', now())", $this->mes, $this->ano, $this->setor, $this->item, $this->valor, $this->usuario);
		} else {
			$sql = sprintf("update rh_balanco_internos set valor = %s, usuario = '%s', data_hora_atualizacao = now() where mes = %s and ano = %s and setor = %s and item = %s", $this->valor, $this->usuario, $this->mes, $this->ano, $this->setor, $this->item);
		}

		$rs = $this->conn->executeSql($sql);

		return $rs;
	}
}

?>
