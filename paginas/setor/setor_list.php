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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_setor = 10;
$pageNum_rs_setor = 0;
if (isset($_GET['pageNum_rs_setor'])) {
  $pageNum_rs_setor = $_GET['pageNum_rs_setor'];
}
$startRow_rs_setor = $pageNum_rs_setor * $maxRows_rs_setor;
if($_GET['setor'] == "")
 $setor = '%';
else
 $setor = $_GET['setor'];

mysql_select_db($database_conn, $conn);
$query_rs_setor = "Select * from setor where setor like '%$setor%'";
$query_limit_rs_setor = sprintf("%s LIMIT %d, %d", $query_rs_setor, $startRow_rs_setor, $maxRows_rs_setor);
$rs_setor = mysql_query($query_limit_rs_setor, $conn) or die(mysql_error());
$row_rs_setor = mysql_fetch_assoc($rs_setor);

if (isset($_GET['totalRows_rs_setor'])) {
  $totalRows_rs_setor = $_GET['totalRows_rs_setor'];
} else {
  $all_rs_setor = mysql_query($query_rs_setor);
  $totalRows_rs_setor = mysql_num_rows($all_rs_setor);
}
$totalPages_rs_setor = ceil($totalRows_rs_setor/$maxRows_rs_setor)-1;

$queryString_rs_setor = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_setor") == false && 
        stristr($param, "totalRows_rs_setor") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_setor = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_setor = sprintf("&totalRows_rs_setor=%d%s", $totalRows_rs_setor, $queryString_rs_setor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/muda.js" type="text/javascript"></script>
</head>
<body>
<div class="acao_pagina" align="center">Controle de Setores</div>
<form id="form1" name="form1" method="GET" action="?setor=<?php echo $_GET['setor'];?>">
  <table width="auto" border="0" align="center" class="KT_tngtable">
    <tr class="KT_row_order">
      <th>Setor:</th>
      <td><input name="setor" type="text" id="setor" size="50" onkeyup="maiusculo(this)" value="<?php echo $_GET['setor'];?>"/></td>
    </tr>
    <tr>
      <th colspan="2" class="KT_row_order"><div align="center"><input name="Submit" type="submit" class="button_small" value="Buscar" /></div></th>
    </tr>
  </table>
  <br />
</form>
<table border="0" align="center" class="KT_tngtable">
  <tr class="KT_row_order">
      <th>Cod</th>
      <th>Setor</th>
      <th>Encarregado</th>
      <th colspan="2"><a href="setor_form.php">Adicionar</a></th>
  </tr>
    <?php do { ?>
    <tr>
     
        <td width="auto"><?php echo $row_rs_setor['id_setor']; ?></td>
        <td width="auto"><?php echo $row_rs_setor['setor']; ?></td>
        <td width="auto"><?php echo $row_rs_setor['encarregado']; ?></td>
        <td width="auto" align="center"><a href="setor_form.php?id_setor=<?php echo $row_rs_setor['id_setor']; ?>" title="Editar"><img src="../../relatorio/images/edit.png" width="16" height="16" border="0" /></a></td>
        
    </tr><?php } while ($row_rs_setor = mysql_fetch_assoc($rs_setor)); ?>
    <tr>
    <th colspan="5" class="KT_row_order"><div align="center"><a href="<?php printf("%s?pageNum_rs_setor=%d%s", $currentPage, max(0, $pageNum_rs_setor - 1), $queryString_rs_setor); ?>">&lt;&lt;Anterior </a><a href="<?php printf("%s?pageNum_rs_setor=%d%s", $currentPage, min($totalPages_rs_setor, $pageNum_rs_setor + 1), $queryString_rs_setor); ?>">Proximo>></a></div> </th>
    </tr>
    
</table>

</body>
</html>
<?php
mysql_free_result($rs_setor);
?>
