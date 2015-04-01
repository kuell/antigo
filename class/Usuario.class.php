<?php

class Usuario extends Connect {
	public function getUsuario($id) {
		$sql = sprintf("Select * from funcionario where id_funcionario = %s", $id);
		return $this->executeSql($sql)->fetch_object();
	}

	public function atualizaEmail($id, $email) {
		$sql = sprintf("update funcionario set email = '%s' where id_funcionario = %s", $email, $id);
		return $this->executeSql($sql);
	}
}

?>