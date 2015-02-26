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

$colname_rsOS = "-1";
if (isset($_GET['id'])) {
  $colname_rsOS = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_rsOS = sprintf("SELECT * FROM ordem_externa_vew WHERE id_OSE = %s", GetSQLValueString($colname_rsOS, "int"));
$rsOS = mysql_query($query_rsOS, $conn) or die(mysql_error());
$row_rsOS = mysql_fetch_assoc($rsOS);
$totalRows_rsOS = mysql_num_rows($rsOS);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Receber Equipamento</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../js/muda.js" type="text/javascript"></script>
<script src="funcao.js" type="text/javascript"></script>
<script type="text/javascript">
function valida(){
	if(document.getElementById('nota').value == ""){
		alert("O campo Nota Fiscal deve ser preenchido!");
		return false
	}else{
		doPost('form1', 'receber')
	}
}

</script>
</head>

<body><div class="acao_pagina">Informe o numero da Nota Fiscal ou Documento de Referencia</div>
<form method="post" id="form1" action="funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id" type="hidden" id="id" value="<?php echo $row_rsOS['id_OSE']; ?>" />
  <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th">Cod OSE:
      </td>
      <td><?php echo $row_rsOS['id_OSE']; ?></td>
    </tr>
    <tr>
      <td class="KT_th">Data/Envio: </td>
      <td><?php echo date('d/m/Y', strtotime($row_rsOS['data_envio'])); ?></td>
    </tr>
    <tr>
      <td class="KT_th">Empresa</td>
      <td><?php echo $row_rsOS['empresa']; ?></td>
    </tr>
    <tr>
      <td class="KT_th">Valor/Servi&ccedil;o: </td>
      <td><?php echo $row_rsOS['preco_servico']; ?></td>
    </tr>
    <tr>
      <td class="KT_th">Equipamento:</td>
      <td><?php echo $row_rsOS['equipamento']; ?></td>
    </tr>
    <tr>
      <td class="KT_th">Or&ccedil;amento No.</td>
      <td><?php echo $row_rsOS['Num_orcamento']; ?></td>
    </tr>
    <tr>
      <th valign="top">Descri&ccedil;&atilde;o</th>
      <td><label>
        <textarea name="textfield" cols="70" rows="5" disabled="disabled" readonly="readonly" id="textfield" style="overflow:hidden; border:none;"><?php echo $row_rsOS['descricao']; ?></textarea>
      </label></td>
    </tr>
    <tr class="KT_field_error">
      <td colspan="2" class="KT_th"><div align="center" class="KT_field_error">Informa&ccedil;&otilde;es de Recebimento</div></td>
    </tr>
    <tr>
      <td class="KT_th">Nota Fiscal:</td>
      <td><input name="nota" type="text" id="nota" size="32" maxlength="10" />
          </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="button" name="KT_Update1" id="KT_Update1" value="Receber" onclick="valida()" />      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsOS);

?>