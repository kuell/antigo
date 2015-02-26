<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../bibliotecas/mascara.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
			  $(".data").mask('99-99-9999');			   
			   })
	function abre(pagina){
		data = document.getElementById('data').value
		window.open(pagina+'?data='+data,'Digitação','channelmode=yes')
		
		}

</script>
</head>

<body>
<div class="acao_pagina">Movimentação Produtividade RH</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Data Digitação:</th>
      <td><label>
        <input name="data" type="text" class="data" id="data" value="<?php echo date('d-m-Y'); ?>" />
      </label></td>
    </tr>
    <tr class="div_botoes">
      <th colspan="2" scope="row"><div class="div_botoes">
        <input type="button" name="button" id="button" value="Digitar" onclick="abre('prod_mov.php')" />
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>