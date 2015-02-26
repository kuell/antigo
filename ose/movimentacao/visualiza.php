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
$query_ordem = "Select * from Ordem_externa_vew where id_ose = '".$_REQUEST['id_OSE']."'";
$ordem = mysql_query($query_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);
$totalRows_ordem = mysql_num_rows($ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
		   $("#print button").click(function(){
											 $(this).css("display","none")
											 window.print() });
		   });
</script>
</head>
</head>

<body>
<div class="acao_pagina">Ordem Externa Hist&oacute;rico</div>
<br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th colspan="4" scope="col"><div align="center">Dados da Ordem de Servi&ccedil;o</div></th>
  </tr>
  <tr>
    <th scope="col">Codigo da OS:</th>
    <td scope="col"><?php echo $row_ordem['id_OSE']; ?></td>
    <th scope="col">Data do Envio</th>
    <td scope="col"><?php echo date('d/m/Y', strtotime($row_ordem['data_envio'])); ?></td>
  </tr>
  <tr>
    <th>Requisitante:</th>
    <td><?php echo $row_ordem['requisitante']; ?></td>
    <th>Qtd. dias ap&oacute;s envio:</th>
    <td><?php echo $row_ordem['Dias_Apos']; ?> dias</td>
  </tr>
  <tr>
    <th>Equipamento:</th>
    <td><?php echo $row_ordem['equipamento']; ?></td>
    <th>Setor:</th>
    <td><?php echo $row_ordem['setor']; ?></td>
  </tr>
  <tr>
    <th colspan="4"><div align="center">Dados do Or&ccedil;amento</div></th>
  </tr>
  <tr>
    <th>Empresa:</th>
    <td colspan="3"><?php echo $row_ordem['empresa']; ?></td>
  </tr>
  <tr>
   <th>No. Or&ccedil;amento:</th>
    <td><?php echo $row_ordem['Num_orcamento']; ?></td>
    <th>Pre&ccedil;o do Servi&ccedil;o:</th>
    <td><?php echo "R$ ".$row_ordem['preco_servico']; ?></td>
  </tr>
  <tr>
    <th>Descri&ccedil;&atilde;o do Servi&ccedil;o:</th>
    <td colspan="3"><?php echo $row_ordem['descricao']; ?></td>
  </tr>
  <tr>
    <th>Or&ccedil;amento:</th>
    <td colspan="3"><a href="arquivos/<?php echo $row_ordem['doc_orcamento']; ?>">Visualizar</a></td>
  </tr>
</table>
<br /><div align="center" id="print"><button>Print</button></div>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
