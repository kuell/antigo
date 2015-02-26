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
$razao = "%";
		if (isset($_REQUEST['razao'])) {
		  $razao = $_REQUEST['razao'];
		}
	
$cnpj = "%";
		if (isset($_REQUEST['cnpj'])) {
		  $cnpj = $_REQUEST['cnpj'];
		}

$maxRows_rs_empresa = 10;
$pageNum_rs_empresa = 0;
if (isset($_GET['pageNum_rs_empresa'])) {
  $pageNum_rs_empresa = $_GET['pageNum_rs_empresa'];
}
$startRow_rs_empresa = $pageNum_rs_empresa * $maxRows_rs_empresa;

mysql_select_db($database_conn, $conn);
$query_rs_empresa = "Select * from empresas where nome like '%$razao%' AND cnpj_cpf like '%$cnpj%' order by id_empresa";
$query_limit_rs_empresa = sprintf("%s LIMIT %d, %d", $query_rs_empresa, $startRow_rs_empresa, $maxRows_rs_empresa);
$rs_empresa = mysql_query($query_limit_rs_empresa, $conn) or die(mysql_error());
$row_rs_empresa = mysql_fetch_assoc($rs_empresa);

if (isset($_GET['totalRows_rs_empresa'])) {
  $totalRows_rs_empresa = $_GET['totalRows_rs_empresa'];
} else {
  $all_rs_empresa = mysql_query($query_rs_empresa);
  $totalRows_rs_empresa = mysql_num_rows($all_rs_empresa);
}
$totalPages_rs_empresa = ceil($totalRows_rs_empresa/$maxRows_rs_empresa)-1;

$queryString_rs_empresa = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_empresa") == false && 
        stristr($param, "totalRows_rs_empresa") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_empresa = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_empresa = sprintf("&totalRows_rs_empresa=%d%s", $totalRows_rs_empresa, $queryString_rs_empresa);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina" align="center">Controle de Empresas</div>
<form id="form1" name="form1" method="get" action="?razao=<?php echo $_GET['razao'];?>">
  <table width="auto" border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Raz&atilde;o Social:</th>
      <td><input name="razao" type="text" id="razao" value="<?php echo $_GET['razao'] ;?>" size="50" /></td>
    </tr>
    <tr>
      <th>CNPJ/CPF:</th>
      <td><input name="cnpj" type="text" id="cnpj" value="<?php echo $_GET['cnpj'] ;?>" size="32" /></td>
    </tr>
    <tr>
      <th colspan="2" w="w"><div align="center">
        <input name="input" type="submit" value="Buscar" />
      </div></th>
    </tr>
  </table>
</form>
<table width="auto" border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Cod</th>
    <th>Raz&atilde;o</th>
    <th>CNPJ</th>
    <th>e-mail</th>
    <th class="MXW_disabled"><a href="empresa_form.php">Adicionar</a></th>
  </tr>
  <?php do { ?>
  <tr class="button">
    <td><?php echo $row_rs_empresa['id_empresa']; ?></td>
    <td><?php echo $row_rs_empresa['nome']; ?></td>
    <td><?php echo $row_rs_empresa['cnpj_cpf']; ?></td>
    <td><?php echo $row_rs_empresa['email']; ?></td>
    <td align="right"><a href="empresa_form.php?id_empresa=<?php echo $row_rs_empresa['id_empresa']; ?>&amp;KT_back=1"><div align="center"><img src="../../relatorio/images/edit.png" width="16" height="16" border="0" /></div></a></td>
  </tr>
  <?php } while ($row_rs_empresa = mysql_fetch_assoc($rs_empresa)); ?>
  <tr class="button">
    <th colspan="5"><div align="center"><a href="<?php printf("%s?pageNum_rs_empresa=%d%s", $currentPage, max(0, $pageNum_rs_empresa - 1), $queryString_rs_empresa); ?>">&lt;&lt;Anterior</a><a href="<?php printf("%s?pageNum_rs_empresa=%d%s", $currentPage, min($totalPages_rs_empresa, $pageNum_rs_empresa + 1), $queryString_rs_empresa); ?>"> Proximo&gt;&gt;</a></div></th>
    </tr>
  
</table>
</body>
</html>
<?php
mysql_free_result($rs_empresa);
?>
