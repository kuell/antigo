<?php 
	require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
	session_start();
// Variavais salvar movimento
	$data		= date("Y-m-d", strtotime($_REQUEST['data']));
	$cor 		= $_REQUEST['cor'];
	$tipoMov	= $_REQUEST['tipoMov'];
	$cod 		= $_REQUEST['cod'];
	$tpDoc		=	$_REQUEST['tpDoc'];
// Variaveis incluir itens
	$item		=	$_REQUEST['item'];
	$qtd		=	str_replace('.','',$_REQUEST['qtd']);
	$peso		=	str_replace('.','',$_REQUEST['peso']);
	$obs		=	$_REQUEST['obs'];
	$valor		=	str_replace('.','',$_REQUEST['valor']);
	
	
	$funcao = $_REQUEST['action'];
		if(function_exists($funcao)){
			call_user_func($funcao);
					}
/*/ exibir as variaveis			
	echo "Funcao 	= $funcao <br>";
	echo "Data   	= $data <br>";
	echo "Cor    	= $cor <br>";
	echo "Tipo Mov 	= $tipoMov <br>";	
	echo "Codigo	= $cod <br>";
	echo "Peso 		= $peso<br>";
	echo "Peso		= ".str_replace(',','.',$_REQUEST['peso']); */
	function salvar_mov(){
		global $cod;
		global $cor;
		global $tipoMov;
		global $tpDoc;
		global $data;	
		if($cor == ""){
			echo "<script>alert('O campo Corretor deve ser preenchido!'); history.back(1);</script>";
			}
		if($tipoMov ==""){
			echo "<script>alert('O campo Tipo de Movimento deve ser preenchido!'); history.back(1);</script>";
			}
		if($data == ""){
			echo "<script>alert('O campo Data deve ser preenchido!'); history.back(1);</script>";
			}
///////////////////////////////////////////////////////////////////
		$usuario = $_SESSION['kt_login_user'];
		$sql = "insert into `taxa`	
						(cor, data, tipo_movimento, tipo_documento, usuario_cadastro)
					VALUE
						('$cor', '$data', '$tipoMov', '$tpDoc','$usuario')";
						
				$query = mysql_query($sql) or die (mysql_error());

		echo "<script>window.location = 'mtx_f.php?cod=$cod';</script>";
		}
	function exclui_mov(){
		global $cod;
			$sql = "DELETE FROM taxa where cod = '$cod'"	;
			$sqlItem	=	"DELETE FROM txdoc where id_tx = '$cod'";
			
			mysql_query($sql) or die (mysql_error());
			mysql_query($sqlItem) or die (mysql_error());
			voltar();
		
		}
	function edita_mov(){
		global $cod;
		global $cor;
		global $tipoMov;
		global $data;
		if($cor == ""){
			echo "<script>alert('O campo Corretor deve ser preenchido!'); history.back(1);</script>";
			}
		if($tipoMov ==""){
			echo "<script>alert('O campo Tipo de Movimento deve ser preenchido!'); history.back(1);</script>";
			}
		if($data == ""){
			echo "<script>alert('O campo Data deve ser preenchido!'); history.back(1);</script>";
			}
		
		
		$usuario = $_SESSION['kt_login_user'];
		echo "Usuario = $usuario";
		$sql = "UPDATE `taxa`	
						set
							cor = '$cor', 
							data = '$data', 
							tipo_movimento = '$tipoMov', 
							usuario_atualiza = '$usuario'
				WHERE
						cod = '$cod'";
						
				$query = mysql_query($sql) or die (mysql_error());

		echo "<script>window.location = 'mtx_f.php?cod=$cod';</script>";
		}
	function incluir_item(){
		global $cod;
		global $item;
		global $qtd;
		$qtd2 = str_replace(',','.',$qtd);
		global $peso;
		$peso2 =  str_replace(',','.',$peso);
		global $tpDoc;
		global $valor;
		$valor2 = str_replace(',','.',$valor);
		global $obs;
		global $data;
#Inclui informações no banco de dados
			$sql = "Insert into
					txdoc (id_tx, item, qtd, peso,tipo_Doc, doc, obs, valor,data) value
					('$cod', '$item', '$qtd2', '$peso2', '$tpDoc', '$novo_nome', '$obs', '$valor2','$data')
			";
			mysql_query($sql) or die (mysql_error());
///////////////////////////////////////////////////////////////////
			echo "<script>window.location = 'incluir_produto.php?cod=$cod'</script>";

		}
	function exclui_item(){
		$cod = $_REQUEST['cod'];
		$id_item = $_REQUEST['id_item'];
		$doc = $_REQUEST['doc'];
		if(file_exists($doc)){
			unlink($doc);			
			}
				
		echo $doc;
		$sql = "DELETE FROM txDoc where cod='$id_item'";
		mysql_query($sql) or die (mysql_error());
		
		
		echo "<script>window.location = 'incluir_produto.php?cod=$cod'</script>";	
		}		
	function voltar(){
		header("Location: mtx_l.php");		
		
		}
	function Upload(){
		$ano = $_REQUEST['ano'];
		$mes = $_REQUEST['mes'];
		$item = $_REQUEST['item'];
		$cor = $_REQUEST['cor'];
		$idItem = $_REQUEST['idItem'];
		$doc = $_FILES['doc']['name'];
		
		### Testa se existe arquivo ###
		if(!$doc)
			{
			echo "<script>alert('Atenção! Nenhum documento foi incluido!');history.back(1);</script>";
			} 
		else
			{
			if(strrchr($doc, '.') != ".pdf"){
				echo "<script>alert('É aconcelhavel fazer upload de arquivos na extenção PDF!');history.back(1);</script>";
											}			
			}
				###Testa se existe os diretorios se não existir cria-os##
					if(!file_exists("arquivos/cor_cod_$cor"))
					{
					mkdir("arquivos/cor_cod_$cor", 0777); 
					}
					
					if(!file_exists("arquivos/cor_cod_$cor/$ano"))
					{
					mkdir("arquivos/cor_cod_$cor/$ano", 0777); 
					}
					
					if(!file_exists("arquivos/cor_cod_$cor/$ano/$mes"))
					{
					mkdir("arquivos/cor_cod_$cor/$ano/$mes", 0777); 
					}

#Faz o upload do arquivo c/ a extenção 
		$novo_nome = "arquivos/cor_cod_$cor/$ano/$mes/".$item.strrchr($doc, '.');
		move_uploaded_file($_FILES['doc']['tmp_name'], $novo_nome); 
### Grava no Banco de dados o local dos arquivos referentes ###
	$sql = "Select * from taxa where cor = '$cor' and month(data) = '$mes' and year(data) = '$ano'";
	$query = mysql_query($sql) or die(mysql_error());	
	while($res = mysql_fetch_assoc($query)){

			$atualiza = "update txdoc set doc = '$novo_nome' where id_tx = '".$res['Cod']."' and item = '$idItem'";
			mysql_query($atualiza) or die (mysql_error());
		
	}
	echo "Documento enviado com sucesso";
	}

?>