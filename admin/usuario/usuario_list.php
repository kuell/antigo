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
$query_usuario = "Select * from funcionario";
$usuario = mysql_query($query_usuario, $conn) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);mysql_select_db($database_conn, $conn);
$query_usuario = "select      `funcionario`.`id_funcionario` AS `id_funcionario`,     `funcionario`.`login` AS `login`,     `setor`.`setor` AS `setor`,     `acesso`.`acesso` AS `acesso`,     `funcionario`.`ativo`   from      ((`setor` join `funcionario` on((`setor`.`id_setor` = `funcionario`.`setor`))) join `acesso` on((`acesso`.`id` = `funcionario`.`nivel`)))";
$usuario = mysql_query($query_usuario, $conn) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
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
				loadTxt: "<img src='js/modal/doc/styles/loader.gif' /> Carregando...", // Loading text
				closeTxt: "<button>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
});

</script>
</head>

<body>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Cod</th>
    <th>Usuario</th>
    <th>Setor</th>
    <th>Nivel</th>
    <th>Status</th>
    <th><a href="usuario_form.php">Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_usuario['id_funcionario']; ?></td>
      <td><?php echo $row_usuario['login']; ?></td>
      <td><?php echo $row_usuario['setor']; ?></td>
      <td><?php echo $row_usuario['nivel']; ?></td>
      <td><?php echo $row_usuario['ativo']; ?></td>
      <td><a href="usuario_form.php?id_funcionario=<?php echo $row_usuario['id_funcionario']; ?>">edita </a><a href="usuario_sistema.php?id_funcionario=<?php echo $row_usuario['id_funcionario']; ?>" rel="superbox[iframe][700x500]">sistema</a></td>
    </tr>
    <?php } while ($row_usuario = mysql_fetch_assoc($usuario)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($usuario);
?>
