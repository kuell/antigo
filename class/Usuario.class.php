<?php

class Usuario {

	private $id;
	private $nome;
	private $login;
	private $sistemas;
	public $usuario;

	public function __construct($idUsuario) {
		$this->conn    = new Connect();
		$this->usuario = $this->getUsuario($idUsuario);
		$this->id      = $idUsuario;
	}

	public function getUsuario($id) {
		$sql = sprintf("Select * from funcionario where id_funcionario = %s", $id);
		return $this->conn->executeSql($sql)->fetch_object();
	}

	public function atualizaEmail($id, $email) {
		$sql = sprintf("update funcionario set email = '%s' where id_funcionario = %s", $email, $id);
		return $this->conn->executeSql($sql);
	}

	public function getSistemas() {
		$sql = sprintf('Select
						b.nome,
						b.url,
						b.icone
					from
						sistema_acesso a
						inner join sistemas b on a.id_sistema = b.id_sistema
						inner join funcionario c on a.id_usuario = c.id_funcionario
					where
						c.id_funcionario = %s
					group by
						b.id_sistema', $this->id);
		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$this->sistemas[] = $val;
		}
		return $this->sistemas;
	}
}

?>