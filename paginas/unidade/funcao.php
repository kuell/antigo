<?php
	$funcao = $_REQUEST['action'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
		if($funcao == ""){
			echo "<script>location.href = 'unidade.php';</script>";
			}
	function incluir(){
		$unidade 	= $_POST['unidade'];

		
		$sql = "insert into unidade_medida(UM_DESCRICAO) values('$unidade')";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'unidade.php';</script>";
		
		}
	function atualizar(){
		$unidade	= 	$_POST['unidade'];
		$id 		=	$_POST['id_unidade'];
		$sql = "Update unidade_medida set UM_DESCRICAO = '$unidade' where UM_ID = '$id'";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'unidade.php';</script>";
		}
	function buscar(){
		$unidade = $_POST['unidade'];
		echo "<script>location.href = 'unidade.php?unidade=$unidade';</script>";
		}
	function cancelar(){
		echo "<script>location.href = 'unidade.php';</script>";
		}


?>