<?php 
	define('path', '../');
	require(path."../Connections/conn.php");
	
	mysql_select_db($database_conn, $conn);
	echo '<link href="'.path.'../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css">
	';
	echo '<script src="'.path.'../js/jquery.min.js" type="text/javascript"></script>
	';
	echo '<script src="'.path.'../bibliotecas/mascara.js" type="text/javascript"></script>
	';
	echo '<script src="'.path.'../js/muda.js" type="text/javascript"></script>
	';
	session_start();
	define("usuario", $_SESSION['kt_login_user']);
	
	
/*	function incluir($descricao, $ativo, usuario, $qtd, $valor){
		
		$sql = "INSERT INTO 
					  `grupo`
					(
					  `descricao`,
					  `quantidade`,
					  `valor`,
					  `ativo`,
					  `usuario`
					) 
					VALUE (
					  $descricao,
					  $qtd,
					  $valor,
					  $ativo,
					  ".usuario."
					)";
		mysql_query($sql) or die ("Erro ao incluir: ". mysql_error());
							
		
		}
	*/
	
?>


