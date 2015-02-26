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

$maxRows_equip = 10;
$pageNum_equip = 0;
if (isset($_GET['pageNum_equip'])) {
  $pageNum_equip = $_GET['pageNum_equip'];
}
$startRow_equip = $pageNum_equip * $maxRows_equip;
if(@$_GET['equipamento'] =="")
$equip = '%';
else
$equip = $_GET['equipamento'];

mysql_select_db($database_conn, $conn);
$query_equip = "select      `equipamento`.`equipamento` AS `equipamento`,     `equipamento`.`num_patrimonio` AS `num_patrimonio`,     `categ_equip`.`categ_equip` AS `categ_equip`,     `equipamento`.`id_equipamento` AS `id_equipamento`,     `setor`.`setor` AS `setor`    from      ((`categ_equip` join `equipamento` on((`categ_equip`.`id_cat_equip` = `equipamento`.`id_categoria`))) join `setor` on((`setor`.`id_setor` = `equipamento`.`setor`))) where equipamento like '%$equip%'";
$query_limit_equip = sprintf("%s LIMIT %d, %d", $query_equip, $startRow_equip, $maxRows_equip);
$equip = mysql_query($query_limit_equip, $conn) or die(mysql_error());
$row_equip = mysql_fetch_assoc($equip);

if (isset($_GET['totalRows_equip'])) {
  $totalRows_equip = $_GET['totalRows_equip'];
} else {
  $all_equip = mysql_query($query_equip);
  $totalRows_equip = mysql_num_rows($all_equip);
}
$totalPages_equip = ceil($totalRows_equip/$maxRows_equip)-1;

$queryString_equip = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_equip") == false && 
        stristr($param, "totalRows_equip") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_equip = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_equip = sprintf("&totalRows_equip=%d%s", $totalRows_equip, $queryString_equip);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../js/muda.js" type="text/javascript"></script>
</head>

<body><form id="form1" name="form1" method="GET" action="?equipamento=<?php echo $_GET['equipamento'];?>">
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Equipamento:</th>
    <td>
      <input name="equipamento" type="text" id="equipamento" onkeyup="maiusculo(this)" value="<?php echo $_GET['equipamento'];?>" size="70" maxlength="100"/>
   </td>
  </tr>
  <tr>
    <th colspan="2"><div align="center">
      <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
    </div></th>
  </tr>
</table></form>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr class="KT_row_order">
      <th id="equipamento">Cod</th>
      <th id="equipamento"> Equipamento</th>
      <th id="Setor"> Setor</th>
      <th id="id_cateoria"> Grupo</th>
      <th id="num_patrimonio"> No. patrimonio</th>
      <th><a href="equip_form.php">Adicionar</a></th>
    </tr>
    <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listequipamento1'] == 1) {
?>
    <?php } 
  // endif Conditional region3
?>

      <?php do { ?>
        <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
          <td><div><?php echo $row_equip['id_equipamento']; ?></div></td>
          <td><div><?php echo $row_equip['equipamento']; ?></div></td>
          <td><div><?php echo $row_equip['setor']; ?></div></td>
          <td><div><?php echo $row_equip['categ_equip']; ?></div></td>
          <td><div><?php echo $row_equip['num_patrimonio']; ?></div></td>
          <td align="center"><a href="equip_form.php?id_equip=<?php echo $row_equip['id_equipamento']; ?>"><img src="../../relatorio/images/edit.png" width="16" height="16" border="0" /></a></td>
        </tr>
        <?php } while ($row_equip = mysql_fetch_assoc($equip)); ?>
<tr>
      <th colspan="6"><div class="button" align="center"><a href="<?php printf("%s?pageNum_equip=%d%s", $currentPage, max(0, $pageNum_equip - 1), $queryString_equip); ?>">&lt;&lt;Anterior</a> <a href="<?php printf("%s?pageNum_equip=%d%s", $currentPage, min($totalPages_equip, $pageNum_equip + 1), $queryString_equip); ?>">Proximo&gt;&gt;</a></div></th>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($equip);
?>
