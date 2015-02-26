<?php 
	require('../../Connections/conn.php');
	mysql_select_db($database_conn, $conn);
	
	define('id', $_REQUEST['id']);
	define('desc',$_REQUEST['desc']);
	define('ativo',$_REQUEST['ativo']);
	
	$funcao = $_REQUEST['funcao'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
	
		function incluir(){
			$sql = "insert into rh_item(descricao, ativo) value ('".desc."', '".ativo."')";
			mysql_query($sql) or die (mysql_error());
			echo "<script>window.location = 'item_f.php'</script>";
			}
		function atualiza(){
			$sql = "update rh_item set descricao = '".desc."',
											ativo = '".ativo."'
									where
										id = '".id."'";
				mysql_query($sql) or die (mysql_error());
				
				volta();
			
			
			}
		
		function volta(){
			
			header("Location: item_l.php");			
			}
		function ativo(){
			$setor = $_REQUEST['setor'];
			$ativo = $_REQUEST['op'];
			
			$sql = "UPDATE
						setor
							set rh = '".$ativo."'
					 where 
							id_setor = '".$setor."'";
			echo $sql;
			mysql_query($sql) or die (mysql_error());

			header("Location: setor.php");
			
			
			}





?>