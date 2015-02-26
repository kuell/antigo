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
$query_pedido = "Select * from c_pedido_compra";
$pedido = mysql_query($query_pedido, $conn) or die(mysql_error());
$row_pedido = mysql_fetch_assoc($pedido);
$totalRows_pedido = mysql_num_rows($pedido);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript" src="../../js/muda.js" ></script>
<script type="text/javascript">
$(function(){
		   $("#busca").click(function(){
						document.form1.submit()
									  })
		   
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' />", // Loading text
				closeTxt: "<button class='button' onclick='window.location=window.location'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
	
});


</script>
</head>

<body>
<div class="acao_pagina">Manuten&ccedil;&atilde;o de Pedidos</div>
<table border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod/ Peidido</th>
    <th scope="col">Data/Pedido</th>
    <th scope="col">N&ordm; Requisi&ccedil;&atilde;o</th>
    <th scope="col">Setor</th>
    <th scope="col">Requisitante</th>
    <th scope="col">Status</th>
    <th colspan="2" scope="col">Manutne&ccedil;&atilde;o</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_pedido['pc_id']; ?></td>
      <td><?php echo $row_pedido['pc_data']; ?></td>
      <td><?php echo $row_pedido['pc_n_requisicao']; ?></td>
      <td><?php echo $row_pedido['setor']; ?></td>
      <td><?php echo $row_pedido['nome']; ?></td>
      <td><?php echo $row_pedido['status']; ?></td>
      <td><div align="center"><a href="funcao.php?idPedido=<?php echo $row_pedido['pc_id']; ?>&amp;funcao=pedido_estorno"><img src="../../img/manutecao.png" width="16" height="16" border="0" title="Enviar pedido para o status COMPRANDO" /></a></div></td>
      <td><div align="center"><a href="../pedido/visualiza.php?PC_ID=<?php echo $row_pedido['pc_id']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/print.png" width="16" height="16" border="0" title="Visualizar Pedido" /></a></div></td>
    </tr>
    <?php } while ($row_pedido = mysql_fetch_assoc($pedido)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($pedido);
?>
