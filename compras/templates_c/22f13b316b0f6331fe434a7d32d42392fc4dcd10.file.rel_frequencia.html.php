<?php /* Smarty version Smarty-3.1.12, created on 2015-01-12 13:13:23
         compiled from "view/rel_frequencia.html" */ ?>
<?php /*%%SmartyHeaderCode:124063234954b400b359c8c2-43546225%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22f13b316b0f6331fe434a7d32d42392fc4dcd10' => 
    array (
      0 => 'view/rel_frequencia.html',
      1 => 1417177385,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '124063234954b400b359c8c2-43546225',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'setor' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54b400b3820635_88468768',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b400b3820635_88468768')) {function content_54b400b3820635_88468768($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<script type="text/javascript">
    function abre(){
        setor = document.getElementById('setor').value;
        freq = document.getElementById('freq').value;
        window.open("frequencia.php?setor="+setor+"&freq="+freq, "Print", "channelmode=yes");  
    }
</script>
<body>
<div class="acao_pagina">Lista de frequencia de compras</div>
<br />
<form id="form1" name="form1" method="get" action="">
    <table width="auto" border="0" align="center" class="KT_tngtable">
        <tr>
            <th>Setor: </th>
            <td>
                <select id="setor" name="setor">
                    <option value="">Todos ...</option>
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
            <th width="108" scope="row">Frequencia Maior:</th>
            <td width="108" scope="row"><label>
                    <input type="text" name="freq" id="freq" value="5" />
                </label></td>
        </tr>
        <tr>
            <th colspan="2" scope="row">
                <input type="button" name="Button" id="button" value="Gerar"  onclick="abre()" />
            </th>
        </tr>
    </table>
</form>
</body>
</html><?php }} ?>