<?php
	$funcao = $_REQUEST['action'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
function incluir(){
	$id			= $_POST['id_usuario'];
	$sistema	= $_POST['sistema'];
	
	$sql = "insert into sistema_acesso(id_usuario, id_sistema)
						values('$id', '$sistema')";
	require('../../Connections/conn.php');
	mysql_select_db($database_conn, $conn);
	$resultado = mysql_query($sql);
	echo "<script>location.href = 'usuario_sistema.php?id_funcionario=$id';</script>";
	
	}

function excluir(){
	$id			= $_REQUEST['id_funcionario'];
	$sistema	= $_REQUEST['sistema'];
	$sql = "DELETE FROM sistema_acesso WHERE id_usuario = '$id' AND id_sistema = '$sistema'";
	require('../../Connections/conn.php');
	mysql_select_db($database_conn, $conn);
	$resultado = mysql_query($sql) or die (mysql_error());
	echo "<script>location.href = 'usuario_sistema.php?id_funcionario=$id';</script>";
	}


?>