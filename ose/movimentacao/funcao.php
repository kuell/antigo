<?php
	require('../../Connections/conn.php');
	mysql_select_db($database_conn, $conn);
	
	$funcao = $_REQUEST["action"];
	if(function_exists($funcao)){
					   call_user_func($funcao);
				   }
				   
	function excluir(){
	$id = $_REQUEST['id_ose'];
		$sql = "DELETE FROM ordem_externa where id_ose = $id";
		mysql_query($sql) or die (mysql_error());
		
		header("Location: mov_list.php");
	
	
	}
				   
				   
	function orcamento(){		
		$id = $_POST['id_OSE'];
		$orcamento = $_POST['orcamento'];
		$valor = $_POST['preco'];
		$arquivo = $_FILES['arquivo']['name'];
		if(file_exists("arquivos/$id"))
			{
			echo "Diretorio ja existente";
			}
		else
			{
				mkdir("arquivos/$id", 0777);
			}
			
		$novo_nome = "arquivos/$id/orcamento".strrchr($arquivo, '.');
		move_uploaded_file($_FILES['arquivo']['tmp_name'],$armazenamento.$novo_nome);
		$sql = 
			"Update ordem_externa 
				set
					num_orcamento = '$orcamento',
					preco_servico = '$valor',
					orcamento = '$novo_nome'
				where 
					id_ose = '$id'			
			";
		mysql_query($sql) or die (mysql_error());
		echo "<div align='center' class='ewHeaderRow'>O Or�amento foi Lan�ado, a Ordem Externa esta esperando Aprova��o!<div>";
		echo "<div align='center' class='ewHeaderRow'><a href = 'class_form.php?id_OSE=$id'>Classificar Ordem de servi�o</a><div>";
		}
	function aprovar(){
		$id 	= $_POST['id_OSE'];
		require('../../Connections/conn.php');
		$sql = "
					update ordem_externa set
							status	=	'3'
						where id_OSE = '$id'";
		mysql_select_db($database_conn, $conn);
		$result = mysql_query($sql);
		echo "<div align='center' class='ewHeaderRow'>Ordem Externa N. = ".$id." Aprovada com sucesso!<div>";
		}
	function reprovar(){
		$id 	= $_POST['id_OSE'];
		require('../../Connections/conn.php');
		$sql = "
					update ordem_externa set
							status	=	'4'
						where id_OSE = '$id'";
		mysql_select_db($database_conn, $conn);
		$result = mysql_query($sql);
		echo "<div align='center' class='ewHeaderRow'>Ordem Externa N. = ".$id." Reprovada!<div>";
		}
	function receber(){
		$id = $_REQUEST['id'];
		$nota = $_REQUEST['nota'];
		
		if(!$nota){
			echo "<script>alert('O campo nota fiscal n�o pode ser nulo'); history.back(1);</script>";
			}
		
		
			$sql = "update ordem_externa set
							status = '5',
							num_nota = '$nota'
						where id_ose = '$id'";
		require("../../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		mysql_query($sql);
		echo "<div align='center'>Equipamento Recebido!</div>";		
		}
	function cancelar(){
		echo "<div align='center'>A��o Cancelada!</div>";
		}
	function estornar(){
		$id = $_REQUEST['id'];
			$sql = "update ordem_externa set
							status = '1'
						where id_ose = '$id'";
		require("../../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		echo "<script>window.location = 'manutencao.php'</script>";		
		}
	
?>