<?php /* Smarty version Smarty-3.1.12, created on 2014-11-28 10:40:35
         compiled from "view/comprar_pedido.html" */ ?>
<?php /*%%SmartyHeaderCode:417163116547889634bfeb1-06686957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '393f8d7706b148e31f1ed28790204572702c8970' => 
    array (
      0 => 'view/comprar_pedido.html',
      1 => 1417177385,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '417163116547889634bfeb1-06686957',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pedidos' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54788963613744_53279094',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54788963613744_53279094')) {function content_54788963613744_53279094($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sig/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ('topo.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
    function acao(faz, id){
        if(confirm("Deseja "+faz+" o pedido: "+id)){
            location = "?"+faz+"&id="+id
        }
    }
</script>

</head>

<body>
    <div class="acao_pagina">Comprar por Pedidos</div>
    <form action="" method="POST" name="form1">
        
        <table border="0" align="center" class="KT_tngtable">
            <tr>
                <th>Pedido:</th>
                <td>
                    <input type="text" name="idPedido" id="idPedido" class="int" value="<?php echo (($tmp = @$_POST['idPedido'])===null||$tmp==='' ? '' : $tmp);?>
" />
                </td>
            </tr>
            <tr>
                <th>Cod. Osi:</th>
                <td>
                    <input type="text" name="osi" id="osi" class="int" value="<?php echo (($tmp = @$_POST['osi'])===null||$tmp==='' ? '' : $tmp);?>
" />
                    <input type="hidden" name="template" value="<?php echo basename($_smarty_tpl->source->filepath);?>
" />
                </td>
            </tr>
            
            <tr>
                <th colspan="2"><input type="submit" value="Buscar" name="acao" id="buscar" /> </th>  
            </tr>
        </table>
    </form>
<br /><table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
        <th scope="col">Cod</th>
        <th scope="col">Data/Pedido</th>
        <th scope="col">No. Req.</th>
        <th scope="col">Setor</th>
        <th scope="col">Nome</th>
        <th scope="col">Prioridade</th>
        <th scope="col">Status</th>
        <th colspan="4" scope="col">&nbsp;</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pedidos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
        <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y");?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['osi'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['setor'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['solicitante'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['prioridade'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['status'];?>
</td>
        <td>
            <a href="ProdutoPedido.php?incluir&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" rel="superbox[iframe][800x500]">
                <img src="../img/manutencao.gif" width="16" height="16" border="0" title="Manuten&ccedil;&atilde;o no Pedido!" />
            </a>
        </td>
        
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['status']=='RECEBIDO'){?>
            <img src="../img/bloqueado.gif" />
            <?php }else{ ?>
            <a href="#" onclick="acao('Comprar','<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">
                <img src="../img/comprar.png" width="16" height="16" border="0" title="Comprar pedido" onclick="baixar(<<?php ?>?php echo $row_pedido['pc_id']; ?<?php ?>>)" />
            </a>
            <?php }?>
        </td>
        
        <td>
            <a href="?visualizar&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" rel="superbox[iframe][700x500]">
                <img src="../img/print.png" width="16" height="16" border="0" title="Visualizar Pedido." />
            </a>
        </td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['status']=='RECEBIDO'){?>
            <img src="../img/bloqueado.gif" />
            <?php }else{ ?>
            <a href="#" onclick="acao('Reprovar','<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">
                <img src="../img/reprova.png" alt="" width="16" height="16" border="0" title="Reprovar Pedido?" />
            </a>
            <?php }?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <th colspan="11"></th>
    </tr>
</table>
</body>
</html>
<?php }} ?>