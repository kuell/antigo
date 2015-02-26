<?php
	$funcao = $_REQUEST['action'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
		if($funcao == ""){
			echo "<script>location.href = 'servico_list.php';</script>";
			}
	function incluir(){
		$servico 	= $_POST['servico'];

		
		$sql = "insert into acao(acao) values('$servico')";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'servico_list.php';</script>";
		
		}
	function atualizar(){
		$servico	= 	$_POST['servico'];
		$id 		=	$_POST['id_acao'];
		$sql = "Update acao set acao = '$servico' where id_acao = '$id'";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'servico_list.php';</script>";
		}
	function buscar(){
		$servico = $_POST['servico'];
		echo "<script>location.href = 'servico_list.php?id=$servico';</script>";
		}
	function cancelar(){
		echo "<script>location.href = 'servico_list.php?id_servico=%'</script>";
		}


?>