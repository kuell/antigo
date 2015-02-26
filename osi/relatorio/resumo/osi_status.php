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
$query_Recordset1 = "SELECT status FROM ordem_interna_vew group by status";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Relatorio de Ordens Internas</div>
<br />
<?php do { ?>
  <table width="800px" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Status: <?php echo $row_Recordset1['status']; ?></th>
    </tr>
    <tr>
      <td><table width="100%" border="1" class="KT_tngform">
        <tr>
          <th scope="col">Cod</th>
          <th scope="col">Data</th>
          <th scope="col">Requisitante</th>
          <th scope="col">Responsavel</th>
          <th scope="col">Serviço</th>
          <th scope="col">Setor</th>
          </tr>
           <?php 
		  $sql = "Select * from ordem_interna_vew where status = '".$row_Recordset1['status']."'";
		  $qr = mysql_query($sql) or die (mysql_error());
		  while($ln = mysql_fetch_assoc($qr)){
		  ?>
         
        <tr>
          <td scope="col"><?php echo $ln['id_osi']; ?></td>
          <td scope="col"><?php echo $ln['data_pedido']; ?></td>
          <td scope="col"><?php echo $ln['requisitante']; ?></td>
          <td scope="col"><?php echo $ln['responsavel']; ?></td>
          <td scope="col"><?php echo $ln['acao']; ?></td>
          <td scope="col"><?php echo $ln['setor']; ?></td>
        </tr>
	<?php } ?>
      </table></td>
    </tr>
    <?php 		  
		  $conta = "Select count(*) as resultado from ordem_interna_vew where status = 'BAIXADO' ";
		  $contaQR = mysql_query($conta);
		  $total = mysql_fetch_assoc($contaQR);
		  ?>
    <tr>
      <td><div align="right" class="MXW_disabled">Total : <?php echo $total['resultado'];?> registros</div></td>
    </tr>
  </table>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
