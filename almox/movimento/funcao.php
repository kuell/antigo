<?php
require ("../../Connections/conect_mysqli.php");
require ('../../class/Almoxarifado.php');

session_start();

$funcao = $_REQUEST['funcao'];

if (function_exists($funcao)) {
	call_user_func($funcao);
}

function incluir() {
	$almox = new Almoxarifado();
	$almox->setData(implode('-', array_reverse(explode('/', $_REQUEST['data']))));
	$almox->setGrupo($_REQUEST['grupo']);
	$almox->setTipo($_REQUEST['tipo']);
	$almox->setQtd($_REQUEST['qtd']);
	$almox->setValor($_REQUEST['valor']);

	print_r($almox->save());
}
function delete() {
	$almox = new Almoxarifado();
	$almox->setData(implode('-', array_reverse(explode('/', $_REQUEST['data']))));
	$almox->setGrupo($_REQUEST['grupo']);
	$almox->setTipo($_REQUEST['tipo']);
	return $almox->delete();
}

function listar() {
	$almox = new Almoxarifado();
	print_r($almox->getMovimentos('2015-01-29'));
}

?>