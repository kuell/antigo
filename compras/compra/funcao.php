<?php
	$pagina = 'manutencao_produto.php';
	define('setor', $_REQUEST['setor']);
	
	$funcao = $_REQUEST['funcao'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
	
	function comprar_produto(){
			$id  = $_REQUEST['id_produto'];
			$pedido = $_REQUEST['pedido'];
			$data = date('Y-m-d');
			
			require('../../connections/conn.php');
			mysql_select_db($database_conn, $conn);
	
	//Compra produto 'X'
			$sql = "update produto_pedido set status = 7, data_compra = '$data' where prod_id = '$id' and PC_ID = '$pedido'";
			mysql_query($sql);
	
	//Muda o status do pedido para 'COMPRANDO'
			$sql2 = "update pedido_compra set pc_status = 8 where pc_id = '$pedido'";
			mysql_query($sql2);
	
	// verifica se ainda há produtos no pedido
			$sqlVerifica = "Select count(status) as resultado from produto_pedido where pc_id = '$pedido' and status = 6";
			$qrVerifica = mysql_query($sqlVerifica) or die (mysql_error());
			$resultadoVerifica = mysql_fetch_assoc($qrVerifica);
				$resultado = $resultadoVerifica['resultado'];
					if($resultado == 0)
					{
						$sqlBaixa = "Update pedido_compra set pc_status = 7 where pc_id = '$pedido'";
						mysql_query($sqlBaixa) or die (mysql_error());
					}
				gravaLog("comprar_produtos.php?setor=".setor);
					
				
			}
	function manutencao_produto(){
		require("../../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		
			$quantidade = $_REQUEST['qtd'];
			$idProduto = $_REQUEST['produto'];
			$idPedido = $_REQUEST['pedido'];
		$sql = "UPDATE produto_pedido
				SET
					qtd = '$quantidade'
				WHERE
					prod_id = '$idProduto' AND pc_id = '$idPedido'";
		require('../../Connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		gravaLog("../pedido/produto_pedido.php?PC_ID=$idPedido");
		}
	function baixar_pedido(){
			require('../../Connections/conn.php');
			mysql_select_db($database_conn, $conn);
		
			 $pedido = $_REQUEST['PC_ID'];
			 $data = date('Y-m-d');
	//Compra o pedido
		 $sql = "update pedido_compra set PC_STATUS = '7' where PC_ID = '$pedido'";
			mysql_query($sql) or die (mysql_error());
	
	//Compra os Produtos do Pedido qua ainda não foram comprados
		 $sql2 = "update `produto_pedido` set status = '7', DATA_COMPRA = '$data' where PC_ID = '$pedido' and status <> 5 and data_compra is not null";
			mysql_query($sql2) or die (mysql_error());
			
			 gravaLog("compra_list.php");
			 }
	function reprova_pedido(){
		$id  = $_REQUEST['id_pedido'];
		echo $id;
		$sql = "UPDATE pedido_compra set pc_status = '4' where pc_id = '$id'";
		$sql_produto = "UPDATE produto_pedido set status = '4' where pc_id = '$id'";
		require('../../connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql) or die (mysql_error());
		mysql_query($sql_produto) or die (mysql_error());
		gravaLog("compra_list.php");
		}
	function reprova_produto(){
		$id  = $_REQUEST['id_produto'];
		$id_produto = $_REQUEST['id_produto'];
		
		$sql_produto = "UPDATE produto_pedido set pc_status = '4' where pc_id = '$id' and prod_id = $id_produto";
		require('../../connections/conn.php');
		mysql_select_db($database_conn, $conn);
		mysql_query($sql_produto) or die (mysql_error());
		gravaLog("compra_list.php");
		
		}
	function pedido_estorno(){
		require("../../Connections/conn.php");
		mysql_select_db($database_conn, $conn);
		
		$id = $_REQUEST['idPedido'];
		$sql = "
				update pedido_compra
				set	pc_status = '7'
				where pc_id = '$id'		
		";
		mysql_query($sql);
		
		gravaLog("pedido_manut.php?PC_ID=$idPedido");
		}


	function gravaLog($direciona){
			session_start();
			global $funcao;
			$pedido		= $_REQUEST['PC_ID'];
			if(!$pedido){
				$pedido  = $_REQUEST['pedido'];
				}
			if(!$pedido){
				$pedido  = $_REQUEST['id_pedido'];
				}
			
			$usuario = $_SESSION['kt_login_user'];
			$data_arquivo = date('d-M-Y');
			
			$hora = date('H') - 1;
			
			$data = date("d-m-Y ($hora:i)");
			
			if($_REQUEST['id_produto'] <> ""){
				$idProd = $_REQUEST['id_produto'];
				}				
			if($_REQUEST['PROD_ID'] <> ""){
				$idProd = $_REQUEST['PROD_ID'];
				}				
			if($_REQUEST['id_prod'] <> ""){
				$idProd = $_REQUEST['id_prod'];
				}
			if($_REQUEST['PRODUTO'] <> ""){
				$idProd = $_REQUEST['PRODUTO'];
				}
			if($_REQUEST['produto'] <> ""){
				$idProd = $_REQUEST['produto'];
				}
			
					if(!$idProd)
						{
							$produto = "";
						}
						else
						{
							$produto = "Produto: ".$idProd;
						} 
			
			// Abre ou cria o arquivo bloco1.txt
			// "a" representa que o arquivo é aberto para ser escrito
			$fp = fopen('logs/log '.$data_arquivo.'.txt', "a");
			// Escreve "exemplo de escrita" no bloco1.txt
			$escreve = fwrite($fp, "Usuario: ".$usuario." Data/Hora: ".$data." - Pedido: ".$pedido." -   Acao = ".$funcao." - $produto \r\n");
						
			header("Location: $direciona"); 
						
						}	

?>