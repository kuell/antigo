<?php require_once('../../Connections/conn.php'); ?>
<?php require('funcao.php');?>
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
	$requisit = "%";
			if (isset($_GET['requisit'])) {
			  $requisit = $_GET['requisit'];}
	$empresa = "%";
			if (isset($_GET['empresa'])) {
			  $empresa = $_GET['empresa'];}

mysql_select_db($database_conn, $conn);
$query_rs_ordem = "SELECT *, date_format(data_envio, '%d/%m/%Y') as data_envio FROM ordem_externa_vew WHERE (id_status = '1' or id_status = '2') AND id_OSE like '%".$_GET['id']."%' AND requisitante LIKE '%$requisit%' AND empresa LIKE '%$empresa%'";
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Classifica&ccedil;&atilde;o</title>
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
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' /> Carregando ...", // Loading text
				closeTxt: "<button onclick='window.location = window.location'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
});
</script>

</head>

<body>
<div class="acao_pagina" align="center">Classifica&ccedil;&atilde;o de Ordem Externa</div><br />
    <form id="form1" name="form1" method="GET" action="?id=<?php echo $_GET['id'];?>&requisit=<?php echo $_GET['requisit'];?>&empresa=<?php echo $_GET['empresa'];?>">
    <table width="auto" border="0" align="center" class="KT_tngtable" style="border:1px solid #009">
  <tr>
    <th>Codigo</th>
    <td><input name="id" type="text" id="id" value="<?php echo $_REQUEST['id'] ;?>" size="20" /></td>
  </tr>
  <tr>
    <th width="86">Requisitante</th>
    <td width="204">
      <input name="requisit" type="text" id="requisit" onkeyup="maiusculo(this)" value="<?php echo $_GET['requisit'];?>" size="70" />
 </td>
  </tr>
  <tr>
    <th>Empresa</th>
    <td><input name="empresa" type="text" id="empresa" onkeyup="maiusculo(this)" value="<?php echo $_GET['empresa'];?>" size="70" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Buscar" /></td>
    </tr>
</table>
</form>
    <table width="auto" border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Cod</th>
    <th>Data/Envio</th>
    <th>Equip</th>
    <th>Setor</th>
    <th>Requisit.</th>
    <th>Empresa</th>
    <th>Status</th>
    <td colspan="3" class="ewRptGrpSummary3" ><a href="mov_form.php">Adicionar</a></td>
  <?php if($row_rs_ordem['id_OSE'] == ""){ ?>
  <tr>
  	<td colspan="10">N�o existem ordens de servi�o para serem classificadas</td>
  </tr>
  <?php }else{?>
  <?php do { ?>
    <tr>
      <td title="Imprimir Ordem = <?php echo $row_rs_ordem['id_OSE'] ;?>"><?php echo $row_rs_ordem['id_OSE']; ?></td>
      <td><?php echo $row_rs_ordem['data_envio']; ?></td>
      <td><?php echo $row_rs_ordem['equipamento']; ?></td>
      <td><?php echo $row_rs_ordem['setor']; ?></td>
      <td><?php echo $row_rs_ordem['requisitante']; ?></td>
      <td><?php echo $row_rs_ordem['empresa']; ?></td>
      <td style="font:7px Verdana, Geneva, sans-serif;"><?php echo $row_rs_ordem['status']; ?></td>
      
      <?php if($row_rs_ordem['id_status'] == 1){ ?>
      <td>
      <img src="../../img/bloqueado.gif" alt="" width="16" height="16" title="Digite o Or&ccedil;amento"/>
      </td>
      <td>
      <a href="mov_orcamento.php?id_OSE=<?php echo $row_rs_ordem['id_OSE']; ?>" rel="superbox[iframe][700x500]" title="Digita��o/Manuten��o do Or�amento!"><img src="../../img/classificar.png" alt="" width="16" height="16" border="0" /></a>
     </td>
      <?php }else{?>
      <td>
      <a href="class_form.php?id_OSE=<?php echo $row_rs_ordem['id_OSE']; ?>" rel="superbox[iframe][700x500]" title="Classificar OS"><img src="../../img/orcamento.png" alt="" width="16" height="16" border="0" /></a>
      </td>
     <td> 
      <img src="../../img/bloqueado.gif" alt="" width="16" height="16" title="Digite o Or&ccedil;amento"/>
      </td>
	  <?php }?>
      </td>
      <td>
      <a href="visualiza.php?id_OSE=<?php echo $row_rs_ordem['id_OSE']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/print.png" alt="" width="16" height="16" border="0" /></a></td>
   
    </tr>
    <?php } while ($row_rs_ordem = mysql_fetch_assoc($rs_ordem)); ?>
    <?php } ?>
    </table>
</body>
</html>
<?php
mysql_free_result($rs_ordem);
?>
