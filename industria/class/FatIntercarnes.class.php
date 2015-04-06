<?php

class FatIntercarnes extends Connect {
	protected $conn;
	private $id;
	private $mes;
	private $ano;
	private $produto;
	private $valor;

	public function __construct($mes, $ano) {
		$this->conn = new Connect();
		$this->mes  = $mes;
		$this->ano  = $ano;
	}

	public function save() {

		$sql = sprintf("SELECT count(*) as res from fat_intercarnes where produto_id = %s and mes = %s and ano = %s",
			$this->produto,
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

		return $this->conn->executeSql($sql);
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