<?php require_once ('../../Connections/conn.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/script.js"></script>
</head>

<body>
<div class="well"><h3>Controle de Produtos do Faturamento</h3></div>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="funcao" id="funcao" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Codigo Produ&ccedil;&atilde;o:</th>
      <td scope="col"><input name="cod_prod" type="text" class="ewRptGrpSummary1" id="cod_prod" onblur="busca()" value="<?php
if (!$row_produto['cod_prod']) {
	echo $_REQUEST['id'];
} else {
	echo $row_produto['cod_prod'];}?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="col">Codigo Faturamento:</th>
      <td scope="col"><label>
        <input name="cod_fat" class="numero" type="text" id="cod_fat" value="<?php echo $row_produto['cod_fat'];?>" />
      </label>
      </td>
    </tr>
    <tr>
      <th scope="row">Descri&ccedil;
&atilde;
o da Produ&ccedil;
&atilde;
o:</th>
      <td><?php echo $row_produto['desc_prod'];?></td>
    </tr>
    <tr>
      <th scope="row">Descri&ccedil;
&atilde;
o do Faturamento:</th>
      <td><label>
        <input name="descricao" type="text" id="descricao" value="<?php echo $row_produto['desc_fat'];?>" size="50" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Ativo:</th>
      <td><label>
        <select name="ativo" id="ativo">
          <option value="<?php echo $row_produto['ativo'];?>"><?php echo $row_produto['ativo'];
?></option>
          <option value="Sim">Sim</option>
          <option value="Nao">Não</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <label>
<?php if (!$_REQUEST['cod']) {?>
	<input type="hidden" value="adicionar_fat" name="funcao"/>
	<input type="submit" name="button" id="button" value="Incluir" />
	<?php } else {?>
         <input type="submit" name="button3" id="button3" value="Atualizar" />
	<?php }?>
			<input type="button" name="button2" id="button2" value="Voltar"  onclick="document.location = 'fat_prod_l.php'"/>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($produto);
?>
