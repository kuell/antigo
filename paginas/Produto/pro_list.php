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

$maxRows_rs_produto = 10;
$pageNum_rs_produto = 0;
if (isset($_GET['pageNum_rs_produto'])) {
  $pageNum_rs_produto = $_GET['pageNum_rs_produto'];
}
$startRow_rs_produto = $pageNum_rs_produto * $maxRows_rs_produto;
if(@$_GET['produto'] == ""){
	$produto = "%";	
	}
	else
	$produto = $_GET['produto'];
	
mysql_select_db($database_conn, $conn);
$query_rs_produto = "Select * from produto WHERE PRO_DESCRICAO LIKE '%$produto%'";
$query_limit_rs_produto = sprintf("%s LIMIT %d, %d", $query_rs_produto, $startRow_rs_produto, $maxRows_rs_produto);
$rs_produto = mysql_query($query_limit_rs_produto, $conn) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);

if (isset($_GET['totalRows_rs_produto'])) {
  $totalRows_rs_produto = $_GET['totalRows_rs_produto'];
} else {
  $all_rs_produto = mysql_query($query_rs_produto);
  $totalRows_rs_produto = mysql_num_rows($all_rs_produto);
}
$totalPages_rs_produto = ceil($totalRows_rs_produto/$maxRows_rs_produto)-1;

$queryString_rs_produto = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_produto") == false && 
        stristr($param, "totalRows_rs_produto") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_produto = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_produto = sprintf("&totalRows_rs_produto=%d%s", $totalRows_rs_produto, $queryString_rs_produto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="acao_pagina" align="center">
  Controle de Produtos
</div>

<form id="form1" name="form1" method="get" action="?produto=<?php echo $_GET['produto'];?>">
<table width="auto%" border="0" align="center" style="border:1px #009 solid;">
  <tr>
    <td>Produto:</td>
    <td><input name="produto" type="text" id="produto" value="<?php echo $_GET['produto'];?>" size="100" />
    </td>
    </tr>
  <tr>
    <td colspan="2"><div align="center">
      
        <input type="submit" name="button" id="button" value="busca" />

    </div></td>
    </tr>

</table>
  </form>


<table width="auto" border="0" align="center" class="KT_tngtable" >
  <tr>
    <th>Cod
    <th>Descrição</td>
    <th><a href="pro_form.php">Adicionar</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rs_produto['PRO_ID']; ?></td>
      <td><?php echo $row_rs_produto['PRO_DESCRICAO']; ?></td>
      <td><a href="pro_form.php?PRO_ID=<?php echo $row_rs_produto['PRO_ID'];?>">editar</a></td>
    </tr>
    <?php } while ($row_rs_produto = mysql_fetch_assoc($rs_produto)); ?>
    <tr>
    <td colspan="3"><div align="center"><a href="<?php printf("%s?pageNum_rs_produto=%d%s", $currentPage, max(0, $pageNum_rs_produto - 1), $queryString_rs_produto); ?>"><img src="../../includes/jaxon/widgets/dtable/img/double_arrow_left.gif" name="ant" width="15" height="12" border="0" id="ant" /></a><a href="<?php printf("%s?pageNum_rs_produto=%d%s", $currentPage, min($totalPages_rs_produto, $pageNum_rs_produto + 1), $queryString_rs_produto); ?>"><img src="../../includes/jaxon/widgets/dtable/img/double_arrow_right.gif" name="prox" width="15" height="12" border="0" id="prox" /></a></div></td>
    </tr>
</table>

</body>
</html>
<?php
mysql_free_result($rs_produto);
?>
