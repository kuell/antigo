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
if(@$_GET['servico'] == "")
	$servico = '%';
else
$servico = $_GET['servico'];

if(@$_GET['id'] == "")
	$id = '%';
else
$id = $_GET['id'];

mysql_select_db($database_conn, $conn);
$query_rs_servico = "Select * from acao where acao like '%$id%'";
$rs_servico = mysql_query($query_rs_servico, $conn) or die(mysql_error());
$row_rs_servico = mysql_fetch_assoc($rs_servico);
$totalRows_rs_servico = mysql_num_rows($rs_servico);

mysql_select_db($database_conn, $conn);
$query_acao = "Select * from acao where id_acao = '$servico'";
$acao = mysql_query($query_acao, $conn) or die(mysql_error());
$row_acao = mysql_fetch_assoc($acao);
$totalRows_acao = mysql_num_rows($acao);
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
<div class="acao_pagina" align="center">Controle de Servi&ccedil;os</div>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_acao" type="hidden" id="id_acao" value="<?php echo $row_acao['id_acao']; ?>" />
  <table border="0" align="center" class="KT_tngtable">
    <tr>
    <th>Servi&ccedil;o</th>
    <td><input name="servico" type="text" id="servico" onkeyup="maiusculo(this)" value="<?php echo $row_acao['acao']; ?>" size="50" /></td>
  </tr>
  <tr>
    <th colspan="2"><div align="center">
        <?php if(@$_GET['servico'] == ""){?>
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
        <td><?php echo $row_rs_servico['id_acao']; ?></td>
        <td><?php echo $row_rs_servico['acao']; ?></td>
        <td><a href="?servico=<?php echo $row_rs_servico['id_acao']; ?>">editar</a></td>
      </tr>
      <?php } while ($row_rs_servico = mysql_fetch_assoc($rs_servico)); ?>
  </table>

</body>
</html>
<?php
mysql_free_result($rs_servico);

mysql_free_result($acao);
?>
