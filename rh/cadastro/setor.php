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
$query_setor = "Select * from setor";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Controle de Setores</div>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Setor</th>
    <th scope="col">Encarregado</th>
    <th scope="col">Ativo</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_setor['id_setor']; ?></td>
      <td><?php echo utf8_encode($row_setor['setor']); ?></td>
      <td><?php echo utf8_encode($row_setor['encarregado']); ?></td>
      <td title="Ativa ou desativa">
        <?php if($row_setor['rh'] == "SIM"){?>
        <a href="funcao.php?funcao=ativo&amp;op=NAO&amp;setor=<?php echo $row_setor['id_setor']; ?>"><img src="../../img/ativo.gif" width="14" height="14" title="Desativar" /></a>
        <?php }else{ ?>
        <a href="funcao.php?funcao=ativo&amp;op=SIM&amp;setor=<?php echo $row_setor['id_setor']; ?>"><img src="../../img/delete.png" width="16" height="16" title="Ativar" /></a>
        <?php } ?>
      </td>
    </tr>
    <?php } while ($row_setor = mysql_fetch_assoc($setor)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($setor);
?>
