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
$query_ose = "Select * from ordem_externa_vew";
$ose = mysql_query($query_ose, $conn) or die(mysql_error());
$row_ose = mysql_fetch_assoc($ose);
$totalRows_ose = mysql_num_rows($ose);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Estorna Ordem externa</div>

<form id="form1" name="form1" method="post" action="">
<table border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Cod OSE:</th>
      <td><?php echo $row_ose['id_OSE']; ?></td>
    </tr>
    <tr>
      <th scope="row">Status:</th>
      <td><label>
        <select name="status" id="status">
        <option value="0">Selecione</option>
        <option value="1">Esperando Orçamento</option>
        <option value="2">Esperando Aprovação</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <input type="submit" name="button" id="button" value="Estornar" />
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($ose);
?>
