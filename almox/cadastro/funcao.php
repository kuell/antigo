<?php 
	require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
	
	
	// Variaveis
	define('id', $_REQUEST['id']);
	define('descricao', $_REQUEST['descricao']);
	define('qtd', str_replace(',','.',str_replace('.','',$_REQUEST['qtd'])));
	define('valor', str_replace(',','.',str_replace('.','',$_REQUEST['valor'])));
	define('ativo', $_REQUEST['ativo']);
	
		if(descricao == ''){
			echo "<script>alert('O campo Descrição não pode ser nulo');
							history.back(1);</script>";
			
			}
	
	$funcao = $_REQUEST['funcao'];
	
	if(function_exists($funcao)){
		call_user_func($funcao)	;
		
		}
	
	
	
	function incluir(){
		
		$sql = "INSERT INTO 
							  `grupo`(
							  `descricao`,
							  `quantidade`,
							  `valor`,
							  `ativo`,
							  `usuario`
							) 
							VALUE (
							  '".descricao."',
							  '".qtd."',
							  '".valor."',
							  '".ativo."',
							  '".usuario."'
							)";
		mysql_query($sql) or die (mysql_error());
		echo $sql;
		header("Location: grupo_l.php");
				}
	function alterar(){
		$sql = "
			UPDATE   `grupo`  
				SET 
				  `descricao` = '".descricao."',
				  `ativo` = '".ativo."',
				  `usuario` = '".usuario."'
				WHERE 
				  `id` = '".id."'";
		
		mysql_query($sql) or die (mysql_error());
		
		header("Location: grupo_l.php");
		
		
		}



	function voltar(){
		header("Location: grupo_l.php");
		
		}



?>