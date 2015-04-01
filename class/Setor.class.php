<?php

/**
 *
 */
class Setor extends Connect {
	private $conn;

	function __construct() {
		$this->conn = new Connect();
	}

	public function lista($param = null) {
		$sql = "Select * from setor ".$param.' order by setor';

		$res = $this->conn->executeSql($sql);

		return $res;
	}
}

?>