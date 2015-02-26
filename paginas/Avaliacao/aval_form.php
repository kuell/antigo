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
$query_avalia = "Select * from Avaliacao where id_aval = '".$_REQUEST['id_aval']."'";
$avalia = mysql_query($query_avalia, $conn) or die(mysql_error());
$row_avalia = mysql_fetch_assoc($avalia);
$totalRows_avalia = mysql_num_rows($avalia);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../js/muda.js"></script>
<script src="../funcao.js" type="text/javascript"></script>
</head>

<body>
<div class="acao_pagina" align="center">Controle de Avalia&ccedil;&otilde;es</div>
<br />
<form id="form1" name="form1" method="post" action="../funcao.php">
  <input name="id_avalia" type="hidden" id="id_avalia" value="<?php echo $row_avalia['ID_AVAL']; ?>" />
  <input type="hidden" name="action" id="action" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Setor:</th>
      <td scope="col"><label>
      <select name=""></select>
      </label></td>
    </tr>
    <tr>
      <th scope="col">Descri&ccedil;&atilde;o do Tipo de Avalia&ccedil;&atilde;o:</th>
      <td scope="col"><label>
        <input name="descricao" type="text" id="descricao" value="<?php echo $row_avalia['DESC_AVAL']; ?>" size="60" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
      <?php if($row_avalia['ID_AVAL'] == ""){?>
        <label>
          <input type="button" name="salvar" id="salvar" value="Salvar" onclick="doPost('form1', 'avaliacao_salvar')" />
        </label>
        <?php }else{ ?>
        <label>
          <input type="submit" name="edita" id="edita" value="Editar" onclick="doPost('form1', 'avaliacao_editar')" />
        </label>
        <?php }?>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($avalia);
?>
