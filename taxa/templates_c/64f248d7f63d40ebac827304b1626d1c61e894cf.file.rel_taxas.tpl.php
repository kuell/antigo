<?php /* Smarty version Smarty-3.1.12, created on 2015-01-30 12:59:45
         compiled from "view/rel_taxas.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18732506254cbb8811369a5-90221544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64f248d7f63d40ebac827304b1626d1c61e894cf' => 
    array (
      0 => 'view/rel_taxas.tpl',
      1 => 1422637099,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18732506254cbb8811369a5-90221544',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cor' => 0,
    'corr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54cbb88116b045_32647756',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54cbb88116b045_32647756')) {function content_54cbb88116b045_32647756($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sigAntigo/sig2/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="well form-search">
    <form class="form-horizontal">
        <fieldset>
            <legend>Relatorio de Taxas</legend>
  <div class="control-group">
    <label class="control-label">Corretor: </label>
    <div class="controls">
        <select name="cor" id="cor">
            <option value="0">Todos ...</option>
            <?php  $_smarty_tpl->tpl_vars['corr'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['corr']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['corr']->key => $_smarty_tpl->tpl_vars['corr']->value){
$_smarty_tpl->tpl_vars['corr']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['corr']->value['cor_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['corr']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['corr']->value['cor_nome'];?>
</option>
            <?php } ?>
        </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Data: </label>
    <div class="controls">
        <input type="text" id="dataI" class="validate[required] data" value="<?php echo smarty_modifier_date_format(time(),"01/%m/%Y");?>
"> até
        <input type="text" id="dataF" class="validate[required] data" value="<?php echo smarty_modifier_date_format(time(),"%d/%m/%Y");?>
">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
        <button type="button" class="btn" onclick="window.open('rel_taxa.php?cor='+document.getElementById('cor').value+'&datai='+document.getElementById('dataI').value+'&dataf='+document.getElementById('dataF').value,'Print', 'channelmode=yes')">Buscar</button>
    </div>
  </div>
    </fieldset>
</form>
    
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../../view/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>