<?php

class Corretor extends Connect {
	private $conn;
	public $id;
	public $codigo_interno;
	public $nome;
	public $situacao;
	public $cor;

	public function __construct($id = null) {
		$this->conn = new Connect();

		if (!empty($id)) {
			$this->getCorretor($id);
		}

	}

	public function getTaxaAjustes($datai, $dataf) {
		$sql   = sprintf("call p_taxa_ajuste_corretor(%s, '%s', '%s')", $this->id, $datai, $dataf);
		$dados = $this->conn->executeSql($sql);

		while ($val = $dados->fetch_object()) {
			$res[date('d/m/Y', strtotime($val->data))][$val->grupo][] =
			(object) [
				'id'        => $val->id,
				'descricao' => $val->item,
				'peso'      => number_format($val->peso, 2, ',', '.'),
				'qtd'       => $val->qtd,
				'valor'     => number_format($val->valor, 2, ',', '.'),
				'tipo'      => $val->tipo];
		}

		return $res;

	}

	public function lista($param = null) {
		$sql = sprintf("Select * from corretor where 1 = 1 %s", $param);

		$rs = $this->conn->executeSql($sql);

		while ($res = $rs->fetch_object()) {
			$return[] = $res;
		}

		return $return;
	}

	public function getCorretor($id) {
		$sql   = sprintf("Select * from corretor where cor_id = %s", $id);
		$dados = $this->conn->executeSql($sql)->fetch_object();

		$this->id             = $dados->cor_id;
		$this->codigo_interno = $dados->cor_cod;
		$this->nome           = $dados->cor_nome;
		$this->situacao       = $dados->cor_ativo;
		$this->cor            = $dados->cor;
		return $this;
	}

	public function abate($cor) {
		$sql = sprintf("select
							sum(b.qtd) as qtd,
							sum(b.peso) as peso
						from
							taxa a
							inner join taxaitens b on a.id = b.idTaxa
							inner join taxa_item c on b.idItem = c.id
						where
							a.data between '2015-01-01' and '2015-01-31' and
							c.grupo = 1 and
							a.corretor = %s", $cor);

		$abate = $this->conn->executeSql($sql)->fetch_object();

		return $abate;
	}
}

?>