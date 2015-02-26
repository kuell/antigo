<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../../bibliotecas/mascara.js" type="text/javascript"></script>
	<script type="text/javascript">
    	$(function(){
			$(".data").mask("99-99-9999");			   
				   })
		function abre(pagina){
			data1 = document.getElementById('data1').value
			data2 = document.getElementById('data2').value
							
			window.open(pagina+"?data1="+data1+'&data2='+data2,"Imprimir","channelmode=yes")
				
			}
    
    
    </script>
</head>

<body>
<div class="acao_pagina">Relatorio de Produtividade RH</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><input name="data1" type="text" class="data" id="data1" value="<?php echo date('01-m-Y') ?>" /> 
        a 
        <input type="text" name="data2" id="data2" class="data" value="<?php echo date('d-m-Y') ?>" /></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <label>
          <input type="button" name="button" id="button" value="Buscar" onclick="abre('../rel_prod.php')" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>