<?php require_once('../../../Connections/conn.php'); ?>
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
$query_prod = "Select * from txproduto";
$prod = mysql_query($query_prod, $conn) or die(mysql_error());
$row_prod = mysql_fetch_assoc($prod);
$totalRows_prod = mysql_num_rows($prod);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Controle de Produtos e Itens<br /></div>
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Cod</th>
      <th>Descrição</th>
      <th>U.M.</th>
      <th>Tipo</th>
      <th colspan="2"><a href="pf.php">Adicionar</a></th>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_prod['prod_id']; ?></td>
        <td><?php echo $row_prod['prod_desc']; ?></td>
        <td><?php echo $row_prod['prod_UnMed']; ?></td>
        <td><?php echo $row_prod['prod_tipo']; ?></td>
        <td><div align="center"><a href="pf.php?prod_id=<?php echo $row_prod['prod_id']; ?>"><img src="../../../img/edit.png" alt="" width="16" height="16" /></a></div></td>
        <td>&nbsp;</td>
      </tr>
      <?php } while ($row_prod = mysql_fetch_assoc($prod)); ?>
  </table>
</body>
</html>
<?php
mysql_free_result($prod);
?>
