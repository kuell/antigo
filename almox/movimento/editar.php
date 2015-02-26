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
$query_movAlmox = "Select  	`mov_almox`.id as cod,     data,     grupo.`descricao`,     tipo,     qtd,     mov_almox.valor as val from 	mov_almox inner join grupo on(`mov_almox`.`grupo` = grupo.`id`) where `mov_almox`.id = '".$_REQUEST['id']."'";
$movAlmox = mysql_query($query_movAlmox, $conn) or die(mysql_error());
$row_movAlmox = mysql_fetch_assoc($movAlmox);
$totalRows_movAlmox = mysql_num_rows($movAlmox);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include('../config.php'); ?>
<script type="text/javascript">
	function acao(){
		document.getElementById('funcao').value = 'atualiza'
		
		alert(document.getElementById('funcao').value)
		form1.submit()
		}


</script>
</head>

<body>
<div class="acao_pagina">Editar Movimento</div>
<form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="funcao" id="funcao" />
  <input type="hidden" name="grupo" id="grupo" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Cod</th>
      <th scope="col">Data</th>
      <th scope="col">Item</th>
      <th scope="col">Tipo</th>
      <th scope="col">Qtd</th>
      <th scope="col">Valor</th>
    </tr>
    <tr>
      <td><input name="id" type="text" id="id" value="<?php echo $row_movAlmox['cod']; ?>" readonly="readonly" /></td>
      <td><input name="data" type="text" id="data" value="<?php echo date('d-m-Y', strtotime($row_movAlmox['data'])); ?>" readonly="readonly" /></td>
      <td><?php echo $row_movAlmox['descricao']; ?></td>
      <td><label>
        <select name="select" id="select">
          <option value="1" <?php if (!(strcmp(1, $row_movAlmox['tipo']))) {echo "selected=\"selected\"";} ?>>Entrada normal</option>
          <option value="2" <?php if (!(strcmp(2, $row_movAlmox['tipo']))) {echo "selected=\"selected\"";} ?>>Devolução da saida</option>
          <option value="3" <?php if (!(strcmp(3, $row_movAlmox['tipo']))) {echo "selected=\"selected\"";} ?>>Saida normal</option>
          <option value="4" <?php if (!(strcmp(4, $row_movAlmox['tipo']))) {echo "selected=\"selected\"";} ?>>Devolução da entrada</option>
        </select>
      </label></td>
      <td><label>
        <input name="qtd" type="text" id="qtd" class="valor" value="<?php echo number_format($row_movAlmox['qtd'],2,',','.'); ?>" />
      </label></td>
      <td><label>
        <input name="valor" type="text" id="valor" class="valor" value="<?php echo number_format($row_movAlmox['val'],2,',','.'); ?>" />
      </label></td>
    </tr>
    <tr>
      <td colspan="6"><div class="div_botoes" align="center">
        <label>
          <input type="button" name="button" id="button" value="Atualizar" onclick="acao()" />
        </label>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($movAlmox);
?>
