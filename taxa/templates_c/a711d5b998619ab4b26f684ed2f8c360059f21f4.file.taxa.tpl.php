<?php /* Smarty version Smarty-3.1.12, created on 2015-01-30 12:59:43
         compiled from "view/taxa.tpl" */ ?>
<?php /*%%SmartyHeaderCode:193233494754cbb87f685b69-89964008%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a711d5b998619ab4b26f684ed2f8c360059f21f4' => 
    array (
      0 => 'view/taxa.tpl',
      1 => 1422637099,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193233494754cbb87f685b69-89964008',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'op' => 0,
    'cor' => 0,
    'c' => 0,
    'data' => 0,
    'taxa' => 0,
    'row' => 0,
    't' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54cbb87f78c2f4_49012905',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54cbb87f78c2f4_49012905')) {function content_54cbb87f78c2f4_49012905($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sigAntigo/sig2/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("../../view/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if ((($tmp = @$_smarty_tpl->tpl_vars['op']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
    
    <script>
    function excluir(idTaxa){
            if(confirm("Deseja realmente excluir este registro!!!")){
                $.post("taxa.php", {id: idTaxa, 
                                    acao: "delete"}, function(val){
                    alert(val)
                  //  location = "taxa.php";
                    })
            }
            return false;
        }    
    </script>
    
<div class="well form-search">
<form class="form-search" method="GET">
    <fieldset>
        <legend>Controle de taxas</legend>
            <label>Data:</label>
                <input type="text" name="datai" value="<?php echo (($tmp = @$_GET['datai'])===null||$tmp==='' ? (smarty_modifier_date_format(time(),"%d/%m/%Y")) : $tmp);?>
" class="data">
                <input type="text" name="dataf" value="<?php echo (($tmp = @$_GET['dataf'])===null||$tmp==='' ? (smarty_modifier_date_format(time(),"%d/%m/%Y")) : $tmp);?>
" class="data">
            <label>Corretor: </label>
            <select name="cor">
                <option value="">Todos</option>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['c']->value['cor_id'];?>
" <?php if ((($tmp = @$_GET['cor'])===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['c']->value['cor_id']){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['c']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['c']->value['cor_nome'];?>
</option>
            <?php } ?>
            </select>
            
            <input name="acao" value="Buscar" type="submit" class="btn" />            
    </fieldset>
</form>
</div>
<div class="span12 offset1">
<table class="table table-striped" align="center">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Data</th>
            <th>Corretor</th>
            <th colspan="2">
                <a href="?add&data=<?php echo smarty_modifier_date_format(((($tmp = @$_smarty_tpl->tpl_vars['data']->value)===null||$tmp==='' ? time() : $tmp)),"%d/%m/%Y");?>
" class="btn btn-primary">Adicionar</a> 
            </th>
        </tr>
        </thead>
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['taxa']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
    <tbody>
        
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['row']->value['cor_nome'];?>
</td>
            <td>
                <div class="input-append">
                    <a data-toggle="tooltip" href="?grupo=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" rel="superbox[iframe][1000x500]" class="btn">Itens</a>
                    <a href="?edit=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="btn">editar</a>
                    <a href="#" class="btn disabled">excluir</a>
            </div></td>
        </tr>
    </tbody>
    <?php } ?>
</table>
 </div>
<?php }else{ ?>

    <script>
        $(function(){
            $("select[name=corretor]").blur(function(){
                if($(this).val() == ""){
                    alert("Este campo deve ser preenchido!")
                    $(this).focus();
                }
                else{
                $.post("taxa.php", {cor:$(this).val(),
                                    acao:"buscar",
                                    data: $("input[name=data]").val()
                                    }, function(val){
                                        if(val !=0){
                                            alert("\t Antenção!!! \n Já existe um lançamento para este corretor neste dia!");
                                            location = "taxa.php";
                                        }
                                    })
                }
            });
        })
            
    </script>

<div class="">
<form method="POST" class="form-inline">
    <fieldset>
        <legend>Controle de Taxas</legend>
        <div class="span7 offset5">
    <div class="control-group">
        <label class="control-label">Usuario: </label>
        <div class="controls">
            <input type="text" class="disabled" name="id" value="<?php echo $_SESSION['kt_login_user'];?>
" /> 
        </div>     
    </div>
    <div class="control-group">
        <label class="control-label">Data:</label>
        <div class="controls">
            <input type="text" name="data" class="validate[required] data" value="<?php echo smarty_modifier_date_format(((($tmp = @$_smarty_tpl->tpl_vars['t']->value['data'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value : $tmp)),"%d/%m/%Y");?>
" /> 
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Corretor</label>
        <div class="controls">    
            <select name="corretor" class="validate[required]">
                     <option value="">Selecione ...</option>
                    <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['c']->value['cor_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['c']->value['cor_id']==(($tmp = @$_smarty_tpl->tpl_vars['t']->value['corretor'])===null||$tmp==='' ? '' : $tmp)){?>selected=<?php }?> ><?php echo $_smarty_tpl->tpl_vars['c']->value['cor_cod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['c']->value['cor_nome'];?>
</option>
                    <?php } ?>
            </select>
        </div>
    </div>
   <div class="control-group" >
       <label class="control-label">Observação: </label>
       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['obs'])===null||$tmp==='' ? '' : $tmp);?>

       <div class="controls">
           <textarea cols="50" rows="5" name="obs"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['obs'])===null||$tmp==='' ? '' : $tmp);?>
</textarea> 
       </div>
   </div>
   <div class="control-group">
       <input class="btn" type="submit" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['op']->value)===null||$tmp==='' ? '' : $tmp);?>
" name="acao" />  
       
        <?php if ((($tmp = @$_GET['edit'])===null||$tmp==='' ? '' : $tmp)!=''){?>
            <a href="?grupo=<?php echo $_GET['edit'];?>
" rel="superbox[iframe][900x500]" class="btn btn-primary">Itens</a>  
        <?php }?>
       <input class="btn" type="button" value="Visualizar" name="acao" />  
       <input class="btn" type="button" value="Voltar" name="acao" onclick="location = '?data=<?php echo smarty_modifier_date_format(((($tmp = @$_smarty_tpl->tpl_vars['t']->value['data'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value : $tmp)),"%d/%m/%Y");?>
'" />
       <input type="hidden" name="id" value="<?php echo (($tmp = @$_GET['edit'])===null||$tmp==='' ? '' : $tmp);?>
">
    </div>
       </div>
       </fieldset>
</form>
        </div>
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("../../view/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>