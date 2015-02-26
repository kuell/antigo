<?php
	require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
	// cadastro de corretor
		$corNome	= $_REQUEST['cor_nome'];
		$corCod 	= "COR ".$_REQUEST['cor_cod'];
		$corId		= $_REQUEST['cor_id'];
		$corAtivo	= $_REQUEST['cor_ativo'];
	// cadastro de produtos e itens
		$prodDesc 	= $_REQUEST['prod_nome'];
		$prodUnMed	= $_REQUEST['unidade_medida'];
		$prodTipo	= $_REQUEST['prod_tipo'];
		$prodId		= $_REQUEST['prod_id'];

	$funcao = $_REQUEST['funcao'];
		if(function_exists($funcao)){
			call_user_func($funcao);
			}
			echo $funcao;
	
	function valida_cor(){
		global $corNome;
		if($corNome == ""){ 
				echo "<script>alert('Os campos Codigo interno e Nome do corretor não podem ser nulos!); history.back(1)'</script>";}
			
		echo "Valida corretor";
		
		}
		
	
	
	function add_cor(){
		global $corNome;
		global $corCod;
		global $corAtivo;

		if(!$corCod){
			echo "<script>history.back(1); alert('O campo Codigo interno do Corretor não pode ser nulo!');</script>";
			}
		if(!$corNome){
			echo "<script>history.back(1); alert('O campo Nome do Corretor não pode ser nulo!');</script>";
			}
		
		$sql = "Insert into corretor(cor_nome, cor_cod, cor_ativo) value('$corNome', '$corCod', '$corAtivo')";
		$query = mysql_query($sql) or die (mysql_error());
		
	Voltar("cor/cl.php");
		}
	function edit_cor(){
		global $corId;
		global $corAtivo;
		$sql = "update 
					corretor
				set
					cor_ativo = '$corAtivo'
				where
					cor_id = '$corId'";
		$query = mysql_query($sql) or die (mysql_error());
		
		Voltar("cor/cl.php");
		}
	function Voltar($pagina){
		 mysql_close($conn);
		header("Location: $pagina");
		}
	function add_prod(){
		global $prodDesc;
		global $prodUnMed;
		global $prodTipo;
		
		if(!$prodTipo){
			echo "<script>history.back(1); alert('O campo Descrição não pode ser nulo!');</script>";
			}
		if(!$prodDesc){
			echo "<script>history.back(1); alert('O campo Descrição não pode ser nulo!');</script>";
			}
		
			$sql = "Insert Into txproduto(prod_desc, prod_UnMed, prod_tipo) value ('$prodDesc', '$prodUnMed', '$prodTipo')";
			$query = mysql_query($sql) or die (mysql_error());
		Voltar("produtos_Itens/pl.php");
		
		}
	function edit_prod(){
		echo $funcao;
		global $prodDesc;
		global $prodUnMed;
		global $prodTipo;
		global $prodId;
		
		if(!$prodTipo){
			echo "<script>history.back(1); alert('O campo Descrição não pode ser nulo!');</script>";
			}
		if(!$prodDesc){
			echo "<script>history.back(1); alert('O campo Descrição não pode ser nulo!');</script>";
			}else{
		
			$sql = "Update 
						txproduto
					set
						prod_desc = '$prodDesc', 
						prod_UnMed = '$prodUnMed', 
						prod_tipo = '$prodTipo'
					where
						prod_id = '$prodId'";
			$query = mysql_query($sql) or die (mysql_error());

			Voltar("produtos_Itens/pl.php");
			}
		}
?>