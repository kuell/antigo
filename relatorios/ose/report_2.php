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


if($_REQUEST['data_1'] == ""){
	$dia = 1;
	$data1 = date("Y-m-".$dia."");
	}
	else{
	$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));
	}
if($_REQUEST['data_2'] == ""){
	$data2 = date('Y-m-d');
	}
	else{
	$data2 = date('Y-m-d', strtotime($_REQUEST['data_2']));
	}
mysql_select_db($database_conn, $conn);
$query_rs_ordem = "
	select `setor`.`setor` as setor,     
		(select count(*) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') as registros_setor, 
		(select (((select count(*) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2')* 100)/(select count(*) from `ordem_externa_vew` where data_envio between '$data1' and '$data2' ))) as par_registro,     
		(Select	sum(preco_servico) from	`ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') as custo_setor,     
		((Select sum(preco_servico) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') * 100 / (select sum(preco_servico) from ordem_externa_vew where data_envio between '$data1' and '$data2')) as part_setor 
	from  	
		`setor` join ordem_externa_vew on(`setor`.`setor` = `ordem_externa_vew`.`setor`) 
	group by 	
		`setor`.`setor`;";
$rs_ordem = mysql_query($query_rs_ordem, $conn) or die(mysql_error());
$row_rs_ordem = mysql_fetch_assoc($rs_ordem);
$totalRows_rs_ordem = mysql_num_rows($rs_ordem);

mysql_select_db($database_conn, $conn);
$query_total = "SELECT (select count(*) FROM ordem_externa_vew where data_envio between '$data1' and '$data2') as total_registros, (select sum(preco_servico) from ordem_externa_vew where data_envio between '$data1' and '$data2') as total_custos";
$total = mysql_query($query_total, $conn) or die(mysql_error());
$row_total = mysql_fetch_assoc($total);
$totalRows_total = mysql_num_rows($total);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../../js/maskedinput.js" type="text/javascript"></script>
<script type="text/ecmascript">
	$(function(){
			$(".data").mask("99-99-9999");
			$("#print").click(function(){
											 $(this).css("display","none")
											 $("#form1 table").css("display","none")
											 PreVisualizar();
											 window.location = window.location
											 });
			
			   });

</script> 
<script>
function PreVisualizar() 
{
	try 
	{
		 //Utilizando o componente WebBrowser1 registrado no MS Windows Server 2000/2003 ou XP/Vista
		 var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
		 document.body.insertAdjacentHTML('beforeEnd', WebBrowser); 
		 WebBrowser1.ExecWB( 7, 1 ); 
		 WebBrowser1.outerHTML = ""; 
	} 
	catch(e) 
	{
		alert("Para visualizar a impressão você precisa habilitar o uso de controles ActiveX na página.");
		return;
	}
}
</script>
<style type="text/css">
	.KT_tngtable tr:hover{
		background:#CCC;
		cursor:default;
		}
</style>
</head>

<body>
<div align="center" class="acao_pagina">Relatorio Resumido por Setor<br />
</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto" border="0" align="center" class="KT_tngtable">
    <tr>
      <th class="div_botoes">De:</th>
      <td><input name="data_1" type="text" id="data" class="data" value="<?php echo date('d-m-Y', strtotime($data1)); ?>" /></td>
    </tr>
    <tr>
      <th class="div_botoes">At&eacute;:</th>
      <td><input type="text" name="data_2" id="data" class="data" value="<?php echo date('d-m-Y', strtotime($data2));?>"/></td>
    </tr>
    <tr>
      <th colspan="2"><div align="center">
        <input type="submit" name="button" id="button" value="buscar" />
        <label>
          <input type="submit" name="print" id="print" value="Visualizar" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
<br />
<table width="auto" border="0" align="center" class="KT_tngtable" id="custo" style="border:#000">
  <tr class="div_botoes">
    <th>Setor</th>
    <th>Registros</th>
    <th>Part. Registro</th>
    <th>Custo do Setor</th>
    <th>Part. no Custo</th>
  </tr>
  <?php do { ?>
    <tr bordercolor="#000000" style="font:10px Verdana, Geneva, sans-serif;">
      <td><a href="report_1.php?setor=<?php echo $row_rs_ordem['setor']; ?>"><?php echo $row_rs_ordem['setor']; ?></a></td>
      <td><div align="right"><?php echo	$row_rs_ordem['registros_setor']; ?></div></td>
      <td><div align="right"><?php echo number_format($row_rs_ordem['par_registro'], 2, ",", "."); ?> %</div></td>
      <td><div align="right">R$ <?php echo number_format($row_rs_ordem['custo_setor'], 2, ",", "."); ?></div></td>
      <td><div align="right"><?php echo number_format($row_rs_ordem['part_setor'], 2, ",", "."); ?> %</div></td>
    </tr>
    <?php } while ($row_rs_ordem = mysql_fetch_assoc($rs_ordem)); ?>
<tr bordercolor="#000000" class="div_botoes" style="font:10px Verdana, Geneva, sans-serif;">
<th>&nbsp;</th>
      <th>Total Registros</th>
<th><?php echo $row_total['total_registros']; ?></th>
      <th>Total Custos</th>
      <th>R$ <?php echo number_format($row_total['total_custos'], 2, ",", "."); ?></th>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_ordem);

mysql_free_result($total);
?>
