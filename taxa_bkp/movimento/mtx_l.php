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
$mes = date('m') -1;
$data11 = date("Y-$mes-01");
	$data1 = date("Y-m-d", strtotime($data11));
	
	if($_REQUEST['data1'] <> ''){
		$data1 = date('Y-m-d', strtotime($_REQUEST['data1']));
		}
$data2 = date('Y-m-d');
	if($_REQUEST['data2'] <> ''){
		$data2 = date('Y-m-d', strtotime($_REQUEST['data2']));
		}
$cor = "%";
	if($_REQUEST['cor'] <> ''){
		$cor = $_REQUEST['cor'];
	}
mysql_select_db($database_conn, $conn);
$query_taxa = "SELECT * FROM taxamov where data between '$data1' and '$data2' and cor_nome like '$cor' order by cod desc";

$taxa = mysql_query($query_taxa, $conn) or die(mysql_error());
$row_taxa = mysql_fetch_assoc($taxa);
$totalRows_taxa = mysql_num_rows($taxa);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Lan&ccedil;amento de Taxas</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript">
$(function(){
		   $(".data").mask('99-99-9999');		   
		   })
</script>
</head>

<body>
<div class="acao_pagina">
  Controle de Movimento de Taxas
</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Periodo:</th>
      <td scope="col"><label>
        <input name="data1" type="text" class="data" id="data1" value="<?php echo date('d-m-Y', strtotime($data1)); ?>" />
      </label>
        a 
        <label>
          <input type="text" name="data2" id="data2" class="data" value="<?php echo date('d-m-Y', strtotime($data2))?>" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Corretor:</th>
      <td><label>
        <select name="cor" id="cor">   
        
		<?php
			if($_REQUEST['cor'] <> ''){	
			$sql = "Select * from corretor where cor_nome ='".$_REQUEST['cor']."' order by cor_ativo ";
			$query = mysql_query($sql) or die (mysql_error());
			while($res = mysql_fetch_assoc($query)){			
		?>     
        <option value="<?php echo $_REQUEST['cor_id'] ?>"><?php echo $res['cor_cod']?> - <?php echo $res['cor_nome'];?></option>
        <option value="">Todos</option>
        <?php }} else{	?>
            <option value="">Todos</option>
            <?php } ?>	
		
		
		<?php 
		$sql = "Select * from corretor";
		$query = mysql_query($sql) or die (mysql_error());
		while($res = mysql_fetch_assoc($query)){
		?>
        <option value="<?php echo $res['cor_nome']?>"><?php echo $res['cor_cod']?> - <?php echo $res['cor_nome']?></option>
        <?php } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
        <label>
          <input type="submit" name="button" id="button" value="Buscar" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
<br />
<table border="0" align="center" class="KT_tngtable">
  <tr>
    <th>Cod</th>
    <th>Data</th>
    <th>Corretor</th>
    <th>Lan&ccedil;amentos</th>
    <th>Tipo de Movimento</th>
    <th colspan="3"><a href="mtx_f.php">Adicionar</a></th>
  </tr>
  <?php if(!$row_taxa['Cod']){ ?>
  <tr>
  <td colspan="8">Não há registros!</td>
  </tr>
  <?php }else{ ?>
  <?php do { ?>
    <tr>
      <td><?php echo $row_taxa['Cod']; ?></td>
      <td><?php echo date("d-m-Y", strtotime($row_taxa['data'])); ?></td>
      <td><?php echo $row_taxa['cor_cod']." - ". $row_taxa['cor_nome']; ?></td>
      <td>
      <?php 
	  	$sql = "Select * from taxaDoc where id_tx = '".$row_taxa['Cod']."' ";
	  	$query = mysql_query($sql) or die (mysql_error());
		while($res = mysql_fetch_assoc($query)){
			echo wordwrap($res['item'].' ',15,'<br>');
		}
	  
	  ?>
      
      
      </td>
      <td><?php echo $row_taxa['tipo_movimento']; ?></td>
      <td><div align="center"><a href="mtx_f.php?cod=<?php echo $row_taxa['Cod']; ?>"><img src="../../img/edit.png" width="16" height="16" /></a></div></td>
      <td><div align="center"><a href="funcao.php?cod=<?php echo $row_taxa['Cod']; ?>&amp;action=exclui_mov"><img src="../../img/delete.png" alt="" width="16" height="16" /></a></div></td>
    </tr>
    <?php } while ($row_taxa = mysql_fetch_assoc($taxa)); }?>
</table>
</body>
</html>
<?php
mysql_free_result($taxa);
?>
