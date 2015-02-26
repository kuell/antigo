<?php require_once('../../Connections/conn.php'); ?>
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

$id_produto = $_GET['PRO_ID'];

mysql_select_db($database_conn, $conn);
$query_unidade = "SELECT * FROM unidade_medida";
$unidade = mysql_query($query_unidade, $conn) or die(mysql_error());
$row_unidade = mysql_fetch_assoc($unidade);
$totalRows_unidade = mysql_num_rows($unidade);

mysql_select_db($database_conn, $conn);
$query_Produto = "Select * from produto where PRO_ID ='$id_produto'";
$Produto = mysql_query($query_Produto, $conn) or die(mysql_error());
$row_Produto = mysql_fetch_assoc($Produto);
$totalRows_Produto = mysql_num_rows($Produto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Controle de Produtos</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/muda.js" type="text/javascript"></script>
<script src="funcao.js" type="text/javascript"></script>
</head>
<body>
<div class="acao_pagina">Controle de Produtos</div>
<form id="form1" name="form1" method="POST" action="funcao.php">
  <input name="id_produto" type="hidden" id="id_produto" value="<?php echo $row_Produto['PRO_ID']; ?>" />
  <input type="hidden" name="action" id="action" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Descri&ccedil;&atilde;o do Produto:</th>
      <td><input name="descricao" type="text" id="descricao" onkeyup="maiusculo(this)" value="<?php echo $row_Produto['PRO_DESCRICAO']; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <th>Unidade de Medida:</th>
      <td><label>
        <select name="unidade" id="unidade">
          <option value="" <?php if (!(strcmp("", $row_Produto['PRO_UNIDADE']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_unidade['UM_ID']?>"<?php if (!(strcmp($row_unidade['UM_ID'], $row_Produto['PRO_UNIDADE']))) {echo "selected=\"selected\"";} ?>><?php echo $row_unidade['UM_DESCRICAO']?></option>
          <?php
} while ($row_unidade = mysql_fetch_assoc($unidade));
  $rows = mysql_num_rows($unidade);
  if($rows > 0) {
      mysql_data_seek($unidade, 0);
	  $row_unidade = mysql_fetch_assoc($unidade);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
      <?php if($id_produto == ""){?>
      <input type="button" name="incluir" id="incluir" value="Incluir" onclick="doPost('form1', 'incluir')" />
      <?php }else{ ?>
        <input type="button" name="atualizar" id="atualizar" value="Atualizar" onclick="doPost('form1', 'atualizar')"/>
        <?php }?>
        <input type="button" name="Voltar" id="Voltar" value="Voltar" onclick="doPost('form1', 'voltar')" />
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($unidade);

mysql_free_result($Produto);
?>
