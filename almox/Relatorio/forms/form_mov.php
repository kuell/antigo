<?php
	require("../../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);

?>
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
			   $('.data').mask('99-99-9999')			   
			   })
	function abre(){
		data1 = document.getElementById('data1').value
		data2 = document.getElementById('data2').value
		grupo = document.getElementById('prod').value
		
		window.open('../rel_mov.php?data1='+data1+'&data2='+data2+'&prod='+grupo,'Imprime', 'channelmode=yes')
		
		
		}

</script>
</head>

<body>
<div class="acao_pagina">Movimentação Almoxarifado</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td><label>
        <input type="text" name="data1" id="data1" class="data" value="<?php echo date('01-m-Y'); ?>" />
      </label>
        a 
        <label>
          <input type="text" name="data2" id="data2" class="data" value="<?php echo date('d-m-Y'); ?>" />
        </label></td>
    </tr>
    <tr>
      <th scope="row">Grupo:</th>
      <td><label>
        <select name="prod" id="prod">
           <option value="">Todos ..</option>
		<?php
			$sql = "Select * from grupo";
			$qr = mysql_query($sql) or die (mysql_error());
			while($res = mysql_fetch_assoc($qr)){
		?>
          <option value="<?php echo $res['descricao']; ?>"><?php echo $res['descricao']; ?></option>
        <?php } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes"><input name="" type="button" value="Buscar" onclick="abre()" /></div></th>
    </tr>
  </table>
</form>
</body>
</html>