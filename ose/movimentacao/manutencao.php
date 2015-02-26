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
if($_REQUEST['id_ose'] == ""){
	$id_ose = "%";
	}else{
	$id_ose = $_REQUEST['id_ose'];
		}
mysql_select_db($database_conn, $conn);
$query_ordem = "SELECT * FROM ordem_externa_vew where id_ose = '$id_ose'";
$ordem = mysql_query($query_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);
$totalRows_ordem = mysql_num_rows($ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
</head>

<body>
<form id="form1" name="form1" method="GET" action="?id_ose=<?php echo $_GET['id_ose'];?>&empresa=<?php echo $_GET['empresa'];?>">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Codigo da Ordem</th>
      <td><input name="id_ose" type="text" id="id_ose" value="<?php echo $_GET['id_ose'];?>" class="numero" /></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
        <input name="busca" type="submit" id="busca" value="Buscar" />
      </div></th>
    </tr>
  </table>
</form><br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
<thead>
  <tr class="KT_row_filter_submit_button">
    <th id="KT_tngtrace_details">Cod</th>
    <th>Data/Envio</th>
    <th>Equipameto</th>
    <th>Setor</th>
    <th>Requisitante</th>
    <th>Empresa</th>
    <th>Status</th>
    <th>&nbsp;</th>
  </tr>
  <?php if($row_ordem['id_OSE'] == ""){ ?>
  <tr>
  <td colspan="8">Digite o Codigo da O.S.!</td>
  </tr>
  <?php }else{?>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ordem['id_OSE']; ?></td>
      <td><?php echo date('d/m/Y',strtotime($row_ordem['data_envio'])); ?></td>
      <td><?php echo $row_ordem['equipamento']; ?></td>
      <td><?php echo $row_ordem['setor']; ?></td>
      <td><?php echo $row_ordem['requisitante']; ?></td>
      <td><?php echo $row_ordem['empresa']; ?></td>
      <td><?php echo $row_ordem['status']; ?></td>
      <td><a href="funcao.php?id=<?php echo $row_ordem['id_OSE']; ?>&amp;action=estornar"><img src="../../img/manutecao.png" width="16" height="16" border="0" /></a></td>
      </tr>
    <?php } while ($row_ordem = mysql_fetch_assoc($ordem)); ?>
    <?php } ?>
  </thead>
</table>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
