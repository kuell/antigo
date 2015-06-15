<?php /* Smarty version Smarty-3.1.12, created on 2015-06-08 13:48:41
         compiled from "view/receber_list.html" */ ?>
<?php /*%%SmartyHeaderCode:13511476585478896568e684-88439158%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de0b7a252d3458852aacbd12948ea9fc50ed5bee' => 
    array (
      0 => 'view/receber_list.html',
      1 => 1433351864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13511476585478896568e684-88439158',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54788965708358_83282570',
  'variables' => 
  array (
    'produtos' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54788965708358_83282570')) {function content_54788965708358_83282570($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sig/includes/smarty/libs/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
    function acao(faz, prod, ped, desc){
        if(confirm("Deseja "+faz+"?\n Pedido: "+ped+"\n Produto: "+prod+" - "+desc)){
            location = "?"+faz+"&idPedido="+ped+"&idProduto="+prod
                    }
    }
</script>
<script src="funcao.js" type="text/javascript"></script>
</head>
<body>
    <div class="acao_pagina">Recebimento de Produtos</div><div>
        <form id="form1" name="form1" method="post" action="">
            <table border="0" align="center" class="KT_tngtable">
                <tr>
                    <th scope="row">Pedido:</th>
                    <td>
                        <input type="hidden" name="template" value="<?php echo basename($_smarty_tpl->source->filepath);?>
" />
                        <input name="idPedido" type="text" id="idPedido" value="<?php echo (($tmp = @$_POST['idPedido'])===null||$tmp==='' ? '' : $tmp);?>
" />
                    </td>
                </tr>
                 <tr>
                    <th scope="row">Produto: </th>
                    <td>
                        <input name="prod" type="text" id="prod" value="<?php echo (($tmp = @$_POST['produto'])===null||$tmp==='' ? '' : $tmp);?>
" size="40" />
                    </td>
                </tr>
                <tr>
                    <th colspan="2" scope="row">
                        <input type="submit" name="acao" id="busca" value="Buscar" />
                    </th>
                </tr>
            </table>
        </form>

        <table width="auto%" border="0" align="center" class="KT_tngtable">
            <tr>
                <th>Pedido</th>
                <th>Produto</th>
                <th>Data/Pedido</th>
                <th>Comprado</th>
                <th>Status</th>
            </tr>   
            <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['produtos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['prodId'];?>
 - <?php echo $_smarty_tpl->tpl_vars['row']->value['produto'];?>
</td>
                <td><?php echo (smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%d/%m/%Y"));?>
</td>
                <td><?php echo (smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['dataCompra'],"%d/%m/%Y"));?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['status'];?>
</td>
                <td>
                    <a href="#" onclick="acao('Receber','<?php echo $_smarty_tpl->tpl_vars['row']->value['prodId'];?>
', '<?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
', '<?php echo $_smarty_tpl->tpl_vars['row']->value['produto'];?>
')">
                        <img src="../img/receber.gif" width="16" height="16" border="0" />
                    </a>
                </td>
                <td>
                    <a href="PedidoCompra.php?visualizar&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
" rel="superbox[iframe][730x500]" onclick="">
                        <img src="../img/print.png" width="16" height="16" border="0" />
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html><?php }} ?>