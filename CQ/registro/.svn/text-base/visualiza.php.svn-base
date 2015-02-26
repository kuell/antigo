<?php require_once('../../Connections/conn.php'); ?>
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
$query_avaliacao = "SELECT * FROM c_registro_controle WHERE COD = '".$_GET['id_registro']."'";
$avaliacao = mysql_query($query_avaliacao, $conn) or die(mysql_error());
$row_avaliacao = mysql_fetch_assoc($avaliacao);
$totalRows_avaliacao = mysql_num_rows($avaliacao);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Registro de N&atilde;o-Conformidade Controle de Qualidade</div>
<table width="700" border="0" align="center" class="KT_tngtable">
  <tr>
    <th colspan="4" scope="row"><div align="center">Dados do Local</div></th>
  </tr>
  <tr>
    <th width="151" scope="row">Registro de Avalia&ccedil;&atilde;o No.:</th>
    <td width="225"><?php echo $row_avaliacao['COD']; ?></td>
    <th width="108">Data da Avalia&ccedil;&atilde;o:</th>
    <td width="196"><?php echo date('d-m-Y', strtotime($row_avaliacao['DATA'])); ?> <?php echo $row_avaliacao['HORA']; ?></td>
  </tr>
  <tr>
    <th scope="row">Agente Responsavel:</th>
    <td><?php echo $row_avaliacao['AGENTE']; ?></td>
    <th>Setor:</th>
    <td><?php echo $row_avaliacao['SETOR']; ?></td>
  </tr>
  <tr>
    <th colspan="4" scope="row"><div align="center">Avalia&ccedil;&atilde;o</div></th>
  </tr>
  <tr>
    <th scope="row">Tipo de Avalia&ccedil;&atilde;o:</th>
    <td><?php echo $row_avaliacao['AVALIACAO']; ?></td>
    <th>Categoria:</th>
    <td><?php echo $row_avaliacao['CATEG_DESC']; ?></td>
  </tr>
  <tr>
    <th scope="row">Sub-Categoria</th>
    <td><?php echo $row_avaliacao['SUB_DESC']; ?></td>
    <th>Item</th>
    <td><?php echo utf8_decode($row_avaliacao['DESC_ITEM']); ?></td>
  </tr>
  <tr>
    <th colspan="2" scope="row">Descri&ccedil;&atilde;o:</th>
    <th>Quantidade:</th>
    <td><?php echo $row_avaliacao['QUANTIDADE']; ?></td>
  </tr>
  <tr>
    <td colspan="6" scope="row" valign="top"><textarea  style="overflow:hidden" name="textfield" cols="150" rows="5" readonly="readonly" id="textfield"><?php echo $row_avaliacao['DESC_NC']; ?></textarea>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($avaliacao);
?>
