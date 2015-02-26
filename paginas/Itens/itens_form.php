<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn, $conn);
$query_setor = "Select * from setor";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);

mysql_select_db($database_conn, $conn);
$query_item = "SELECT * FROM itens WHERE id_item = '".$_REQUEST['id_item']."'";
$item = mysql_query($query_item, $conn) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);
$totalRows_item = mysql_num_rows($item);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../funcao.js" type="text/javascript"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
</head>
<body>
<div class="acao_pagina">Incluir Item</div>
<form id="form1" name="form1" method="post" action="../funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_item" type="hidden" id="id_item" value="<?php echo $row_item['ID_ITEM']; ?>" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Setor:</th>
      <td><label>
        <select name="setor" id="setor">
          <option value="" <?php if (!(strcmp("", $row_item['setor']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
          <?php
do {  
?>
          <option value="<?php   echo $row_setor['id_setor']; ?> "<?php if (!(strcmp($row_setor['id_setor'], $row_item['setor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_setor['setor']?></option>
          <?php
} while ($row_setor = mysql_fetch_assoc($setor));
  $rows = mysql_num_rows($setor);
  if($rows > 0) {
      mysql_data_seek($setor, 0);
	  $row_setor = mysql_fetch_assoc($setor);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th scope="row">Item:</th>
      <td><label>
        <input name="item" type="text" id="item" onkeyup="maiusculo(this)" value="<?php echo $row_item['DESC_ITEM']; ?>" size="70" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div align="center">
      <?php if(!$_REQUEST['id_item']){ ?>
        <label>
          <input type="button" name="salvar" id="salvar" value="Salvar" onclick="doPost('form1', 'salvar_item')" />
        <?php }else { ?></label>
        <label>
          <input type="button" name="editar" id="editar" value="Editar" onclick="doPost('form1', 'editar_item')" />
        </label>
        <?php } ?>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($setor);

mysql_free_result($item);
?>
