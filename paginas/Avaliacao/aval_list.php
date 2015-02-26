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
$query_rs_aval = "Select * from avaliacao";
$rs_aval = mysql_query($query_rs_aval, $conn) or die(mysql_error());
$row_rs_aval = mysql_fetch_assoc($rs_aval);
$totalRows_rs_aval = mysql_num_rows($rs_aval);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
<div class="acao_pagina" align="center"> Controle de Avalia&ccedil;&otilde;es </div>
<table width="auto" border="0" align="center" class="KT_tngtable">
  <tr>
    <th width="12%">Cod</th>
    <th width="79%">Avalia&ccedil;&atilde;o</th>
    <th width="9%"><a href="aval_form.php" rel="superbox[iframe][700x500]">Adicionar</a></th>
  </tr>
  <?php do { ?>
  <tr style="border:1px solid #000;">
    <td><?php echo $row_rs_aval['ID_AVAL']; ?></td>
    <td><?php echo $row_rs_aval['DESC_AVAL']; ?></td>
    <td><a href="aval_form.php?id_aval=<?php echo $row_rs_aval['ID_AVAL']; ?>" rel="superbox[iframe][700x500]">editar</a></td>
	<?php } while ($row_rs_aval = mysql_fetch_assoc($rs_aval)); ?>
  <tr>
</table>
<br />

</body>
</html>
<?php
mysql_free_result($rs_aval);
?>
