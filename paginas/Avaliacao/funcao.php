<?php
	$funcao = $_REQUEST['acao'];
	if(function_exists($funcao)){
		call_user_func($funcao);
		}
	function salvar(){
		$descricao = $_REQUEST['descricao'];
		$sql = "insert into avaliacao(DESC_AVAL) value ('$descricao')";
		require("../../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		echo "<div align='center'>Registro incluido com sucesso!</div>";
		}



?>