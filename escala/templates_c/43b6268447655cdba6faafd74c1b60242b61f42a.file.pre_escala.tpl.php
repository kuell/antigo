<?php /* Smarty version Smarty-3.1.12, created on 2015-02-16 07:21:38
         compiled from "view/pre_escala.tpl" */ ?>
<?php /*%%SmartyHeaderCode:182841400454e1d2c2a1de10-15367884%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43b6268447655cdba6faafd74c1b60242b61f42a' => 
    array (
      0 => 'view/pre_escala.tpl',
      1 => 1422637097,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182841400454e1d2c2a1de10-15367884',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'op' => 0,
    'mes' => 0,
    'm' => 0,
    'ano' => 0,
    'mesNome' => 0,
    'dia' => 0,
    'd' => 0,
    'qtd' => 0,
    'pecuarista' => 0,
    'cor' => 0,
    'c' => 0,
    'cr' => 0,
    'qtdBoi' => 0,
    'qtdVaca' => 0,
    'qtdNov' => 0,
    'qtdTouro' => 0,
    'id' => 0,
    'lista' => 0,
    'pe' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54e1d2c2bf9fd0_46535204',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54e1d2c2bf9fd0_46535204')) {function content_54e1d2c2bf9fd0_46535204($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sigAntigo/sig2/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if ((($tmp = @$_smarty_tpl->tpl_vars['op']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
<h1>Pré-Escala de abate</h1>
<div>
<table class="table table-striped">
    <thead>
        <tr>
          <th colspan="7" >
              <?php $_smarty_tpl->tpl_vars['m'] = new Smarty_variable((smarty_modifier_date_format($_smarty_tpl->tpl_vars['mes']->value,"%m")), null, 0);?>
            <a class="btn" href="?ref=-1&mes=<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
&ano=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
"><i class="icon-chevron-left"></i></a>
            <a class="btn"><?php echo $_smarty_tpl->tpl_vars['mesNome']->value;?>
 -  <?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
</a>
            <a class="btn" href="?ref=1&mes=<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
&ano=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
"><i class="icon-chevron-right"></i></a>
          </th>
        </tr>
        <tr>
            <th>Domingo</th>
            <th>Segunda</th>
            <th>Terça</th>
            <th>Quarta</th>
            <th>Quinta</th>
            <th>Sexta</th>
            <th>Sabado</th>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['d']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dia']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
$_smarty_tpl->tpl_vars['d']->_loop = true;
?>
            <tr>
                <td><div class="well">
                   <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[0])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[0])===null||$tmp==='' ? '' : $tmp);?>
    
                    <div>
                        Domingo
                    </div>
                    <?php }?>
                   </div>
                </td>
                <td><div class="well">
                    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[1])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <a class="btn btn-primary btn-large" href="?add=1&data=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['d']->value[1];?>
" rel="superbox[iframe][1100x500]">
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[1])===null||$tmp==='' ? '' : $tmp);?>

                    </a>
                        <div>
                            Total: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtd']->value[$_smarty_tpl->tpl_vars['d']->value[1]])===null||$tmp==='' ? '' : $tmp);?>
</div>
                    </div>
                    <?php }?>
                </td>
                <td><div class="well">
                        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[2])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <a class="btn btn-primary btn-large" href="?add=1&data=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['d']->value[2];?>
" rel="superbox[iframe][1100x500]">
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[2])===null||$tmp==='' ? '' : $tmp);?>

                    </a>
                        <div>
                            Total: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtd']->value[$_smarty_tpl->tpl_vars['d']->value[2]])===null||$tmp==='' ? '' : $tmp);?>
</div>
                    </div>
                    <?php }?>
                </td>
                <td><div class="well">
                        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[3])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <a class="btn btn-primary btn-large" href="?add=1&data=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['d']->value[3];?>
" rel="superbox[iframe][1100x500]">
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[3])===null||$tmp==='' ? '' : $tmp);?>

                    </a>
                        <div>
                            Total: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtd']->value[$_smarty_tpl->tpl_vars['d']->value[3]])===null||$tmp==='' ? '' : $tmp);?>
</div>
                   </div>
                   <?php }?>
                </td>
                <td><div class="well">
                        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[4])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <a class="btn btn-primary btn-large" href="?add=1&data=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['d']->value[4];?>
" rel="superbox[iframe][1100x500]">
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[4])===null||$tmp==='' ? '' : $tmp);?>

                    </a>
                        <div>
                            Total: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtd']->value[$_smarty_tpl->tpl_vars['d']->value[4]])===null||$tmp==='' ? '' : $tmp);?>
</div>
                </div>
                <?php }?>
                </td>
                <td><div class="well">
                        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[5])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <a class="btn btn-primary btn-large" href="?add=1&data=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['d']->value[5];?>
" rel="superbox[iframe][1100x500]">
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[5])===null||$tmp==='' ? '' : $tmp);?>

                        </a>
                        <div>
                            Total: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtd']->value[$_smarty_tpl->tpl_vars['d']->value[5]])===null||$tmp==='' ? '' : $tmp);?>
</div>
                        </div>
                        <?php }?>
                </td>
                <td><div class="well">
                        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['d']->value[6])===null||$tmp==='' ? '' : $tmp)!=''){?>
                    <a class="btn btn-primary btn-large" href="?add=1&data=<?php echo $_smarty_tpl->tpl_vars['ano']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['m']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['d']->value[6];?>
" rel="superbox[iframe][1100x500]">
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['d']->value[6])===null||$tmp==='' ? '' : $tmp);?>

                    </a>
                        <div>
                            Total: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtd']->value[$_smarty_tpl->tpl_vars['d']->value[6]])===null||$tmp==='' ? '' : $tmp);?>
</div>
                    </div>
                    <?php }?>
                </td>
        </tr>
       <?php } ?>
    </tbody>
</table>
</div>
<?php }else{ ?>    
    <div>
        <form method="POST" class="form form-horizontal well">
            <fieldset>
                <legend>Digitação de Pré-Escala</legend>
                <div class="control-group">
                    <label class="control-label">Data: </label>
                    <div class="controls">
                        <input type="text" name="data" id="data" class="data" value="<?php echo smarty_modifier_date_format($_GET['data'],"%d/%m/%Y");?>
" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pecuarista: </label>
                    <div class="controls">
                        <input type="text" name="pecuarista" class="input-xxlarge" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['pecuarista']->value)===null||$tmp==='' ? '' : $tmp);?>
" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Corretor: </label>
                    <div class="controls">
                        <select name="corretor">
                            <option value="0">Selecione ...</option>
                            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['c']->value['cor_id'];?>
" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['cr']->value)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['c']->value['cor_id']){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['c']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['c']->value['cor_nome'];?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="container-fluid" >
                            <div class="row-fluid">
                             <div class="span3 well">
                            <label>Qtd. Boi</label>                            
                                <input class="int input-small" type="text" name="qtdBoi" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdBoi']->value)===null||$tmp==='' ? "0" : $tmp);?>
"  />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Vaca</label>
                                <input class="int input-small" type="text" name="qtdVaca" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdVaca']->value)===null||$tmp==='' ? "0" : $tmp);?>
" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Novilha</label>
                                <input class="int input-small" type="text" name="qtdNov" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdNov']->value)===null||$tmp==='' ? "0" : $tmp);?>
" />
                                </div>
                                <div class="span3 well">
                            <label class="">Qtd. Touro</label>
                                <input class="int input-small" type="text" name="qtdTouro" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['qtdTouro']->value)===null||$tmp==='' ? "0" : $tmp);?>
" />
                                </div>
                            </div>
                        </div>
               <div class="control-group">
                   <input type="submit" class="btn" name="acao" value="<?php echo $_smarty_tpl->tpl_vars['op']->value;?>
" />
                   <input type="button" class="btn" name="acao" value="Visualizar" onclick="window.open('view_preEscala.php?data='+document.getElementById('data').value, 'Print', 'channelmode=yes')" />
                   <input type="hidden" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? '' : $tmp);?>
" name="id" />
               </div>
            </fieldset>
        </form>
    </div>
 <div>
     <table border="0" class="table table-hover well">
       <thead>
         <tr>
            <th>Pecuarista</th>
            <th>Corretor</th>
            <th>Qtd. Boi</th>
            <th>Qtd. Vaca</th>
            <th>Qtd. Nov</th>
            <th>Qtd. Touro</th>
            <th>#</th>
         </tr>
        </thead>
                           <tbody>
                               <?php  $_smarty_tpl->tpl_vars['pe'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pe']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pe']->key => $_smarty_tpl->tpl_vars['pe']->value){
$_smarty_tpl->tpl_vars['pe']->_loop = true;
?>
                               <tr>
                                   <td><?php echo $_smarty_tpl->tpl_vars['pe']->value['pecuarista'];?>
</td>
                                   <td><?php echo $_smarty_tpl->tpl_vars['pe']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['pe']->value['cor_nome'];?>
</td>
                                   <td><?php echo $_smarty_tpl->tpl_vars['pe']->value['qtdBoi'];?>
</td>
                                   <td><?php echo $_smarty_tpl->tpl_vars['pe']->value['qtdVaca'];?>
</td>
                                   <td><?php echo $_smarty_tpl->tpl_vars['pe']->value['qtdNov'];?>
</td>
                                   <td><?php echo $_smarty_tpl->tpl_vars['pe']->value['qtdTouro'];?>
</td>
                                   <td>
                                       <?php if ($_smarty_tpl->tpl_vars['pe']->value['situacao']=="e"){?>
                                           <i class="icon-lock" title="Para desbloquear é preciso excluir da escala de abate!"></i>
                                       <?php }else{ ?>
                                            <a href="?editar=<?php echo $_smarty_tpl->tpl_vars['pe']->value['id'];?>
&data=<?php echo $_GET['data'];?>
" class="icon-pencil" title="Editar!"></a>
                                            <a href="?del=<?php echo $_smarty_tpl->tpl_vars['pe']->value['id'];?>
&data=<?php echo $_GET['data'];?>
" class="icon-remove" title="Remover da pré-escala!"></a>
                                            <a href="?conf=<?php echo $_smarty_tpl->tpl_vars['pe']->value['id'];?>
&data=<?php echo $_GET['data'];?>
" class="icon-ok" title="Confirmar na escala!"></a>
                                       <?php }?>
                                   </td>
                               </tr>
                               <?php } ?>
                           </tbody>
    </table>
</div>
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("../../view/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>