<?php
	$funcao = $_REQUEST['action'];
	if(function_exists($funcao)){
		call_user_func($funcao);
		}
	
	function busca_categ(){
		require("../../Connections/conn.php");
		   	mysql_select_db($database, $conn);
			
			$avaliacao = $_POST['avaliacao'];
			
			$sql = "Select * from categoria where id_aval = '$avaliacao'";
			$qr = mysql_query($sql) or die(mysql_error());
			echo '<option value="0">Selecione uma categoria</option>';
			while($ln = mysql_fetch_assoc($qr)){
				echo '<option value="'.$ln['CATEG_ID'].'">'.$ln['CATEG_DESC'].'</option>';
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
				echo '<option value="'.$ln['ID_SUB'].'">'.$ln['SUB_DESC'].'</option>';
				}	
		}
?>