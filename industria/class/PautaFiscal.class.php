<?php

/**
 *
 */
class PautaFiscal {
	protected $conn;
	private $mes;
	private $ano;
	private $produto_id;
	private $valor;

	public function __construct($mes, $ano) {
		$this->conn = new Connect();
		$this->mes  = $mes;
		$this->ano  = $ano;
	}

	public function save() {
		$sql = sprintf("SELECT count(*) as res from pauta_fiscal where produto_id = %s and mes = %s and ano = %s",
			$this->produto_id,
			$this->mes,
			$this->ano);

		$res = $this->conn->executeSql($sql)->fetch_object();

		if ($res->res == 0) {
			return $this->insert();
		} else {
			return $this->update();
		}
	}

	public function update() {
		$sql = sprintf("UPDATE pauta_fiscal SET valor = %s WHERE produto_id = %s and mes = %s and ano = %s",
			$this->valor,
			$this->produto_id,
			$this->mes,
			$this->ano);

		return $this->conn->executeSql($sql);
	}

	public function insert() {
		$sql = sprintf("insert into pauta_fiscal (mes, ano, produto_id, valor) values(%s, %s, %s, %s)",
			$this->mes,
			$this->ano,
			$this->produto_id,
			$this->valor);

		return $this->conn->executeSql($sql);
	}

	public function getValor($produto) {

		$this->conn = new Connect();
		$sql        = sprintf('Select valor from pauta_fiscal where produto_id = %s and mes = %s and ano = %s',
			$produto,
			$this->mes,
			$this->ano);
		$res = $this->conn->executeSql($sql)->fetch_object();

		return number_format($res->valor, 2, ',', '.');
	}

	public function setValor($valor) {
		$this->valor = str_replace(',', '.', str_replace('.', '', $valor));

		return $this;
	}
	public function setProduto($produto) {
		$this->produto_id = $produto;
		return $this;
	}

}

?>