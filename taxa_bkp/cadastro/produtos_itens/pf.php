<?php require_once('../../../Connections/conn.php'); ?>
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

mysql_select_db($database_conn, $conn);
$query_prod = "Select * from txproduto where prod_id='".$_REQUEST['prod_id']."'";
$prod = mysql_query($query_prod, $conn) or die(mysql_error());
$row_prod = mysql_fetch_assoc($prod);
$totalRows_prod = mysql_num_rows($prod);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../../js/util.js" type="text/javascript"></script>
<script type="text/javascript">
	function validar(){
			if($(".valida").val() == 0){
				alert("Alguns campos obrigatorios estão nulos");
				$(this).fucus()	
				return false
			}
			
		}
function envia(acao){
		document.getElementById('funcao').value = acao
	document.form1.submit();
	}
</script>
</head>

<body>
<div class="acao_pagina">Controle de Produtos/Itens</div>
<form action="../class.php" method="post" name="form1" id="form1" onsubmit="validar()">
  <table align="center" class="KT_tngtable">
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Descrição:</th>
      <td><input id="valida" class="valida" type="text" name="prod_nome" value="<?php echo utf8_decode($row_prod['prod_desc']); ?>" size="50" /></td>
    </tr>
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Unidade de medida:</th>
      <td><select name="unidade_medida">
      <?php if(!$_REQUEST['prod_id']) { }else{ ?>
      		<option value="<?php echo $row_prod['prod_UnMed']; ?>"><?php echo $row_prod['prod_UnMed']; ?></option>
            <?php } ?>
        <option value="Cx" >Cx</option>
        <option value="Kg" >Kg</option>
        <option value="@" >@</option>
        <option value="Lt" >Lt</option>
        <option value="Un" >Un</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Tipo:</th>
      <td><select name="prod_tipo">
        <?php if(!$_REQUEST['prod_id']){ ?>
        <option value="1" <?php if (!(strcmp(1, $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>>Animal</option>
        <option value="2" <?php if (!(strcmp(2, $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>>Item</option>
		<option value="3" <?php if (!(strcmp(3, $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>>Romaneio de Expedição</option>
        <?php }else { ?>
        <option value="<?php echo $row_prod['prod_tipo']; ?>" <?php if (!(strcmp($row_prod['prod_tipo'], $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_prod['prod_tipo']; ?></option>
        <option value="1" <?php if (!(strcmp(1, $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>>Animal</option>
        <option value="2" <?php if (!(strcmp(2, $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>>Item</option>
		<option value="3" <?php if (!(strcmp(3, $row_prod['prod_tipo']))) {echo "selected=\"selected\"";} ?>>Romaneio de Expedição</option>
        <?php } ?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap">
      <div class="div_botoes">
      	<?php if(!$_REQUEST['prod_id']){ ?>
     	 <input name="incluir" type="button" id="inclui" value="Incluir" onclick="envia('add_prod')" />
         <?php }else{ ?>
         <input name="edita" type="button" id="edita" value="Editar" onclick="envia('edit_prod')" />
         <?php } ?>
         <input name="volta" type="button" id="volta" value="Voltar" onclick="window.location = 'pl.php'" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="prod_id" value="<?php echo $row_prod['prod_id']; ?>" />
  <input name="funcao" type="hidden" id="funcao" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($prod);
?>
