<?php
require_once ('../../Connections/conn.php');
mysql_select_db($database_conn, $conn);

$d    = explode('-', $_REQUEST['data']);
$data = $d[2].'-'.$d[1].'-'.$d[0];

$sql = sprintf("Select coalesce(`AbatePeso`('%s', '%s'),0) as pesoAbate, coalesce(AbateQtd('%s','%s'),0) abateQtd", $data, $data, $data, $data);
$qr  = mysql_query($sql);
$res = mysql_fetch_assoc($qr);

$pesoAbate = $res['pesoAbate'];
$qtdAbate  = $res['abateQtd'];

function getValores() {
	$d = explode('-', $_REQUEST['data']);

	$data = $d[2].'-'.$d[1].'-'.$d[0];

	$qrVal  = sprintf("Select * from faturamento  where data = '%s'", $data);
	$resVal = mysql_query($qrVal) or die(mysql_error());

	$val = array();

	while ($r = mysql_fetch_assoc($resVal)) {
		$val[$r['produto']] = array(
			'qtd'         => $r['qtd'],
			'peso'        => $r['peso'],
			'preco'       => $r['preco'],
			'total_venda' => $r['total_venda'],
			'frete'       => $r['frete'],
			'seguro'      => $r['seguro'],
			'imposto'     => $r['imposto'],
			'comissao'    => $r['comissao'],
			'bonificacao' => $r['bonificacao'],
			'doacao'      => $r['doacao'],
			'refeitorio'  => $r['refeitorio'],
		);
	}

	$qrProduto = "Select * from fat_produto where ativo = 'SIM' order by cod_fat";

	$resProduto = mysql_query($qrProduto);

	$return = array();

	while ($produto = mysql_fetch_assoc($resProduto)) {

		//	echo $val[$produto['cod_fat']]['qtd']."<br />";

		if (empty($val[$produto['cod_fat']])) {
			$return[] = array(
				'cod'         => $produto['cod_fat'],
				'descricao'   => utf8_encode($produto['descricao']),
				'qtd'         => '0',
				'peso'        => '0,00',
				'preco'       => 'R$ 0,00',
				'total_venda' => 'R$ 0,00',
				'frete'       => 'R$ 0,00',
				'seguro'      => 'R$ 0,00',
				'imposto'     => 'R$ 0,00',
				'comissao'    => 'R$ 0,00',
				'bonificacao' => 'R$ 0,00',
				'doacao'      => 'R$ 0,00',
				'refeitorio'  => 'R$ 0,00',
			);
		} else {
			$return[] = array(
				'cod'         => $produto['cod_fat'],
				'descricao'   => utf8_encode($produto['descricao']),
				'qtd'         => number_format($val[$produto['cod_fat']]['qtd'], 0, ',', '.'),
				'peso'        => number_format($val[$produto['cod_fat']]['peso'], 2, ',', '.'),
				'preco'       => 'R$ '.number_format($val[$produto['cod_fat']]['preco'], 4, ',', '.'),
				'total_venda' => 'R$ '.number_format($val[$produto['cod_fat']]['total_venda'], 2, ',', '.'),
				'frete'       => 'R$ '.number_format($val[$produto['cod_fat']]['frete'], 2, ',', '.'),
				'seguro'      => 'R$ '.number_format($val[$produto['cod_fat']]['seguro'], 2, ',', '.'),
				'imposto'     => 'R$ '.number_format($val[$produto['cod_fat']]['imposto'], 2, ',', '.'),
				'comissao'    => 'R$ '.number_format($val[$produto['cod_fat']]['comissao'], 2, ',', '.'),
				'bonificacao' => 'R$ '.number_format($val[$produto['cod_fat']]['bonificacao'], 2, ',', '.'),
				'doacao'      => 'R$ '.number_format($val[$produto['cod_fat']]['doacao'], 2, ',', '.'),
				'refeitorio'  => 'R$ '.number_format($val[$produto['cod_fat']]['refeitorio'], 2, ',', '.')
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
      		qtd = document.getElementById('qtd['+unidade.cod+']').value
			
			document.getElementById('qtd['+unidade.cod+']').focus()
			
          peso = document.getElementById('peso['+unidade.cod+']').value
          preco = document.getElementById('preco['+unidade.cod+']').value
          frete = document.getElementById('frete['+unidade.cod+']').value
          seguro = document.getElementById('seguro['+unidade.cod+']').value
          imposto = document.getElementById('imposto['+unidade.cod+']').value
          comissao = document.getElementById('comissao['+unidade.cod+']').value
          bonif = document.getElementById('bonif['+unidade.cod+']').value
          doacao = document.getElementById('doacao['+unidade.cod+']').value
          refeitorio = document.getElementById('refeitorio['+unidade.cod+']').value


      		date = document.getElementById('data').value
          $('input').attr('disabled', 'disabled');

      		$http.get('funcao.php?funcao=incluir_fat&produto='+unidade.cod+
                                                 '&data='+date+
                                                 '&qtd='+qtd+
                                                 '&peso='+peso+
                                                 '&preco='+preco+
                                                 '&frete='+frete+
                                                 '&seguro='+seguro+
                                                 '&imposto='+imposto+
                                                 '&comissao='+comissao+
                                                 '&bonif='+bonif+
                                                 '&doacao='+doacao+
                                                 '&refeitorio='+refeitorio)
      			.success(function(data){
              $('input').removeAttr('disabled');
              document.getElementById('totalVenda['+unidade.cod+']').value = data;
              $('.total').attr('disabled', 'disabled');
			  $window.console.log(data);
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
		$(".valor4").maskMoney({symbol:"R$ ",decimal:",", thousands: ".", showSymbol: true, symbolStay: true, precision: 4 });
        $(".decimal").maskMoney({symbol:"",decimal:",", thousands: "." });
      })

  </script>
</head>

<body>

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
        Digitação do Faturamento ref. ao dia <?php echo $_REQUEST['data'];?> <br />
  <span>Peso do Abate: <?php echo number_format($pesoAbate, 2, ',', '.');?> Kg -
        Qtde. do Abate: <?php echo number_format($qtdAbate, 0, ',', '.');
?></span></div>
  <div class="panel-body">

<input type="hidden" id="data" value="<?php echo $_REQUEST['data'];?>">

<div ng-controller="ProdutosCtrl">
  <table class="table table-hover table-striped">
  <thead>
    <tr>
      <th>Cod</th>
      <th>Descrição</th>
      <th>Qtde</th>
      <th>Peso em Kg</th>
      <th>Preço Venda</th>
      <th>Total Venda</th>
      <th>Frete</th>
      <th>Seg.</th>
      <th>Impost.</th>
      <th>Comiss.</th>
      <th>Bonif.</th>
      <th>Doaç.</th>
      <th>Ref.</th>
    </tr>
    </thead>
    <tbody>
      <tr ng-repeat="produto in lista">
          <th>{{ produto.cod }}</th>
          <td>{{ produto.descricao }}</td>
          <td><input title="Quantidade" id="qtd[{{ produto.cod }}]" type="text" class="form-control" value="{{ produto.qtd }}" /></td>
          <td><input title="Peso" id="peso[{{ produto.cod }}]" type="text" class="decimal form-control" value="{{ produto.peso }}" /></td>
          <td><input title="Preço" id="preco[{{ produto.cod }}]" type="text" class="valor4 form-control" value="{{ produto.preco }}" /></td>
          <td><input id="totalVenda[{{ produto.cod }}]" type="text" disabled="disabled" class="form-control total" value="{{ produto.total_venda }}" /></td>
          <td><input title="Frete" id="frete[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.frete }}" /></td>
          <td><input title="Seguro" id="seguro[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.seguro }}" /></td>
          <td><input title="Imposto" id="imposto[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.imposto }}" /></td>
          <td><input title="Comissão" id="comissao[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.comissao }}" /></td>
          <td><input title="Bonificação" id="bonif[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.bonificacao }}" /></td>
          <td><input title="Doação" id="doacao[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.doacao }}" /></td>
          <td><input title="Refeitorio" id="refeitorio[{{ produto.cod }}]" type="text" class="valor form-control" value="{{ produto.refeitorio }}" ng-blur="save(produto)" /></td>

          </td>
      </tr>
  </tbody>
  </table>
  </div>

  </div>
</body>
</html>
