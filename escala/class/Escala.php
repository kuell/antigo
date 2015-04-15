<?php

/**
 *
 */
class Escala {
	private $conn;

	public $id;
	public $preEscala;
	public $data;
	public $lote;
	public $corretor;
	public $pecuarista;
	public $qtdBoi   = 0;
	public $qtdVaca  = 0;
	public $qtdNov   = 0;
	public $qtdTouro = 0;
	public $duracao;

	function __construct($data = null) {
		$this->conn = new Connect();

		if (!$data) {
			$this->data = date('Y-m-d');
		} else {
			$this->data = $data;
		}

	}

	public function insertPre(PreEscala $pre) {
		$this->preEscala  = $pre->id;
		$this->data       = $pre->data;
		$this->lote       = $this->buscaLote()+1;
		$this->pecuarista = $pre->pecuarista;
		$this->corretor   = $pre->corretor;
		$this->qtdBoi     = $pre->qtdBoi;
		$this->qtdVaca    = $pre->qtdVaca;
		$this->qtdNov     = $pre->qtdNov;
		$this->qtdTouro   = $pre->qtdTouro;
		$this->duracao    = (($this->qtdBoi+$this->qtdNov+$this->qtdTouro+$this->qtdVaca)*60)/100;

		$this->insert($this);

	}

	public function buscaLote() {
		$sql = sprintf("Select coalesce(max(lote),0) as lote from escala where data = '%s'", $this->data);

		$rs = $this->conn->executeSql($sql)->fetch_object();

		return $rs->lote;
	}

	public function insert() {
		$this->duracao = (($this->qtdBoi+$this->qtdNov+$this->qtdTouro+$this->qtdVaca)*60)/100;

		$sql = sprintf("Insert into escala (pre_escala, data, corretor, pecuarista, qtdBoi, qtdVaca, qtdNov, qtdTouro, lote, duracao) value(%s, '%s', %s, '%s', %s, %s, %s, %s, %s, %s)", $this->preEscala, $this->data, $this->corretor, $this->pecuarista, $this->qtdBoi, $this->qtdVaca, $this->qtdNov, $this->qtdTouro, $this->lote, $this->duracao);

		return $this->conn->executeSql($sql);
	}

	public function update() {

		$this->duracao = (($this->qtdBoi+$this->qtdNov+$this->qtdTouro+$this->qtdVaca)*60)/100;

		$sql = sprintf("update
							escala set
									data = '%s',
									corretor = %s,
									pecuarista ='%s',
									qtdBoi = %s,
									qtdVaca = %s,
									qtdNov = %s,
									qtdTouro = %s,
									duracao = %s
							where
								id = %s", $this->data, $this->corretor, $this->pecuarista, $this->qtdBoi, $this->qtdVaca, $this->qtdNov, $this->qtdTouro, $this->duracao, $this->id);

		return $this->conn->executeSql($sql);
	}

	public function lista($param = '') {

		$sql = sprintf("select
					*
				from
					escala
				where
					data = '%s' %s
				order by
					lote", $this->data, $param);
		$rs = $this->conn->executeSql($sql);

		while ($val = $rs->fetch_object()) {
			$return[] = $val;
		}

		return $return;
	}

	public function getEscala() {
		$sql = sprintf("Select * from escala where id = %s", $this->id);

		$rs = $this->conn->executeSql($sql)->fetch_object();

		$this->id         = $rs->id;
		$this->lote       = $rs->lote;
		$this->preEscala  = $rs->preEscala;
		$this->corretor   = $rs->corretor;
		$this->pecuarista = $rs->pecuarista;
		$this->qtdBoi     = $rs->qtdBoi;
		$this->qtdVaca    = $rs->qtdVaca;
		$this->qtdNov     = $rs->qtdNov;
		$this->qtdTouro   = $rs->qtdTouro;
		$this->duracao    = $rs->duracao;

		return $this;

	}

	public function ordena($ordem, $lote) {
		$sobe  = $lote-$ordem;
		$desce = $lote;

		$sql = "UPDATE escala set lote = %s where lote = %s and data = '%s'";

		$r1 = sprintf($sql, 0, $sobe, $this->data);
		$r2 = sprintf($sql, $sobe, $desce, $this->data);
		$r3 = sprintf($sql, $desce, 0, $this->data);

		//	echo $r1."<br />".$r2."<br />".$r3;

		$this->conn->executeSql($r1);
		$this->conn->executeSql($r2);
		$this->conn->executeSql($r3);
		return true;
	}

	public function delete() {
		$sql = sprintf("Delete from escala where id = %s", $this->id);
		$this->conn->executeSql($sql);

		$sqlLote = sprintf("Select count(lote) as max from escala where data='%s'", $this->data);
		$rs      = $this->conn->executeSql($sqlLote)->fetch_object();

		for ($i = $this->lote; $i < $rs->max; $i++) {
			$this->ordena(-1, $i);
		}

		$sqlPe = sprintf("update escala_pre set usuario_alteracao = '%s', data_alteracao = current_timestamp, situacao = 'pe'  where  id = %s ", $_SESSION['kt_login_user'], $this->preEscala);

		$this->conn->executeSql($sqlPe);

		return true;
	}

}

?>