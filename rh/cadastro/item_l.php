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
$query_item = "Select * from rh_item";
$item = mysql_query($query_item, $conn) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);
$totalRows_item = mysql_num_rows($item);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">
  Itens RH
</div>
<br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Descrição</th>
    <th scope="col">Ativo</th>
    <th scope="col"><a href="item_f.php">Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_item['id']; ?></td>
      <td><?php echo $row_item['descricao']; ?></td>
      <td><?php echo $row_item['ativo']; ?></td>
      <td><a href="item_f.php?id=<?php echo $row_item['id']; ?>"><img src="../../img/edit.gif" width="16" height="16" /></a></td>
    </tr>
    <?php } while ($row_item = mysql_fetch_assoc($item)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($item);
?>
