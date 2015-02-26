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
$query_sub = "SELECT  	`sub_categoria`.*,        `avaliacao`.`DESC_AVAL` AS `DESC_AVAL`,          `categoria`.`CATEG_DESC` AS `CATEG_DESC` FROM  (((`avaliacao` join `sub_categoria` on((`avaliacao`.`ID_AVAL` = `sub_categoria`.`ID_AVAL`)))  join `categoria` on((`categoria`.`CATEG_ID` = `sub_categoria`.`ID_CATEG`)))) where id_sub = '".$_GET['id_sub']."'";
$sub = mysql_query($query_sub, $conn) or die(mysql_error());
$row_sub = mysql_fetch_assoc($sub);
$totalRows_sub = mysql_num_rows($sub);

mysql_select_db($database_conn, $conn);
$query_avaliacao = "Select * from avaliacao";
$avaliacao = mysql_query($query_avaliacao, $conn) or die(mysql_error());
$row_avaliacao = mysql_fetch_assoc($avaliacao);
$totalRows_avaliacao = mysql_num_rows($avaliacao);
?>
<?php require("../../Connections/conn.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/muda.js" type="text/javascript"></script>
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../funcao.js" type="text/javascript"></script>
<script type="text/javascript" src="../fbusca.js"></script>
</head>

<body>
<div class="acao_pagina">Controle de Categorias</div>
<form id="form1" name="form1" method="post" action="../funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_sub" type="hidden" id="id_sub" value="<?php echo $row_sub['ID_SUB']; ?>" />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="row">Avalia&ccedil;&atilde;o:</th>
    <td>
      <label>
        <select name="avaliacao" id="avaliacao">
          <option value="0" <?php if (!(strcmp(0, $row_sub['ID_AVAL']))) {echo "selected=\"selected\"";} ?>>Selecione um tipo de Avalia&ccedil;&atilde;o</option>
          <?php
do {  
?>
          <option value="<?php echo $row_avaliacao['ID_AVAL']?>"<?php if (!(strcmp($row_avaliacao['ID_AVAL'], $row_sub['ID_AVAL']))) {echo "selected=\"selected\"";} ?>><?php echo $row_avaliacao['DESC_AVAL']?></option>
          <?php
} while ($row_avaliacao = mysql_fetch_assoc($avaliacao));
  $rows = mysql_num_rows($avaliacao);
  if($rows > 0) {
      mysql_data_seek($avaliacao, 0);
	  $row_avaliacao = mysql_fetch_assoc($avaliacao);
  }
?>
        </select>
      </label>
    </td>
  </tr>
  <tr>
    <th scope="row">Categoria:</th>
    <td><label>
      <select name="categoria" id="categoria">
        <option value="<?php echo $row_sub['ID_CATEG']; ?>"><?php echo $row_sub['CATEG_DESC']; ?></option>
        </select>
      </label></td>
  </tr>
  <tr>
    <th scope="row">Sub-Categoria:</th>
    <td><label>
      <input name="sub" type="text" id="sub" onkeyup="maiusculo(this)" value="<?php echo $row_sub['SUB_DESC']; ?>" size="70" />
    </label></td>
  </tr>
  <tr>
    <th colspan="2" scope="row"><div align="center">
    <?php if($_GET['id_sub'] == ""){?>
      <label>
        <input type="button" name="button" id="button" value="Salvar" onclick="doPost('form1', 'sub_salvar')" />
      </label>
      <?php }else{?>
      <label>
        <input type="button" name="edita" id="edita" value="Editar" onclick="doPost('form1', 'sub_editar')" />
      </label>
      <?php }?>
    </div></th>
    </tr>
</table>
</form>
</body>
</html>
<?php
mysql_free_result($sub);

mysql_free_result($avaliacao);
?>
