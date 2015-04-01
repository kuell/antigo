<?php
require ("../../Connections/conn.php");
require ('../../Connections/conect_mysqli.php');
require ('../../class/FatIntercarnes.class.php');
mysql_select_db($database_conn, $conn);
session_start();

$funcao = $_REQUEST['funcao'];

if (function_exists($funcao)) {
	call_user_func($funcao);
} else {
	echo ("Erro funчуo inexistente");
}

function incluir() {
	$qtd     = call_user_func('numero', $_REQUEST['qtd']);
	$peso    = call_user_func('numero', $_REQUEST['peso']);
	$valUnit = call_user_func('numero', str_replace('R$', '', $_REQUEST['valor']));
	$peca    = call_user_func('numero', $_REQUEST['peca']);
	$produto = call_user_func('numero', $_REQUEST['produto']);
	$usuario = $_SESSION['kt_login_user'];
	$data    = call_user_func('data', $_REQUEST['data']);

	$sqlConsulta = sprintf("select count(id) as resultado from ind_producao where produto = %s and data_producao = '%s'", $produto, $data);
	$query       = mysql_query($sqlConsulta) or die("Erro1 01 :".mysql_error());
	$res         = mysql_fetch_assoc($query);

	if ($res['resultado']) {
		$sql = sprintf("Update ind_producao
						set
							peca = %s,
							qtd = %s,
							peso = %s,
							valor_unitario = %s,
							usuario_alteracao = '%s'
						where
							data_producao = '%s' and
							produto = %s", $peca, $qtd, $peso, $valUnit, $usuario, $data, $produto);
	} else {
		$sql = sprintf("insert Into ind_producao
							 (data_producao,produto,peca,qtd,peso,valor_unitario,usuario_digitacao)
						value('%s','%s','%s','%s','%s','%s','%s')", $data, $produto, $peca, $qtd, $peso, $valUnit, $usuario);

	}

	$id = mysql_query($sql) or die(mysql_error());

	$valFat = $peso*$valUnit;

	echo 'R$ '.number_format($valFat, 2, ',', '.');
}

function numero($num) {
	$numero = str_replace(".", "", $num);
	$return = str_replace(",", ".", $numero);

	return $return;
}

function data($data) {
	$d = explode('-', $data);

	return $d[2].'-'.$d[1].'-'.$d[0];
}

function getRendimento() {
	$pesoAbate   = $_REQUEST['abate'];
	$pesoProduto = call_user_func('numero', $_REQUEST['produto']);
	if ($pesoAbate == 0 or $pesoProduto == 0) {
		echo "0,00 %";
	} else {
		$rendimento = $pesoProduto*100/$pesoAbate;
		echo number_format($rendimento, 2).' %';
	}
}

function incluir_fat() {
	$produto     = $_REQUEST['produto'];
	$data        = call_user_func('data', $_REQUEST['data']);
	$qtd         = call_user_func('numero', $_REQUEST['qtd']);
	$peso        = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['peso']));
	$preco       = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['preco']));
	$total_venda = $preco*$peso;
	$frete       = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['frete']));
	$seguro      = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['seguro']));
	$imposto     = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['imposto']));
	$comissao    = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['comissao']));
	$bonificacao = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['bonif']));
	$doacao      = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['doacao']));
	$refeitorio  = call_user_func('numero', str_replace('R$ ', '', $_REQUEST['refeitorio']));
	$usuario     = $_SESSION['kt_login_user'];

	$consulta = sprintf("Select count(*) as resultado from faturamento where produto = %s and data = '%s'", $produto, $data);

	$qr = mysql_query($consulta) or die('ERRO QR 01 '.mysql_error());

	$res = mysql_fetch_assoc($qr);

	if ($res['resultado']) {

		$sql = sprintf("update faturamento
					set
						qtd			= %s,
						peso		= %s,
						preco		= %s,
						total_venda	= '%s',
						frete		= %s,
						seguro		= %s,
						imposto		= %s,
						comissao	= %s,
						bonificacao	= %s,
						doacao		= %s,
						refeitorio	= %s,
						usuario_up	= '%s'
					where
						produto = %s and
						data 	= '%s'", $qtd, $peso, $preco, $total_venda, $frete, $seguro, $imposto, $comissao, $bonificacao, $doacao, $refeitorio, $usuario, $produto, $data);
	} else {

		$sql = sprintf("insert Into faturamento
						(produto, data, qtd, peso, preco, total_venda, frete, seguro, imposto, comissao, bonificacao, doacao, refeitorio, usuario_add)
		value
						(%s, '%s', %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '%s')", $produto, $data, $qtd, $peso, $preco, $total_venda, $frete, $seguro, $imposto, $comissao, $bonificacao, $doacao, $refeitorio, $usuario);

	}
	mysql_query($sql) or die("Erro: ".mysql_error()."/n ".$sql);

	echo 'R$ '.number_format($total_venda, 2, ',', '.');
}

function intercarnes_incluir() {
	$data = explode('/', $_POST['data']);

	$int = new FatIntercarnes();

	$int->setProduto($_POST['produto']);
	$int->setMes($data[1]);
	$int->setAno($data[2]);
	$int->setValor($_POST['valor']);

	return $int->save();

}

?>