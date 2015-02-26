<?php
		//pego o nome da função que foi passada para o campo hidden 
		
				 $requisitante  	= $_POST["requisitante"];
				 $responsavel 		= $_POST["responsavel"]; 
				 $servico			= $_POST["servico"];
				 $equipamento		= $_POST["equipamento"];
				 $setor				= $_POST["setor"];
				 $prazo				= $_POST["prazo"];
				 $funcao			= $_REQUEST['action'];
		
							if (function_exists($funcao)) {
								 call_user_func($funcao);
								 } 
		
		 function salvar(){
			 session_start();
				 $requisitante  	= $_SESSION['kt_login_id'];
				 $responsavel 		= $_POST["responsavel"]; 
				 $servico			= $_POST["servico"];
				 $equipamento		= $_POST["equipamento"];
				 $setor				= $_POST["setor"];
				 $obs				= $_POST["descricao"];
				
			require_once('../../Connections/conn.php');
			$sql ="INSERT INTO `sig`.`ordem_interna` (`requisitante` ,`responsavel` ,`servico` ,`equipamento` ,`setor` ,`obs`)
	VALUES ('$requisitante', '$responsavel', '$servico', '$equipamento', '$setor', '$obs')";
			mysql_select_db($database_conn, $conn);
			//mysql_select_db('sig',$conn);
			$Result1 = mysql_query($sql, $conn) or die(mysql_error());	
			echo "<script>location.href = 'mov_list.php?PC_ID=$pedido';</script>";
		 }
		 
		function editar() 
		{ 
				 $id				= $_POST['id_osi'];
				 $responsavel 		= $_POST["responsavel"]; 
				 $servico			= $_POST["servico"];
				 $equipamento		= $_POST["equipamento"];
				 $setor				= $_POST["setor"];
				 $obs				= $_POST["descricao"];
				require_once('../../Connections/conn.php');
			$sql ="UPDATE ordem_interna SET 
							responsavel	= '$responsavel', 
							servico 	= '$servico',
							equipamento	= '$equipamento',
							setor		= '$setor',
							prazo_conclusao = '',
							obs			= '$obs'
				 WHERE id_osi = '$id'";
			
			mysql_select_db($database_conn, $conn);
			//mysql_select_db('sig',$conn);
			$Result1 = mysql_query($sql, $conn) or die(mysql_error());	
			echo "<script>location.href = 'mov_list.php?PC_ID=$pedido';</script>";
				
		} 
		
		function executar() 
		{ 
				 $id				= $_REQUEST['id_osi'];
				 $executante 		= $_REQUEST['executante'];
				 $executa			= 3;
				 
				 echo "ID = $id<br>Executante = $executante<br>Executa = $executa";
				require_once('../../Connections/conn.php');
			$sql ="UPDATE ordem_interna SET 
							executante = '$executante',
							status = '$executa'				
				 WHERE id_osi = '$id'";
			
			mysql_select_db($database_conn, $conn);
			mysql_query($sql, $conn) or die(mysql_error());	
			echo "<script>history.back(1);</script>";
				
		} 
		
		function excluir() 
		{ 
				 $id				= $_GET['id_osi'];
				require_once('../../Connections/conn.php');
			$sql ="DELETE FROM ordem_interna
				 WHERE id_osi = '$id'";
			
			mysql_select_db($database_conn, $conn);
			mysql_query($sql) or die(mysql_error());	
			echo utf8_decode("<script>alert('Ordem de serviço excluida!');location.href = 'mov_list.php?PC_ID=$pedido';</script>");
				
		} 
		
		
		
		 
		function voltar() 
		{ 
			   echo "<script>location.href = 'mov_list.php';</script>";
		}
	?>