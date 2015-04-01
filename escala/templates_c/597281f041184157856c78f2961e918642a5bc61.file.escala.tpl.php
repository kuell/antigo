<?php /* Smarty version Smarty-3.1.12, created on 2015-04-01 13:18:04
         compiled from "view/escala.tpl" */ ?>
<?php /*%%SmartyHeaderCode:63309550754f1c782a15f66-42767400%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '597281f041184157856c78f2961e918642a5bc61' => 
    array (
      0 => 'view/escala.tpl',
      1 => 1427908678,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63309550754f1c782a15f66-42767400',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54f1c782bf5fc4_00122136',
  'variables' => 
  array (
    'op' => 0,
    'data' => 0,
    'pecuarista' => 0,
    'corretor' => 0,
    'cor' => 0,
    'c' => 0,
    'qtdBoi' => 0,
    'qtdVaca' => 0,
    'qtdNov' => 0,
    'qtdTouro' => 0,
    'escala' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54f1c782bf5fc4_00122136')) {function content_54f1c782bf5fc4_00122136($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sigAntigo/sig2/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script type="text/javascript">
    
function exclui(id,data){
        if(confirm("ATENÇÃO \n Ao excluir este lote, ele automaticamente voltará a pré-escala na mesma data! \t \n Deseja realmente excluir este registro?")){
            location = "?excluir&id="+id+"&data="+data
            
        }
        return false
    }
    
</script>

<?php if ((($tmp = @$_smarty_tpl->tpl_vars['op']->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
<div class="offset1">
    
    <form method="POST" class="form form-horizontal">
        <fieldset>
            <legend>Cadastro de Lote</legend>
            <div class="control-group">
                <label class="control-label" >Data: </label>   
                <div class="controls"> 
                    <input type="text" name="data" <?php if (((($tmp = @$_GET['id'])===null||$tmp==='' ? '' : $tmp)!='')){?> readonly <?php }else{ ?>class="data" <?php }?> value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value,"%d/%m/%Y");?>
" />                   
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label">Pecuarista:</label>
                    <div class="controls">
                        <input type="text" name="pecuarista" id="pecuarista" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['pecuarista']->value)===null||$tmp==='' ? '' : $tmp);?>
" size="70" />
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label">Corretor: </label>
                        <div class="controls">
                            <select name="corretor" class="input-xxlarge">
                            <option value="">Selecione ...</option>
                            <?php  $_smarty_tpl->tpl_vars['cor'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cor']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['corretor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cor']->key => $_smarty_tpl->tpl_vars['cor']->value){
$_smarty_tpl->tpl_vars['cor']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['cor']->value['cor_id'];?>
" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['c']->value)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['cor']->value['cor_id']){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['cor']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['cor']->value['cor_nome'];?>
</option>    
                            <?php } ?>
                        </select>
                        
                        </div>
                    </div>
          
                        <legend>Escala</legend>
                        <div class="container-fluid" >
                            <div class="row-fluid">
                             <div class="span3 well">
                            <label>Qtd. Boi</label>                            
                                <input class="int" type="text" name="qtdBoi" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdBoi']->value)===null||$tmp==='' ? "0" : $tmp);?>
"  />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Vaca</label>
                                <input class="int" type="text" name="qtdVaca" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdVaca']->value)===null||$tmp==='' ? "0" : $tmp);?>
" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Novilha</label>
                                <input class="int" type="text" name="qtdNov" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdNov']->value)===null||$tmp==='' ? "0" : $tmp);?>
" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Touro</label>
                                <input class="int" type="text" name="qtdTouro" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdTouro']->value)===null||$tmp==='' ? "0" : $tmp);?>
" />
                                </div>
                            </div>
                        </div>
                                <div class="control-group well span11">
                                    <input type="submit" name="acao" value="<?php echo $_smarty_tpl->tpl_vars['op']->value;?>
" class="btn" />
                                    <input type="submit" name="acao" value="Voltar" class="btn" />
                                    <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>
" />
                       </div>
        </fieldset>

    </form>
 </div>
<?php }else{ ?>
    <div class="offset1">
        <form method="GET" class="form form-horizontal" />
        <fieldset>
            <legend>Controle da escala de abate.</legend>
            <div class="control-group">
                <label class="control-label">Data: </label>
                <div class="controls">
                    <input type="text" class="data" name="data" id="data"  value="<?php echo smarty_modifier_date_format(((($tmp = @$_smarty_tpl->tpl_vars['data']->value)===null||$tmp==='' ? time() : $tmp)),"%d/%m/%Y");?>
" />
                </div>
            </div>
                <div class="control-group">
                <label class="control-label">Hora de incio: </label>
                <div class="controls">
                    <input type="text" class="hora" name="hora" id="hora"  value="05:00" />
                </div>
            </div>
                <div class="control-group well span5">
                    <input class="btn" type="submit" value="Buscar" name="acao" />
                    <input class="btn" onclick="window.open('rel_escala.php?data='+document.getElementById('data').value+'&hora='+document.getElementById('hora').value, 'Print', 'channelmode=yes')" type="button" value="Escala" title="Escala todos os lotes selecionados!" name="acao" />
                </div>
                </fieldset>
            </form>
    </div>

<div class="offset1 span">
    <table border="0" class="table table-hover" align="center">
        <thead>
        <tr>
            <th>Lote</th>
            <th>Data</th>
            <th>Corretor</th>
            <th>Pecuarista</th>
            <th>Qtd. boi</th>
            <th>Qtd. Vaca</th>
            <th>Qtd. Nov.</th>
            <th>Qtd. Touro</th>
            <th>Total</th>
            <th>Duração</th>
            <th colspan="4"><a href="?add&data=<?php echo smarty_modifier_date_format(((($tmp = @$_smarty_tpl->tpl_vars['data']->value)===null||$tmp==='' ? time() : $tmp)),"%d/%m/%Y");?>
" class="btn btn-primary" >Adicionar</a></th>
        </tr>
        </thead>
        <tbody>
            
            <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['escala']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['row']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['row']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['row']->iteration++;
 $_smarty_tpl->tpl_vars['row']->last = $_smarty_tpl->tpl_vars['row']->iteration === $_smarty_tpl->tpl_vars['row']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['esc']['last'] = $_smarty_tpl->tpl_vars['row']->last;
?>
        <tr>            
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['lote'];?>
</td>
            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['cor_cod'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['pecuarista'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['qtdBoi'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['qtdVaca'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['qtdNov'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['qtdTouro'];?>
</td>
            <th class="well"><?php echo $_smarty_tpl->tpl_vars['row']->value['qtdVaca']+$_smarty_tpl->tpl_vars['row']->value['qtdTouro']+$_smarty_tpl->tpl_vars['row']->value['qtdNov']+$_smarty_tpl->tpl_vars['row']->value['qtdBoi'];?>
</th>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['duracao'];?>
 min</td>
            <td>
                
                <a href="?editar&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
&data=<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
" class="icon-pencil" title="Editar registro"></a>
                <a href="#" class="icon-remove" title="Remover da escala" onclick="exclui('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
', '<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
')" ></a>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['lote']=="1"){?>
                    <a href="?ordem=-1&lote=<?php echo $_smarty_tpl->tpl_vars['row']->value['lote'];?>
&data=<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
" class="icon-arrow-down"></a>
                <?php }elseif($_smarty_tpl->getVariable('smarty')->value['foreach']['esc']['last']==1){?>
                    <a href="?ordem=1&lote=<?php echo $_smarty_tpl->tpl_vars['row']->value['lote'];?>
&data=<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
" class="icon-arrow-up"></a>
                <?php }else{ ?>
                    <a href="?ordem=1&lote=<?php echo $_smarty_tpl->tpl_vars['row']->value['lote'];?>
&data=<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
" class="icon-arrow-up"></a>
                    <a href="?ordem=-1&lote=<?php echo $_smarty_tpl->tpl_vars['row']->value['lote'];?>
&data=<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
" class="icon-arrow-down" ></a>
                <?php }?>
            </td>
        </tr>
        <?php } ?>
        
        </tbody>
    </table>
</div>
                            
<?php }?>
</html>
<?php }} ?>