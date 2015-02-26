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
$id = $_REQUEST['cod'];

if(!$id){
	echo "Pagina não encontrada, por favor avise o administrador";
	error_reporting(404);
	
	}



mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM txproduto";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funcao.js"></script>
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../../bibliotecas/mascara.js" type="text/javascript"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
<script type="text/javascript">
	function validar(acao){
		if(document.getElementById('item').value == ""){
			alert("O campo Item não pode ser nulo")
			return false			
			}		
		if(document.getElementById('qtd').value == ""){
			alert("O campo Quantidade não pode ser nulo")
			return false			
			}
		if(document.getElementById('peso').value == ""){
			alert("O campo Peso não pode ser nulo")
			return false			
			}		
		return doPost('form1', acao)
		}
function exclui(id, cod,doc){
	if(confirm("Deseja realmente excluir o registro?")){
			   window.location = 'funcao.php?action=exclui_item&id_item='+id+'&cod='+cod+'&doc='+doc	 
			   }
	
	}
	</script>
</head>

<body>
<div class="acao_pagina">Adicionar Animais/Items no Movimento <?php echo $id; ?> </div>
<br />
<table border="0" align="center">
  <tr class="div_botoes">
    <th width="684" class="" scope="row"><form action="funcao.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table width="auto%" border="0" align="center" class="KT_tngtable">
        <tr>
          <th scope="row">Item</th>
          <th>Quantidade</th>
          <th>Peso</th>
          <th>Valor</th>
          <th>Observa&ccedil;&atilde;o</th>
          <th colspan="2">&nbsp;</th>
          </tr>
        <tr>
          <td scope="row"><label>
            <select name="item" id="item">
              <option value="">Selecione ...</option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['prod_id']?>"><?php echo $row_Recordset1['prod_desc']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
          </label></td>
          <td><label>
            <input name="qtd" type="text" class="valor" id="qtd" dir="rtl" size="20"  />
          </label></td>
          <td><input name="peso" type="text" id="peso" dir="rtl" size="20" class="valor"/></td>
          <td><label>
            <input name="valor" type="text"  id="valor" dir="rtl" size="20" class="valor" />
          </label></td>
          <td><input name="obs" type="text" id="obs" value="" size="70" /></td>
          <td colspan="2" valign="bottom"><a href="#" onclick="validar('incluir_item')" ><img src="../../img/ativo.gif" width="14" height="14" title="Adiciona" /></a></td>
          </tr>
        
      </table>
      <input type="hidden" name="action" id="action" />
      <input name="cod" type="hidden" id="cod" value="<?php echo $_REQUEST['cod']; ?>" />
    </form></th>
  </tr>
  <tr>
    <th scope="row">
    <title>Informa&ccedil;&otilde;es do registro</title>
    <table width="100%" border="0" align="center" class="KT_tngtable">
       <tr>
        <th scope="row">Tipo / Item</th>
        <th scope="row">Quantidade</th>
        <th scope="row">Peso</th>
        <th scope="row">Valor</th>
        <th scope="row">&nbsp;</th>
        </tr>
      <tr>
      <?php 
		$sql = "Select * from taxaDoc where id_tx = '".$id."'";
		$qr = mysql_query($sql) or die (mysql_error());
		while($reg = mysql_fetch_assoc($qr)){
	?>      
        <td scope="row"><?php echo $reg['tipo']; ?> - <?php echo $reg['item']; ?> (<?php echo $reg['unidade']; ?>)</td>
        <td scope="row"><?php echo $reg['qtd']; ?></td>
        <td scope="row"><?php echo number_format($reg['peso'],2,',','.'); ?></td>
        <td scope="row"><?php echo number_format($reg['valor'],2,',','.'); ?></td>
        <td scope="row"><div align="center"><a href="#" onclick="exclui('<?php echo $reg['cod']; ?>', '<?php echo $id;?>','<?php echo $reg['doc'] ?>')"><img src="../../img/delete.png" alt="" width="16" height="16" /></a></div></td>
        </tr>
      <?php } ?>
    </table></th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
