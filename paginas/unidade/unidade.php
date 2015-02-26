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

if(@$_GET['unidade'] == "")
	$unidade = '%';
else
$unidade = $_GET['unidade'];

if(@$_GET['id_unidade'] == "")
	$id = '%';
else
$id = $_GET['id_unidade'];

mysql_select_db($database_conn, $conn);
$query_unidade_lista = "Select * from unidade_medida where UM_DESCRICAO like '%$unidade%'";
$unidade_lista = mysql_query($query_unidade_lista, $conn) or die(mysql_error());
$row_unidade_lista = mysql_fetch_assoc($unidade_lista);
$totalRows_unidade_lista = mysql_num_rows($unidade_lista);

mysql_select_db($database_conn, $conn);
$query_unidade = "Select * from unidade_medida where UM_ID = '$id'";
$unidade = mysql_query($query_unidade, $conn) or die(mysql_error());
$row_unidade = mysql_fetch_assoc($unidade);
$totalRows_unidade = mysql_num_rows($unidade);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/muda.js" type="text/javascript"></script>
<script src="funcao.js" type="text/javascript"></script>
</head>

<body>
<div class="acao_pagina" align="center">Controle de Unidade de Medida</div>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_unidade" type="hidden" id="id_unidade" value="<?php echo $row_unidade['UM_ID']; ?>" />
  <table border="0" align="center" class="KT_tngtable">
    <tr>
    <th>Unidade de Medida:</th>
    <td><input name="unidade" type="text" id="unidade" onkeyup="maiusculo(this)" value="<?php echo $row_unidade['UM_DESCRICAO']; ?>" size="50" /></td>
  </tr>
  <tr>
    <th colspan="2"><div align="center">
        <?php if(@$_GET['id_unidade'] == ""){?>
        <label>
        	<input type="button" name="incluir" id="incluir" value="Incluir" onclick="doPost('form1', 'incluir')" />
            <input type="button" name="button" id="button" value="Buscar" onclick="doPost('form1', 'buscar')" />
        </label>
 		<?php }else{ ?>
        <input type="button" name="atualiza" id="atualiza" value="Atualizar" onclick="doPost('form1', 'atualizar')" />
        <input type="button" name="cancela" id="cancela" value="Cancela" onclick="doPost('form1', 'cancelar')" />
      <?php } ?>
      </div></th>
  </tr>
</table>     </form>
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Cod</th>
      <th colspan="2">Servi&ccedil;o</th>
    </tr>
    <?php do { ?>
    <tr>
      <td><?php echo $row_unidade_lista['UM_ID']; ?></td>
      <td><?php echo $row_unidade_lista['UM_DESCRICAO']; ?></td>
      <td><a href="unidade.php?id_unidade=<?php echo $row_unidade_lista['UM_ID']; ?>">editar</a></td>
    </tr>
      <?php } while ($row_unidade_lista = mysql_fetch_assoc($unidade_lista)); ?>
  </table>

</body>
</html>
<?php
mysql_free_result($unidade_lista);

mysql_free_result($unidade);
?>
