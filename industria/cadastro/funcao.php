<?php 
	require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
define('produto', $_POST['descricao']);
define('tipo', $_POST['tipo']);
define('ativo',	$_POST['ativo']);
define('cod', $_REQUEST['cod']);

define('descricao', $_REQUEST['descricao']);
define('cod_fat', $_REQUEST['cod_fat']);
define('cod_prod', $_REQUEST['cod_prod']);


	$funcao = $_REQUEST['funcao'];
	if(function_exists($funcao))
	{
		call_user_func($funcao);
	}
	function adicionar(){
		$sql = "INSERT INTO ind_produtos (cod, descricao, tipo, ativo) 
								   value('".cod."','".produto."','".tipo."','".ativo."')";
																				 
		echo $sql;
		mysql_query($sql) or die (mysql_error());
		
		header("Location: produto_list.php");
		}
	function adicionar_fat(){
		$sql = "INSERT INTO fat_produto (cod_prod,cod_fat, descricao, ativo) 
								   value('".cod_prod."','".cod_fat."','".descricao."','".ativo."')";
																				 
		echo $sql;
		mysql_query($sql) or die (mysql_error());
		
		header("Location: fat_prod_l.php");
		}
	function atualiza_fat(){
		$sql = "update fat_produto 
					set
						cod_prod = '".cod_prod."',
							cod_fat = '".cod_fat."',
							descricao = '".descricao."',
							ativo =  '".ativo."'
						where
							id = '".cod."'";
																											 
		echo $sql;
		mysql_query($sql) or die (mysql_error());
		
		header("Location: fat_prod_l.php");
		}





?>
