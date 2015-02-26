<?php /* Smarty version Smarty-3.1.12, created on 2013-09-19 10:17:43
         compiled from "view\rel_frequencia.html" */ ?>
<?php /*%%SmartyHeaderCode:10671512cfdffdf6446-66331263%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2ceefb271a6a23185dc8a880df00e93d2560eee' => 
    array (
      0 => 'view\\rel_frequencia.html',
      1 => 1379596658,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10671512cfdffdf6446-66331263',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_512cfe00038d88_85432516',
  'variables' => 
  array (
    'setor' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512cfe00038d88_85432516')) {function content_512cfe00038d88_85432516($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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