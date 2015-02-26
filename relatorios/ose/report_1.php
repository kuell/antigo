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
	///$data_1 = $_REQUEST['data_1'];
	//$data1 = date('Y-m-d', strtotime($data_1));
	$data_ano = date('Y');
	$data_soma = $data_ano - 1;
	$data_1 = date("m/d/$data_soma");
		if(isset($_REQUEST['data_1'])){
			$data_1 = $_REQUEST['data_1'];}
	$data1 = date('Y-m-d', strtotime($data_1));
	
	$data_2 = date("m/d/Y");
		if(isset($_REQUEST['data_2'])){
			$data_2 = $_REQUEST['data_2'];}
	$data2 = date('Y-m-d', strtotime($data_2));
$status = "%";
	if (isset($_REQUEST['status'])) {
	  $status = $_REQUEST['status'];}
$setor = "%";
			if (isset($_REQUEST['setor'])) {
			  $setor = $_REQUEST['setor'];}
$equip = "%";
			if (isset($_REQUEST['equip'])) {
			  $equip = $_REQUEST['equip'];}
$requisit = "%";
			if (isset($_REQUEST['requisit'])) {
			  $requisit = $_REQUEST['requisit'];}
			  

mysql_select_db($database_conn, $conn);
$query_rs_ordem = "SELECT *, date_format(data_envio, '%d/%m/%Y') as data_envio FROM ordem_externa_vew WHERE data_envio between '$data1' and '$data2' and status like '%$status%' and setor like '%$setor%' and equipamento like '%$equip%' and requisitante like '%$requisit%'";
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "Select SUM(preco_servico) from ordem_externa_vew WHERE data_envio between '$data1' and '$data2' and status like '%$status%' and setor like '%$setor%' and equipamento like '%$equip%' and requisitante like '%$requisit%'";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection1.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#CCCCCC">
<table width="auto" height="auto" border="0" align="center" bgcolor="#FFFFFF" class="KT_tngtable">
  <tr align="left" class="hasevent_cal">
    <th width="auto" height="16" scope="col"><div class="relatorio_titulo">Cod</div></th>
    <th width="auto" scope="col"><div class="relatorio_titulo">Data envio</div></th>
    <th width="auto" scope="col"><div class="relatorio_titulo">Equipamento</div></th>
    <th width="auto" scope="col"><div class="relatorio_titulo">Setor</div></th>
    <th width="auto" scope="col"><div class="relatorio_titulo">Requisitante</div></th>
    <th width="auto" scope="col"><div class="relatorio_titulo">Status</div></th>
    <th width="auto" scope="col"><div class="relatorio_titulo">Valor</div></th>
  </tr>
  <?php do { ?>
    <tr style="text-align:left; font-size:9px; font-family:Verdana, Geneva, sans-serif; border-top: medium">
      <td height="19"><?php echo $row_rs_ordem['id_OSE']; ?></td>
      <td><?php echo $row_rs_ordem['data_envio']; ?></td>
      <td><?php echo $row_rs_ordem['equipamento']; ?></td>
      <td><?php echo $row_rs_ordem['setor']; ?></td>
      <td><?php echo $row_rs_ordem['requisitante']; ?></td>
      <td><?php echo $row_rs_ordem['status']; ?></td>
      <td><div align="right"><?php echo $row_rs_ordem['preco_servico']; ?></div></td>
    </tr>
    <?php } while ($row_rs_ordem = mysql_fetch_assoc($rs_ordem)); ?>
<tr class="MXW_disabled">
  <th height="26" colspan="9"><div align="right" class="relatorio_titulo"> Total = R$    <?php echo $row_Recordset1['SUM(preco_servico)']; ?></div></th></tr>
  
</table>
</body>
</html>
<?php
mysql_free_result($rs_ordem);

mysql_free_result($Recordset1);
?>
