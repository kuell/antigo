<?php

class ConnectPgsql {
	private $host     = "127.0.0.1";
	private $dbname   = "internos";
	private $user     = "postgres";
	private $port     = "5432";
	private $password = "aporedux";
	private $conn;

	public function Connect() {
		$this->conn = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->user;password=$this->password");
		return $this->conn;
	}
	public function RunSelect($sql) {
		$sta = $this->Connect()->prepare($sql);
		$sta->execute();

		return $sta->fetchAll(PDO::FETCH_OBJ);
	}

}

?>