<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../../../bibliotecas/mascara.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
			   $(".data").mask("99-99-9999")		   
			   
			   })
	function abre(){
		data1 = document.getElementById('data_1').value
		data2 = document.getElementById('data_2').value
		
		window.open('../equipamento_custo.php?data1='+data1+'&data2='+data2, 'Print', 'channelmode=yes');
	
	
	}

</script>
</head>

<body>
<div class="acao_pagina">Relatorio de Equipamento p/ Custo</div>
<form id="form1" name="form1" method="get" action="../equipamento_custo.php" target="_blank">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><label>
        <input type="text" name="data_1" id="data_1" class="data" value="<?php echo date('01/m/Y'); ?>" />
      </label></td>
      <th>a</th>
      <td><label>
        <input type="text" name="data_2" id="data_2" class="data" value="<?php echo date('d/m/Y'); ?>" />
      </label></td>
    </tr>
    <tr>
      <th colspan="4" scope="row"><div class="div_botoes">
        <label>
          <input type="button" name="button" id="button" value="Buscar" onclick="abre()" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>