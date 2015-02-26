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

$dia = date('d') -1;

if(!$_REQUEST['data1'] && !$_REQUEST['data2']){
	$data1 = date("Y-m-$dia");
	$data2 = date("Y-m-d");
	}
	else
	{
	$data1 = date('Y-m-d', strtotime($_REQUEST['data1']));
	$data2 = date('Y-m-d', strtotime($_REQUEST['data2']));
		}
mysql_select_db($database_conn, $conn);
$query_registros = "SELECT * FROM c_registro_controle WHERE digitacao_data between '$data1' and '$data2'";
$registros = mysql_query($query_registros, $conn) or die(mysql_error());
$row_registros = mysql_fetch_assoc($registros);
$totalRows_registros = mysql_num_rows($registros);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.3.1.js" type="text/javascript"></script>
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript" src="../../bibliotecas/mascara.js"></script>

<script type="text/javascript">
$(function(){
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' /> Carregando...", // Loading text
				closeTxt: "<button>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};	
	$(".data").mask("99-99-9999");
	$.superbox();
});

function exclui(id){
	if(confirm("Deseja realmente excluir o registro?")){
		window.location = 'funcao.php?action=excluir_registro&id='+id;
		}
	return false
	}

</script>
</head>

<body>
<div class="acao_pagina">Registros de Avalia&ccedil;&otilde;es</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Periodo:</th>
      <td scope="row"><label>
        <input type="text" name="data1" id="data1" value="<?php echo date("d-m-Y", strtotime($data1)); ?>"  class="data"/>
      </label></td>
      <th scope="row">a</th>
      <td scope="row"><input type="text" name="data2" id="data2" value="<?php echo date("d-m-Y", strtotime($data2)) ?>"  class="data"/></td>
    </tr>
    <tr>
      <th colspan="4" scope="row"><div align="center">
        <label>
          <input type="submit" name="button" id="button" value="Busca" />
        </label>
      </div></th>
    </tr>
  </table>
</form>
<br />
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">Cod</th>
    <th scope="col">Data/Avalia&ccedil;&atilde;o</th>
    <th scope="col">Setor</th>
    <th scope="col">Tipo Aval.</th>
    <th scope="col">Inspetor</th>
    <th scope="col">Qtd. N/C</th>
    <th colspan="2" scope="col"><a href="registro_form.php">Adicionar</a></th>
  </tr>

  <?php if(!$row_registros['COD']){ ?>
    <tr>
        <td colspan="8">Ainda n&atilde;o h&aacute; registros entre digitador entre estas datas.</td>
    </tr>
    <?php }else{ ?>
     <?php do { ?>
    <tr>
      <td><?php echo $row_registros['COD']; ?></td>
      <td><?php echo date('d/m/Y', strtotime($row_registros['DATA'])); ?> <?php echo $row_registros['HORA']; ?></td>
      <td><?php echo $row_registros['SETOR']; ?></td>
      <td><?php echo $row_registros['AVALIACAO']; ?></td>
      <td><?php echo $row_registros['AGENTE']; ?></td>
      <td><?php echo $row_registros['QUANTIDADE']; ?>
            </td>
      <td><a href="#" onclick="exclui('<?php echo $row_registros['COD']; ?>')"><div align="center" title="Excluir registro!"><img src="../../img/delete.png" width="16" height="16" border="0" /></div></a></td>
      <td><a href="visualiza.php?id_registro=<?php echo $row_registros['COD']; ?>" rel="superbox[iframe][800x500]"><img src="../../img/print.png" alt="" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_registros = mysql_fetch_assoc($registros)); ?>
    <?php } ?>
</table>
</body>
</html>
<?php
mysql_free_result($registros);
?>
