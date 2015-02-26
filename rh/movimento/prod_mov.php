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
	function faz(set,val){
    $('input[name=valor]').attr('disabled', 'disabled');

    $.post( "funcao.php", { funcao: "incluir_prod",
                            setor:  set,
                            data: '<?php echo $_REQUEST['data'];?>',
                            valor: val
                            } , function(data){
                              $('input[name=valor]').removeAttr('disabled', 'disabled');
                            });


		}

</script>
</head>

<body>
<div class="well"><h1>Digitação do Balanço Ref. <?php echo date('d-m-Y', strtotime($_REQUEST['data']));?></h1></div>
<br />

  <form id="" name="" method="post" action="funcao.php" class="form">
  <table width="400" border="0" align="center" class="table table-striped">
    <tr>
      <th>Setor</th>
      <th>Horas Trabalhadas</th>
    </tr>
<?php do {?>
																						    <tr>
																						      <th width="30%"><?php echo utf8_encode($row_setor['setor']);?></th>
																						      <td width="70%"><label>
	<?php
	$sql   = "select * from rh_produtividade where setor = '".$row_setor['id_setor']."' and data = '".date('Y-m-d', strtotime($_REQUEST['data']))."'";
	$qr    = mysql_query($sql) or die(mysql_error());
	$valor = mysql_fetch_assoc($qr);
	?>
								<input type="text" name="valor" class="valor form-control" value="<?php echo number_format($valor['horas_trabalhadas'], 2, ',', '.')?>" onblur="faz('<?php echo $row_setor['id_setor'];?>',this.value)"/>
												                                                  </label></td>
																																		    </tr>
	<?php } while ($row_setor = mysql_fetch_assoc($setor));?></table>
  </form>

</body>
</html>
<?php
mysql_free_result($setor);
?>
