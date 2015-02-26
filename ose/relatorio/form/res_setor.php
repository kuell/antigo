<?php
if($_REQUEST['data_1'] == ""){
	$dia = 1;
	$data1 = date("Y-m-".$dia."");
	}
	else{
	$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));
	}
if($_REQUEST['data_2'] == ""){
	$data2 = date('Y-m-d');
	}
	else{
	$data2 = date('Y-m-d', strtotime($_REQUEST['data_2']));
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../../../js/maskedinput.js" type="text/javascript"></script>
<script type="text/ecmascript">
	$(function(){
			$(".data").mask("99-99-9999");
			
			   });
	function busca(){
		open('../custo_setor.php', 'new', 'width=auto,height=auto,toolbar=no,location=no, directories=no,status=no,menubar=no,scrollbars=no,resizable=yes')

		}

</script>
</head>

<body>
<div align="center" class="acao_pagina">Relatorio Resumido por Setor<br />
</div>
<form action="" method="post" name="form1" id="form1">
  <table width="auto" border="0" align="center" class="KT_tngtable">
    <tr>
      <th class="div_botoes">De:</th>
      <td><input name="data_1" type="text" id="data" class="data" value="<?php echo date('d-m-Y', strtotime($data1)); ?>" /></td>
    </tr>
    <tr>
      <th class="div_botoes">At&eacute;:</th>
      <td><input type="text" name="data_2" id="data" class="data" value="<?php echo date('d-m-Y', strtotime($data2));?>"/></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
        <input type="button" name="button" id="button" value="buscar" onclick="busca()"/>
      </div></th>
    </tr>
  </table>
</form>
<br />
<p>&nbsp;</p>
</body>
</html>
