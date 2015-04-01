<?php

class FatIntercarnes extends Connect {
	public $conn;
	private $id;
	private $mes;
	private $ano;
	private $produto;
	private $valor;

	function __construct() {
		//	session_start();
	}

	public function save() {
		$sql = sprintf("SELECT count(*) as res from fat_intercarnes where produto_id = %s and mes = %s and ano = %s",
			$this->produto,
			$this->mes,
			$this->ano);

		$this->conn = new Connect();
		$res        = $this->conn->executeSql($sql)->fetch_object();

		if ($res->res == 0) {
			$this->insert();
		} else {
			$this->update();
		}
	}

	public function update() {
		$sql = sprintf("UPDATE fat_intercarnes SET valor = %s WHERE produto_id = %s and mes = %s and ano = %s",
			$this->valor,
			$this->produto,
			$this->mes,
			$this->ano);

		return $this->conn->executeSql($sql);
	}

	public function insert() {
		$sql = sprintf("insert into fat_intercarnes (mes, ano, produto_id, valor) values(%s, %s, %s, %s)",
			$this->mes,
			$this->ano,
			$this->produto,
			$this->valor);
		echo $sql;

		$this->conn->executeSql($sql);
	}

	/**
	 * Gets the value of id.
	 *
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Sets the value of id.
	 *
	 * @param mixed $id the id
	 *
	 * @return self
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}

	/**
	 * Gets the value of mes.
	 *
	 * @return mixed
	 */
	public function getMes() {
		return $this->mes;
	}

	/**
	 * Sets the value of mes.
	 *
	 * @param mixed $mes the mes
	 *
	 * @return self
	 */
	public function setMes($mes) {
		$this->mes = $mes;

		return $this;
	}

	/**
	 * Gets the value of ano.
	 *
	 * @return mixed
	 */
	public function getAno() {
		return $this->ano;
	}

	/**
	 * Sets the value of ano.
	 *
	 * @param mixed $ano the ano
	 *
	 * @return self
	 */
	public function setAno($ano) {
		$this->ano = $ano;

		return $this;
	}

	/**
	 * Gets the value of produto.
	 *
	 * @return mixed
	 */
	public function getProduto() {
		return $this->produto;
	}

	/**
	 * Sets the value of produto.
	 *
	 * @param mixed $produto the produto
	 *
	 * @return self
	 */
	public function setProduto($produto) {
		$this->produto = $produto;

		return $this;
	}

	/**
	 * Gets the value of valor.
	 *
	 * @return mixed
	 */
	public function getValor($produto) {

		$this->conn = new Connect();
		$sql        = sprintf('Select valor from fat_intercarnes where produto_id = %s and mes = %s and ano = %s',
			$produto,
			$this->mes,
			$this->ano);
		$res = $this->conn->executeSql($sql)->fetch_object();

		return number_format($res->valor, 2, ',', '.');
	}

	/**
	 * Sets the value of valor.
	 *
	 * @param mixed $valor the valor
	 *
	 * @return self
	 */
	public function setValor($valor) {
		$this->valor = str_replace(',', '.', str_replace('.', '', $valor));

		return $this;
	}
}

?>