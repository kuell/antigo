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

$maxRows_categoria = 10;
$pageNum_categoria = 0;
if (isset($_GET['pageNum_categoria'])) {
  $pageNum_categoria = $_GET['pageNum_categoria'];
}
$startRow_categoria = $pageNum_categoria * $maxRows_categoria;

mysql_select_db($database_conn, $conn);
$query_categoria = "SELECT categ_id,desc_aval, categ_desc FROM (avaliacao join categoria on(avaliacao.id_aval = categoria.id_aval))";
$query_limit_categoria = sprintf("%s LIMIT %d, %d", $query_categoria, $startRow_categoria, $maxRows_categoria);
$categoria = mysql_query($query_limit_categoria, $conn) or die(mysql_error());
$row_categoria = mysql_fetch_assoc($categoria);

if (isset($_GET['totalRows_categoria'])) {
  $totalRows_categoria = $_GET['totalRows_categoria'];
} else {
  $all_categoria = mysql_query($query_categoria);
  $totalRows_categoria = mysql_num_rows($all_categoria);
}
$totalPages_categoria = ceil($totalRows_categoria/$maxRows_categoria)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript">
$(function(){
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../includes/jaxon/css/images/loading.gif' /> Carregando...", // Loading text
				closeTxt: "<button onclick='window.location = window.location'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
});

</script>
</head>

<body>
<div class="acao_pagina">Controle de Procedimentos</div>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Avalia&ccedil;&atilde;o</th>
    <th scope="col">Categoria</th>
    <th scope="col"><a href="categ_form.php" rel="superbox[iframe][700x600]">Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_categoria['categ_id']; ?></td>
      <td><?php echo $row_categoria['desc_aval']; ?></td>
      <td><?php echo $row_categoria['categ_desc']; ?></td>
      <td><a href="categ_form.php?id_categ=<?php echo $row_categoria['categ_id']; ?>" rel="superbox[iframe][700x500]">editar</a></td>
    </tr>
    <?php } while ($row_categoria = mysql_fetch_assoc($categoria)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($categoria);
?>
