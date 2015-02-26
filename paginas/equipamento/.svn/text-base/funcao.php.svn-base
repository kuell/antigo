<?php
	$funcao = $_REQUEST['action'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
	function incluir(){
		$equipamento 	= $_POST['equipamento'];
		$categoria 		= $_POST['categoria'];
		$setor			= $_POST['setor'];
		$serie			= $_POST['serie'];
		$patrimonio		= $_POST['patrimonio'];
		$identificador	= $_POST['identificador'];
		$sql = "insert into equipamento(equipamento, id_categoria, setor, num_serie, num_patrimonio, identificador) 
								values('$equipamento', '$categoria', '$setor', '$serie', '$patrimonio', '$identificador')";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'equip_list.php';</script>";
		
		}
	function atualizar(){
		$id				= $_POST['id_equip'];
		$equipamento 	= $_POST['equipamento'];
		$categoria 		= $_POST['categoria'];
		$setor			= $_POST['setor'];
		$serie			= $_POST['serie'];
		$patrimonio		= $_POST['patrimonio'];
		$identificador	= $_POST['identificador'];
		//echo "$id = id, <br> $equipamento = equip<br> $categoria = categ<br> $setor = setor<br> $serie = serie<br> $patrimonio = patri<br> $identificador = identifica";
		$sql = "Update equipamento set 
							equipamento = '$equipamento', 
							id_categoria = '$categoria',
							setor		= '$setor',
							num_serie		= '$serie',
							num_patrimonio 	= '$patrimonio',
							identificador	= '$identificador'							
							where id_equipamento = '$id'";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		echo "<script>location.href = 'equip_list.php';</script>";
		}

	function voltar(){
		echo "<script>location.href = 'equip_list.php'</script>";
		}


?>