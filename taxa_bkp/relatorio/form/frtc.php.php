<?php require('../../../Connections/conn.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Filtro Realtorio</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../../bibliotecas/mascara.js"></script>
<script type="text/javascript">
	$(function(){
			$(".data").mask('99-99-9999');   
			   })
	function abre(pagina){
            window.open(pagina+'?data_1='+document.getElementById('data_1').value+'&data_2='+document.getElementById('data_2').value+"&cor="+document.getElementById('cor').value, 'Imprimir','channelmode=yes')
		}
</script>
</head>

<body>
<div class="acao_pagina">Relatorio Fechamento por Corretor</div>
<br />
<form id="form1" name="form1" method="get" action="../rtc.php" target="_blank">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><label>
        <input name="data_1" type="text" class="data" id="data_1" value="<?php echo date('01-m-Y') ?>" />
      </label>
        a 
        <label>
          <input name="data_2" type="text" class="data" id="data_2" value="<?php echo date('d-m-Y') ?>" />
        </label></td>
    </tr>
    <tr>
      <th scope="row">Corretor:</th>
      <td><label>
        <select name="cor" id="cor">
          <option value="" selected="selected">Selecione ...</option>
          <?php 
			mysql_select_db($database_conn, $conn);
			$sql = "Select * from corretor order by cor_ativo, cor_nome";
			$query = mysql_query($sql) or dir (mysql_error());
			while($row = mysql_fetch_assoc($query)){
		?>
          <option value="<?php echo $row['cor_id']?>"><?php echo $row['cor_cod'];?> - <?php echo $row['cor_nome'].' | Ativo: '; echo $row['cor_ativo'] ?></option>
		  <?php }?>
          <?php if($_REQUEST['cod'] == ''){ } else { ?>
          <option value="<?php echo $row_mov['cor_id']?>"><?php echo $row_mov['cor_cod']?> - <?php echo $row_mov['cor_nome']?></option>
			<?php } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <label>
            <input type="button" name="button" id="button" value="Buscar" onclick="abre('../rtc.php')" />
        </label>
        <label>
          <input type="button" name="button2" id="button2" value="Acumulado" onclick="abre('../rtca.php');" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>