<?php /* Smarty version Smarty-3.1.12, created on 2013-07-15 18:24:39
         compiled from "view\pedido_list.html" */ ?>
<?php /*%%SmartyHeaderCode:32544512763d13938a9-84649922%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ebae5e045a1100ffa19e53abdde5e4998228a06' => 
    array (
      0 => 'view\\pedido_list.html',
      1 => 1373923475,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32544512763d13938a9-84649922',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_512763d147cad4_72301187',
  'variables' => 
  array (
    'pedidos' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512763d147cad4_72301187')) {function content_512763d147cad4_72301187($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\wamp\\www\\includes\\smarty\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
	function excluir_pedido(id){
		if(confirm("Deseja realmente excluir este pedido? \n Ao excluir este pedido, todos os produtos contidos nele também serão excluidos! \n\n\
                            Deseja realmente fazer isso?")){
			location.href = '?excluir&id='+id
			}
			return false
		}
</script>
</head>
<body>
<div class="acao_pagina">Requisição de Pedidos de Compra</div>
<form id="form1" name="form1" method="POST" action="">
    <table border="0" align="center" class="KT_tngtable" >
        <tr>
            <th>Cod. do Pedido :</th>
            <td>
                <input name="idPedido" type="text" id="idPedido" value="<?php echo (($tmp = @$_POST['idPedido'])===null||$tmp==='' ? '' : $tmp);?>
" />
                <input name="template" type="hidden" id="template" value="<?php echo basename($_smarty_tpl->source->filepath);?>
" />
            </td>
            
        </tr>
        <tr>
            <th>No. Ordem Interna :</th>
            <td><input name="osi" type="text" id="osi" value="<?php echo (($tmp = @$_POST['osi'])===null||$tmp==='' ? '' : $tmp);?>
" /></td>
        </tr>
        <tr>
            <th colspan="2">
                <input type="submit" name="acao" id="acao" value="Buscar" />
            </th>
        </tr>
    </table>
</form>
<br /><form action="funcao.php" method="post" id="form_list">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Pedido</th>
      <th>Data/Hora</th>
      <th>No. Ordem interna</th>
      <th>Solicitante</th>
      <th>Setor</th>
      <th>Status</th>
      <th>Prioridade</th>
      <th colspan="3"><a href="?Incluir">
        Adicionar
      </a></th>
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
 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['data'],"%H:%M:%S");?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['row']->value['osi'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['row']->value['solicitante'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['row']->value['setor'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['row']->value['status'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['row']->value['prioridade'];?>
</td>
        
        <?php if ($_SESSION['kt_login_level']!=1||$_smarty_tpl->tpl_vars['row']->value['status']=='RECEBIDO'){?>
      <td><img src="../img/bloqueado.gif" width="16" height="16" title="Bloqueado"/></td>
      <td><img src="../img/bloqueado.gif" width="16" height="16" title="Bloqueado" /></td>
        <?php }else{ ?>
      <td><a href="?editar&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"> <img src="../img/edit.gif" width="16" height="16" border="0" /></a></td>
      <td><a href="#" onclick="excluir_pedido('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')"><img title="Excluir" src="../includes/qub/images/delete.gif" width="16" height="16" border="0" /></a></td>
        <?php }?>
      <td><a href="?visualizar&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" rel="superbox[iframe][700x500]"><img src="../img/print.png" alt="" width="16" height="16" border="0" /></a></td>
    </tr>
   <?php } ?>
    <tr>
      <th colspan="14"></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php }} ?>