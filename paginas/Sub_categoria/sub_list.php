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
$query_sub = "SELECT id_sub,             desc_aval,           categ_desc, sub_desc FROM (avaliacao join sub_categoria on(avaliacao.id_aval = sub_categoria.id_aval) join categoria on(categoria.categ_id = sub_categoria.id_categ))";
$sub = mysql_query($query_sub, $conn) or die(mysql_error());
$row_sub = mysql_fetch_assoc($sub);
$totalRows_sub = mysql_num_rows($sub);
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
<div class="acao_pagina">Controle de Sub-Categorias</div>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Avalia&ccedil;&atilde;o</th>
    <th scope="col">Categoria</th>
    <th scope="col">Sub-Categoria</th>
    <th scope="col"><a href="sub_form.php" rel="superbox[iframe][700x500]">Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_sub['id_sub']; ?></td>
      <td><?php echo $row_sub['desc_aval']; ?></td>
      <td><?php echo $row_sub['categ_desc']; ?></td>
      <td><?php echo $row_sub['sub_desc']; ?></td>
      <td><a href="sub_form.php?id_sub=<?php echo $row_sub['id_sub']; ?>" rel="superbox[iframe][700x500]">editar</a></td>
    </tr>
    <?php } while ($row_sub = mysql_fetch_assoc($sub)); ?>
<tr>
    <th colspan="5"><div align="center"><a href="#">&lt;&lt;Anterior</a> <a href="#">Proximo&gt;&gt;</a></div></th>
    </tr>
    
</table>
</body>
</html>
<?php
mysql_free_result($sub);
?>
