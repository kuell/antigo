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
$query_rs_setor = "Select * from Setor";
$rs_setor = mysql_query($query_rs_setor, $conn) or die(mysql_error());
$row_rs_setor = mysql_fetch_assoc($rs_setor);
$totalRows_rs_setor = mysql_num_rows($rs_setor);

mysql_select_db($database_conn, $conn);
$query_rs_status = "Select * from Status";
$rs_status = mysql_query($query_rs_status, $conn) or die(mysql_error());
$row_rs_status = mysql_fetch_assoc($rs_status);
$totalRows_rs_status = mysql_num_rows($rs_status);

mysql_select_db($database_conn, $conn);
$query_rs_requisit = "Select * from requisitante";
$rs_requisit = mysql_query($query_rs_requisit, $conn) or die(mysql_error());
$row_rs_requisit = mysql_fetch_assoc($rs_requisit);
$totalRows_rs_requisit = mysql_num_rows($rs_requisit);

mysql_select_db($database_conn, $conn);
$query_rs_equip = "Select * from equipamento";
$rs_equip = mysql_query($query_rs_equip, $conn) or die(mysql_error());
$row_rs_equip = mysql_fetch_assoc($rs_equip);
$totalRows_rs_equip = mysql_num_rows($rs_equip);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection1.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../../../js/maskedinput.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
		   $(".data").mask("99/99/9999");
       $("input[type=button]").bind("click", function(){

              datai   = document.getElementById("datai").value
              dataf   = document.getElementById("dataf").value
              status  = document.getElementById("status").value
              setor   = document.getElementById("setor").value
              req     = document.getElementById("requisit").value
              equip   = document.getElementById("equip").value


              window.open('../geral.php?datai='+datai+'&dataf='+dataf+'&status='+status+'&setor='+setor+'&req='+req+'&equip='+equip,'Print','channelmode=yes');
       })

		   });



</script>
</head>

<body>
<form id="form1" name="form1" method="get" action="" target="_blank">
  <table width="auto" border="0" align="center" class="KT_tngtable">
    <tr class="MXW_disabled">
      <td colspan="2">RELATORIO DE ORDEM EXTERNA</td>
    </tr>
    <tr>
      <td colspan="2">Data: 
      <input class="data" name="datai" type="text" id="datai"  value="<?php echo date("01-m-Y")  ;?>" maxlength="10" /> 
      at&eacute; 
      <input class="data" name="dataf" type="text" id="dataf" value="<?php echo date('d-m-Y')  ;?>" maxlength="10"/></td>
    </tr>
    <tr>
      <td width="66">Status:</td>
      <td width="173"><select name="status" id="status" dir="rtl" title="Escolha um Stus">
          <option value="">Todos</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_status['id_status']?>"><?php echo $row_rs_status['status']?></option>
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
                        <option value="<?php echo $row_rs_setor['id_setor']?>"><?php echo $row_rs_setor['setor']?></option>
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
          <option value="<?php echo $row_rs_requisit['id_requisitante']?>"><?php echo $row_rs_requisit['nome']?></option>
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
      <td><select name="equip" id="equip">
          <option value="">Todos</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_equip['id_equipamento']?>"><?php echo $row_rs_equip['equipamento']?></option>
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
      <td colspan="2"><input type="button" name="Submit" id="button" value="buscar" onclik="busca()" /></td>
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
