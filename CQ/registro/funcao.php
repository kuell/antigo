<?php

		$id				= $_POST['cod'];
		$data			= date('Y-m-d', strtotime($_POST['data']));
		$hora			= date('H:m', strtotime($_POST['hora']));
		$funcionario	= $_POST['agente'];
		$avaliacao		= $_POST['avaliacao'];
		$setor			= $_POST['setor'];
		$categoria		= $_POST['categoria'];
		$sub			= $_POST['sub'];
		$item			= $_POST['itens'];
		$desc 			= $_POST['desc'];
		$qtd			= $_POST['qtd'];

	$funcao = $_REQUEST['action'];
	if(function_exists($funcao)){
		call_user_func($funcao);
		}
	
	function busca_categ(){
		require("../../Connections/conn.php");
		   	mysql_select_db($database, $conn);
			
			$avaliacao = $_REQUEST['avaliacao'];
			$sql = "Select * from categoria where id_aval = '$avaliacao'";
			$qr = mysql_query($sql) or die(mysql_error());
			echo '<option value="0">Selecione uma categoria</option>';
			while($ln = mysql_fetch_assoc($qr)){
				echo '<option value="'.$ln['CATEG_ID'].'">'.utf8_encode($ln['CATEG_DESC']).'</option>';
				}	
		}
	function busca_sub(){
		require("../../Connections/conn.php");
		   	mysql_select_db($database, $conn);
			
			$avaliacao = $_POST['avaliacao'];
			$categoria = $_POST['categoria'];
			
			$sql = "Select * from sub_categoria where id_categ = '$categoria'";
			$qr = mysql_query($sql) or die(mysql_error());
			echo '<option value="0">Selecione uma sub-categoria</option>';
			while($ln = mysql_fetch_assoc($qr)){
				echo '<option value="'.$ln['ID_SUB'].'">'.utf8_encode($ln['SUB_DESC']).'</option>';
				}	
		}
	function busca_item(){
		require("../../Connections/conn.php");
		   	mysql_select_db($database, $conn);
			
			$setor = $_POST['setor'];
			$sql = "Select * from itens where setor = '$setor'";
			$qr = mysql_query($sql) or die(mysql_error());
			echo '<option value="0">Selecione um item</option>';
			while($ln = mysql_fetch_assoc($qr)){
					echo '<option value="'.$ln['ID_ITEM'].'">'.utf8_decode($ln['DESC_ITEM']).'</option>';
				}	
				
		}
	function voltar(){
		echo "<script>location.href = 'registro_list.php';</script>";
		}
	function salvar_registro(){
		global $id;
		global $data;
		global $hora;
		global $setor;
		global $funcionario;
		global $avaliacao;
		global $categoria;
		global $sub;
		global $item;
		global $desc;
		global $qtd;
		require("../../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		$sql = "Insert into registro_controle(DATA, HORA, AGENTE, AVALIACAO, CATEGORIA, SUB_CATEGORIA, ITEM, DESC_NC, QUANTIDADE, SETOR)
							value('$data', '$hora', '$funcionario', '$avaliacao', '$categoria', '$sub', '$item', '$desc', '$qtd', '$setor')";
		$qr = mysql_query($sql) or die (mysql_error());
		header("Location: registro_form.php");
		
		}
	function excluir_registro(){
		require("../../Connections/conn.php");
		   	mysql_select_db($database, $conn);
		$id = $_REQUEST['id'];
		$sql = "delete from registro_controle where ID_REGISTRO = '$id'";
		mysql_query($sql) or die (mysql_error());
		header("Location: registro_list.php");
		}
?>