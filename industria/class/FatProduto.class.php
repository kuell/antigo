<?php

/**
 *
 */
class FatProduto extends Connect {
	private $conn;
	private $id;
	private $cod_fat;
	private $cod_prod;
	private $descricao;
	private $ativo;
	private $ordem;
	private $grupo_intercarnes;
	private $fatTotal;

	public function __construct() {
		$this->conn = new Connect();
	}

	public function produto($id) {
		$sql = sprintf('Select * from fat_produto where id = %s', $id);

		return $this->conn->executeSql($sql);
	}

	public function lista($param) {
		$sql = "Select * from fat_produto";
		if ($param) {
			$sql .= ' '.$param;
		}

		return $this->conn->executeSql($sql);
	}

	public function producao($cod) {
		$sql = sprintf("Select * from ind_produtos a where a.cod = %s ", $cod);

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
	 * Gets the value of cod_fat.
	 *
	 * @return mixed
	 */
	public function getCodFat() {
		return $this->cod_fat;
	}

	/**
	 * Sets the value of cod_fat.
	 *
	 * @param mixed $cod_fat the cod fat
	 *
	 * @return self
	 */
	public function setCodFat($cod_fat) {
		$this->cod_fat = $cod_fat;

		return $this;
	}

	/**
	 * Gets the value of cod_prod.
	 *
	 * @return mixed
	 */
	public function getCodProd() {
		return $this->cod_prod;
	}

	/**
	 * Sets the value of cod_prod.
	 *
	 * @param mixed $cod_prod the cod prod
	 *
	 * @return self
	 */
	public function setCodProd($cod_prod) {
		$this->cod_prod = $cod_prod;

		return $this;
	}

	/**
	 * Gets the value of descricao.
	 *
	 * @return mixed
	 */
	public function getDescricao() {
		return $this->descricao;
	}

	/**
	 * Sets the value of descricao.
	 *
	 * @param mixed $descricao the descricao
	 *
	 * @return self
	 */
	public function setDescricao($descricao) {
		$this->descricao = $descricao;

		return $this;
	}

	/**
	 * Gets the value of ativo.
	 *
	 * @return mixed
	 */
	public function getAtivo() {
		return $this->ativo;
	}

	/**
	 * Sets the value of ativo.
	 *
	 * @param mixed $ativo the ativo
	 *
	 * @return self
	 */
	public function setAtivo($ativo) {
		$this->ativo = $ativo;

		return $this;
	}

	/**
	 * Gets the value of ordem.
	 *
	 * @return mixed
	 */
	public function getOrdem() {
		return $this->ordem;
	}

	/**
	 * Sets the value of ordem.
	 *
	 * @param mixed $ordem the ordem
	 *
	 * @return self
	 */
	public function setOrdem($ordem) {
		$this->ordem = $ordem;

		return $this;
	}

	/**
	 * Gets the value of grupo_intercarnes.
	 *
	 * @return mixed
	 */
	public function getGrupoIntercarnes() {
		return $this->grupo_intercarnes;
	}

	/**
	 * Sets the value of grupo_intercarnes.
	 *
	 * @param mixed $grupo_intercarnes the grupo intercarnes
	 *
	 * @return self
	 */
	public function setGrupoIntercarnes($grupo_intercarnes) {
		$this->grupo_intercarnes = $grupo_intercarnes;

		return $this;
	}
}

?>