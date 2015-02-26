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
$query_produto = "Select * from ind_produtos";
$produto = mysql_query($query_produto, $conn) or die(mysql_error());
$row_produto = mysql_fetch_assoc($produto);
$totalRows_produto = mysql_num_rows($produto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Cadastro de Produtos</div>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Codigo Interno</th>
    <th scope="col">Descrição</th>
    <th scope="col">Tipo</th>
    <th scope="col"><span class="div_botoes">Adicionar</span></th>
  </tr>
  <?php do { ?>
    <tr>
      <th scope="row"><?php echo $row_produto['id']; ?></th>
      <td><?php echo $row_produto['cod']; ?></td>
      <td><?php echo $row_produto['descricao']; ?></td>
      <td><?php echo $row_produto['tipo']; ?></td>
      <td><img src="../../img/edit.gif" width="16" height="16" /></td>
    </tr><?php } while ($row_produto = mysql_fetch_assoc($produto)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($produto);
?>
