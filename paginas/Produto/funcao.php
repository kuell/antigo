<?php
	$funcao = $_REQUEST['action'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
	function incluir(){
		$descricao 	= $_POST['descricao'];
		$unidade 	= $_POST['unidade'];
		
		$sql = "insert into produto(PRO_DESCRICAO, PRO_UNIDADE) values('$descricao', '$unidade')";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'pro_list.php';</script>";
		
		}
	function atualizar(){
		$descricao 	= $_POST['descricao'];
		$unidade 	= $_POST['unidade'];
		$id_produto = $_POST['id_produto'];
		
		$sql = "Update produto set PRO_DESCRICAO = '$descricao', PRO_UNIDADE = '$unidade' where PRO_ID = '$id_produto'";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'pro_list.php';</script>";
		}

	function voltar(){
		echo "<script>location.href = 'pro_list.php'</script>";
		}


?>