<?php
require ("../../Connections/conect_mysqli.php");
require ("../../Connections/connect_pgsql.php");
require ("../../class/Interno.class.php");
require ('../../class/Setor.class.php');
require ("../class/Balanco.class.php");

session_start();

$i                = new Interno();
$internos         = $i->fechamentoBalanco($_GET['mes'], $_GET['ano']);
$balanco          = new Balanco(null, null);
$balanco->usuario = $_SESSION['kt_login_user'];

foreach ($internos as $val) {
	$balanco->setor = $val['setor'];
	$balanco->mes   = $val['mes'];
	$balanco->ano   = $val['ano'];

	foreach ($val['item'] as $item => $valor) {
		$balanco->item  = $item;
		$balanco->valor = $valor;
		$balanco->saveBalancoInterno();
	}
}

?>