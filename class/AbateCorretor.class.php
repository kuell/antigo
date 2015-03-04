<?php

class AbateCorretor extends Connect {
	public $dados;

	public function __construct($ano) {
		$sql   = " call p_abate_corretor('2015-01-01', '2015-01-31')";
		$dados = $this->executeSql($sql);

		while ($res = $dados->fetch_object()) {
			$this->dados[] = $res;
		}

	}

}
?>