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

$setor = $_POST['setor'];
	if(!$_POST['setor']){
		$setor = '%';
		}

mysql_select_db($database_conn, $conn);
$query_setor = "SELECT 
					id_item, setor.setor, desc_item 
				FROM 
					setor inner join itens on(setor.id_setor = itens.setor)
				WHERE
					setor.setor like '$setor'
				ORDER BY 
					setor.setor, desc_item
				";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);

$queryString_itens = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_itens") == false && 
        stristr($param, "totalRows_itens") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_itens = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_itens = sprintf("&totalRows_itens=%d%s", $totalRows_itens, $queryString_itens);
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
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next", // "Next" button text
				closeTxt: "<div align='center'><button onclick='window.location = window.location'>Sair</button></div>" // "Close" button text
};		   
	$.superbox();
});

</script>
</head>

<body>
<div class="acao_pagina">Controle de Itens</div>
<form id="form1" name="form1" method="post" action="">
  <table border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Setor:</th>
      <td><label>
        <select name="setor" id="setor">
        <option value="%">Todos</option>
        <?php
			mysql_select_db($database_conn, $conn);
			$sql = "Select ucase(setor.setor) as setor from setor order by setor";
			$qr = mysql_query($sql) or die (mysql_error());
			while($resultado = mysql_fetch_assoc($qr)){
		?>
        <option value="<?php echo $resultado['setor']; ?>"><?php echo $resultado['setor']; ?></option>
        <?php }?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2"><div class="div_botoes">
        <label>
          <input type="submit" name="buscar" id="buscar" value="Buscar" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
<br />
<table width="700" border="0" align="center" class="KT_tngtable">
  <tr>
    <th width="72" scope="row">Cod</th>
    <th width="198">Setor</th>
    <th width="152">Descricao</th>
    <th width="58"><a href="itens_form.php" rel="superbox[iframe][700x500]" >Adicionar</a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td scope="row"><?php echo $row_setor['id_item']; ?></td>
      <td scope="row"><?php echo $row_setor['setor']; ?></td>
      <td scope="row"><?php echo $row_setor['desc_item']; ?></td>
      <td scope="row"><div align="center"><a href="itens_form.php?id_item=<?php echo $row_setor['id_item']; ?>" rel="superbox[iframe][700x500]" ><img src="../../img/005.gif" width="16" height="16" border="0" /></a></div></td>
    </tr>
    <?php } while ($row_setor = mysql_fetch_assoc($setor)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($setor);
?>
