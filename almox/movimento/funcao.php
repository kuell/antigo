<?php 
	require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
	
	session_start();
	
	define('usuario', $_SESSION['kt_login_user']);
	define('id', $_REQUEST['id']);
	define('data', date('Y-m-d', strtotime($_REQUEST['data'])));
	define('grupo', $_REQUEST['grupo']);
	define('tipo', $_REQUEST['tipo']);
	define('qtd', str_replace(',','.',str_replace('.','',$_REQUEST['qtd'])));
	define('valor', str_replace(',','.',str_replace('.','',$_REQUEST['valor'])));
	
	
	$funcao = $_REQUEST['funcao'];
	
	if(function_exists($funcao)){
		call_user_func($funcao);
		}

		function incluir(){
				$sql = "call mov_almox_proc('".data."','".grupo."','".tipo."','".qtd."','".valor."','".usuario."')";
				echo $sql;
				mysql_query($sql) or die (mysql_error());
				
			echo "<script>history.back(1);</script>";
			}
		function excluir(){
			$sql = " delete from 
					 	mov_almox  
					 WHERE 
					 	data = '".data."' and 
						grupo = '".grupo."' and 
						tipo = '".tipo."'";
						echo $sql.'<br >';
			mysql_query($sql) or die (mysql_error());
			header("Location: operacao.php?data=".data."&id=".grupo);
			}


		


?>