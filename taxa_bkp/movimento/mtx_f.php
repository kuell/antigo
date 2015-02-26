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
$sql = "Select max(cod) as result from taxamov";
$qr = mysql_query($sql) or dir (mysql_error());
$res = mysql_fetch_assoc($qr);

$query_mov = "SELECT * FROM taxamov where cod = '".$_REQUEST['cod']."'";
$mov = mysql_query($query_mov, $conn) or die(mysql_error());
$row_mov = mysql_fetch_assoc($mov);
$totalRows_mov = mysql_num_rows($mov);

if(!$_REQUEST['cod']){
	$id = $res['result']+1;
	$data = date("d-m-Y");
	}
	else
	{
	$id = $_REQUEST['cod'];
	$data = date("d-m-Y", strtotime($row_mov['data']));
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="funcao.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox.js"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript">

	$(function(){
		$("#data").mask("99-99-9999")
		})
	// função para o modal
	

$(function(){
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "KT_tngform", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' /> Carregando...", // Loading text
				closeTxt: "<button>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text

};		   
	$.superbox();
});	

</script>
</head>

<body>
<div class="acao_pagina">Controle de Taxas</div>
<form action="funcao.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <input type="hidden" name="action" id="action" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Cod. Movimento</th>
      <td><label>
        <input name="cod" type="text" id="cod" value="<?php echo $id;  ?>" readonly="readonly" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Data:</th>
      <td><label>
        <input name="data" type="text" id="data" value="<?php echo $data; ?>" />
      </label></td>
    </tr>
    <tr>
      <th scope="row">Corretor:</th>
      <td><label>
        <select name="cor" id="cor">
          <option value="">Selecione ...</option>
          <?php 
			mysql_select_db($database_conn, $conn);
			$sql = "Select * from corretor where cor_ativo = 1";
			$query = mysql_query($sql) or dir (mysql_error());
			while($row = mysql_fetch_assoc($query)){
		?>
          <option value="<?php echo $row['cor_id']?>"><?php echo $row['cor_cod'];?> - <?php echo $row['cor_nome']; ?></option>
		  <?php }?>
          <?php if($_REQUEST['cod'] == ''){ } else { ?>
          <option value="<?php echo $row_mov['cor_id']?>" selected="selected"><?php echo $row_mov['cor_cod']?> - <?php echo $row_mov['cor_nome']?></option>
			<?php } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th scope="row">Tipo de Movimento:</th>
      <td><label>
        <?php if(!$_REQUEST['cod']){ ?>
        <select name="tipoMov" id="tipoMov">
        <option value="" selected="selected">Selecione ...</option>
        <option value="1">A PAGAR</option>
		<option value="2">A RECEBER</option>
		<option value="3">IFORMATIVO</option>
        <?php }else{ ?>
        <select name="tipoMov" id="tipoMov">
   		<option value="<?php echo $row_mov['tipo_movimento']?>"><?php echo $row_mov['tipo_movimento']?></option>
        <option value="1">A PAGAR</option>
		<option value="2">A RECEBER</option>
		<option value="3">IFORMATIVO</option>
        <?php } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <th scope="row">Tipo de Documento:</th>
      <td scope="row"><select name="tpDoc" id="tpDoc">
        <option value="ROMANEIO">ROMANEIO</option>
        <option value="RECIBO">RECIBO</option>
        <option value="BOLETO">BOLETO</option>
        <option value="NENHUM">NENHUM</option>
      </select></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div class="div_botoes">
      <?php if(!$_REQUEST['cod']){ ?>
        <label>
          <input type="button" name="salvar" id="funcao" value="salvar" onclick="doPost('form1', 'salvar_mov')" />
        </label>
        <?php }else{ ?>
        <label>
          <input type="button" name="funcao" id="funcao" value="Atualiza" onclick="doPost('form1', 'edita_mov')" />
          <a href="incluir_produto.php?cod=<?php echo $id; ?>&data=<?php echo $data ?>" rel="superbox[iframe][1000x500]"> <input type="button" name="button3" id="button3" value="Adicionar Itens" /></a>
          <?php } ?>
          <input type="button" name="action" id="funcao" value="Voltar" onclick="doPost('form1', 'voltar')" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($mov);
?>
