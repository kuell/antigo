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
$query_rs_setor = "Select * from Setor";
$rs_setor = mysql_query($query_rs_setor, $conn) or die(mysql_error());
$row_rs_setor = mysql_fetch_assoc($rs_setor);
$totalRows_rs_setor = mysql_num_rows($rs_setor);

mysql_select_db($database_conn, $conn);
$query_rs_status = "Select status from Status";
$rs_status = mysql_query($query_rs_status, $conn) or die(mysql_error());
$row_rs_status = mysql_fetch_assoc($rs_status);
$totalRows_rs_status = mysql_num_rows($rs_status);

mysql_select_db($database_conn, $conn);
$query_rs_requisit = "Select nome from requisitante";
$rs_requisit = mysql_query($query_rs_requisit, $conn) or die(mysql_error());
$row_rs_requisit = mysql_fetch_assoc($rs_requisit);
$totalRows_rs_requisit = mysql_num_rows($rs_requisit);

mysql_select_db($database_conn, $conn);
$query_rs_equip = "Select equipamento from equipamento";
$rs_equip = mysql_query($query_rs_equip, $conn) or die(mysql_error());
$row_rs_equip = mysql_fetch_assoc($rs_equip);
$totalRows_rs_equip = mysql_num_rows($rs_equip);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection1.css" rel="stylesheet" type="text/css" />
<script src="../../js/muda.js" type="text/javascript"></script>
</head>

<body>
<form id="form1" name="form1" method="get" action="report_1.php?setor=<?php $_GET['setor'] ; ?>&status=<?php $_GET['status'] ; ?>" target="_blank">
  <table width="auto" border="0" align="center" class="KT_tngtable">
    <tr class="MXW_disabled">
      <td colspan="2">RELATORIO DE ORDEM EXTERNA</td>
    </tr>
    <tr>
      <td colspan="2">Data: 
      <input name="data_1" type="text" id="data_1" onkeyup="DATA(this)" onfocus="limpa(this)" value="<?php echo date('d-m-Y')  ;?>" maxlength="10" /> 
      at&eacute; 
      <input name="data_2" type="text" id="data_2" onfocus="limpa(this)" onkeyup="DATA(this)" value="<?php echo date('d-m-Y')  ;?>" maxlength="10"/></td>
    </tr>
    <tr>
      <td width="66">Status:</td>
      <td width="173"><select name="status" id="status" dir="rtl" title="Escolha um Stus">
          <option value="">Todos</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_status['status']?>"><?php echo $row_rs_status['status']?></option>
          <?php
} while ($row_rs_status = mysql_fetch_assoc($rs_status));
  $rows = mysql_num_rows($rs_status);
  if($rows > 0) {
      mysql_data_seek($rs_status, 0);
	  $row_rs_status = mysql_fetch_assoc($rs_status);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Setor:</td>
      <td><label>
        <select name="setor" id="setor" dir="rtl">
          <option value="">Todos</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_setor['setor']?>"><?php echo $row_rs_setor['setor']?></option>
          <?php
} while ($row_rs_setor = mysql_fetch_assoc($rs_setor));
  $rows = mysql_num_rows($rs_setor);
  if($rows > 0) {
      mysql_data_seek($rs_setor, 0);
	  $row_rs_setor = mysql_fetch_assoc($rs_setor);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Requisitante:</td>
      <td><select name="requisit" id="requisit" dir="rtl">
          <option value="">Todos</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_requisit['nome']?>"><?php echo $row_rs_requisit['nome']?></option>
          <?php
} while ($row_rs_requisit = mysql_fetch_assoc($rs_requisit));
  $rows = mysql_num_rows($rs_requisit);
  if($rows > 0) {
      mysql_data_seek($rs_requisit, 0);
	  $row_rs_requisit = mysql_fetch_assoc($rs_requisit);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Equipamento:</td>
      <td><select name="equip" id="equip" dir="rtl">
          <option value="">Todos</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_equip['equipamento']?>"><?php echo $row_rs_equip['equipamento']?></option>
          <?php
} while ($row_rs_equip = mysql_fetch_assoc($rs_equip));
  $rows = mysql_num_rows($rs_equip);
  if($rows > 0) {
      mysql_data_seek($rs_equip, 0);
	  $row_rs_equip = mysql_fetch_assoc($rs_equip);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="Submit" id="button" value="buscar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($rs_setor);

mysql_free_result($rs_status);

mysql_free_result($rs_requisit);

mysql_free_result($rs_equip);
?>
