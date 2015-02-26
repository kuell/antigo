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
$query_responsavel = "Select * from requisitante";
$responsavel = mysql_query($query_responsavel, $conn) or die(mysql_error());
$row_responsavel = mysql_fetch_assoc($responsavel);
$totalRows_responsavel = mysql_num_rows($responsavel);

mysql_select_db($database_conn, $conn);
$query_servico = "Select * from acao";
$servico = mysql_query($query_servico, $conn) or die(mysql_error());
$row_servico = mysql_fetch_assoc($servico);
$totalRows_servico = mysql_num_rows($servico);

mysql_select_db($database_conn, $conn);
$query_equip = "Select * from equipamento";
$equip = mysql_query($query_equip, $conn) or die(mysql_error());
$row_equip = mysql_fetch_assoc($equip);
$totalRows_equip = mysql_num_rows($equip);

mysql_select_db($database_conn, $conn);
$query_setor = "Select * from setor";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);

$colname_ordem_interna = "-1";
if (isset($_GET['id_osi'])) {
  $colname_ordem_interna = $_GET['id_osi'];
}
mysql_select_db($database_conn, $conn);
$query_ordem_interna = sprintf("SELECT * FROM ordem_interna WHERE id_osi = %s", GetSQLValueString($colname_ordem_interna, "int"));
$ordem_interna = mysql_query($query_ordem_interna, $conn) or die(mysql_error());
$row_ordem_interna = mysql_fetch_assoc($ordem_interna);
$totalRows_ordem_interna = mysql_num_rows($ordem_interna);
session_start();
if(@$_GET['id_osi'] == "")
	$colname_usuario = $_SESSION['kt_login_id'];
	else
	$colname_usuario = $row_ordem_interna['requisitante'];
	
mysql_select_db($database_conn, $conn);
$query_usuario = sprintf("SELECT * FROM funcionario WHERE id_funcionario = %s", GetSQLValueString($colname_usuario, "int"));
$usuario = mysql_query($query_usuario, $conn) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<script src="funcao.js" type="text/javascript"></script>
<script src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="acao_pagina"><?php if(@$_GET['id_osi'] == "")
									echo "Incluir Ordem de Serviço Interna";
								else
									echo "Alterar Ordem de Serviço Interna No. ".$row_ordem_interna['id_osi']; ?></div>
<form id="formulario" name="formulario" method="post" action="funcao.php">
  <input name="id_osi" type="hidden" id="id_osi" value="<?php echo $_GET['id_osi'];?>" />
<table width="auto%" border="0" align="center" class="KT_tngtable" style="border:1px #009 solid;">
       <tr>
        <th>Requisitante:</th>
        <td><input name="requisitante" type="text" disabled="disabled" id="requisitante" value="<?php echo $row_usuario['nome']; ?>" />
        </td>
      </tr>
       <tr>
        <th>Responsavel:</th>
        <td><select name="responsavel" id="responsavel">
          <option value="" <?php if (!(strcmp("", $row_ordem_interna['responsavel']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_responsavel['id_requisitante']?>"<?php if (!(strcmp($row_responsavel['id_requisitante'], $row_ordem_interna['responsavel']))) {echo "selected=\"selected\"";} ?>><?php echo $row_responsavel['nome']?></option>
          <?php
} while ($row_responsavel = mysql_fetch_assoc($responsavel));
  $rows = mysql_num_rows($responsavel);
  if($rows > 0) {
      mysql_data_seek($responsavel, 0);
	  $row_responsavel = mysql_fetch_assoc($responsavel);
  }
?>
        </select></td>
      </tr>
       <tr>
        <th>Servi&ccedil;o:</th>
        <td><select name="servico" id="servico">
          <option value="" <?php if (!(strcmp("", $row_ordem_interna['servico']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_servico['id_acao']?>"<?php if (!(strcmp($row_servico['id_acao'], $row_ordem_interna['servico']))) {echo "selected=\"selected\"";} ?>><?php echo $row_servico['acao']?></option>
          <?php
} while ($row_servico = mysql_fetch_assoc($servico));
  $rows = mysql_num_rows($servico);
  if($rows > 0) {
      mysql_data_seek($servico, 0);
	  $row_servico = mysql_fetch_assoc($servico);
  }
?>
        </select></td>
      </tr>
       <tr>
        <th>Equipamento:</th>
        <td><select name="equipamento" id="equipamento">
          <option value="" <?php if (!(strcmp("", $row_ordem_interna['equipamento']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_equip['id_equipamento']?>"<?php if (!(strcmp($row_equip['id_equipamento'], $row_ordem_interna['equipamento']))) {echo "selected=\"selected\"";} ?>><?php echo $row_equip['equipamento']?></option>
          <?php
} while ($row_equip = mysql_fetch_assoc($equip));
  $rows = mysql_num_rows($equip);
  if($rows > 0) {
      mysql_data_seek($equip, 0);
	  $row_equip = mysql_fetch_assoc($equip);
  }
?>
        </select></td>
      </tr>
       <tr>
         <th>Setor:</th>
         <td><select name="setor" id="setor">
           <option value="" <?php if (!(strcmp("", $row_ordem_interna['setor']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
           <?php
do {  
?>
           <option value="<?php echo $row_setor['id_setor']?>"<?php if (!(strcmp($row_setor['id_setor'], $row_ordem_interna['setor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_setor['setor']?></option>
           <?php
} while ($row_setor = mysql_fetch_assoc($setor));
  $rows = mysql_num_rows($setor);
  if($rows > 0) {
      mysql_data_seek($setor, 0);
	  $row_setor = mysql_fetch_assoc($setor);
  }
?>
         </select></td>
       </tr>
       <tr>
        <th>Descri&ccedil;&atilde;o:</th>
        <td><textarea name="descricao" cols="70" rows="7" id="descricao" onkeyup="maiusculo(this)"><?php echo $row_ordem_interna['obs']; ?></textarea></td>
      </tr>
      <tr>
        <th colspan="2"><div align="center">
        <?php if(@$_GET['id_osi'] == ""){?>
         <input type="button" name="salvar" id="salvar" value="Incluir" onclick="doPost('formulario', 'salvar')"  />
        <?php }else{?>
       
          <input type="button" name="editar" id="editar" value="Editar" onclick="doPost('formulario', 'editar')"/>
          <?php } ?>
        <input type="button" name="excluir" id="excluir" value="Voltar" onclick="doPost('formulario', 'voltar')"/></div>
        </th>
      </tr>
    </table>
<br />
      <input type="hidden" name="action" id="action" />
</form>
</body>
</html>
<?php
mysql_free_result($responsavel);

mysql_free_result($servico);

mysql_free_result($equip);

mysql_free_result($setor);

mysql_free_result($ordem_interna);

mysql_free_result($usuario);
?>
