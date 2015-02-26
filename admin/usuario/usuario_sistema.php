<?php require_once('../../Connections/conn.php'); ?>
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

$id_usuario = $_GET['id_funcionario'];
mysql_select_db($database_conn, $conn);
$query_sistema = "Select * from sistemas";
$sistema = mysql_query($query_sistema, $conn) or die(mysql_error());
$row_sistema = mysql_fetch_assoc($sistema);
$totalRows_sistema = mysql_num_rows($sistema);

mysql_select_db($database_conn, $conn);
$query_Usuario = "SELECT *, setor.setor FROM (setor join funcionario on(setor.id_setor = funcionario.setor)) where id_funcionario = '$id_usuario'";
$Usuario = mysql_query($query_Usuario, $conn) or die(mysql_error());
$row_Usuario = mysql_fetch_assoc($Usuario);
$totalRows_Usuario = mysql_num_rows($Usuario);

mysql_select_db($database_conn, $conn);
$query_sistema_acesso = "SELECT * FROM acess_sistem WHERE funcionario = '$id_usuario'";
$sistema_acesso = mysql_query($query_sistema_acesso, $conn) or die(mysql_error());
$row_sistema_acesso = mysql_fetch_assoc($sistema_acesso);
$totalRows_sistema_acesso = mysql_num_rows($sistema_acesso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="funcao.js" type="text/javascript"></script>
</head>

<body>
<div class="acao_pagina">Controle de Acessos</div>
<br />
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $id_usuario;?>" />
  <div align="center">Usuario = <?php echo $row_Usuario['nome']; ?></div>
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Sistema</th>
      <td><select name="sistema" id="sistema">
        <option value="">Selecione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_sistema['id_sistema']?>"><?php echo $row_sistema['nome']?></option>
        <?php
} while ($row_sistema = mysql_fetch_assoc($sistema));
  $rows = mysql_num_rows($sistema);
  if($rows > 0) {
      mysql_data_seek($sistema, 0);
	  $row_sistema = mysql_fetch_assoc($sistema);
  }
?>
      </select></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center"><input type="button" name="incluir" id="incluir" value="Incluir" onclick="doPost('form1', 'incluir')" /></div></th>
    </tr>
  </table>
</form><br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th colspan="2" scope="col">Sistema</th>
  </tr>
  <?php do { ?>
    <tr>
      
      <?php if($row_sistema_acesso['Sistema'] == ""){ ?>
      <td>Não exixtem sistemas para este usuario</td>
      <?php }else{?>
      <td><?php echo $row_sistema_acesso['Sistema']; ?></td>
      <td scope="col"><a href="funcao.php?id_funcionario=<?php echo $row_sistema_acesso['funcionario']; ?>&amp;sistema=<?php echo $row_sistema_acesso['id_sistema']; ?>&amp;action=excluir"><img src="../../CQ/images/Delete.png" width="16" height="16" border="0" /></a></td>
      <?php } ?>
    </tr>
    <?php } while ($row_sistema_acesso = mysql_fetch_assoc($sistema_acesso)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($sistema);

mysql_free_result($Usuario);

mysql_free_result($sistema_acesso);

?>
