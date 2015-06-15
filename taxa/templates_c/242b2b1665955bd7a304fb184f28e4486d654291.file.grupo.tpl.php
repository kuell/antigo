<?php /* Smarty version Smarty-3.1.12, created on 2015-06-08 12:16:16
         compiled from "view/grupo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3136530965575bfd08d3b67-96894272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '242b2b1665955bd7a304fb184f28e4486d654291' => 
    array (
      0 => 'view/grupo.tpl',
      1 => 1428603534,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3136530965575bfd08d3b67-96894272',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'op' => 0,
    'grupo' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5575bfd0b75a70_19430080',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5575bfd0b75a70_19430080')) {function content_5575bfd0b75a70_19430080($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php if ((($tmp = @$_smarty_tpl->tpl_vars['op']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
<h4>Controle dos Grupos</h4>
<div class=" span7 offset1">
<table class="table table-striped" align="center">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Descricao</th>
            <th colspan="2">
                <a class="btn btn-primary" href="?add">Adicionar</a></th>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['grupo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['descricao'];?>
</td>
            <td>
                <div class="input-append">
                    <a href="?editar=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="btn"/><i class="icon-pencil"></i></a>
                    <a href="#" class="btn" /><i class="icon-remove"></i></a>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<?php }else{ ?>
    <h1>Controle de Grupos</h1>
    <div class="span4 offset1">
        <form method="POST" class="form">
            <div class="control-group">
                <label class="control-label">Descricao: </label>
                <input type="hidden" name="id" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['grupo']->value[0]['id'])===null||$tmp==='' ? '' : $tmp);?>
" />
                <div class="controls"> 
                    <input type="text" name="descricao" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['grupo']->value[0]['descricao'])===null||$tmp==='' ? '' : $tmp);?>
" class="validate[required] input-xlarge" /> 
                </div>
            </div>
            <div>
                <input type="submit" name="acao" value="<?php echo $_smarty_tpl->tpl_vars['op']->value;?>
" class="btn" />
            </div>
    </form>
    </div>
<?php }?>        
<?php echo $_smarty_tpl->getSubTemplate ("../../view/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php }} ?>