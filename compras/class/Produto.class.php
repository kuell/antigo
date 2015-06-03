<?php
/**
 *
 */
class Produto {
	private $con;

	public function __construct() {
		$this->con = new Connect();

	}

	public function find($id) {
		$sql = sprintf("Select * from produto where PRO_ID = %s", $id);

		return $this->con->executeSql($sql)->fetch_object();
	}

}

?>