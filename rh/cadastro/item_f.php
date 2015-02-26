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

mysql_select_db($database_conn, $conn);
$query_item = "SELECT * FROM rh_item where id = '".$_REQUEST['id']."'";
$item = mysql_query($query_item, $conn) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);
$totalRows_item = mysql_num_rows($item);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script src="../../bibliotecas/mascara.js" type="text/javascript"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
<script>
	function faz(acao)
	{
		document.getElementById('funcao').value = acao
		form1.submit()		
	}
</script>
</head>

<body>
<div class="acao_pagina">Controle de Itens RH</div>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="funcao" id="funcao" />
  <input name="id" type="hidden" id="id" value="<?php echo $row_item['id']; ?>" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Descrição:</th>
      <td><label>
        <input name="desc" type="text" id="desc" value="<?php echo $row_item['descricao']; ?>" size="100" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Ativo:</th>
      <td><label>
        <select name="ativo" id="ativo">
          <option value="1">Sim</option>
          <option value="2">Não</option>
          <?php
do {  
?>
          <option value="<?php echo $row_item['ativo']?>"><?php echo $row_item['ativo']?></option>
          <?php
} while ($row_item = mysql_fetch_assoc($item));
  $rows = mysql_num_rows($item);
  if($rows > 0) {
      mysql_data_seek($item, 0);
	  $row_item = mysql_fetch_assoc($item);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div align="center">
      <?php if(!$_REQUEST['id']){ ?>
        <label>
          <input type="button" name="button" id="button" value="Incluir" onclick="faz('incluir')" />
        </label>
        <?php }else{ ?>
        <label>
          <input type="button" name="button2" id="button2" value="Atualizar" onclick="faz('atualiza')" />
        </label>
        <?php } ?>
        <label>
          <input type="button" name="button3" id="button3" value="Voltar" onclick="faz('volta')" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($item);
?>
