<?php
require_once '../conf/Base.class.php';

class Taxa extends Base {
	function __construct($campos = array()) {
		$this->tabela   = "taxa";
		$this->campo_pk = "id";

		if (sizeof($campos) < 0) {
			$this->campos_valores = array(
				"data"     => NULL,
				"corretor" => NULL,
				"obs"      => NULL
			);
		} else {
			$this->campos_valores = $campos;
		}
	}
	public function listaTaxa($where = "", $order = "") {
		$sql = "select
                    *
                from
                    taxa a
                    inner join `corretor` b on(b.`cor_id` = a.`corretor`)
                where
                    1=1 %s %s";
		$rs = $this->RunSelect(sprintf($sql, $where, $order));

		return $rs;
	}
	public function buscaCor($cor, $data) {
		$sql = "select
                        coalesce(count(a.`id`),0) as result
                from
                        `taxa` a
                where
                        a.`corretor` = %s and
                    a.`data` = '%s'";

		$rs = $this->RunSelect(sprintf($sql, $cor, $this->dbData($data)));
		return $rs[0]['result'];
	}
}

?>
