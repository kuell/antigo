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
$query_ordem = "Select * from ordem_externa_vew where status like 'APROVADO'";
$ordem = mysql_query($query_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);
$totalRows_ordem = mysql_num_rows($ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript">
$(function(){   
	$.superbox();
});
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' />Carregando...", // Loading text
				closeTxt: "<button class='button' onclick='window.location = window.location'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		
function pergunta(acao, id){
	if(confirm("Receber Equipamento?"))
			   {
			location.href = "funcao.php?action="+acao+"&id_ose="+id;
			   }
	return false
	}

</script>
</head>

<body>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <thead>
    <tr class="KT_row_order">
      <th>Cod</th>
      <th> Data_envio</th>
      <th> Requisitante</th>
      <th> Equipamento</th>
      <th> No. orcamento</th>
      <th> Pre&ccedil;o do servi&ccedil;o</th>
      <th> Status</th>
      <th colspan="2">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
      <tr>
        <td><?php echo $row_ordem['id_OSE']; ?></td>
        <td><?php echo $row_ordem['data_envio']; ?></td>
        <td><?php echo $row_ordem['requisitante']; ?></td>
        <td><?php echo $row_ordem['equipamento']; ?></td>
        <td><?php echo $row_ordem['Num_orcamento']; ?></td>
        <td><?php echo $row_ordem['preco_servico']; ?></td>
        <td><?php echo $row_ordem['status']; ?></td>
        <td><a href="receb_form.php?id=<?php echo $row_ordem['id_OSE']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/receber.gif" width="16" height="16" border="0" title="Receber Equipamento" /></a></td>
        <td><a href="visualiza.php?id_OSE=<?php echo $row_ordem['id_OSE']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/informacao.gif" width="16" height="16" border="0" title="Informação da Ordem de Serviço" /></a></td>
      </tr>
      <?php } while ($row_ordem = mysql_fetch_assoc($ordem)); ?>
  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
