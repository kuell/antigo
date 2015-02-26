<?php /* Smarty version Smarty-3.1.12, created on 2013-02-22 09:35:24
         compiled from "view\teste.html" */ ?>
<?php /*%%SmartyHeaderCode:13445512772ae74e130-52829243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54ff1d29f236edea31a57083af1255e13288e249' => 
    array (
      0 => 'view\\teste.html',
      1 => 1361540121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13445512772ae74e130-52829243',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_512772ae7a2e95_25853930',
  'variables' => 
  array (
    'id' => 0,
    'solicitante' => 0,
    'data' => 0,
    'setor' => 0,
    'osi' => 0,
    'obs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_512772ae7a2e95_25853930')) {function content_512772ae7a2e95_25853930($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
$(function(){
		   $("#print button").click(function(){
			$(this).css("display","none")
			window.print() });
		   });
</script>
</head>

    <body>
       <table width="645" border="0" align="center" style="border:#000 solid 1px;">
  <tr>
    <th width="150" scope="col" style="border:#000 solid 1px;"><img src="../logo/Logo.JPG" width="150" height="75" /></th>
    <th width="483" colspan="3" scope="col" style="border:#000 solid 1px;">
        Pedido de Compra No. <?php echo $_smarty_tpl->tpl_vars['id']->value;?>
<br />
        Peri Alimentos Ltda</th>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0">
      <tr>
        <td width="24%" class="titulos" scope="col">Solicitante:
        <td width="28%" class="dados" scope="col"><?php echo $_smarty_tpl->tpl_vars['solicitante']->value;?>

        <td width="21%" class="titulos" scope="col">Data:<td width="27%" class="dados" scope="col"><?php echo $_smarty_tpl->tpl_vars['data']->value;?>

      </tr>
      <tr>
        <td class="titulos">Setor:</td>
        <td class="dados"><?php echo $_smarty_tpl->tpl_vars['setor']->value;?>
</td>
        <td class="titulos">No. da Ordem Interna:</td>
        <td class="dados"><?php echo $_smarty_tpl->tpl_vars['osi']->value;?>
</td>
      </tr>
      <tr>
      <td class="titulos">Observa&ccedil;&atilde;o:</td>
      <td colspan="3"><span class="dados"><?php echo $_smarty_tpl->tpl_vars['obs']->value;?>
</td>
      </tr>
      <tr>
        <td colspan="4"><table width="100%" border="0" style="border:solid #000 1px; font:10px 'Arial', Helvetica, sans-serif;">
          <tr>
            <td width="94" class="titulos" id="id">Cod.
          <td id="descricao" width="204" class="titulos" scope="col">Descri&ccedil;&atilde;o
          <td width="122"class="titulos" id="qtd" scope="col">Qtd. Pedido
          <td width="72"class="titulos" id="qtd" scope="col">Qtd.<br />Estoque          
          <td width="56"class="titulos" id="qtd" scope="col">Sub-Total          
          <td width="27"class="titulos" id="qtd" scope="col">Unidadede medida                                                  
          <td width="28"class="titulos" id="qtd" scope="col">Status                    </tr>
          
            <tr>
               <td style="border-bottom:1px #000 solid;" align="center"></td>
               <td style="border-bottom:1px #000 solid;"></td>
               <td align="center" style="border-bottom:1px #000 solid;"></td>
               <td align="center" style="border-bottom:1px #000 solid;"></td>
               <td align="center" style="border-bottom:1px #000 solid;"></td>
               <td align="center" style="border-bottom:1px #000 solid;"></td>
               <td align="center" style="border-bottom:1px #000 solid;"></td>
              </tr>
          
        </table>
            
        </td>
        </tr>
    </table></td>
  </tr>
</table>
        <div align="center" id="print"><button>Print</button></div>
    </body>
</html>
<?php }} ?>