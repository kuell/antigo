<?php

/**
 *
 */
class Almoxarifado extends Connect {
	protected $connection;
	private $id;
	private $data;
	private $grupo;
	private $tipo;
	private $qtd;
	private $valor;
	private $valor_anterior;
	private $valor_atual;
	private $estoque_anterior;
	private $estoque_atual;

	function __construct() {
		$this->connection = new Connect();
	}

	public function save() {
		$sql = sprintf("call mov_almox_proc('%s', '%s', '%s', '%s', '%s', '%s')",
			$this->data,
			$this->grupo,
			$this->tipo,
			$this->qtd,
			$this->valor,
			$_SESSION['kt_login_user']);

		$res = $this->connection->executeSql($sql);

		return $res;
	}
	public function delete(){
		$sql = sprintf("DELETE FROM mov_almox WHERE tipo = '%s' and grupo = %s and data = '%s'",
						$this->tipo,
						$this->grupo,
						$this->data
			);
		return $this->connection->executeSql($sql);
	}

	public function getMovimentos($data) {
		$sql = "Select * from grupo";
		$res = $this->connection->executeSql($sql);

		while ($rs = $res->fetch_object()) {
			$result[] = (object) $rs;
		}
		return $result;
	}

	public function getValores($grupo, $data) {
		$sql = sprintf("call p_mov_almox('%s', %s)", $data, $grupo);
		$con = new Connect();

		$val = $con->executeSql($sql)->fetch_object();

		return $val;

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
	}

	/**
	 * Gets the value of data.
	 *
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Sets the value of data.
	 *
	 * @param mixed $data the data
	 *
	 * @return self
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * Gets the value of grupo.
	 *
	 * @return mixed
	 */
	public function getGrupo() {
		return $this->grupo;
	}

	/**
	 * Sets the value of grupo.
	 *
	 * @param mixed $grupo the grupo
	 *
	 * @return self
	 */
	public function setGrupo($grupo) {
		$this->grupo = $grupo;

		return $this;
	}

	/**
	 * Gets the value of tipo.
	 *
	 * @return mixed
	 */
	public function getTipo() {
		return $this->tipo;
	}

	/**
	 * Sets the value of tipo.
	 *
	 * @param mixed $tipo the tipo
	 *
	 * @return self
	 */
	public function setTipo($tipo) {
		$this->tipo = $tipo;

		return $this;
	}

	/**
	 * Gets the value of qtd.
	 *
	 * @return mixed
	 */
	public function getQtd() {
		$this->qtd;
		return $this;
	}

	/**
	 * Sets the value of qtd.
	 *
	 * @param mixed $qtd the qtd
	 *
	 * @return self
	 */
	public function setQtd($qtd) {
		$this->qtd = str_replace(',', '.', str_replace('.', '', $qtd));

		return $this;
	}

	/**
	 * Gets the value of valor.
	 *
	 * @return mixed
	 */
	public function getValor() {
		return $this->valor;
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

	/**
	 * Gets the value of valor_anterior.
	 *
	 * @return mixed
	 */
	public function getValorAnterior() {
		return $this->valor_anterior;
	}

	/**
	 * Sets the value of valor_anterior.
	 *
	 * @param mixed $valor_anterior the valor anterior
	 *
	 * @return self
	 */
	public function setValorAnterior($valor_anterior) {
		$this->valor_anterior = $valor_anterior;

		return $this;
	}

	/**
	 * Gets the value of valor_atual.
	 *
	 * @return mixed
	 */
	public function getValorAtual() {
		return $this->valor_atual;
	}

	/**
	 * Sets the value of valor_atual.
	 *
	 * @param mixed $valor_atual the valor atual
	 *
	 * @return self
	 */
	public function setValorAtual($valor_atual) {
		$this->valor_atual = $valor_atual;

		return $this;
	}

	/**
	 * Gets the value of estoque_anterior.
	 *
	 * @return mixed
	 */
	public function getEstoqueAnterior() {
		return $this->estoque_anterior;
	}

	/**
	 * Sets the value of estoque_anterior.
	 *
	 * @param mixed $estoque_anterior the estoque anterior
	 *
	 * @return self
	 */
	public function setEstoqueAnterior($estoque_anterior) {
		$this->estoque_anterior = $estoque_anterior;

		return $this;
	}

	/**
	 * Gets the value of estoque_atual.
	 *
	 * @return mixed
	 */
	public function getEstoqueAtual() {
		return $this->estoque_atual;
	}

	/**
	 * Sets the value of estoque_atual.
	 *
	 * @param mixed $estoque_atual the estoque atual
	 *
	 * @return self
	 */
	public function setEstoqueAtual($estoque_atual) {
		$this->estoque_atual = $estoque_atual;

		return $this;
	}
}

?>
