<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../../../bibliotecas/mascara.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$(".data").mask('99-99-9999');
		$("[name=buscar]").click(function(){
										  form1.submit()
										  })
		})
</script>
</head>

<body>
<div class="acao_pagina">Relatorio de Auditoria dos procedimentos</div>
<br />
<form id="form1" name="form1" method="post" action="../nc_setor.php" target="_blank">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Periodo:</th>
      <td scope="col"><label>
        <input type="text" name="data_1" id="data_1" class="data"  value="<?php echo date('01-m-Y'); ?>" />
        a 
        <input type="text" name="data_2" id="data_2" class="data" value="<?php echo date('d-m-Y'); ?>" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2"><div class="div_botoes"><input name="buscar" type="button" value="Gerar" /></div></th>
    </tr>
  </table>
</form>
</body>
</html>