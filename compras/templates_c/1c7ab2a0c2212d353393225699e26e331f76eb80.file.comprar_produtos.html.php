<?php /* Smarty version Smarty-3.1.12, created on 2013-02-28 13:26:54
         compiled from "view\comprar_produtos.html" */ ?>
<?php /*%%SmartyHeaderCode:3308512ba620c976e1-56484604%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c7ab2a0c2212d353393225699e26e331f76eb80' => 
    array (
      0 => 'view\\comprar_produtos.html',
      1 => 1362072408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3308512ba620c976e1-56484604',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_512ba620d036a8_87529780',
  'variables' => 
  array (
    'produtos' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512ba620d036a8_87529780')) {function content_512ba620d036a8_87529780($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
    function acao(ped,prod,desc,faz){
        if(confirm("::: "+faz+" ::: \n Produto: "+prod+" - "+desc+"\n Pedido: "+ped)){
            location = "?comprarProduto&"+faz+"&idPedido="+ped+"&idProduto="+prod
        }
        return false;
    }
</script>
</head>
<body>
    <div class="acao_pagina">Compra por Produtos</div>
    <form action="" id="form1" method="POST" name="form1">
        <table align="center" class="KT_tngtable">
            <tr>
                <th scope="row">Pedido: </th>
                <td>
                    <input type="text" name="pedido" id="pedido" class="int" value="<?php echo (($tmp = @$_POST['pedido'])===null||$tmp==='' ? '' : $tmp);?>
" />
                </td>
            </tr>
            <tr>
                <th scope="row">Ordem Interna: </th>
                <td>
                    <input type="text" name="osi" id="osi" class="int" value="<?php echo (($tmp = @$_POST['osi'])===null||$tmp==='' ? '' : $tmp);?>
" />
                </td>
            </tr>
            <tr>
                <th scope="row">Produto: </th>
                <td>
                    <input type="text" size="40" name="prod" id="prod" value="<?php echo (($tmp = @$_POST['prod'])===null||$tmp==='' ? '' : $tmp);?>
" />
                </td>
            </tr>
            <tr>
                <th colspan="2" scope="row">
                    <input type="hidden" name="template" value="<?php echo basename($_smarty_tpl->source->filepath);?>
" />
                    <input name="acao" type="submit" id="acao" value="Buscar" />
                </th>
            </tr>
        </table>
    </form>
    <table align="center" class="KT_tngtable">
        <tr>
            <th>Pedido</th>
            <th>Produto</th>
            <th>Qtd. Pedido</th>
            <th>Qtd. Estoque</th>
            <th>Sub-Total</th>
            <th>Ordem Interna</th>
            <th>Prioridade</th>
            <th colspan="3">Comprar</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['produtos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
        <tr <?php if ($_smarty_tpl->tpl_vars['row']->value['prioridade']==" ALTA"){?>class="prio_auta"<?php }?>>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['prodId'];?>
 - <?php echo $_smarty_tpl->tpl_vars['row']->value['produto'];?>
</td>
            <td><?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['row']->value['qtd']);?>
</td>
            <td><?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['row']->value['qtdEstoque']);?>
</td>
            <td><?php echo sprintf('%.2f',($_smarty_tpl->tpl_vars['row']->value['qtdEstoque']+$_smarty_tpl->tpl_vars['row']->value['qtd']));?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['osi'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['row']->value['prioridade'];?>
</td>
            <td>
                <a href="?incluir&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
" rel="superbox[iframe][800x500]">
                    <img src="../img/manutencao.gif" alt="" width="16" height="16" border="0" title="Editar produto nos Pedidos" />
                </a>
            </td>
            <td>
                <a href="#" onclick="acao('<?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['prodId'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['produto'];?>
','Comprar')">
                    <img src="../img/comprar.png" alt="" width="16" height="16" border="0" title="Comprar produto?" />
                </a>
            </td>
            <td>
                <a href="PedidoCompra.php?visualizar&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['pcId'];?>
" rel="superbox[iframe][730x500]">
                    <img src="../img/print.png" width="16" height="16" border="0" title="Visualizar Pedido" /> 
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php }} ?>