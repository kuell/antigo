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
$query_rs_proc = "SELECT 		`procedimento`.`PROC_ID` AS COD,         `avaliacao`.`DESC_AVAL`,         `procedimento`.`PROC_DESC`  FROM   		(`avaliacao` JOIN `procedimento` ON(`avaliacao`.`ID_AVAL` = `procedimento`.`ID_AVAL`))";
$rs_proc = mysql_query($query_rs_proc, $conn) or die(mysql_error());
$row_rs_proc = mysql_fetch_assoc($rs_proc);
$totalRows_rs_proc = mysql_num_rows($rs_proc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:100%;
	height:auto;
	z-index:1;
}
-->
</style>
</head>

<body>
<div class="pgn_acao" align="center">Controle de Procedimentos</div>
<div id="apDiv1"><table width="auto" border="0" align="center" style="border:1px solid #069">
  <tr class="ewRptColHeader">
    <td>Cod</td>
    <td>Avaliação</td>
    <td>Procedimento</td>
    <td class="ewRptGrpSummary1"><a href="#">Adicionar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rs_proc['COD']; ?></td>
      <td><?php echo $row_rs_proc['DESC_AVAL']; ?></td>
      <td><?php echo $row_rs_proc['PROC_DESC']; ?></td>
      <td><a href="proc_form.php?PROC_ID=<?php echo $row_rs_proc['COD'] ;?>">editar</a></td>
    </tr>
    <?php } while ($row_rs_proc = mysql_fetch_assoc($rs_proc)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rs_proc);
?>
