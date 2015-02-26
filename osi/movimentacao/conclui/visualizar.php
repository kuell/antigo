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

$colname_Recordset1 = "-1";
if (isset($_GET['id_osi'])) {
  $colname_Recordset1 = $_GET['id_osi'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM ordem_interna_vew WHERE id_osi = %s", GetSQLValueString($colname_Recordset1, "int"));
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
<script type="text/javascript" src="../../../js/jquery-1.3.1.js"></script>
<script type="text/javascript">
	$(function(){
		$("button").click(function(){
								   $("#print").css("display","none");								   
								   window.print();
								   })			   
			   })
</script>
<style media="screen">
table{
	width:589px;
	}

</style>
</head>

<body><table border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col"><div class="acao_pagina">Registro de Ordem Interna N&ordm; <?php echo $row_Recordset1['id_osi']; ?></div></th>
  </tr>
  <tr>
    <td scope="col"><table width="100%" border="0">
      <tr>
        <th scope="col">Data/Digita&ccedil;&atilde;o:</th>
        <td scope="col"><?php echo date("d-m-Y", strtotime($row_Recordset1['data_pedido'])); ?></td>
        <th scope="col">Data/Execu&ccedil;&atilde;o</th>
        <td scope="col"><?php echo date("d-m-Y", strtotime($row_Recordset1['data_entrega'])); ?></td>
      </tr>
      <tr>
        <th scope="row">Solicitante:</th>
        <td><?php echo $row_Recordset1['requisitante']; ?></td>
        <th>Responsavel:</th>
        <td><?php echo $row_Recordset1['responsavel']; ?></td>
      </tr>
      <tr>
        <th scope="row">Prazo de entrega:</th>
        <td><?php echo $row_Recordset1['prazo_conclusao']; ?></td>
        <th>Executante:</th>
        <td><?php echo $row_Recordset1['executante']; ?></td>
      </tr>
      <tr>
        <th scope="row">Servi&ccedil;o:</th>
        <td><?php echo $row_Recordset1['acao']; ?></td>
        <th>Setor:</th>
        <td><?php echo $row_Recordset1['setor']; ?></td>
      </tr>
      <tr>
        <th scope="row">Equipamento:</th>
        <td colspan="3"><?php echo $row_Recordset1['equipamento']; ?></td>
        </tr>
      <tr>
        <th scope="row">Descri&ccedil;&atilde;o:</th>
        <td colspan="3"><?php echo wordwrap($row_Recordset1['obs'], 79,"<br />"); ?></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p><div align="center" id="print"><button>Imprimir</button></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
