<?php
	$funcao = $_REQUEST['action'];
	if(function_exists($funcao)){
		call_user_func($funcao);
		}
	
	function avaliacao_salvar(){
		$descricao = $_POST['descricao'];
		$sql = "insert into avaliacao(DESC_AVAL) value ('$descricao')";
		require("../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		echo "<div align='center'>Registro incluido com sucesso!</div>";
		}
	function avaliacao_editar(){
		$descricao 	= $_POST['descricao'];
		$id			= $_REQUEST['id_avalia'];
		$sql = "update avaliacao set DESC_AVAL = '$descricao' where ID_AVAL = '$id'";
		require("../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		echo "<div align='center'>Registro atualizado com sucesso!</div>";
		}
	
	function categoria_salvar(){
		$categoria		= $_POST['categoria'];
		$avaliacao			= $_POST['avaliacao'];
		
		$sql = "Insert into categoria(ID_AVAL, CATEG_DESC) value('$avaliacao', '$categoria') ";
		
		require("../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		mysql_query($sql);
			
		echo "<div align='center'>Categoria salva com sucesso!</div>";
		}
	function categoria_editar(){
		$categoria		= $_POST['categoria'];
		$avaliacao			= $_POST['avaliacao'];
		$id					= $_REQUEST['id_categoria'];
		echo "id = $id, Avaliacao = $avaliacao, $categoria";
		$sql = "update categoria set
							categ_desc = '$categoria'
				where categ_id = '$id'";
		require('../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		
		echo "<div align='center'>Categoria atualizada com sucesso!</div>";
		}
	function sub_salvar(){
		$avaliacao		= $_POST['avaliacao'];
		$categoria		= $_POST['categoria'];
		$sub			= $_POST['sub'];
		require("../Connections/conn.php");
		$sql = "Insert Into sub_categoria(ID_AVAL, ID_CATEG, SUB_DESC) values('$avaliacao', '$categoria', '$sub')";
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die(mysql_error());
		
		echo "<div align='center'>Sub-Categoria Incluida com sucesso!</div>";
		echo "<div align='center'><a href='sub_categoria/sub_form.php'>Incluir nova</a></div>";
		
		}
	function sub_editar(){
		$avaliacao		= $_POST['avaliacao'];
		$categoria		= $_POST['categoria'];
		$sub			= $_POST['sub'];
		$id				= $_REQUEST['id_sub'];
		require("../Connections/conn.php");
		$sql = "Update sub_categoria set 
					ID_AVAL = '$avaliacao', 
					ID_CATEG = '$categoria', 
					SUB_DESC = '$sub' 
				where 
					id_sub = '$id'";
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		echo "<div align='center'>Sub-Categoria Atualizada com sucesso!</div>";
		
		}
	function salvar_item(){
		require("../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		$item			= $_POST['item'];
		$setor			= $_POST['setor'];
		
		$sql = "Insert Into itens(DESC_ITEM, setor) value ('$item', '$setor')" ;
		$result = mysql_query($sql) or die(mysql_error());
		header("Location: itens/itens_form.php");
		}
	function editar_item(){
			require("../Connections/conn.php");
			mysql_select_db($database_conn, $conn);
		$item			= $_POST['item'];
		$setor			= $_POST['setor'];
		$id				= $_REQUEST['id_item'];
		
		$sql = "Update itens set
						setor = '$setor',
						DESC_ITEM = '$item' 
				where ID_ITEM = '$id'";
		$qr = mysql_query($sql) or die (mysql_error());
		echo "<div align='center'>Item Atualizado com sucesso!</div>'";
			}
	function busca_categ(){
		require("../Connections/conn.php");
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
		require("../Connections/conn.php");
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
	function busca_categoria(){
		require("../Connections/conn.php");
		   	mysql_select_db($database, $conn);
			
			$setor = $_POST['setor'];
			
			$sql = "Select * from seg_categoria where id_setor = '$setor'";
			$qr = mysql_query($sql) or die(mysql_error());
			echo '<option value="0">Selecione uma categoria</option>';
			while($ln = mysql_fetch_assoc($qr)){
				echo '<option value="'.$ln['ID_CATEG'].'">'.$ln['DESC_CATEG'].'</option>';
				}
		}
	function seg_categ_salvar(){
			require("../Connections/conn.php");
			mysql_select_db($database_conn, $conn);
			$categoria = $_POST['categoria'];
			$setor = $_POST['setor'];
			
			$sql = "Insert into seg_categoria(ID_SETOR, DESC_CATEG) value('$setor', '$categoria')";
			$qr = mysql_query($sql) or die (mysql_error());
			
			echo "<div align='center'>Registro Incluido com sucesso!</div><br />
					$setor, $categoria";
			}
	function seg_categ_editar(){
			require("../Connections/conn.php");
			mysql_select_db($database_conn, $conn);
			$id = $_REQUEST['id_categ'];
			$categoria = $_POST['categoria'];
			$setor = $_POST['setor'];
			
			$sql = "update seg_categoria set
						ID_SETOR = '$setor',
						DESC_CATEG = '$categoria'
				where ID_CATEG = $id";
			$qr = mysql_query($sql);
			
		echo "<div align='center'>Registro Alterado com sucesso!</div>";
		}
	function salvar_posto(){
		require("../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		$categoria = $_POST['categ'];
		$setor 	= $_POST['setor'];
		$posto  = $_POST['posto'];
		
		$sql = "insert into posto_trabalho (ID_SETOR, ID_CATEGORIA, DESC_POSTO) value ('$setor', '$categoria', '$posto')";
		$qr = mysql_query($sql);
		
		echo "<div align='center'>Posto de Trabalho Incluido</div><br />";
		echo "<div align='center'><a href = 'posto/posto_form.php'>Novo Posto de Trabalho</a></div>";
		}
	function busca_posto(){
		require("../Connections/conn.php");
		   	mysql_select_db($database, $conn);
			
			$categoria = $_POST['categ'];
			
			$sql = "Select * from posto_trabalho where id_categoria = '$categoria'";
			$qr = mysql_query($sql) or die(mysql_error());
			echo '<option value="0">Selecione um Posto de Trabalho</option>';
			while($ln = mysql_fetch_assoc($qr)){
				echo '<option value="'.$ln['ID_POSTO'].'">'.$ln['DESC_POSTO'].'</option>';
				}	
		}
		
?>