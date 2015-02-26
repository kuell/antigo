<?php
		//pego o nome da função que foi passada para o campo hidden 
		
				 $funcao			= $_REQUEST['action'];
		
							if (function_exists($funcao)) {
								 call_user_func($funcao);
								 } 		 
		function concluir() 
		{ 
				 $id				= $_REQUEST['id_osi'];
				 $status				= 4;
				require_once('../../../Connections/conn.php');
			$sql ="UPDATE ordem_interna SET 
							status = '$status'								
				 WHERE id_osi = '$id'";
			
			mysql_select_db($database_conn, $conn);
			//mysql_select_db('sig',$conn);
			$Result1 = mysql_query($sql, $conn) or die(mysql_error());	
			echo "<script>location.href = 'mov_list_conc.php';</script>";
				
		} 
		 
?>