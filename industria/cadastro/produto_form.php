<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/script.js"></script>
<script type="text/javascript">
	function acao(action){
		document.getElementById('funcao').value = action
		document.form1.submit()
	}
</script>
</head>

<body>
<div class="acao_pagina">Controle de Produtos / Produção Industrial</div>
<form action="funcao.php" method="post" name="form1" id="form1">
  <input type="hidden" name="funcao" id="funcao" />
  <table align="center" class="KT_tngtable">
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Codigo interno:</th>
      <td><input type="text" name="cod" value="" size="15" class="numero" /></td>
    </tr>
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Produto:</th>
      <td><input type="text" name="descricao" value="" size="50" class="texto" /></td>
    </tr>
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Tipo de Produto:</th>
      <td><select name="tipo">
        <option value="" >Selecione ..</option>
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Miudos</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Sub-Produto</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Ativo:</th>
      <td><select name="ativo">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Sim</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Não</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <th colspan="2" align="right" nowrap="nowrap">
        <em>
      <?php if(!$_REQUEST['id']){ ?>
      <input name="adicionar" type="button" onclick="acao('adicionar')" value="Adicionar" id="adicionar" />
      <?php } else { ?>
      <input type="submit" value="Editar" />
      <?php } ?>
      </em> </th>
    </tr>
  </table>
  <input type="hidden" name="id" value="" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>