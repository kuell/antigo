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
$query_Produtos = "SELECT * FROM c_produto_pedido WHERE pc_id = '".$_REQUEST['pedido']."' and prod_id = '".$_REQUEST['produto']."'";
$Produtos = mysql_query($query_Produtos, $conn) or die(mysql_error());
$row_Produtos = mysql_fetch_assoc($Produtos);
$totalRows_Produtos = mysql_num_rows($Produtos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script>
function edita(pedido, produto){
	qtd = document.form1.qtd.value
	window.location = 'funcao.php?pedido='+pedido+'&produto='+produto+'&funcao=manutencao_produto&qtd='+qtd
	}


</script>
</head>

<body>
<div class="acao_pagina">Editar Itens dos Pedidos</div>
<form action="" method="post" name="form1" id="form1">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
    <th>Cod</th>
    <th>Pedido</th>
    <th>Produto</th>
    <th>Qtd. Pedido</th>
    <th>&nbsp;</th>
  </tr>
  <?php do { ?>
    <tr>
      <td scope="col"><?php echo $row_Produtos['PROD_ID']; ?></td>
      <td scope="col"><?php echo $row_Produtos['PC_ID']; ?></td>
      <td scope="col"><?php echo $row_Produtos['PRO_DESCRICAO']; ?></td>
      <td scope="col"><input name="qtd" id="qtd" value="<?php echo $row_Produtos['Qtd_pedido']; ?>" /></td>
      <td scope="col"><label>
        <button type="button" style="border:none; background:none;" onclick="edita('<?php echo $row_Produtos['PC_ID']; ?>', '<?php echo $row_Produtos['PROD_ID']; ?>')"><img src="../../img/manutecao.png" width="16" height="16" /></button>
      </label></td>
    </tr>
        <?php } while ($row_Produtos = mysql_fetch_assoc($Produtos)); ?>

</table>
</form>
</body>
</html>
<?php
mysql_free_result($Produtos);
?>
