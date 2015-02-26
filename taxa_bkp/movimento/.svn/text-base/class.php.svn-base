<?php 
	require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
	
	$idMov = $_REQUEST['id_mov'];
	
	$funcao = $_REQUEST['funcao'];
	
	if(function_exists($funcao)){
		call_user_func($funcao);
		}
	function salvar_movimento(){
		global $idMov;
		echo "Salver Movimento";
		//header("Location: mtx_f.php?$id_mov");
		}
	function voltar(){
		header("Location: mtx_l.php");		
		
		}
?>