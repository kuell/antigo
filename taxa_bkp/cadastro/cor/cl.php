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
$query_cor = "SELECT * FROM corretor";
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
</head>

<body>
<div class="acao_pagina">
	Controle de Corretores
</div>
<table border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Cod</th>
    <th>Nome do Corretor</th>
    <th>Codigo Interno</th>
    <th>Ativo</th>
    <th><a href="cf.php">Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cor['cor_id']; ?></td>
      <td><?php echo $row_cor['cor_nome']; ?></td>
      <td><?php echo $row_cor['cor_cod']; ?></td>
      <td><?php echo $row_cor['cor_ativo']; ?></td>
	  <td><div class="div_botoes">
    <?php if($row_cor['cor_ativo'] == 'Sim'){?>  
      <a href="../class.php?funcao=edit_cor&cor_id=<?php echo $row_cor['cor_id']; ?>&cor_ativo=2" title="Desativar"><img src="../../../img/ativo.gif" width="16" height="16" border="0" /></a>
    <?php } else { ?>
   	  <a href="../class.php?funcao=edit_cor&cor_id=<?php echo $row_cor['cor_id']; ?>&cor_ativo=1" title="Ativar"><img src="../../../img/delete.png" width="16" /></a>
	<?php }?>
    </div></td>
    </tr>
    <?php } while ($row_cor = mysql_fetch_assoc($cor)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($cor);
?>
