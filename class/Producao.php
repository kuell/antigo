<?php

class Producao extends Connect {

	public function producaoAnualMes($ano) {
		$sql = sprintf("Select
							a.cod,
							a.`descricao` as produto,
							a.tipo,
							month(b.data_producao) as mes,
							YEAR(b.data_producao) as ano,
							sum(b.peso) as producao
						from
							`ind_produtos` a
							inner join `ind_producao` b on(a.`cod` = b.`produto`)
						where
							year(b.data_producao) = %s and
							a.tipo = 'SUBPRODUTOS'
						group by
							a.cod,MONTH(b.data_producao), YEAR(b.data_producao)
						order by
							a.tipo, a.descricao

						", $ano);
		$dados     = $this->executeSql($sql);
		$pesoAbate = $this->getPesoAbate($ano);

		while ($rs = $dados->fetch_object()) {
			$rend                      = ($rs->producao/$pesoAbate[$rs->mes])*100;
			$v[$rs->produto][$rs->mes] = $rend;
		}

		foreach ($v as $key => $v) {
			$return .= ' {	type: "spline",
				        	showInLegend: true,
				        	name: "'.$key.'",
				        	dataPoints: [';

			arsort($v);
			for ($i = 1; $i <= 12; $i++) {
				!$v[$i]?$v[$i] = 0:$v[$i];

				$return .= '{label:"'.$i.'", y:'.$v[$i].'},';
			}
			$return .= ']} ,';
		}

		return $return;
	}

	/**
	 * Gets the value of pesoAbate.
	 *
	 * @return mixed
	 */
	public function getPesoAbate($ano) {
		$sql = sprintf("Select
		                    MONTH(a.`data`) as mes,
		                    sum(b.`peso`) as PesoAbate
		                from
		                    `taxa` a
		                    inner join `taxaitens` b on(a.`id` = b.`idTaxa`)
		                    inner join `taxa_item` c on(b.`idItem` = c.`id`)
		                where
		                    c.`grupo` = 1 and
		                    YEAR(a.`data`) = %s
		                group by
		                    month(a.`data`)", $ano);

		$dados = $this->executeSql($sql);

		while ($rs = $dados->fetch_object()) {
			$this->pesoAbate[$rs->mes] = $rs->PesoAbate;
		}

		return $this->pesoAbate;
	}
}

?>