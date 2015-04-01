<?php /* Smarty version Smarty-3.1.12, created on 2015-04-01 13:58:32
         compiled from "view/taxaItem.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55520298554f06790597287-39726320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00cf11d58de8dcab97a7123cf490f9ee66aabc17' => 
    array (
      0 => 'view/taxaItem.tpl',
      1 => 1427911047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55520298554f06790597287-39726320',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54f067906b27e9_24821311',
  'variables' => 
  array (
    'taxa' => 0,
    'item' => 0,
    'i' => 0,
    'taxaItem' => 0,
    'it' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f067906b27e9_24821311')) {function content_54f067906b27e9_24821311($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sig/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div>
    <form class="well form-search" method="POST">
    <div class="control-group">
        <label class="controls">Cod. Taxa: </label>
            <span class="badge"><?php echo $_GET['idTaxa'];?>
</span> 
        <label class="controls">Data: </label>
            <span class="badge"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['taxa']->value[0]['data'],"%d/%m/%Y");?>
</span> 
        <label class="controls">Corretor: </label>
            <span class="badge"><?php echo $_smarty_tpl->tpl_vars['taxa']->value[0]['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['taxa']->value[0]['cor_nome'];?>
</span> 
    </div>
    
    <label>Item: </label>
    <select name="idItem" class="validate[required]">
                        <option value="">Selecione ...</option>
                        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value['descricao'];?>
</option>
                        <?php } ?>
                    </select>
    <label>Qtd.:</label>
    <input type="text" size="5" name="qtd" class="validate[required] valor" value="" /> 
    
    <label>Peso.:</label>
    <input type="text" size="5" name="peso" class="validate[required] valor" value="" /> 
    
    <label>Valor: </label>
    <input type="text" size="5" class="validate[required] valor" name="valor" value="" />
    
    <label>Tipo: </label>
    <select name="tipo">
        <option value="c">A PAGAR</option>
        <option value="d">A RECEBER</option>
        <option value="i" selected>INFORMATIVO</option>
    </select>
    
    <input type="submit" value="Incluir" class="btn" name="acao" /> 
    <input type="hidden" value="<?php echo $_GET['idTaxa'];?>
" name="idTaxa" />
    </form>
</div>
        <div>
            <table border="0" class="table table-hover">
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Item</th>
                        <th>Qtd</th>
                        <th>Peso</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $_smarty_tpl->tpl_vars['it'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['it']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['taxaItem']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['it']->key => $_smarty_tpl->tpl_vars['it']->value){
$_smarty_tpl->tpl_vars['it']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['it']->value['grupo'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['it']->value['item'];?>
</td>
                        <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['it']->value['qtd']);?>
</td>
                        <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['it']->value['peso']);?>
</td>
                        <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['it']->value['valor']);?>
</td>
                        <td><?php if ($_smarty_tpl->tpl_vars['it']->value['tipo']=="d"){?> 
                                A RECEBER 
                            <?php }elseif($_smarty_tpl->tpl_vars['it']->value['tipo']=="c"){?> 
                                A PAGAR 
                            <?php }else{ ?>
                                INFORMATIVO
                                <?php }?></td>
                        <td>
                            <div class="input-append">
                                <a href="?excluirItem&idTaxa=<?php echo $_GET['idTaxa'];?>
&item=<?php echo $_smarty_tpl->tpl_vars['it']->value['idItem'];?>
&grupo=<?php echo $_GET['g'];?>
" class="icon-remove"></a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        
        </div>
<?php echo $_smarty_tpl->getSubTemplate ("../../view/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>