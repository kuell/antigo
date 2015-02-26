<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../js/modal/jquery.superbox.js" type="text/javascript"></script>
<script src="../../js/modal/jquery.superbox.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/script.js"></script>
<script src="../../bibliotecas/mascara.js" type="text/javascript"></script>
<script type="text/javascript">
	function abre(pagina){
		window.open(pagina+"?data="+document.getElementById('data').value,"Print","channelmode=yes,scrollbars=yes")
		}
	$(function(){
			$(".data").mask("99-99-9999");
			   
			   })
</script>
</head>

<body>
<div class="acao_pagina">Digitação da produção</div>
<form id="form1" name="form1" method="post" action="">
<table border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Data:</th>
    <td scope="col"><label>
      <input name="data" type="text" id="data" value="<?php echo date("d-m-Y") ?>" class="data" />
    </label></td>
  </tr>
  <tr>
    <th colspan="2" scope="row">
    <div class="div_botoes"><label>
      <input name="Button" type="button" onclick="abre('producao_produto.php')" value="Buscar"/>
    </label>
      <label>
        <input name="Button" type="button" onclick="abre('visualizar.php')" value="Visualizar"/>
      </label>
    </div></th>
  </tr>
</table>
</form>
</body>
</html>