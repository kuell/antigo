<?php require_once ('../../Connections/conn.php');?>
<?php
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc()?stripslashes($theValue):$theValue;
		}

		$theValue = function_exists("mysql_real_escape_string")?mysql_real_escape_string($theValue):mysql_escape_string($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "")?"'".$theValue."'":"NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "")?intval($theValue):"NULL";
				break;
			case "double":
				$theValue = ($theValue != "")?doubleval($theValue):"NULL";
				break;
			case "date":
				$theValue = ($theValue != "")?"'".$theValue."'":"NULL";
				break;
			case "defined":
				$theValue = ($theValue != "")?$theDefinedValue:$theNotDefinedValue;
				break;
		}
		return $theValue;
	}
}

mysql_select_db($database_conn, $conn);
$query_setor     = "Select * from setor where rh = 'SIM' order by ordem_rh";
$setor           = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor       = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript" src="../../js/muda.js"></script>
<script type="text/javascript">
	function faz(it,set,val){
	/*
  	document.getElementById('setor').value =  setor
		document.getElementById('funcao').value =  acao
		document.getElementById('item').value =  rhItem
		document.getElementById('valor').value =  valor

		incluir.submit()
*/
    $.post( "funcao.php", { funcao: "incluir",
                            setor:  set,
                            item:   it,
                            mes: <?php echo $_REQUEST['mes'];?>,
                            ano: <?php echo $_REQUEST['ano'];?>,
                            valor: val} );

		}

</script>
</head>

<body>
<div><h1>Digitação do Balanço Ref. <?php echo $_REQUEST['mes'].'/'.$_REQUEST['ano'];?></h1></div>

<br />
<?php do {?>
						  <form id="form<?php echo $row_setor['id_setor'];?>" name="form<?php echo $row_setor['id_setor'];?>" method="post" action="funcao.php">
						  <table width="800" border="0" align="center" class="table table-hover">
						    <tr>
						      <th class="well" colspan="2" scope="col"><div align="center">
						        <h2><?php echo $row_setor['ordem_rh'];
	?> - <?php echo utf8_encode($row_setor['setor']);
	?></h2>
																				      </div></th>
																				    </tr>

	<?php
	$sql = "select * from rh_item where ativo = 1 and por_setor = 1";
	$qr  = mysql_query($sql) or die(mysql_error());
	while ($res = mysql_fetch_assoc($qr)) {

		$sqlValor = "select * from rh_balanco where mes = '".$_REQUEST['mes']."' and ano = '".$_REQUEST['ano']."' and item = '".$res['id']."' and setor = '".$row_setor['id_setor']."'";
		$qrValor  = mysql_query($sqlValor) or die('Erro no valor: '.mysql_error());
		$valor    = mysql_fetch_assoc($qrValor);
		?>
																																								    <tr>
																																								      <td width="30%"><?php echo utf8_encode($res['descricao']);?></td>
																																								      <td width="70%"><label>
																																								        <input value="<?php echo number_format($valor['valor'], 2, ',', '.');?>" type="text" name="text" id="text" class='valor' onblur="faz('<?php echo $res['id'];?>','<?php echo $row_setor['id_setor'];?>',this.value)"/>
																																								      </label></td>
																																								    </tr>
		<?php }?>
	</table>
																				  </form>
	<?php } while ($row_setor = mysql_fetch_assoc($setor));?>
</body>
</html>
<?php
mysql_free_result($setor);
?>
