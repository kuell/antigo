<?php 
	require('../../Connections/conn.php');
	mysql_select_db($database_conn, $conn);
	session_start();
	define('data', date('Y-m-d',strtotime($_REQUEST['data'])));
	define('setor', $_REQUEST['setor']);
	define('mes', $_REQUEST['mes']);
	define('ano', $_REQUEST['ano']);
	define('mesAbate', $_REQUEST['mes_abate']);
	define('anoAbate', $_REQUEST['ano_abate']);
	define('item', $_REQUEST['item']);
	define('usuario', $_SESSION['kt_login_user']);
	define('valor', str_replace(',','.',str_replace('.','',$_REQUEST['valor'])));
	define('qtd', str_replace(',','.',str_replace('.','',$_REQUEST['qtd_abate'])));
	define('peso', str_replace(',','.',str_replace('.','',$_REQUEST['peso_abate'])));
	define('fat', str_replace(',','.',str_replace('.','',$_REQUEST['fat'])));
	
	/*
	echo "Setor = ".setor.'<br>';
	echo 'Mes = '.mes.'<br>';
	echo 'Ano = '.ano.'<br>';
	echo 'Item ='.item.'<br>';
	echo 'Usuario ='.usuario.'<br>';
	echo 'Valor = '.valor.'<br>';
	echo 'Data = '.data.'<br>';
		*/
		$funcao = $_REQUEST['funcao'];
			if(function_exists($funcao)){
				call_user_func($funcao);
				}
			
	
		function incluir(){

			$busca = "Select count(*) as resultado from rh_balanco where mes = '".mes."' and ano = '".ano."' and item = '".item."' and setor = '".setor."'";
			$qrBusca = mysql_query($busca) or die (mysql_error());
				$res = mysql_fetch_assoc($qrBusca);
				
			if($res['resultado'] == 0)
				{
				$sql = "Insert into rh_balanco(mes, ano, setor, item, valor, usu_dig) 
								value('".mes."','".ano."','".setor."','".item."','".valor."','".usuario."')";
				}
			else
				{
				$sql = "update rh_balanco 
										set 
											valor = '".valor."',
											usu_atu = '".usuario."'
										where
											mes = '".mes."' and
											ano = '".ano."' and
											item = '".item."' and
											setor = '".setor."'
										";
					}
			echo $res['resultado']."<br>";
			echo $busca."<br>";
			echo $sql;
			mysql_query($sql) or die (mysql_error());
			
			echo "<script>history.back(1)</script>";
			
			}
		function incluir_prod(){
			
			$busca = "select count(*) as result from rh_produtividade where data = '".data."' and setor = '".setor."'";
			$qr = mysql_query($busca) or die ('Erro 1: '.mysql_error());
			$res = mysql_fetch_assoc($qr);
			
			if($res['result'] == 1){			
						$sql = "update rh_produtividade 
									set
										horas_trabalhadas = '".valor."',
										usu_atu = '".usuario."'
									where
										data = '".data."' and
										setor= '".setor."'";
			}
			else
			{
					$sql = "Insert into rh_produtividade (data, setor, horas_trabalhadas, usu_dig) 
								value('".data."','".setor."','".valor."','".usuario."')";
			}
			mysql_query($sql) or die (mysql_error());
			
			echo "<script>history.back(1)</script>";
			}
	function informar(){
		echo mesAbate.'<br>';
		echo anoAbate.'<br>';
		echo qtd.'<br>';
		echo peso.'<br>';
		
		
			$busca = "Select count(*) as resultado from rh_info where mes = '".mesAbate."' and
																			ano = '".anoAbate."' ";
			$qr = mysql_query($busca) or die (mysql_error());
			$res = mysql_fetch_assoc($qr);
			
			if($res['resultado'] == 1){
				$sql = "
							update rh_info
									set
										qtd = '".qtd."',
										peso = '".peso."',
										fat = '".fat."',
										usu_up = '".usuario."'
									where
										mes = '".mesAbate."' and
										ano = '".anoAbate."'		
				";
		
				
				}
			else
			{
				$sql = "insert into rh_info(mes, ano, qtd, peso,fat, usu_add) value
											('".mesAbate."','".anoAbate."','".qtd."','".peso."','".fat."','".usuario."')";
		
				}
		
			echo $sql.'<br>';
		mysql_query($sql) or die (mysql_error());
		header("Location: bal_busca.php");
		}




?>