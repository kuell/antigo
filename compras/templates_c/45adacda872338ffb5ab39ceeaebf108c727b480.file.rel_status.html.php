<?php /* Smarty version Smarty-3.1.12, created on 2015-06-05 12:25:03
         compiled from "view/rel_status.html" */ ?>
<?php /*%%SmartyHeaderCode:14670756525478981c719211-38067823%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45adacda872338ffb5ab39ceeaebf108c727b480' => 
    array (
      0 => 'view/rel_status.html',
      1 => 1428603532,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14670756525478981c719211-38067823',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5478981c9d72f1_84090175',
  'variables' => 
  array (
    'setor' => 0,
    'row' => 0,
    'produtos' => 0,
    'prd' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5478981c9d72f1_84090175')) {function content_5478981c9d72f1_84090175($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/sig/includes/smarty/libs/plugins/modifier.date_format.php';
?>
<?php echo $_smarty_tpl->getSubTemplate ('topo.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
    function abre(){
        
        setor = document.getElementById('setor').value
        datai = document.getElementById('datai').value
        dataf = document.getElementById('dataf').value
        produto = document.getElementById('produto').value
        
        window.open("view_ProdutoPedido.php?setor="+setor+"&status="+form1.status.value+"&datai="+datai+"&dataf="+dataf+"&prod="+produto, "Print", "channelmode=yes");
    }
</script>
</head>

<body>
    <div class="acao_pagina">Relatorio por Produtos</div>
    <br />
    <form id="form1" name="form1" method="get" action="">
        <table width="auto" border="0" align="center" class="KT_tngtable">
            <tr>
                <th scope="row">Periodo:</th>
                <td>
                    <input type="text" class="data" name="datai" id="datai" value="<?php echo (smarty_modifier_date_format(time(),"01/%m/%Y"));?>
" />
                    a
                    <input type="text" name="dataf" class="data" id="dataf" value="<?php echo smarty_modifier_date_format(time(),"%d/%m/%Y");?>
" />
                </td>
            </tr>
            <tr>
                <th scope="row">Setor:</th>
                <td>
                    <select name="setor" id="setor">
                        <option value="">Selecione ...</option>
                        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['setor']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id_setor'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['setor'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="42" scope="row">Produto: </th>
                <td width="176">
                    <select name="produto" id="produto">
                        <option value="">TODOS ...</option>
                        <?php  $_smarty_tpl->tpl_vars['prd'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['prd']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['produtos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['prd']->key => $_smarty_tpl->tpl_vars['prd']->value){
$_smarty_tpl->tpl_vars['prd']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['prd']->value['PRO_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['prd']->value['PRO_DESCRICAO'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
             <tr>
                <th width="42" scope="row">Status: </th>
                <td width="176">
                    <select name="status" id="status">
                        <option value="">TODOS ...</option>
                            <option value="REQUISITADO">REQUISITADO</option>
                            <option value="COMPRADO">COMPRADO</option>
                            <option value="RECEBIDO">RECEBIDO</option>
                            
                    </select>
                </td>
            </tr>
            <tr>
                <th colspan="2" scope="row">
                    <input type="button" name="button" id="button" value="Gerar" onclick="abre()" />
                </th>
            </tr>
        </table>
    </form>
</body>
</html><?php }} ?>