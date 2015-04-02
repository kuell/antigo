<?php

class Corretor extends Connect {
	private $conn;
	public $id;
	public $codigo_interno;
	public $nome;
	public $situacao;

	public function __construct($id) {
		$this->conn = new Connect();

		$sql   = sprintf("Select * from corretor where cor_id = %s", $id);
		$dados = $this->conn->executeSql($sql)->fetch_object();

		$this->id             = $dados->cor_id;
		$this->codigo_interno = $dados->cor_cod;
		$this->nome           = $dados->cor_nome;
		$this->situacao       = $dados->cor_ativo;

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
}

?>