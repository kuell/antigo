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
$id = $_GET['id_OSE'];
mysql_select_db($database_conn, $conn);
$query_ordem = strtolower("Select * from Ordem_externa_vew where id_ose = '$id'");
$ordem = mysql_query($query_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);
$totalRows_ordem = mysql_num_rows($ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="funcao.js" ="javascript"></script>
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<script src="../../bibliotecas/mascara.js" type="text/javascript"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
<script type="text/javascript">
	function valida(acao){
		if( document.form1.preco.value == ""){
			alert("O campo Preco n�o pode ser nulo!")
			return false
			}
			return doPost('form1', acao)
		}

</script>
</head>

<body>
<div class="acao_pagina">Lan&ccedil;amento de Or&ccedil;amento</div>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="funcao.php">
  <input type="hidden" name="action" id="action" />
  <input name="id_OSE" type="hidden" id="id_OSE" value="<?php echo $row_ordem['id_OSE']; ?>" />
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="col">Codigo OSE:</th>
      <td scope="col"><?php echo $row_ordem['id_OSE']; ?></td>
      <th scope="col">Data de Envio:</th>
      <td scope="col"><?php echo date('d/m/Y', strtotime($row_ordem['data_envio'])); ?></td>
    </tr>
    <tr>
      <th>Requisitante:</th>
      <td><?php echo $row_ordem['requisitante']; ?></td>
      <th>Equipamento:</th>
      <td><?php echo $row_ordem['equipamento']; ?></td>
    </tr>
    <tr>
      <th>Setor</th>
      <td><?php echo $row_ordem['setor']; ?></td>
      <th>Servi&ccedil;o:</th>
      <td><?php echo $row_ordem['acao']; ?></td>
    </tr>
    <tr>
      <th>Empresa:</th>
      <td colspan="3"><?php echo $row_ordem['empresa']; ?></td>
    </tr>
    <tr>
      <th colspan="4"><div align="center">Dados do Or&ccedil;amento</div></th>
    </tr>
    <tr>
      <th>No. Or&ccedil;amento:</th>
      <td><label>
        <input name="orcamento" type="text" id="orcamento" value="<?php echo $row_ordem['Num_orcamento']; ?>" />
      </label></td>
      <th>Pre&ccedil;o do Servi&ccedil;o:</th>
      <td><label>
        <input class="valor" name="preco" type="text" id="preco" value="<?php echo $row_ordem['preco_servico']; ?>" />
      </label></td>
    </tr>
    <tr>
      <th>Or&ccedil;amento:</th>
      <td colspan="3"><input name="arquivo" type="file" id="arquivo" size="70" /></td>
    </tr>
    <tr>
      <th colspan="4"><div align="center">
        <label>
          <input type="submit" name="salva" id="salva" value="Salvar" onclick="valida('orcamento')"/>
        </label>
      </div></th>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
