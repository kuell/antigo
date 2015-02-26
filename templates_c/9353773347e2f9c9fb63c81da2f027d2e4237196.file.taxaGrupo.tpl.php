<?php /* Smarty version Smarty-3.1.12, created on 2014-12-01 13:11:13
         compiled from "view/taxaGrupo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1064063795547ca131eaf8c0-17027996%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9353773347e2f9c9fb63c81da2f027d2e4237196' => 
    array (
      0 => 'view/taxaGrupo.tpl',
      1 => 1417177386,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1064063795547ca131eaf8c0-17027996',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'grupo' => 0,
    'g' => 0,
    'item' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_547ca132107b08_04088415',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_547ca132107b08_04088415')) {function content_547ca132107b08_04088415($_smarty_tpl) {?><?php if ((($tmp = @$_GET['lanc'])===null||$tmp==='' ? '' : $tmp)==''){?>
    <?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<h1>Inclusão</h1>
<div class="well form-search">
<ul class="nav nav-pills">
  <?php  $_smarty_tpl->tpl_vars['g'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['g']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['grupo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['g']->key => $_smarty_tpl->tpl_vars['g']->value){
$_smarty_tpl->tpl_vars['g']->_loop = true;
?>
<li class="active">
       <a href="?addItem&idTaxa=<?php echo $_GET['grupo'];?>
&g=<?php echo $_smarty_tpl->tpl_vars['g']->value['id'];?>
" rel="superbox[iframe][1000x500]" > <?php echo $_smarty_tpl->tpl_vars['g']->value['descricao'];?>
</a>
  </li>
    <?php } ?>
</ul>
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
                        <th>Tipo de Movimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['a']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['i']->value['grupo'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['i']->value['item'];?>
</td>
                        <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['i']->value['qtd']);?>
</td>
                        <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['i']->value['peso']);?>
</td>
                        <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['i']->value['valor']);?>
</td>
                        <td><?php if ($_smarty_tpl->tpl_vars['i']->value['tipo']=="d"){?>
                                A RECEBER
                            <?php }elseif($_smarty_tpl->tpl_vars['i']->value['tipo']=="c"){?>
                                A PAGAR
                            <?php }else{ ?>
                                INFORMATIVO
                            <?php }?>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
           </table>
    </div>
<?php echo $_smarty_tpl->getSubTemplate ("../../view/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>