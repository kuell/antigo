<?php

class Connect {
	protected $host = "localhost";
	protected $user = "root";
	protected $pass = "aporedux";
	protected $db   = "sig";
	protected $con;

	public function __construct() {
		$this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);
	}

	public function connect() {
		$this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);
	}

	public function executeSql($sql, $returno = 'array') {
		$qr = $this->con->query($sql) or die('Erro na instrução ou na conexão!<br />'.$sql."<br>");
		$this->con->close();

		return $qr;

	}
}