<?php

class PreEscala {

	protected $conn;

	public $id;
	public $data;
	public $corretor;
	public $pecuarista;
	public $qtdBoi;
	public $qtdVaca;
	public $qtdNov;
	public $qtdTouro;

	function __construct() {
		$this->conn = new Connect();
	}

	public function grava(PreEscala $pre) {

		$sql = sprintf("Insert into `escala_pre` (`data`, `corretor`, `pecuarista`, `qtdBoi`, `qtdVaca`, `qtdNov`, `qtdTouro`, `usuario_inclusao`, `data_inclusao`, situacao) VALUES ('%s', %s, '%s', %s, %s, %s, %s, '%s', '%s', '%s')", $pre->data, $pre->corretor, $pre->pecuarista, $pre->qtdBoi, $pre->qtdVaca, $pre->qtdNov, $pre->qtdTouro, $_SESSION['kt_login_user'], 'current_timestamp', 'pe');

		return $this->conn->executeSql($sql);
	}

	public function confirmar() {
		$preEscala = $this->getPreEscala();

		$sql = sprintf("Update escala_pre set situacao = 'e' where id = %s", $preEscala->id);
		$this->conn->executeSql($sql);

		$escala = new Escala();
		$escala->insertPre($preEscala);

	}

	public function delete($id) {
		$sql = sprintf("DELETE FROM escala_pre where id = %s", $id);

		return $this->conn->executeSql($sql);
	}

	public function getPreEscala() {
		$sql = sprintf("Select * from escala_pre where id = %s", $this->id);

		$rs = $this->conn->executeSql($sql)->fetch_object();

		$this->id         = $rs->id;
		$this->data       = $rs->data;
		$this->corretor   = $rs->corretor;
		$this->pecuarista = $rs->pecuarista;
		$this->qtdBoi     = $rs->qtdBoi;
		$this->qtdVaca    = $rs->qtdVaca;
		$this->qtdNov     = $rs->qtdNov;
		$this->qtdTouro   = $rs->qtdTouro;

		return $this;

	}

	public function lista($param = '') {
		$sql = sprintf("select
					*
				from
					escala_pre
				where
					data = '%s' %s", $this->data, $param);

		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$return[] = $val;
		}

		return $return;
	}

	public function tratarData($data = null, $dp = true) {
		if ($dp) {
			$mes = ['Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04', 'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08', 'Sep' => '09', 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
			$d   = explode(' ', $data);

			$dt = $d[3].'-'.$mes[$d[1]].'-'.$d[2];
			return $dt;
		}
		if (empty($data)) {
			return date("Y-m-d");
		}

		return false;
	}

	public function buscaPecuarista($param = null) {
		$sql = sprintf("Select	pecuarista from escala_pre a where 1 = 1 %s	group by  a.pecuarista limit 10", $param);

		$rs = $this->conn->executeSql($sql);

		while ($res = $rs->fetch_object()) {
			$return[] = utf8_encode($res->pecuarista);
		}

		return $return;

	}

}?>
