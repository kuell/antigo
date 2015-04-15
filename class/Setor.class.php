<?php

/**
 *
 */
class Setor {
	private $conn;

	function __construct() {
		$this->conn = new Connect();
	}

	public function lista($param = null) {
		$sql = "Select * from setor ".$param.' order by setor';

		$res = $this->conn->executeSql($sql);

		return $res;
	}

	public function getSetor($id) {
		return $this->lista(' where id_setor = '.$id)->fetch_object();

	}

	public function setores($param = null) {
		$sql = "Select * from setor ".$param.' order by setor';

		$res = $this->conn->executeSql($sql);

		while ($setor = $res->fetch_object()) {
			$rs[] = $setor;
		}
		return $rs;
	}
}

?>