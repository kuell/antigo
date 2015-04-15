
<?php
require "../Connections/conect_mysqli.php";
require "class/Escala.php";
require "class/PreEscala.php";

$action = $_REQUEST['action'];
session_start();

if (function_exists($action)) {
	call_user_func($action);
}

function delete() {
	$pre = new PreEscala();
	$id  = $_REQUEST['id'];
	$pre->delete($id);

	header('Location: pre_escala.php?dt='.$_SESSION['data']);

}

function grava() {
	$pre             = new PreEscala();
	$pre->data       = $_REQUEST['data'];
	$pre->corretor   = $_REQUEST['corretor'];
	$pre->pecuarista = $_REQUEST['pecuarista'];
	$pre->qtdBoi     = $_REQUEST['qtdBoi'];
	$pre->qtdVaca    = $_REQUEST['qtdVaca'];
	$pre->qtdNov     = $_REQUEST['qtdNov'];
	$pre->qtdTouro   = $_REQUEST['qtdTouro'];

	$pre->grava($pre);
	header('Location: pre_escala.php?dt='.$_SESSION['data']);

}

function confirma() {
	$pre = new PreEscala();
	$id  = $_GET['id'];

	$pre->id = $id;

	$pre->confirmar();

	header('Location:  pre_escala.php?dt'.$_SESSION['data']);

}

function buscaPecuarista() {
	$pre        = new PreEscala();
	$pecuarista = $_REQUEST['pecuarista'];

	print_r(json_encode($pre->buscaPecuarista(' and pecuarista like "'.$pecuarista.'%"')));

}

function ordenar() {
	$escala       = new Escala();
	$ordem        = $_GET['ordem'];
	$lote         = $_GET['lote'];
	$escala->data = $_GET['data'];

	$escala->ordena($ordem, $lote);

	header("Location: escala.php?data=".date('d/m/Y', strtotime($_GET['data'])));

}

function deleteEscala() {
	$escala            = new Escala();
	$escala->id        = $_GET['id'];
	$escala->data      = $_GET['data'];
	$escala->lote      = $_GET['lote'];
	$escala->preEscala = $_GET['pe'];
	$escala->delete();

	header("Location: escala.php?data=".date('d/m/Y', strtotime($_GET['data'])));

}

function gravaEscala() {
	$e = new Escala();

	$e->preEscala  = 'null';
	$e->data       = $_POST['data'];
	$e->corretor   = $_POST['corretor'];
	$e->pecuarista = $_POST['pecuarista'];
	$e->qtdBoi     = $_POST['qtdBoi'];
	$e->qtdVaca    = $_POST['qtdVaca'];
	$e->qtdNov     = $_POST['qtdNov'];
	$e->qtdTouro   = $_POST['qtdTouro'];
	$e->lote       = $_POST['lote'];

	if ($_POST['id']) {
		$e->id = $_POST['id'];
		$e->update();
	} else {
		$e->insert();
	}
	header('Location: escala.php?data='.date('d/m/Y', strtotime($e->data)));
}

?>