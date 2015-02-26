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

$maxRows_ordem = 15;
$pageNum_ordem = 0;
if (isset($_GET['pageNum_ordem'])) {
  $pageNum_ordem = $_GET['pageNum_ordem'];
}
$startRow_ordem = $pageNum_ordem * $maxRows_ordem;

mysql_select_db($database_conn, $conn);
$query_ordem = "SELECT * FROM ordem_interna_vew where status LIKE '%EM ANDAMENTO%'";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Movimenta&ccedil;&otilde;es</title>
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
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' width='24' height='24' /> Carregando...", // Loading text
				closeTxt: "<button onclick='window.location.href = window.location'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
});

</script>
<script type="text/javascript">
function excluir(id){
	
	if(confirm("Deseja Realmente excluir a OSI nº "+id+"?")){
	location.href = "funcao.php?id_osi="+id+"&amp;action=excluir"
	}
	return false
	}


function pergunta(id){
	if(confirm("O serviço foi executado?")){
	location.href = "funcao.php?id_osi="+id+"&amp;action=executar"
	}
	return false
	}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body><form id="form1" name="form1" method="post" action="">
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Requisitante:</th>
    <td>
      <input type="text" name="textfield" id="textfield" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<br />
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable" width="auto">
  <thead>
    <tr>
      <th id="data_pedido" class="">Cod</th>
      <th id="requisitante" class=""> Data/Pedido</th>
      <th>Requisitante</th>
      <th id="responsavel" class=""> Respons&aacute;vel</th>
      <th id="acao" class=""> Servi&ccedil;o</th>
      <th id="setor" class=""> Setor</th>
      <th id="status" class=""> Status</th>
      <th>Prazo</th>
      <th colspan="4" align="center"><a href="mov_form.php">Adicionar</a></th>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <?php if($row_ordem['id_osi'] == ""){?>
      <tr>
      <td colspan="11">Não Existem Ordens Internas para serem executadas</td>
      </tr>
      <?php }else{?>
      <tr>
        <td><div class="KT_col_data_pedido"><?php echo $row_ordem['id_osi']; ?></div></td>
        <td><div><?php echo date("d-m-Y", strtotime($row_ordem['data_pedido'])); ?></div></td>
        <td><div class="KT_col_requisitante"><?php echo $row_ordem['requisitante']; ?></div></td>
        <td><div class="KT_col_responsavel"><?php echo $row_ordem['responsavel']; ?></div></td>
        <td><div class="KT_col_acao"><?php echo $row_ordem['acao']; ?></div></td>
        <td><div class="KT_col_setor"><?php echo $row_ordem['setor']; ?></div></td>
        <td><div class="KT_col_status"><?php echo $row_ordem['status']; ?></div></td>
        <td><div align="center">
        <?php if($row_ordem['prazo_conclusao'] == "0"){ ?>
        <a href="prazo.php?id_osi=<?php echo $row_ordem['id_osi']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/prazo.png" width="16" height="16" border="0" title="Informar prazo para conclusão!" /></a>
        <?php }else{?>
        <img src="../../img/bloqueado.gif" width="16" height="16" title="Prazo para conclusão = <?php echo $row_ordem['prazo_conclusao']; ?> dia(s)" />
        <?php }?>
        </div>
        </td>
        <td align="center">
		<?php 
		session_start();
		if($_SESSION['kt_login_user'] == $row_ordem['requisitante']){?>
        <a href="mov_form.php?id_osi=<?php echo $row_ordem['id_osi']; ?>"><img src="../../img/edit.png" width="16" height="16" border="0" /></a>
        <?php }else{ ?>
        <img src="../../img/bloqueado.gif" width="16" height="16" />
        <?php } ?>
        </td>
        <?php if($row_ordem['prazo_conclusao'] == "0"){ ?>
        <td align="center"><a href="#" onclick="excluir('<?php echo $row_ordem['id_osi']; ?>')"><img src="../../img/delete.png" width="16" height="16"  title="excluir"/></a>
        </td>
        <td><img src="../../img/bloqueado.gif" width="16" height="16" /></td>
        <?php }else{?>
        <td align="center"><a href="#"><img src="../../img/print.png" width="16" height="16" border="0" onclick="MM_openBrWindow('../relatorio/recibo_os.php?id_osi=<?php echo $row_ordem['id_osi']; ?>','Imprimir','width=800,height=800')" /></a></td>
        <td><a href="executar.php?id_osi=<?php echo $row_ordem['id_osi']; ?>" rel="superbox[iframe][700x500]" title="Executar serviço!"><img src="../../img/ativo.gif" width="16" height="16" border="0" /></a></td>
        <?php }?>
        <?php } ?>
      </tr>
            <?php } while ($row_ordem = mysql_fetch_assoc($ordem)); ?>
      <tr>
        <th colspan="13"><div align="center"><a href="<?php printf("%s?pageNum_ordem=%d%s", $currentPage, max(0, $pageNum_ordem - 1), $queryString_ordem); ?>">&lt;&lt;Anterior</a> <a href="<?php printf("%s?pageNum_ordem=%d%s", $currentPage, min($totalPages_ordem, $pageNum_ordem + 1), $queryString_ordem); ?>">Proximo&gt;&gt;</a></div></th>
      </tr>

  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
