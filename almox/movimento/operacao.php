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
if(!empty($_REQUEST['id'])){
	$query_grupo = "Select 	
					a.id,
					a.descricao,
					a.quantidade,
					a.valor,
					b.`data`,
					b.`qtd` as qtd    
				from
					grupo a left join mov_almox b on(a.id = b.grupo)
				 where
				 	a.id = '".$_REQUEST['id']."'
				group by 
					a.id";
				}
else{
	$query_grupo = "Select 	
					a.id,
					a.descricao,
					a.quantidade,
					a.valor,
					b.`data`,
					b.`qtd` as qtd    
				from
					grupo a left join mov_almox b on(a.id = b.grupo)
				group by 
					a.id
				";
	
	}
					
$grupo = mysql_query($query_grupo, $conn) or die(mysql_error());
$row_grupo = mysql_fetch_assoc($grupo);
$totalRows_grupo = mysql_num_rows($grupo);
	function numero($num){
		return number_format($num,2,',','.');
		}
	
	define('data', date('Y-m-d',strtotime($_REQUEST['data'])));
	define('id', $_REQUEST['id']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimentação</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript" src="../../js/muda.js"></script>
<script type="text/javascript" src="js.js"></script>

</head>

<body>
<div class="acao_pagina">Movimentação Almoxarifado <?php echo date('d/m/Y', strtotime($_REQUEST['data'])); ?></div>
<br />
<form name="form" id="form">
  <input name="data" type="hidden" disabled="disabled" id="data" value="<?php echo data; ?>" />
  <table width="200" border="1" align="center" class="KT_tngtable">
    <tr>
      <th colspan="4" scope="col">Escolha o grupo:
        <select name="grupo" id="grupo" onchange="busca(this.value)">
          <option value="" <?php if(empty($_REQUEST['id'])){echo 'selected="selected"';} ?>>Selecione ...</option>
          <?php
do {  
?>
          <option value="<?php echo $row_grupo['id']?>" <?php if(!empty($_REQUEST['id'])){echo 'selected="selected"';} ?> ><?php echo $row_grupo['descricao']?></option>
          <?php
} while ($row_grupo = mysql_fetch_assoc($grupo));
  $rows = mysql_num_rows($grupo);
  if($rows > 0) {
      mysql_data_seek($grupo, 0);
	  $row_grupo = mysql_fetch_assoc($grupo);
  }
?>
      </select></th>
    </tr>
	<?php if(empty($_REQUEST['id'])){ } else{ ?>
    <tbody class="MXW_SMDCAL_visual_alert_div">
      <tr>
      <td>&nbsp;</td>
      <td>Quantidade</td>
      <td>Financeiro</td>
      <td>&nbsp;</td>
    </tbody>
    <tr>
      
    <?php 
		$sql = "Select 
					(Select quantidade from grupo where id = '".id."') as quantidade,
					(Select valor from grupo where id = '".id."') as valor,
					(Select qtd from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'Entrada') as entrada,
					(Select valor from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'Entrada') as val_entrada,
					(Select qtd from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'DevEntrada') as devEnt,
					(Select valor from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'DevEntrada') as val_devEnt,
					(Select qtd from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'DevSaida') as devSai,
					(Select valor from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'DevSaida') as val_devSai,
					(Select qtd from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'saida') as saida,
					(Select valor from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'saida') as val_saida,
					(Select qtd from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'ctf') as ctf,
					(Select valor from mov_almox where grupo = '".id."' and data = '".data."' and  tipo = 'ctf') as val_ctf				
					
				from
					mov_almox";
		$qr = mysql_query($sql) or die (mysql_error());
		$res = mysql_fetch_assoc($qr);
	
	?>
    <td>Estoque Atual:</td>
      <td><label>
        <input name="estoque_atual" type="text" disabled="disabled" id="estoque_atual" value="<?php echo numero($res['quantidade']); ?>" />
      </label></td>
      <td><input name="valor_atual" type="text" disabled="disabled" id="valor_atual" value="<?php echo 'R$ '.numero($res['valor']); ?>" /></td>
      <td>  </td>
    </tr>
    <tr>
      <td>Entrada</td>
      <td><label>
        <input name="qtd_entrada" type="text" id="qtd_entrada" class="qtd" value="<?php echo numero($res['entrada']); ?>" <?php if($res['entrada'] <> ''){
																																	echo 'disabled="disabled"';}?> />
      </label></td>
      <td><input name="val_entrada" type="text" id="val_entrada" class="valor" value="<?php echo numero($res['val_entrada']); ?>" <?php if($res['val_entrada'] <> ''){
																																	echo 'disabled="disabled"';}?> /></td>
      <td><?php if($res['val_entrada'] == "" && $res['entrada'] == ""){ ?>
     		<a href="#"><img src="../../img/ativo.gif" width="14" height="14" onclick="acao('entrada')" /></a>
      <?php }
	 	 else{ ?>
            <a href="#"><img src="../../img/delete.png" width="16" height="16" onclick="excluir('entrada')" /></a>
      <?php } ?>     
      </td>
    </tr>
    <tr>
      <td>Devolução de entrada</td>
      <td><input class="qtd" name="qtd_devEntrada" type="text" id="qtd_devEntrada" value="<?php echo numero($res['devEnt']); ?>" <?php if($res['devEnt'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><input name="val_devEntrada" type="text" class="valor" id="val_devEntrada" value="<?php echo numero($res['val_devEnt']); ?>" <?php if($res['val_devEnt'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><?php if($res['devEnt'] == "" && $res['val_devEnt'] == ""){ ?>
     		<a href="#"><img src="../../img/ativo.gif" width="14" height="14" onclick="acao('deventrada')" /></a>
      <?php }
	 	 else{ ?>
            <a href="#"><img src="../../img/delete.png" width="16" height="16" onclick="excluir('deventrada')" /></a>
      <?php } ?> </td>
    </tr>
    <tr>
      <td>Devolução de saida</td>
      <td><input class="qtd" name="qtd_devSaida" type="text" id="qtd_devSaida" value="<?php echo numero($res['devSai']); ?>" <?php if($res['devSai'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><input class="valor" name="val_devSaida" type="text" id="val_devSaida" value="<?php echo numero($res['val_devSai']); ?>" <?php if($res['val_devSai'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><?php if($res['devSai'] == "" && $res['val_devSai'] == ""){ ?>
     		<a href="#"><img src="../../img/ativo.gif" width="14" height="14" onclick="acao('devsaida')" /></a>
      <?php }
	 	 else{ ?>
            <a href="#"><img src="../../img/delete.png" width="16" height="16" onclick="excluir('devsaida')" /></a>
      <?php } ?> </td>
    </tr>
    <tr>
      <td>Saida</td>
      <td><input class="qtd" name="qtd_saida" type="text" id="qtd_saida" value="<?php echo numero($res['saida']); ?>"  <?php if($res['saida'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><input name="val_saida" class="valor" type="text" id="val_saida" value="<?php echo numero($res['val_saida']); ?>" <?php if($res['val_saida'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><?php if($res['saida'] == "" && $res['val_saida'] == ""){ ?>
     		<a href="#"><img src="../../img/ativo.gif" width="14" height="14" onclick="acao('saida')" /></a>
      <?php }
	 	 else{ ?>
            <a href="#"><img src="../../img/delete.png" width="16" height="16" onclick="excluir('saida')" /></a>
      <?php } ?> </td>
    </tr>
    <tr>
      <td>Contagem física</td>
      <td><input class="negativo" name="qtd_ctf" type="text" id="qtd_ctf" value="<?php echo numero($res['ctf']); ?>" <?php if($res['ctf'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><input class="negativo" name="val_ctf" type="text" id="val_ctf" value="<?php echo numero($res['val_ctf']); ?>" <?php if($res['val_ctf'] <> ''){
																																	echo 'disabled="disabled"';}?>/></td>
      <td><?php if($res['ctf'] == "" && $res['val_ctf'] == ""){ ?>
     		<a href="#"><img src="../../img/ativo.gif" width="14" height="14" onclick="acao('ctf')" /></a>
      <?php }
	 	 else{ ?>
            <a href="#"><img src="../../img/delete.png" width="16" height="16" onclick="excluir('ctf')" /></a>
      <?php } ?> </td>
    </tr>
    <tr>
      <th align="right">Total</th>
      <th><label>
        <input name="estoque" type="text" disabled="disabled" id="estoque" />
      </label></th>
      <th><label>
        <input name="valor" type="text" disabled="disabled" id="valor" />
      </label></th>
      <th><input type="button" name="button" id="button" value="Calcular"  onclick="calcula()"/></th>
    </tr>
	<?php }?>
  </table>
</form>
</body>
</html>
