<?php 
	require("../../Connections/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 	
	if($_REQUEST["data"] == ""){
		$data = date('d-m-Y');
	}
	else{
		$data= date('d-m-Y', strtotime($_REQUEST['data']));
	}
	
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimentação Almoxarifado</title>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript">
	$(function(){
			   $(".data").mask("99-99-9999");
			   })
	function func(){
		data = document.getElementById('data').value
		window.open('operacao.php?data='+data+'&id=0', 'Print', 'channelmode=yes')
		}
</script>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Movimentação do Almoxarifado</div>
<div><form id="form1" name="form1" method="post" action="?data=<?php echo $data ?>&">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Data:</th>
      <td><label>
        <input name="data" type="text" class="data" id="data" value="<?php echo $data;?>" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><label>
        <input type="submit" name="button" id="button" value="Busca" />
      	<input type="button" name="button2" id="button2" value="Adicionar" onclick="func()" />
        </label></th>
    </tr>
  </table>
  </form>
</div>
<br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Data</th>
    <th scope="col">Grupo</th>
    <th>Tipo</th>
    <th>Qtd. Mov</th>
    <th>Valor. Mov</th>
    <th>Estoque Atual</th>
    <th>Valor Atual</th>
  </tr>
   
  <?php
  
	$sql = "
		SELECT 
			  mov_almox.`id` as cod,
			  `data`,
			  `grupo`.descricao as descricao,
			  `tipo`,
			  mov_almox.`qtd` as qtd,
			  mov_almox.`valor` as val,
			  `usu_add`,
			  `usu_up`,
			  `data_dig`,
			  (select quantidade from estoque_atual where id = grupo.id) as estoque,
			  estoque_atual,
			  valor_atual
			FROM 
			  `mov_almox` left outer join grupo on (mov_almox.grupo = grupo.id)
			";
	$qr = mysql_query($sql) or die (mysql_error());
	while($linha = mysql_fetch_assoc($qr)){
		?>
  <tr>
    <td><?php echo $linha['cod']; ?></td>
    <td><?php echo date('d/m/Y', strtotime($linha['data'])); ?></td>
    <td><?php echo $linha['descricao']; ?></td>
    <td><?php if($linha['tipo'] == 'ctfe'){echo 'Contagem Fisica Entrada';}
		  elseif($linha['tipo'] == 'ctfs'){echo 'Contagem Fisica Saida';}
		  elseif($linha['tipo'] == 'deventrada'){echo 'Devolução de entrada';}
		  elseif($linha['tipo'] == 'devsaida'  ){echo 'Devolução de saida';}
		  else {echo $linha['tipo'];} ?></td>
    <td><?php echo number_format($linha['qtd'],2,',','.'); ?></td>
    <td><?php echo number_format($linha['val'],2,',','.'); ?></td>
    <td><?php echo number_format($linha['estoque_atual'],2,',','.'); ?></td>
    <td><?php echo number_format($linha['valor_atual'],2,',','.'); ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>