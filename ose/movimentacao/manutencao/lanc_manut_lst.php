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

$maxRows_rs_ordem = 15;
$pageNum_rs_ordem = 0;
if (isset($_GET['pageNum_rs_ordem'])) {
  $pageNum_rs_ordem = $_GET['pageNum_rs_ordem'];
}
$startRow_rs_ordem = $pageNum_rs_ordem * $maxRows_rs_ordem;

mysql_select_db($database_conn, $conn);
$query_rs_ordem = "SELECT * FROM ordem_externa_vew WHERE status LIKE 'ESPERANDO AP%'";
$query_limit_rs_ordem = sprintf("%s LIMIT %d, %d", $query_rs_ordem, $startRow_rs_ordem, $maxRows_rs_ordem);
$rs_ordem = mysql_query($query_limit_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);

if (isset($_GET['totalRows_rs_ordem'])) {
  $totalRows_rs_ordem = $_GET['totalRows_rs_ordem'];
} else {
  $all_rs_ordem = mysql_query($query_rs_ordem);
  $totalRows_rs_ordem = mysql_num_rows($all_rs_ordem);
}
$totalPages_rs_ordem = ceil($totalRows_rs_ordem/$maxRows_rs_ordem)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div>Manutenção de Ordem Externa</div>
<div>
  <table width="AUTO" border="0">
    <tr class="MXW_disabled">
      <th  scope="col">Cod</th>
      <th  scope="col">Data Envio</th>
      <th  scope="col">Equipamento</th>
      <th scope="col">Setor</th>
      <th  scope="col">Requisitante</th>
      <th  scope="col">Empresa</th>
    </tr>
    <?php do { ?>
      <tr class="">
        <td class="MXW_disabled"><?php echo $row_rs_ordem['id_OSE']; ?></td>
        <td class="MXW_disabled"><?php echo $row_rs_ordem['data_envio']; ?></td>
        <td class="MXW_disabled"><?php echo $row_rs_ordem['equipamento']; ?></td>
        <td class="MXW_disabled"><?php echo $row_rs_ordem['setor']; ?></td>
        <td class="MXW_disabled"><?php echo $row_rs_ordem['requisitante']; ?></td>
        <td class="MXW_disabled"><?php echo $row_rs_ordem['empresa']; ?></td>
      </tr>
      <?php } while ($row_rs_ordem = mysql_fetch_assoc($rs_ordem)); ?>
<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div></body>
</html>
<?php
mysql_free_result($rs_ordem);
?>
