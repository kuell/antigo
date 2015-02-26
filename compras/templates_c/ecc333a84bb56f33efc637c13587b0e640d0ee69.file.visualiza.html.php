<?php /* Smarty version Smarty-3.1.12, created on 2014-02-06 08:56:34
         compiled from "view\visualiza.html" */ ?>
<?php /*%%SmartyHeaderCode:20305127745c4e54c2-33743610%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecc333a84bb56f33efc637c13587b0e640d0ee69' => 
    array (
      0 => 'view\\visualiza.html',
      1 => 1391690816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20305127745c4e54c2-33743610',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5127745c5532a7_25031855',
  'variables' => 
  array (
    'id' => 0,
    'solicitante' => 0,
    'data' => 0,
    'setor' => 0,
    'osi' => 0,
    'obs' => 0,
    'produtos' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5127745c5532a7_25031855')) {function content_5127745c5532a7_25031855($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include 'C:\\wamp\\www\\includes\\smarty\\libs\\plugins\\function.cycle.php';
?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
$(function(){
		   $("#print button").click(function(){
			$(this).css("display","none")
			window.print() });
		   });
</script>
</head>

<body class="prev">        
        <table width="95%" class="KT_tngtable">
            <tr>
                <td style="text-align: center" colspan="8">
                    <img align="left" src="../logo/Logo.JPG" width="150" height="75" />
                    <p><h1>Frizelo Frigorificos Ltda</h1></p>
                    <h2>Pedido de Compra No. <?php echo $_smarty_tpl->tpl_vars['id']->value;?>
</h2>
                </td>
            </tr>
            <tr>
                <th colspan="2">Solicitante:</th>
                <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['solicitante']->value;?>
</td>
                <th colspan="2">Data:</th>
                <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['data']->value;?>
</td>
            </tr>
            <tr>
                <th colspan="2">Setor:</th>
                <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['setor']->value;?>
</td>
                <th colspan="2">No. da Ordem Interna:</th>
                <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['osi']->value;?>
</td>
            </tr>
            <tr>
                <th colspan="2">Observa&ccedil;&atilde;o:</th>
                <td colspan="6"><?php echo $_smarty_tpl->tpl_vars['obs']->value;?>
</td>
            </tr>
            <tr>
                <th>Cod.</th>
                <th colspan="2">Descri&ccedil;&atilde;o</th>
                <th>Qtd. Pedido</th>
                <th>Qtd.<br />Estoque</th>   
                <th>Sub-Total</th>
                <th>U.M.</th>                                              
                <th>Status </th>
            <tr>
                <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['produtos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
            <tr style="background: <?php echo smarty_function_cycle(array('values'=>'#EEE,#FFF'),$_smarty_tpl);?>
">
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['prodId'];?>
</td>
                <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['row']->value['produto'];?>
</td>
                <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['row']->value['qtd']);?>
</td>
                <td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['row']->value['qtdEstoque']);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['qtd']+sprintf("%2.2f",$_smarty_tpl->tpl_vars['row']->value['qtdEstoque']);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['unidade'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['status'];?>
</td>
            </tr>
            <?php } ?>
        </table>
        <div align="center" id="print"><button>Print</button></div>
    </body>
</html>
<?php }} ?>