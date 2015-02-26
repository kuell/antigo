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
$query_Recordset1 = "SELECT * FROM status where id_status = 1 or id_status = 2 or id_status = 3 or id_status = 4 or id_status = 5";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listagem de Ordem Externa</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>
<div class="acao_pagina">Listagem de Ordem de Servi&ccedil;o Externa</div>
<br />
<?php do { ?>
  <table width="80%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th width="7%" valign="baseline">Status</th>
      <td width="93%" colspan="2"><strong><?php echo $row_Recordset1['status']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%" border="1" align="center" class="KT_tnglist">
        <tr>
          <th>Cod</th>
          <th>Data/Envio</th>
          <th>Dias/Ap&oacute;s</th>
          <th>Equipamento</th>
          <th>Setor</th>
          <th>Requisitante</th>
          <th>Empresa</th>
        </tr>
        <?php
        	$sql = "Select * from ordem_externa_vew where status = '".$row_Recordset1['status']."'";
			$qr = mysql_query($sql);
			while($ln = mysql_fetch_assoc($qr)){?>
        <tr style="font:Verdana, Geneva, sans-serif; font-size:6px">
          <td><?php echo $ln['id_OSE']?></td>
          <td><?php echo date('d/m/Y', strtotime($ln['data_envio']));?></td>
          <td><?php echo $ln['Dias_Apos'];?></td>
          <td><?php echo $ln['equipamento'];?></td>
          <td><?php echo $ln['setor'];?></td>
          <td><?php echo $ln['requisitante'];?></td>
          <td><?php echo $ln['empresa'];?></td>
        </tr>
            <?php } ?>
      </table></td>
    </tr>

  </table>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
