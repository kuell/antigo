<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
<script src="../../../bibliotecas/mascara.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
			$(".data").mask("99-99-9999")
			   })

</script>
</head>

<body>
<div class="acao_pagina">Relatorio Geral - Por Status</div>
<br />
<form id="form1" name="form1" method="post" action="../reports/geral_osi.php" target="_blank">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><label>
        <input type="text" name="data_1" id="data_1" class="data" value="<?php echo date("01-m-Y");?>" />
      </label></td>
      <td>a</td>
      <td><label>
        <input type="text" name="data_2" id="data_2" class="data" value="<?php echo date("d-m-Y");?>"/>
      </label></td>
    </tr>
    <tr>
      <th scope="row">Responsavel:</th>
      <td colspan="3" scope="row"><label>
        <select name="responsavel" id="responsavel">
        <option value="">Todos</option>
        <?php 
			require('../../../Connections/conn.php');
			mysql_select_db($database_conn, $conn);
			$sql = 'Select * from ordem_interna_vew group by responsavel';
			$qr = mysql_query($sql) or die (mysql_error());
			while($res = mysql_fetch_assoc($qr))
			{		
		?>
        <option value="<?php echo $res['responsavel']; ?>"><?php echo $res['responsavel']; ?></option>
        <?php }?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th scope="row">Status:</th>
      <td colspan="3" scope="row"><label>
        <select name="status" id="status">
          <option value="">Todos</option>
          <option value="EM ANDAMENTO">EM ANDAMENTO</option>
          <option value="BAIXADO">BAIXADO</option>
          <option value="EXECUTADO">EXECUTADO</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="4" scope="row"><div class="div_botoes">
        <label>
          <input type="submit" name="button" id="button" value="Buscar" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>