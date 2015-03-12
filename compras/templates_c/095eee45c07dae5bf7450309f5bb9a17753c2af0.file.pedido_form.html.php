<?php /* Smarty version Smarty-3.1.12, created on 2015-03-12 15:01:10
         compiled from "view/pedido_form.html" */ ?>
<?php /*%%SmartyHeaderCode:1775828126547c5d0819bff3-90253788%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '095eee45c07dae5bf7450309f5bb9a17753c2af0' => 
    array (
      0 => 'view/pedido_form.html',
      1 => 1426186864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1775828126547c5d0819bff3-90253788',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_547c5d084e62f7_60462003',
  'variables' => 
  array (
    'id' => 0,
    'prioridade' => 0,
    'listaSetor' => 0,
    'set' => 0,
    'setor' => 0,
    'solicitante' => 0,
    'osi' => 0,
    'obs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_547c5d084e62f7_60462003')) {function content_547c5d084e62f7_60462003($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script language="javascript" type="text/javascript">
function validar(form){
	if(form.prioridade.value == "")
	{
		alert("O campo Prioridade nÃ£o pode ser nulo")
		form.prioridade.focus()
	return false	
	}
	
	if(form.setor.value == "")
	{
		alert("O campo Setor nÃ£o pode ser nulo")
		form.setor.focus()
	return false	
	}
	if(form.solicitante.value == "")
	{
		alert("O campo Solicitante nÃ£o pode ser nulo")
		form.solicitante.focus()
	return false	
	}
        return true;
	}
</script>
</head>

<body>
    <form action="" method="post" name="formulario" id="formulario" enctype="multipart/form-data" onsubmit="return validar(this)">
        <input type="hidden" id="id" name="id" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? '' : $tmp);?>
" />
  <div class="acao_pagina">Pedido de Compras</div>
  <table border="0" align="center" class="KT_tngtable" style="border:1px solid #006;">
      <tr>
          <th>Cod.</th>
          <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? '' : $tmp);?>
</td>
      </tr>
    <tr>
      <th>Prioridade:</th>
      <td>   
        <select name="prioridade" id="prioridade">
            <option value="1">BAIXA</option>
          <option value="2">MEDIA</option>
          <option value="3">ALTA</option>
                    <?php if ($_smarty_tpl->tpl_vars['prioridade']->value!=''){?> 
                    <option value="<?php echo $_smarty_tpl->tpl_vars['prioridade']->value;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['prioridade']->value;?>
</option>
                    <?php }?>
        </select>
      </td>
    </tr>
    <tr>
      <th>Setor:</th>
      <td>
          <select name="setor" id="setor">
            <option value="">Selecione</option>
            <?php  $_smarty_tpl->tpl_vars['set'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['set']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listaSetor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['set']->key => $_smarty_tpl->tpl_vars['set']->value){
$_smarty_tpl->tpl_vars['set']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['set']->value['id_setor'];?>
" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['setor']->value)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['set']->value['setor']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['set']->value['setor'];?>
</option>
            <?php } ?>
          </select>
      </td>
    </tr>
    <tr>
      <th>Solicitante:</th>
      <td><input value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['solicitante']->value)===null||$tmp==='' ? '' : $tmp);?>
" type="text" name="solicitante" id="solicitante" size="70"/></td>
    </tr>
	<tr>
      <th>Numero Ordem Interna:</th>
      <td><label>
        <input name="osi" type="text" id="osi" class="int" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['osi']->value)===null||$tmp==='' ? '' : $tmp);?>
" />
      </label></td>
    </tr>
    <tr>
      <th valign="top">Descri&ccedil;&atilde;o:</th>
      <td><textarea name="obs" id="obs" cols="45" rows="5"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['obs']->value)===null||$tmp==='' ? '' : $tmp);?>
</textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
     <?php if ((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
        <input type="submit" name="acao" value="Salvar" class="botao" />
     <?php }else{ ?>
        <input name="acao" type="submit" class="botao"  value="Editar" />
   	<a href="ProdutoPedido.php?incluir&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" rel="superbox[iframe][900x500]"><input type="button" value="Itens" /></a>
        <a href="?visualizar&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" rel="superbox[iframe][800x500]"><input type="button" value="Visualizar" /></a>
     <?php }?>
     <input type="button" name="acao" value="Voltar" id="voltar" class="botao" /></td>
    </tr>
  </table>
</form>

</body>
</html>
<?php }} ?>