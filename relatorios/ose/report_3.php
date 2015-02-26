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
$query_rs_ordem = "SELECT Equipamento, setor, SUM(preco_servico) as total, count(*) as registros FROM ordem_externa_vew GROUP BY equipamento ORDER BY registros desc";
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);mysql_select_db($database_conn, $conn);
$query_rs_ordem = "SELECT Equipamento, setor, SUM(preco_servico) as total, count(*) as registros FROM ordem_externa_vew GROUP BY equipamento ORDER BY registros desc";
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);
$query_rs_ordem = "SELECT Equipamento, setor, SUM(preco_servico) as total, count(*) as registros FROM ordem_externa_vew GROUP BY equipamento ORDER BY registros desc";
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">Relatorio Resumido por Equipamento</div>
<table width="auto" border="0" align="center">
  <tr>
    <td><div class="relatorio_titulo">Equipamento</div></td>
    <td><div class="relatorio_titulo">Setor</div></td>
    <td><div class="relatorio_titulo">Envios</div></td>
    <td><div class="relatorio_titulo">R$</div></td>
  </tr>
  <?php do { ?>
    <tr class="ewGridLowerPanel">
      <td><?php echo $row_rs_ordem['equipamento']; ?></td>
      <td><?php echo $row_rs_ordem['setor']; ?></td>
      <td><div align="center"><?php echo $row_rs_ordem['registros']; ?></div></td>
      <td><?php echo $row_rs_ordem['total']; ?></td>
    </tr>
    <?php } while ($row_rs_ordem = mysql_fetch_assoc($rs_ordem)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_ordem);
?>
