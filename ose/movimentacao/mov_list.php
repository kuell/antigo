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

$maxRows_ordem = 8;
$pageNum_ordem = 0;
if (isset($_GET['pageNum_ordem'])) {
  $pageNum_ordem = $_GET['pageNum_ordem'];
}
$startRow_ordem = $pageNum_ordem * $maxRows_ordem;

mysql_select_db($database_conn, $conn);
$query_ordem = "Select * from ordem_externa_vew where status like '%ESPERANDO O%'";
$query_limit_ordem = sprintf("%s LIMIT %d, %d", $query_ordem, $startRow_ordem, $maxRows_ordem);
$ordem = mysql_query($query_limit_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);

if (isset($_GET['totalRows_ordem'])) {
  $totalRows_ordem = $_GET['totalRows_ordem'];
} else {
  $all_ordem = mysql_query($query_ordem);
  $totalRows_ordem = mysql_num_rows($all_ordem);
}
$totalPages_ordem = ceil($totalRows_ordem/$maxRows_ordem)-1;$maxRows_ordem = 8;
$pageNum_ordem = 0;
if (isset($_GET['pageNum_ordem'])) {
  $pageNum_ordem = $_GET['pageNum_ordem'];
}
$startRow_ordem = $pageNum_ordem * $maxRows_ordem;

mysql_select_db($database_conn, $conn);
$query_ordem = "SELECT * FROM ordem_externa_vew WHERE status like '%ESPERANDO O%'";
$query_limit_ordem = sprintf("%s LIMIT %d, %d", $query_ordem, $startRow_ordem, $maxRows_ordem);
$ordem = mysql_query($query_limit_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);

if (isset($_GET['totalRows_ordem'])) {
  $totalRows_ordem = $_GET['totalRows_ordem'];
} else {
  $all_ordem = mysql_query($query_ordem);
  $totalRows_ordem = mysql_num_rows($all_ordem);
}
$totalPages_ordem = ceil($totalRows_ordem/$maxRows_ordem)-1;

$queryString_ordem = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ordem") == false && 
        stristr($param, "totalRows_ordem") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ordem = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ordem = sprintf("&totalRows_ordem=%d%s", $totalRows_ordem, $queryString_ordem);
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
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript" src="../../js/muda.js"></script>
<script type="text/javascript">

$(function(){
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
	$.superbox();
});

function pergunta(id){
	if(confirm("Deseja EXCLUIR a Ordem No."+id+"?")){
		location.href = "funcao.php?action=excluir&amp;id_ose="+id;
		}
		return false
	}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<div class="acao_pagina">Movimenta&ccedil;&atilde;o de Ordem Externa</div>
<br />
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Id da OS:</th>
      <td scope="col"><label>
        <input type="text" name="textfield" id="textfield" />
      </label></td>
    </tr>
    <tr>
      <th>Equipamento</th>
      <td><label>
        <input name="textfield2" type="text" id="textfield2" size="100" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
        <input type="button" name="Busca" id="Busca" value="Buscar" />
      </div></th>
    </tr>
  </table>
</form>
<p><br />
  
</p>
<table width="600px" border="0" align="center" class="KT_tngtable" >
  <tr>
    <th width="10px"  scope="col">Cod</th>
    <th scope="col" width="10px">Data/Envio</th>
    <th scope="col" width="10px">Equipamento</th>
    <th scope="col">Setor</th>
    <th scope="col">Requisitante</th>
    <th scope="col">Empresa</th>
    <th scope="col">Status</th>
    <th scope="col">Dias/Ap&oacute;s</th>
    <th colspan="4" scope="col"><a href="mov_form.php">Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr title="O.S.E. No.: <?php echo $row_ordem['id_OSE']; ?> - 
    		   Data do envio: <?php echo date('d/m/Y', strtotime($row_ordem['data_envio'])); ?>
               Equipamento: <?php echo $row_ordem['equipamento']; ?> 
               Requisitante: <?php echo $row_ordem['requisitante']; ?>
               Qtd. Dias após o envio: <?php echo $row_ordem['Dias_Apos']; ?> dia(s)">
      <td width="10px"><?php echo $row_ordem['id_OSE']; ?></td>
      <td width="10px"><?php echo date("d-m-Y", strtotime($row_ordem['data_envio'])); ?></td>
      <td width="10px"><?php echo $row_ordem['equipamento']; ?></td>
      <td><?php echo $row_ordem['setor']; ?></td>
      <td><?php echo $row_ordem['requisitante']; ?></td>
      <td><?php echo $row_ordem['empresa']; ?></td>
      <td><?php echo $row_ordem['status']; ?></td>
      <td><?php echo $row_ordem['Dias_Apos']; ?> dias</td>
      <td><a href="mov_form.php?id_OSE=<?php echo $row_ordem['id_OSE']; ?>"><img src="../../img/edit.png" alt="" width="16" height="16" border="0" 
      title="Editar OS"/></a></td>
      <td><a href="#"><img id="fancy2" src="../../img/print.png" alt="" width="16" height="16" border="0" onclick="MM_openBrWindow('../relatorio/recibo_ose/php/recibo.php?descricao=<?php echo $row_ordem['id_OSE']; ?>','Print','width=800,height=600')" title="Imprimir OS" /></a><a href="#" onclick="pergunta(<?php echo $row_ordem['id_OSE']; ?>)"></a></td>
           <td><a href="#" onclick="pergunta(<?php echo $row_ordem['id_OSE']; ?>)"><img src="../../img/delete.png" alt="" width="16" height="16" border="0" title="Excluir OS" /></a><a href="../relatorio/recibo_ose/php/recibo.php?descricao=<?php echo $row_ordem['id_OSE']; ?>" rel="superbox[iframe][700x500]"></a></td>
    </tr>
    <tr>
      <?php } while ($row_ordem = mysql_fetch_assoc($ordem)); ?>
  
    <th colspan="12"><div align="center"><a href="<?php printf("%s?pageNum_ordem=%d%s", $currentPage, max(0, $pageNum_ordem - 1), $queryString_ordem); ?>">&lt;&lt;Anterior</a> <a href="<?php printf("%s?pageNum_ordem=%d%s", $currentPage, min($totalPages_ordem, $pageNum_ordem + 1), $queryString_ordem); ?>">Proximo&gt;&gt;</a></div></th>
    </tr>
    
</table>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
