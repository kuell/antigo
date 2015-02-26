<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_itens = "-1";
if (isset($_GET['id'])) {
  $colname_itens = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_itens = sprintf("SELECT * FROM estoque_atual WHERE id = %s", GetSQLValueString($colname_itens, "int"));
$itens = mysql_query($query_itens, $conn) or die(mysql_error());
$row_itens = mysql_fetch_assoc($itens);
$totalRows_itens = mysql_num_rows($itens);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include("../config.php"); ?>
<script type="text/javascript" >
		function acao(action){
			document.getElementById('funcao').value = action
			
			form1.submit()		
			
			}



</script>

</head>

<body>
<div class="acao_pagina">Controle de Grupos</div>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="funcao" id="funcao" />
  <input name="id" type="hidden" id="id" value="<?php echo $row_itens['id']; ?>" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Descricao:</th>
      <td><input name="descricao" type="text" id="descricao" value="<?php echo $row_itens['descricao']; ?>" size="100" /></td>
    </tr>
    <tr>
      <th scope="row">Quantidade:</th>
      <td><label>
        <input name="qtd" type="text" disabled="disabled" class="valor" id="qtd" value="<?php echo number_format($row_itens['estoque_atual'],2,',','.'); ?>" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Valor:</th>
      <td><label>
        <input name="valor" type="text" disabled="disabled" class="valor" id="valor" value="<?php echo number_format($row_itens['valor_atual'],2,',','.'); ?>" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Ativo</th>
      <td><label>
        <select name="ativo" id="ativo" title="<?php echo $row_itens['ativo']; ?>">
          <option value="1" selected="selected">Sim</option>
          <option value="2">Não</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><label>
      <?php if(!$_REQUEST['id']){ ?>
        <input type="button" name="button" id="button" value="Incluir" class="button" onclick="acao('incluir')" />
        <?php }else{ ?>
        <input type="button" name="button2" id="button2" value="Alterar" onclick="acao('alterar')" />
        <?php } ?>
        <input type="button" name="button3" id="button3" value="Voltar" onclick="acao('voltar')" />
      </label></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($itens);
?>
