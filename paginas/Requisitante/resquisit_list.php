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
$query_resquisit = "SELECT requisitante.id_requisitante, requisitante.nome, setor.setor FROM (setor join requisitante on(setor.id_setor = requisitante.setor))";
$resquisit = mysql_query($query_resquisit, $conn) or die(mysql_error());
$row_resquisit = mysql_fetch_assoc($resquisit);
$totalRows_resquisit = mysql_num_rows($resquisit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina">Controle de Requisitantes e Solicitantes</div>
    
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" style="border:1px #009 solid;">
    <tr>
      <td>Requisitante/Solicitante:</td>
      <td><input name="textfield" type="text" id="textfield" accesskey="70" tabindex="70" size="70" maxlength="80" /></td>
    </tr>
    <tr>
      <td colspan="2"><div class="div_botoes">
        <input type="submit" name="button" id="button" value="busca" />
      </div></td>
      </tr>
  </table>      </form>


  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Cod</th>
      <th scope="col">Requisit./Solicit.</th>
      <th scope="col">Setor</th>
      <th scope="col"><a href="requisit_form.php">Adicionar</a></th>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_resquisit['id_requisitante']; ?></td>
        <td><?php echo $row_resquisit['nome']; ?></td>
        <td><?php echo $row_resquisit['setor']; ?></td>
        <td><a href="requisit_form.php?id_requisitante=<?php echo $row_resquisit['id_requisitante']; ?>">editar</a></td>
      </tr>
      <?php } while ($row_resquisit = mysql_fetch_assoc($resquisit)); ?>
  </table>

</body>
</html>
<?php
mysql_free_result($resquisit);
?>
