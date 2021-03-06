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
$query_setor = "Select *, ucase(setor) as setor from setor order by setor";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);

mysql_select_db($database_conn, $conn);
$query_agente = "Select id_funcionario, nome from funcionario where setor = 14 and ativo = 2";
$agente = mysql_query($query_agente, $conn) or die(mysql_error());
$row_agente = mysql_fetch_assoc($agente);
$totalRows_agente = mysql_num_rows($agente);

mysql_select_db($database_conn, $conn);
$query_registro = "Select * from registro_controle where id_registro = '".$_REQUEST['id']."'";
$registro = mysql_query($query_registro, $conn) or die(mysql_error());
$row_registro = mysql_fetch_assoc($registro);
$totalRows_registro = mysql_num_rows($registro);

mysql_select_db($database_conn, $conn);
$query_avaliacao = "SELECT * FROM avaliacao";
$avaliacao = mysql_query($query_avaliacao, $conn) or die(mysql_error());
$row_avaliacao = mysql_fetch_assoc($avaliacao);
$totalRows_avaliacao = mysql_num_rows($avaliacao);

$regMax = "select max(id_registro) as max from registro_controle";
$queryMax = mysql_query($regMax) or die (mysql_error());
$registroMax = mysql_fetch_assoc($queryMax);

if($_REQUEST['id'] == ""){
	$data = date('d-m-Y');
	$id = $registroMax['max'] + 1;
	}else{
	$id = $_REQUEST['id'];
	$data = date("d-m-Y", strtotime($row_registro['DATA_REGISTRO']));
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script type="text/javascript" src="funcao.js"></script>
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>
<script type="text/javascript" src="fbusca.js" ></script>
<script type="text/javascript">
$(function(){
		   $(".data").mask("99-99-9999")
		   $(".hora").mask("99:99")
		   $("textarea").blur(function(){
				muda = $(this).val().toUpperCase()
						$(this).val(muda)
									   })
		   })

function verifica(){
	campo = document.form1
	if(campo.data.value == "0"){
		alert('Campo Data n�o pode ser vazio');
		campo.data.focus()
		return false
		}
	if(campo.setor.value == "0"){
		alert('Campo Setor n�o pode ser vazio');
		campo.setor.focus()
		return false
		}
	if(campo.agente.value == "0"){
		alert('Campo agente n�o pode ser vazio');
		campo.agente.focus()
		return false
		}
	if(campo.agente.value == "0"){
		alert('Campo agente n�o pode ser vazio');
		campo.agente.focus()
		return false
		}
	if(campo.avaliacao.value == "0"){
		alert('Campo avaliacao n�o pode ser vazio');
		campo.avaliacao.focus()
		return false
		}
	if(campo.categoria.value == "0"){
		alert('Campo Categoria n�o pode ser vazio');
		campo.categoria.focus()
		return false
		}
	if(campo.sub.value == "0"){
		alert('Campo Sub-Categoria n�o pode ser vazio');
		campo.sub.focus()
		return false
		}
	if(campo.item.value == "0"){
		alert('Campo Item n�o pode ser vazio');
		campo.item.focus()
		return false
		}
	doPost('form1', 'salvar_registro')
	}
</script>

</head>

<body>
<div class="acao_pagina">Registro de Avalia&ccedil;&atilde;o</div><form id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="action" id="action" />
<table width="200" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="row">Codigo/Registro:</th>
    <td>
      <label>
        <input name="cod" type="text" id="cod" value="<?php echo $id;?>" readonly="readonly" />
      </label>
    </td>
  </tr>
  <tr>
    <th scope="row">Data/Registro:</th>
    <td><label>
      <input type="text" name="data" id="data" value="<?php echo $data;?>" class="data" />
    </label></td>
  </tr>
  <tr>
    <th scope="row">Hora:</th>
    <td><label>
      <input name="hora" type="text" id="hora" value="<?php echo $row_registro['HORA']; ?>" class="hora"/>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Setor:</th>
    <td><label>
      <select name="setor" id="setor" title="<?php echo $row_registro['setor']; ?>">
        <option value="0" <?php if (!(strcmp(0, $row_registro['ID_SETOR']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_setor['id_setor']?>"<?php if (!(strcmp($row_setor['id_setor'], $row_registro['ID_SETOR']))) {echo "selected=\"selected\"";} ?>><?php echo $row_setor['setor']?></option>
        <?php
} while ($row_setor = mysql_fetch_assoc($setor));
  $rows = mysql_num_rows($setor);
  if($rows > 0) {
      mysql_data_seek($setor, 0);
	  $row_setor = mysql_fetch_assoc($setor);
  }
?>
      </select>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Inspetor da Qualidade:</th>
    <td><label>
      <select name="agente" id="agente" title="<?php echo $row_registro['AGENTE']; ?>">
        <option value="0" <?php if (!(strcmp(0, $row_registro['FUNCIONARIO']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_agente['id_funcionario']?>"<?php if (!(strcmp($row_agente['id_funcionario'], $row_registro['FUNCIONARIO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_agente['nome']?></option>
        <?php
} while ($row_agente = mysql_fetch_assoc($agente));
  $rows = mysql_num_rows($agente);
  if($rows > 0) {
      mysql_data_seek($agente, 0);
	  $row_agente = mysql_fetch_assoc($agente);
  }
?>
      </select>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Tipo de Avalia&ccedil;&atilde;o:</th>
    <td><label>
      <select name="avaliacao" id="avaliacao" title="<?php echo $row_registro['AVALIACAO']; ?>">
        <option value="0" <?php if (!(strcmp(0, $row_registro['AVALIACAO']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_avaliacao['ID_AVAL']?>"<?php if (!(strcmp($row_avaliacao['ID_AVAL'], $row_registro['AVALIACAO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_avaliacao['DESC_AVAL']?></option>
        <?php
} while ($row_avaliacao = mysql_fetch_assoc($avaliacao));
  $rows = mysql_num_rows($avaliacao);
  if($rows > 0) {
      mysql_data_seek($avaliacao, 0);
	  $row_avaliacao = mysql_fetch_assoc($avaliacao);
  }
?>
      </select>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Categoria:</th>
    <td scope="row"><label>
      <select name="categoria" id="categoria" title="<?php echo $row_registro['CATEGORIA']; ?>">
      </select>
    </label></td>
    </tr>
  <tr>
    <th scope="row">Sub-Categoria:</th>
    <td scope="row"><label>
      <select name="sub" id="sub" title="<?php echo $row_registro['SUB_CATEGORIA']; ?>">
        <option value="Selecione ..."></option>
      </select>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Item:</th>
    <td scope="row"><label>
      <select name="itens" id="itens" title="<?php echo $row_registro['ITEM']; ?>">
        <option value="Selecione..."></option>
      </select>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Descri&ccedil;&atilde;o:</th>
    <td scope="row"><label>
      <textarea name="desc" cols="70" rows="5" id="desc"><?php echo $row_registro['DESC_NC']; ?></textarea>
    </label></td>
  </tr>
  <tr>
    <th scope="row">Quantidade:</th>
    <td scope="row"><label>
      <input name="qtd" type="text" class="numero" id="qtd" value="<?php echo $row_registro['QUANTIDADE']; ?>"/>
    </label></td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td scope="row">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="2" scope="row"><div class="div_botoes">
      <label>
        <input type="button" name="button" id="button" value="Incluir" onclick="verifica()" />
        <input type="button" name="button4" id="button4" value="Voltar" onclick="doPost('form1', 'voltar')" />
      </label>
    </div></th>
  </tr>
</table>
</form>

</body>
</html>
<?php
mysql_free_result($setor);

mysql_free_result($agente);

mysql_free_result($registro);

mysql_free_result($avaliacao);
?>
