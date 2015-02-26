<?php 
	define("path", '../');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include("../config.php"); ?>
</head>

<body>
<div class="acao_pagina">Controle de Grupos</div>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Codigo</th>
    <th scope="col">Descricao</th>
    <th scope="col">Estoque</th>
    <th scope="col">Valor</th>
    <th scope="col"><a href="grupo_f.php">Adicionar</a></th>
  </tr>
  <?php 
  	$sql = "Select * from estoque_atual";
	$qr = mysql_query($sql) or die ("Erro ListaGrupo:". mysql_error);
	while($lista = mysql_fetch_assoc($qr)){	
			?>
  <tr>
  	
    <td><?php echo $lista['id'] ?></td>
    <td><?php echo $lista['descricao']; ?></td>
    <td align="right"><?php echo number_format($lista['estoque_atual'],2,',','.'); ?></td>
    <td>R$ <?php echo number_format($lista['valor_atual'],2,',','.'); ?></td>
    <td><a href="grupo_f.php?id=<?php echo $lista['id'] ?>"><img src="../../img/edit.gif" width="16" height="16" /></a></td>
   
  </tr>
   <?php } ?>
</table>
</body>
</html>