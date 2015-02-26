<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../../bibliotecas/mascara.js"></script>
<script type="text/javascript">
	$(function(){
			  $('.data').mask('99-99-9999');
			   
			   })
	function abre(){
		data1 = document.getElementById('data1').value
		data2 = document.getElementById('data2').value
		
		window.open('../relGerFat.php?data1='+data1+'&data2='+data2,'Imprimir','channelmode=yes')
		}
</script>
</head>

<body>
<div class="acao_pagina">Relatorio de Gerenciamento do Faturamento</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><label>
        <input name="data1" type="text" class="data" id="data1" value="<?php echo date('01-m-Y'); ?>" />
      </label>
        a 
        <label>
          <input name="data2" type="text" class="data" id="data2" value="<?php echo date('d-m-Y'); ?>" />
        </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <label>
          <input name="Button" type="button" value="Buscar" onclick="abre()" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>