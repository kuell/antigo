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
$produto = $_REQUEST['produto'];
$pedido = $_REQUEST['pc_id'];
		if($_REQUEST['pc_id'] == ""){
			mysql_select_db($database_conn, $conn);
			$query_produto = "SELECT * FROM c_produto_pedido WHERE status_pp = '6' and pro_descricao LIKE '%$produto%'";
		}else{
			mysql_select_db($database_conn, $conn);
			$query_produto = "SELECT * FROM c_produto_pedido WHERE status_pp = '6' and pc_id = $pedido and pro_descricao LIKE '%$produto%'";
		}
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
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
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
				closeTxt: "<div class='div_botoes'><button class='button' onclick='window.location=window.location'>Sair</button></div>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
	
});


</script>
<script type="text/javascript">
function pergunta(id, pedido, acao){
		if(confirm("Comprar Produto?")){
			window.location.href = "funcao.php?id_produto="+id+"&funcao="+acao+"&pedido="+pedido
			}
		return false
		}
</script>
</head>
<body>
<div class="acao_pagina">Compra por Produtos</div>
<form action="" id="form1" method="post" name="form1">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
    <th scope="row">Pedido</th>
    <td>
        <input name="pc_id" type="text" id="pc_id" title="Nº do Pedido" value="<?php echo $_REQUEST['pc_id'];?>" size="13" />
        </td>
  </tr>
  <tr>
    <th scope="row">Produto</th>
    <td>

        <input name="produto" type="text" id="produto" value="<?php echo $_REQUEST['produto'];?>" size="80" />
</td>
  </tr>
  <tr>
    <th colspan="2" scope="row"><div class="div_botoes">
      <input name="busca" type="button" id="busca" value="busca" />
    </div></th>
  </tr>
</table>
</form>
<table width="auto%" border="0" align="center" class="KT_tngtable">
<tr>
      <td bgcolor="#666666" style="color:#FFF">Produto</td>
      <td bgcolor="#666666" style="color:#FFF">Qtd. Pedido</td>
      <td bgcolor="#666666" style="color:#FFF">Qtd. Estoque</td>
      <td bgcolor="#666666" style="color:#FFF">Sub-Total</td>
      <td bgcolor="#666666" style="color:#FFF">Pedido</td>
      <td bgcolor="#666666" style="color:#FFF" colspan="6">Comprar</td>
  </tr>
  <?php do { ?>
  <?php if($_REQUEST['edita'] == '1'){ ?>
     <?php }else{
		 if($row_produto['PRIO_DESC'] == 'ALTA') {?>	
             <tr class="prio_auta">
             <?php }else{ ?>
             <tr>
      <?php } ?>       
     <?php } ?>
      <td><?php echo $row_produto['PROD_ID']; ?> - <?php echo $row_produto['PRO_DESCRICAO']; ?></td>
      <td><?php echo $row_produto['Qtd_pedido']; ?></td>
      <td><?php echo $row_produto['qtd_estoque']; ?></td>
      <td><?php echo $row_produto['Sub_total']; ?></td>
      <td><?php echo $row_produto['PC_ID']; ?></td>
      <td><?php echo $row_produto['status']; ?></td>
      <td><?php echo $row_produto['PRIO_DESC']; ?></td>
      <td><a href="../pedido/produto_pedido.php?PC_ID=<?php echo $row_produto['PC_ID']; ?>" rel="superbox[iframe][800x500]"><img src="../../img/manutencao.gif" alt="" width="16" height="16" border="0" title="Editar produto nos Pedidos" /></a>
      </td>
      <td><a href="#" onclick="pergunta('<?php echo $row_produto['PROD_ID']; ?>', '<?php echo $row_produto['PC_ID']; ?>', 'comprar_produto')"><img src="../../img/comprar.png" alt="" width="16" height="16" border="0" title="Comprar produto?" /></a></td>
      <td><a href="../pedido/visualiza.php?PC_ID=<?php echo $row_produto['PC_ID']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/print.png" width="16" height="16" border="0" title="Visualizar Pedido" /> </a></td>
    </tr>
      <?php } while ($row_produto = mysql_fetch_assoc($produto)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($produto);
?>
