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
$query_produto = "SELECT * FROM c_produto_pedido WHERE `c_produto_pedido`.`status_pp` = '6'";
$produto = mysql_query($query_produto, $conn) or die(mysql_error());
$row_produto = mysql_fetch_assoc($produto);
$totalRows_produto = mysql_num_rows($produto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
		   $("#print button").click(function(){
											 $(this).css("display","none")
											 window.print() });
		   });
function pergunta(id, acao){
		if(confirm()){
			window.location.href = "../pedido/funcao.php?id_produto="+id+"&action="+acao
			}
		return false
		}
</script>
</head>
<body>
<div class="acao_pagina">Listagem de Produtos em aberto</div>
	<div align="center" id="print"><button>Imprimir</button></div><br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
      <td bgcolor="#666666" style="color:#FFF">Produto</td>
      <td bgcolor="#666666" style="color:#FFF">Qtd. Pedido</td>
      <td bgcolor="#666666" style="color:#FFF">Qtd. Estoque</td>
      <td bgcolor="#666666" style="color:#FFF">Sub-Total</td>
      <td bgcolor="#666666" style="color:#FFF" colspan="3">Comprar</td>
  </tr>
  <?php do { ?>
  <?php if($row_produto['status'] == 'COMPRADO'){ ?>
     <tr bgcolor="#666666">
     <?php }else{?>
     <tr>
     <?php } ?>
      <td><?php echo $row_produto['PROD_ID']; ?> - <?php echo $row_produto['PRO_DESCRICAO']; ?></td>
      <td><?php echo $row_produto['Qtd_pedido']; ?></td>
      <td><?php echo $row_produto['qtd_estoque']; ?></td>
      <td><?php echo $row_produto['Sub_total']; ?></td>
      <td><?php echo $row_produto['status']; ?></td>
      <td><div align="center">
        <a href="#" onclick="pergunta('<?php echo $row_produto['PROD_ID']; ?>', 'comprar_produto')"><img src="../../libs/jquery/tiny_mce/themes/advanced/skins/default/img/menu_check.gif" width="16" height="16" border="0" /></a></div></td>
    </tr>
      <?php } while ($row_produto = mysql_fetch_assoc($produto)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($produto);
?>
