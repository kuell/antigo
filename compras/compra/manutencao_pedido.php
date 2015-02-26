<?php require_once('../../Connections/conn.php'); ?>
<?php
	
$id_pedido = $_REQUEST['PC_ID'];

mysql_select_db($database_conn, $conn);
$query_produto_pedido = "SELECT * FROM c_produto_pedido WHERE pc_id = '$id_pedido'";
$produto_pedido = mysql_query($query_produto_pedido, $conn) or die(mysql_error());
$row_produto_pedido = mysql_fetch_assoc($produto_pedido);
$totalRows_produto_pedido = mysql_num_rows($produto_pedido);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../pedido/funcao.js" language="javascript"></script>
<script language="javascript">
function verifica(resultado){
	var produto = document.form1.PRODUTO.value
	if(resultado > 0){
		if(confirm("ATENÇÂO!!! Este produto ja existe em outro pedido, deseja pedi-lo novamente?")){
		document.form1.PRODUTO.value = produto
			return true
			}
			document.form1.PRODUTO.focus();
			document.form1.PRODUTO.value = 0;
		}
		else{
		document.form1.PRODUTO.value = produto
			}
	}

$(function(){
	$("#PRODUTO").blur(function(){
		var produto = $("#PRODUTO").val();
	$.post("funcao.php?action=verifica_produto",  {PRODUTO: produto}, function(valor){
				verifica(valor);															  
		   });  
		   });
		   });


function valida(){
					if(document.form1.PRODUTO.value == ""){
						alert("O campo Produto não pode ser Branco!")
						return false
						}
					if(document.form1.QUANTIDADE.value == ""){
						alert("O campo Quantidade não pode ser Branco!")
						return false
					}
					if(document.form1.estoque.value == ""){
						alert("O campo Qtd. Estoque não pode ser Branco!")
						return false
					}
					 return  doPost('form1', 'incluir_produto')
					}
	function manutencao(pedido, produto){
		qtd = document.form2.qtd.value
		window.location = 'funcao.php?funcao=manutencao_produto&pedido='+pedido+'&produto='+produto+'&qtd='+qtd;
		
		}
	
</script>
</head>

<body>
<div class="acao_pagina">Produtos do Pedido <?php echo $id_pedido;?></div>
<div class="controle_form">
  <form action="../pedido/funcao.php" method="GET" name="form1" id="form1">
<input name="PC_ID" type="hidden" id="PC_ID" value="<?php echo $id_pedido;?>" />
<table width="auto%" border="0" align="center">
      <tr>
      <th width="50" scope="col">Produto</th>
      <th width="71" scope="col">
      <select name="PRODUTO" id="PRODUTO" tabindex="10">
         <option value="0">Selecione</option>
             <?php
			$sql = "Select * from produto order by PRO_DESCRICAO";
			$qr = mysql_query($sql);
			while($linha = mysql_fetch_assoc($qr)){
			?> 
			<option value="<?php echo $linha['PRO_ID']?>"  ><?php echo $linha['PRO_DESCRICAO']?></option>
            <?php } ?>
 
      </select></th>
      <th width="74" scope="col">Quantidade</th>
      <th width="96" scope="col"><input type="text" name="QUANTIDADE" id="QUANTIDADE" /></th>
      <th width="80" scope="col">Qtd. Estoque</th>
      <th width="96" scope="col"><input type="text" name="estoque" id="estoque" /></th>
      </tr>
    <tr>
      <td colspan="7"><div class="div_botoes" align="center">
        <input type="button" name="button" id="button" value="alterar" onclick="return valida()" />
      </div></td>
    </tr>
  </table>
    <input name="action" type="hidden" id="action" value="form1" />
  </form>
</div>
<div class="lista_conteudo" onfocus="MM_goToURL('parent','../../login.php');return document.MM_returnValue">

  <form id="form2" name="form2" method="post" action="">

  <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
    <thead>
      <tr class="KT_row_order">
        <th> Cod</th>
        <th id="PRO_DESCRICAO">Descri&ccedil;&atilde;o</th>
        <th id="total_produto">Qtd. <br />
          Pedido</th>
        <th>Qtd.<br /> 
          Estoque</th>
        <th>Sub-Total</th>
        <th colspan="3">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td><div class="KT_col_PROD_ID"><?php echo $row_produto_pedido['PROD_ID']; ?></div></td>
          <td><div class="KT_col_PRO_DESCRICAO"><?php echo $row_produto_pedido['PRO_DESCRICAO']; ?></div></td>
          <td><input name="qtd" type="text" id="qtd" value="<?php echo $row_produto_pedido['Qtd_pedido']; ?>" /></td>
          <td><?php echo $row_produto_pedido['qtd_estoque']; ?></td>
          <td><?php echo $row_produto_pedido['Sub_total']; ?></td>
          <td><?php echo $row_produto_pedido['unidade']; ?></td>
          <td><a href="menutencao_produto.php?pedido=<?php echo $row_produto_pedido['PC_ID']; ?>&amp;produto=<?php echo $row_produto_pedido['PROD_ID']; ?>" rel="superbox[iframe][400x400]"><img src="../../img/005.gif" alt="" width="16" height="16" border="0" /></a></td>
          <td><a href="../pedido/funcao.php?action=excluirProduto&amp;PC_ID=<?php echo $id_pedido;?>&amp;PROD_ID=<?php echo $row_produto_pedido['PROD_ID']; ?>"><img src="../../img/004.gif" alt="" width="16" height="16" border="0" /></a></td>
        </tr>
        <?php } while ($row_produto_pedido = mysql_fetch_assoc($produto_pedido)); ?>
    </tbody>
  </table>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($produto_pedido);
?>
