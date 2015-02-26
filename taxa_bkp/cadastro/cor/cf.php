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
$query_cor = "Select * from corretor where cor_id='".$_REQUEST['cor_id']."'";
$cor = mysql_query($query_cor, $conn) or die(mysql_error());
$row_cor = mysql_fetch_assoc($cor);
$totalRows_cor = mysql_num_rows($cor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../../../js/util.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
			$("#inclui").click(function(){
										$("#funcao").val("add_cor")
										$("form").submit()
										})
			$("#edita").click(function(){
										$("#funcao").val("edit_cor")
										$("form").submit()
										})
			})

</script>
</head>

<body><div class="acao_pagina">Cadastro de Corretores</div>
<form action="../class.php" method="post" name="form1" id="form1">
  <input type="hidden" name="funcao" id="funcao" />
  <input name="cor_id" type="hidden" id="cor_id" value="<?php echo $row_cor['cor_id']; ?>" />
  <table align="center" class="KT_tngtable">
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Codigo interno do Corretor:</th>
      <td><input class="numero" type="text" name="cor_cod" value="<?php echo $row_cor['cor_cod']; ?>" size="32"  /></td>
    </tr>
    <tr valign="baseline">
      <th nowrap="nowrap" align="right">Nome do Corretor:</th>
      <td><input type="text" name="cor_nome" value="<?php echo $row_cor['cor_nome']; ?>" size="70" /></td>
    </tr>
    <tr valign="baseline">
      <th align="right" nowrap="nowrap">Corretor ativo?</th>
      <td align="right" nowrap="nowrap"><label>
       <div align="left"> <select name="cor_ativo" id="select" title="">
       	 <?php if(!$_REQUEST['cor_id']){ ?>
         <option value="1">Sim</option>
         <option value="2" selected="selected">N&atilde;o</option>
         <?php }else{ ?>
         <option  selected="selected" value="<?php echo $row_cor['cor_ativo']; ?>"><?php echo $row_cor['cor_ativo']; ?></option>
         <option value="1">Sim</option>
         <option value="2">N&atilde;o</option>
         <?php } ?>
       </select>
      </label></div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap">
      <div class="div_botoes">
      <?php
      	if(!$_REQUEST['cor_id']){ ?>
      <input name="inclui" type="button" id="inclui" value="Incluir" class="inclui" />
      <?php }else{ ?>
        <label>
          <input name="editar" type="button" id="edita" value="Editar" />
        </label>
        <?php } ?>
        <label>
          <input type="button" name="voltar" id="funcao" value="Voltar" onclick="window.location = 'cl.php'" />
        </label>
      </div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($cor);
?>
