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
$query_ordem = "SELECT * FROM ordem_interna_vew where status like '%EXECUTADO%'";
$ordem = mysql_query($query_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);
$totalRows_ordem = mysql_num_rows($ordem);mysql_select_db($database_conn, $conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Concluir</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../../../js/modal/jquery.superbox-min.js" type="text/javascript"></script>
<script src="../../../js/modal/jquery.superbox.js" type="text/javascript"></script>
<script type="text/javascript">
$(function (){
			$.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' /> Carregando...", // Loading text
				closeTxt: "<button>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
$.superbox();		
			
			})



function pergunta(id){
	if(confirm("Baixar esta Ordem Interna??")){
		location.href = "funcao.php?id_osi="+id+"&action=concluir"
		}
	return false
	}
</script>
</head>
<body>
<div class="acao_pagina">Concluir Servi&ccedil;o</div>
<br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Data/OSI</th>
    <th scope="col">Requisitante</th>
    <th scope="col">Responsavel</th>
    <th scope="col">Executante</th>
    <th scope="col">Setor</th>
    <th scope="col">Prazo</th>
    <th scope="col">Equipamento</th>
    <th scope="col">Data/Execu&ccedil;&atilde;o</th>
    <th colspan="3" scope="col">Status</th>
  </tr>
  <?php do { ?>
  <?php if($row_ordem['id_osi'] == ""){?>
  <tr>
  <td colspan="14">Não há ordens para serem baixadas</td>
  </tr>
  <?php }else{ ?>
    <tr>
      <td scope="col"><?php echo $row_ordem['id_osi']; ?></td>
      <td scope="col"><?php echo $row_ordem['data_pedido']; ?></td>
      <td scope="col"><?php echo $row_ordem['requisitante']; ?></td>
      <td scope="col"><?php echo $row_ordem['responsavel']; ?></td>
      <td scope="col"><?php echo $row_ordem['executante']; ?></td>
      <td scope="col"><?php echo $row_ordem['setor']; ?></td>
      <td scope="col"><?php echo $row_ordem['prazo_conclusao']; ?></td>
      <td scope="col"><?php echo $row_ordem['equipamento']; ?></td>
      <td scope="col"><?php echo date('d/m/Y', strtotime($row_ordem['data_entrega'])); ?></td>
      <td scope="col"><?php echo $row_ordem['status']; ?></td>
      <td scope="col">
      <?php 
	  session_start();
	  if($_SESSION['kt_login_nivel'] != '2'){?>
      <a href="#" onclick="pergunta(<?php echo $row_ordem['id_osi']; ?>)"><img src="../../../img/baixar.png" alt="" width="16" height="16" border="0" /></a>
      <?php }else{?>
      <img src="../../../img/bloqueado.gif" width="16" height="16" />
      <?php } ?></td>
      <td scope="col"><a href="visualizar.php?id_osi=<?php echo $row_ordem['id_osi']; ?>" rel="superbox[iframe][700x500]" title="Visualizar"><img src="../../../img/print.png" alt="" width="16" height="16" /></a></td>
    </tr>
    <?php } ?>
 
    <?php } while ($row_ordem = mysql_fetch_assoc($ordem)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
