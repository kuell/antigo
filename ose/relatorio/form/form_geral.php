<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../bibliotecas/calendario/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../../../bibliotecas/calendario/jquery.js"></script>
<script type="text/javascript" src="../../../bibliotecas/calendario/jquery.click-calendario-1.0-min.js"></script>		
<script type="text/javascript" src="../../../bibliotecas/calendario/jquery.click-calendario-1.0.js"></script>
<script type="text/javascript">
$(document).ready(function(){
						   $('#data_1').focus(function(){
				$(this).calendario({ 
					target:'#data_1'
				});
			});
						   						   })
$(document).ready(function(){
						   $('#data_2').focus(function(){
		$(this).calendario({ 
			target:'#data_2'
		});
	});
									   })			   


</script>
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Relatorio Geral Ordem Externa</div>
<form id="form1" name="form1" method="get" action="../recibo_os.php?data_1=<?php echo $_GET['data_1'];?>&data_2=<?php echo $_GET['data_2']?>">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Periodo:</th>
      <td scope="col"><label>
        <input name="data_1" type="text" id="data_1"  maxlength="10" />
      </label></td>
      <th>até</th>
      <td><label>
        <input type="text" name="data_2" id="data_2"/>
      </label></td>
    </tr>
    <tr>
      <th colspan="4" scope="col"><div align="center">
        <label>
          <input type="submit" name="button" id="button" value="Filtrar" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>