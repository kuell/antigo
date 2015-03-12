<?php /* Smarty version Smarty-3.1.12, created on 2015-03-12 15:29:34
         compiled from "view/produto_pedido.html" */ ?>
<?php /*%%SmartyHeaderCode:199351215454804cadb9c485-84249080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d60b9460f8c12aa44bf7ffbd1558dc36d4cb99e' => 
    array (
      0 => 'view/produto_pedido.html',
      1 => 1426188563,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '199351215454804cadb9c485-84249080',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54804cadd4a1a3_68428987',
  'variables' => 
  array (
    'idProduto' => 0,
    'idPedido' => 0,
    'produtos' => 0,
    'row' => 0,
    'prodPed' => 0,
    'prd' => 0,
    'produto' => 0,
    'qtdEstoque' => 0,
    'qtd' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54804cadd4a1a3_68428987')) {function content_54804cadd4a1a3_68428987($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("topo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


  
  <link rel="stylesheet" type="text/css" href="../js/chosen_v1.4.1/docsupport/style.css">
  <link rel="stylesheet" type="text/css" href="../js/chosen_v1.4.1/docsupport/prism.css">
  <link rel="stylesheet" type="text/css" href="../js/chosen_v1.4.1/chosen.css">

  <script src="../js/chosen_v1.4.1/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="../js/chosen_v1.4.1/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript">
    
    $(function(){
      $('#produto').chosen(
            {
              allow_single_deselect:true,
              no_results_text: "Nenhum valor encontrado para o nome: ",
              allow_single_deselect: true
            }
          );

    	$("#produto").blur(function(){
                var produto = $("#produto").val();
                
    	$.post("?acao=verifica_produto",  {prodId: produto, acao: 'verifica'}, function(valor){
    				verifica(valor);		
    	
    		   }); 
            });
      });  
      function verifica(val){
        if(val != 0){
            if(confirm("Atenção!!!\n Este produto ja esta pedido ou ja foi comprado \n Deseja realizar o pedido novamente?")){
                
            }
            else{
                document.getElementById("produto").value = ""
                return false;
            }
                                    
        }
      }
    
    
function excluir(ped,prod,desc){
    if(confirm("::: Deseja realmente excluir este registro? ::: \n"
                                                +"Pedido: "+ped
                                                +"\n Produto: "+prod+" - "+desc)){
       location = "?excluirProduto&idPedido="+ped+"&idProduto="+prod
    }
    return false
}
function validar(form){
    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['idProduto']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
        if(form.produto.value == ""){
            alert("Campo Produto!!! \n Campo Obrigatorio!")
            form.produto.focus();
            return false
        }
        if(form.qtd.value == "" || form.qtd.value == "0,00"){
            alert("Campo Quantidade!!! \n Campo Obrigatorio!")
            form.qtd.focus();
            return false
        }
        if(form.estoque.value == ""){
            alert("Campo estoque!!! \n Campo Obrigatorio!")
            form.estoque.focus();
            return false
        }
    
  <?php }else{ ?>
  if(form.qtd.value == ""){
            alert("Campo Quantidade!!! \n Campo Obrigatorio!")
            form.qtd.focus();
            return false
        }
  <?php }?>
    }
</script>

</head>

<body>
<div class="acao_pagina" >Produtos do Pedido <?php echo $_smarty_tpl->tpl_vars['idPedido']->value;?>
</div>

    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['idProduto']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
  <div class="form_incluir" style="margin:0 0; padding:0 0; width = 900px; ">
    <form action="" method="POST" name="form1" onsubmit="return validar(this)">
    <input name="idPedido" type="hidden" id="idPedido" value="<?php echo $_smarty_tpl->tpl_vars['idPedido']->value;?>
" />
    <table border="0" align="center" class="KT_tngtable" bgcolor="#FFFFFF" style="margin:0 0; padding:0 0;">
      <tr>
        <th scope="col">Produto</th>
        <th scope="col">Quantidade</th>
        <th colspan="4" scope="col">Qtd. Estoque</th>
      </tr>
      <tr>
          <td scope="col">
          <select size="10" name="produto" id="produto" class="chosen-select">
             <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['produtos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['PRO_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['PRO_DESCRICAO'];?>
 - <?php echo sprintf('%05d',$_smarty_tpl->tpl_vars['row']->value['PRO_ID']);?>
</option>
            <?php } ?>
          </select>
      </td>
      <td scope="col">
          <input name="qtd" type="text" class="valor" id="qtd" />
      </td>
      <td scope="col" colspan="2">
          <input name="estoque" type="text" class="valor" id="estoque" />
      </td>
      <td scope="col" colspan="2">
          <input  type="submit" name="acao" id="acao" value="Incluir" />
      </td>
      </tr>
      <tr>
        <th>Cod. / Descri&ccedil;&atilde;o</th>
        <th>Qtd. Pedido</th>
        <th>Qtd. Estoque</th>
        <th>Sub-Total</th>
        <th colspan="3">&nbsp;</th>
      </tr>
          <?php  $_smarty_tpl->tpl_vars['prd'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['prd']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['prodPed']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['prd']->key => $_smarty_tpl->tpl_vars['prd']->value){
$_smarty_tpl->tpl_vars['prd']->_loop = true;
?>
        <tr>
          <td><?php echo $_smarty_tpl->tpl_vars['prd']->value['prodId'];?>
 - <?php echo $_smarty_tpl->tpl_vars['prd']->value['produto'];?>
</td>
          <td><?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['prd']->value['qtd']);?>
</td>
          <td><?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['prd']->value['qtdEstoque']);?>
</td>
          <td><?php echo sprintf('%.2f',($_smarty_tpl->tpl_vars['prd']->value['qtd']+$_smarty_tpl->tpl_vars['prd']->value['qtdEstoque']));?>
</td>
          <td><a href="?editar&idPedido=<?php echo $_smarty_tpl->tpl_vars['idPedido']->value;?>
&idProduto=<?php echo $_smarty_tpl->tpl_vars['prd']->value['prodId'];?>
"><img src="../img/edit.png" alt="" width="16" height="16" /></a></td>
          <td><a href="#" onclick="excluir('<?php echo $_smarty_tpl->tpl_vars['prd']->value['pcId'];?>
','<?php echo $_smarty_tpl->tpl_vars['prd']->value['prodId'];?>
','<?php echo $_smarty_tpl->tpl_vars['prd']->value['produto'];?>
')" ><img src="../img/delete.png" width="16" height="16" border="0" /></a></td>
        </tr>
        <?php } ?>
  </table>
  </form>
    </div>
    <?php }else{ ?>
    <form name="form" id="form" method="POST" onsubmit="return validar(this)">
        <table class="KT_tngtable" width="95%">
        <tr>
            <th>Cod. Pedido</th>
            <th>Cod. Produto</th>
            <th>Produto:</th>
            <th>Qtd. Estoque</th>
            <th colspan="2">Qtd.</th>            
        </tr>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['idPedido']->value;?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['idProduto']->value;?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['produto']->value;?>
</td>
            <td><?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['qtdEstoque']->value);?>
</td>
            <td><input type="text" name="qtd" class="valor" id="qtd" value="<?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['qtd']->value);?>
" /></td>
            <td><input type="submit" value="Editar" name="acao" id="acao" /></td>
        </tr>
    </table>
        <div align="center"><input type="button" value="Voltar" /></div>
        <input type="hidden" id="idPedido" name="idPedido" value="<?php echo $_smarty_tpl->tpl_vars['idPedido']->value;?>
" />
        <input type="hidden" id="idProduto" name="idProduto" value="<?php echo $_smarty_tpl->tpl_vars['idProduto']->value;?>
" />
        
    </form>
    <?php }?>
    
</body>
</html><?php }} ?>