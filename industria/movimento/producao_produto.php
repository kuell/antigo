<?php
require_once ('../../Connections/conn.php');
mysql_select_db($database_conn, $conn);

$d    = explode('-', $_REQUEST['data']);
$data = $d[2].'-'.$d[1].'-'.$d[0];

$sql = sprintf("Select coalesce(`AbatePeso`('%s', '%s'),0) as pesoAbate, coalesce(AbateQtd('%s','%s'),0) as abateQtd", $data, $data, $data, $data);
$qr  = mysql_query($sql);
$res = mysql_fetch_assoc($qr);

$pesoAbate = $res['pesoAbate'];
$qtdAbate  = $res['abateQtd'];

function getValores() {
	$d = explode('-', $_REQUEST['data']);

	$data = $d[2].'-'.$d[1].'-'.$d[0];

	$qrVal  = sprintf("Select * from ind_producao  where data_producao = '%s'", $data);
	$resVal = mysql_query($qrVal) or die(mysql_error());

	$val = array();

	while ($r = mysql_fetch_assoc($resVal)) {
		$val[$r['produto']] = array(
			'qtd'            => $r['qtd'],
			'peca'           => $r['peca'],
			'peso'           => $r['peso'],
			'valor_unitario' => $r['valor_unitario'],
		);
	}

	$qrProduto = sprintf("Select
								a.*,
								`f_ind_valor_unit`(a.cod, '$data') as val_unit,
								`f_ind_prod_rend_dia`('%s', '%s', a.cod) as rendimento
							from
								ind_produtos a
							where
								a.ativo = 1", $data, $data);

	$resProduto = mysql_query($qrProduto);

	$return = array();

	while ($produto = mysql_fetch_assoc($resProduto)) {
		if (empty($val[$produto['cod']])) {
			$return[] = array(
				'cod'            => $produto['cod'],
				'descricao'      => utf8_encode($produto['descricao']),
				'peca'           => '0',
				'qtd'            => '0,00',
				'peso'           => '0,00',
				'valor_unitario' => 'R$ '.number_format($produto['val_unit'], 2, ',', '.'),
				'rendimento'     => '0,00 %',
				'faturado'       => 'R$ 0,00',
			);
		} else {
			$return[] = array(
				'cod'            => $produto['cod'],
				'descricao'      => utf8_encode($produto['descricao']),
				'peca'           => number_format($val[$produto['cod']]['peca'], 0, ',', '.'),
				'qtd'            => number_format($val[$produto['cod']]['qtd'], 2, ',', '.'),
				'peso'           => number_format($val[$produto['cod']]['peso'], 2, ',', '.'),
				'valor_unitario' => 'R$ '.number_format($produto['val_unit'], 2, ',', '.'),
				'rendimento'     => number_format($produto['rendimento'], 2, ',', '.')." %",
				'faturado'       => 'R$ '.number_format($produto['val_unit']*$val[$produto['cod']]['peso'], 2, ',', '.')
			);
		}
	}

	return $return;
}

$produtos = call_user_func('getValores');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="../../js/angular.min.js" type="text/javascript"></script>
<script src="../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../js/mascara.js" type="text/javascript"></script>

<script type="text/javascript">
    function ProdutosCtrl ($scope, $window, $http){

        $scope.save = function(unidade){
          peca = document.getElementById('peca['+unidade.cod+']').value
          qtd = document.getElementById('qtd['+unidade.cod+']').value
          peso = document.getElementById('peso['+unidade.cod+']').value
          valUnit = document.getElementById('valUnit['+unidade.cod+']').value
          date = document.getElementById('data').value

          $http.get('funcao.php?funcao=incluir&produto='+unidade.cod+'&peso='+peso+'&qtd='+qtd+'&peca='+peca+'&valor='+valUnit+'&data='+date)
            .success(function(fat){

              $http.get('funcao.php?funcao=getRendimento&abate='+<?php echo $pesoAbate;?>+'&produto='+peso)
                .success(function(rend){
                  document.getElementById('rend['+unidade.cod+']').value = rend
                })

              document.getElementById('faturado['+unidade.cod+']').value = fat
            }
          )
        }

        var init = function(){
          $scope.unidade = {"cod": 0,"descricao":"","peca":0,"qtd":0,"peso":0,"valor_unitario":0,"rendimento":0,"faturado":0};
          $scope.lista = <?php echo json_encode($produtos);?>
        }

        init();
      }

      $(function(){
        $('input').addClass('input-sm')
        $(".valor").maskMoney({symbol:"R$ ",decimal:",", thousands: ".", showSymbol: true, symbolStay: true });
        $(".decimal").maskMoney({symbol:"",decimal:",", thousands: "." });
      })

  </script>


</head>

<body>
<div class="well">
	Digitação da Produção ref. ao dia <?php echo $_REQUEST['data'];?> <br />
	<span>Peso do Abate: <?php echo number_format($pesoAbate, 2, ',', '.');?> Kg -
		  Qtde. do Abate: <?php echo number_format($qtdAbate, 0, ',', '.');
?></span>
</div>
<input type="hidden" id="data" value="<?php echo $_REQUEST['data'];?>">

<div ng-controller="ProdutosCtrl">
  <table class="table table-hover table-striped">
  <thead>
    <tr>
      <th>Cod</th>
      <th>Descrição</th>
      <th>Peça</th>
      <th>Qtd</th>
      <th>Peso</th>
      <th>Rend. Kg</th>
      <th>Valor Unit.</th>
      <th>Faturado</th>
    </tr>
    </thead>
    <tbody>
      <tr ng-repeat="produto in lista">
          <th><input id="produto" disabled="disabled" name="produto" type="text" value="{{ produto.cod }}" size="20" class="form-control" readonly="readonly" /></th>
          <td>{{ produto.descricao }}</td>
          <td><input id="peca[{{ produto.cod }}]" type="text" class="form-control" value="{{ produto.peca }}" /></td>
          <td><input id="qtd[{{ produto.cod }}]" type="text"  class="form-control decimal" value="{{ produto.qtd }}" /></td>
          <td><input id="peso[{{ produto.cod }}]" type="text"  class="decimal form-control" value="{{ produto.peso }}" /></td>
          <td><input id="rend[{{ produto.cod }}]" type="text"  disabled="disabled" class="form-control" value="{{ produto.rendimento }}" /></td>
          <td><input id="valUnit[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.valor_unitario }}" ng-blur="save(produto)" /></td>
          <td><input id="faturado[{{ produto.cod }}]" class="form-control" disabled value="{{ produto.faturado }}" />
          </td>
      </tr>
	</tbody>
  </table>
  </div>


  
</body>
</html>
