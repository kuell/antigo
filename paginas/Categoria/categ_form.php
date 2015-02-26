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
$query_avalia = "Select * from Avaliacao";
$avalia = mysql_query($query_avalia, $conn) or die(mysql_error());
$row_avalia = mysql_fetch_assoc($avalia);
$totalRows_avalia = mysql_num_rows($avalia);

mysql_select_db($database_conn, $conn);
$query_categoria = "SELECT * FROM categoria WHERE categ_id = '".$_REQUEST['id_categ']."'";
$categoria = mysql_query($query_categoria, $conn) or die(mysql_error());
$row_categoria = mysql_fetch_assoc($categoria);
$totalRows_categoria = mysql_num_rows($categoria);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../funcao.js" type="text/javascript"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
</head>

<body>
<div class="acao_pagina"><?php if($_REQUEST['proc_id'] == ""){ ?>
        Incluir Procedimento
        <?php }else{ ?>
        Editar Procedimento
        <?php }?> 
     </div>
<form id="form1" name="form1" method="post" action="../funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_categoria" type="hidden" id="id_categoria" value="<?php echo $row_categoria['CATEG_ID']; ?>" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Tipo de Avalia&ccedil;&atilde;o:</th>
      <td><label>
        <select name="avaliacao" id="avaliacao" title="<?php echo $row_procedimento['ID_AVAL']; ?>">
          <option value="" <?php if (!(strcmp("", $row_categoria['ID_AVAL']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_avalia['ID_AVAL']?>"<?php if (!(strcmp($row_avalia['ID_AVAL'], $row_categoria['ID_AVAL']))) {echo "selected=\"selected\"";} ?>><?php echo $row_avalia['DESC_AVAL']?></option>
          <?php
} while ($row_avalia = mysql_fetch_assoc($avalia));
  $rows = mysql_num_rows($avalia);
  if($rows > 0) {
      mysql_data_seek($avalia, 0);
	  $row_avalia = mysql_fetch_assoc($avalia);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th>Descri&ccedil;&atilde;o do Procedimento:</th>
      <td><label>
        <input name="categoria" type="text" id="categoria" onkeyup="maiusculo(this)" value="<?php echo $row_categoria['CATEG_DESC']; ?>" size="70" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
      <?php if($_REQUEST['id_categ'] == ""){ ?>
        <input type="button" name="Incluir" id="Incluir" value="Incluir" onclick="doPost('form1', 'categoria_salvar')" />
        <label>
        <?php }else{ ?>
          <input type="button" name="editar" id="editar" value="Editar" onclick="doPost('form1', 'categoria_editar')" />
        </label>
        <?php }?> 
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($avalia);

mysql_free_result($categoria);
?>
