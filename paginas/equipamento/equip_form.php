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
$id_equi = $_GET['id_equip'];

mysql_select_db($database_conn, $conn);
$query_equip     = "Select * from equipamento where id_equipamento = '$id_equip'";
$equip           = mysql_query($query_equip, $conn) or die(mysql_error());
$row_equip       = mysql_fetch_assoc($equip);
$totalRows_equip = mysql_num_rows($equip);

mysql_select_db($database_conn, $conn);
$query_categ     = "Select * from categ_equip";
$categ           = mysql_query($query_categ, $conn) or die(mysql_error());
$row_categ       = mysql_fetch_assoc($categ);
$totalRows_categ = mysql_num_rows($categ);

mysql_select_db($database_conn, $conn);
$query_Setor     = "Select * from setor";
$Setor           = mysql_query($query_Setor, $conn) or die(mysql_error());
$row_Setor       = mysql_fetch_assoc($Setor);
$totalRows_Setor = mysql_num_rows($Setor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<script src="funcao.js" type="text/javascript"></script>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/muda.js" type="text/javascript"></script>
</head>

<body>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_equip" type="hidden" id="id_equip" value="<?php echo $id_equip?>" />
  <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="equipamento">Equipamento:</label></td>
      <td><input name="equipamento" type="text" id="equipamento" value="<?php echo $row_equip['equipamento'];?>" size="32" maxlength="50" onkeyup="maiusculo(this)"/></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="categoria">Categoria:</label></td>
      <td><select name="categoria" id="categoria">
        <option value="" <?php if (!(strcmp("", $row_equip['id_categoria']))) {echo "selected=\"selected\"";}?>>Selecione</option>
<?php
do {
	?>
	        <option value="<?php echo $row_categ['id_cat_equip']?>"<?php if (!(strcmp($row_categ['id_cat_equip'], $row_equip['id_categoria']))) {echo "selected=\"selected\"";}?>><?php echo $row_categ['categ_equip']?></option>
	<?php
} while ($row_categ = mysql_fetch_assoc($categ));
$rows = mysql_num_rows($categ);
if ($rows > 0) {
	mysql_data_seek($categ, 0);
	$row_categ = mysql_fetch_assoc($categ);
}
?>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="setor">Setor:</label></td>
      <td><select name="setor" id="setor">
        <option value=""  <?php if (!(strcmp("", $row_equip['setor']))) {echo "selected=\"selected\"";}?>>Selecione</option>
<?php
do {
	?>
	        <option value="<?php echo $row_Setor['id_setor']?>"<?php if (!(strcmp($row_Setor['id_setor'], $row_equip['setor']))) {echo "selected=\"selected\"";}?>><?php echo $row_Setor['setor']?></option>
	<?php
} while ($row_Setor = mysql_fetch_assoc($Setor));
$rows = mysql_num_rows($Setor);
if ($rows > 0) {
	mysql_data_seek($Setor, 0);
	$row_Setor = mysql_fetch_assoc($Setor);
}
?>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="serie">No. de serie:</label></td>
      <td><input name="serie" type="text" id="serie" value="<?php echo $row_equip['num_serie'];?>" size="32" maxlength="50" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="patrimonio">No. do patrimonio:</label></td>
      <td><input name="patrimonio" type="text" id="patrimonio" value="<?php echo $row_equip['num_patrimonio'];?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="identificador">Identificador:</label></td>
      <td><input name="identificador" type="text" id="identificador" value="<?php echo $row_equip['identificador'];?>" size="7" /></td>
    </tr>
    <tr>

      <td colspan="2" class="KT_th">
      <div align="center">
<?php if (@$_GET['id_equip'] == "") {?>
	<input type="button" name="incluir" value="Incluir" onclick="doPost('form1', 'incluir')"/>
	<?php } else {?>
	<input type="button" name="KT_Update1" value="Atualizar" onclick="doPost('form1', 'atualizar')" />
	<?php }?>
<input type="button" name="KT_Cancel1" value="Voltar" onclick="doPost('form1', 'voltar')" />
        </div>
      </td>

    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($equip);

mysql_free_result($categ);

mysql_free_result($Setor);
?>
