<?php require_once ('../../../Connections/conn.php');?>
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
$query_setor     = "Select * from setor where rh = 1";
$setor           = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor       = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../../bibliotecas/mascara.js" type="text/javascript"></script>
	<script type="text/javascript">
    	$(function(){
			$(".data").mask("99-9999");
		})

	function abre(pagina){
			data = document.getElementById('data').value
			setor = document.getElementById('setor').value

				window.open(pagina+".php?data=01-"+data+'&setor='+setor,"Imprimir","channelmode=yes")
			}


    </script>
</head>

<body>
<div class="acao_pagina">Relatorio de Balanço RH</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><input name="data" type="text" class="data" id="data" value="<?php echo date('m-Y');?>" /></td>
    </tr>
    <tr>
      <th scope="row">Setor:</th>
      <td><label>
        <select name="setor" id="setor">
          <option value="">Todos ...</option>
<?php
do {
	?>
					          <option value="<?php echo utf8_encode($row_setor['id_setor'])?>"><?php echo strtoupper(utf8_encode($row_setor['setor']))?></option>
	<?php
} while ($row_setor = mysql_fetch_assoc($setor));
$rows = mysql_num_rows($setor);
if ($rows > 0) {
	mysql_data_seek($setor, 0);
	$row_setor = mysql_fetch_assoc($setor);
}
?>
</select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <label>
          <input type="button" name="button" id="button" value="Buscar" onclick="abre('../rel_bal')" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($setor);
?>
