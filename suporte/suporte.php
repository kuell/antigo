<?php require_once('../Connections/conn.php'); ?>
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
session_start();
mysql_select_db($database_conn, $conn);
$query_funcionario = "Select * from funcionario where id_funcionario = '".$_SESSION['kt_login_id']."'";
$funcionario = mysql_query($query_funcionario, $conn) or die(mysql_error());
$row_funcionario = mysql_fetch_assoc($funcionario);
$totalRows_funcionario = mysql_num_rows($funcionario);
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Suporte</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../js/muda.js" language="javascript"></script>
<script>
function sair(){
	window.close()	
	}
function valida(){
	if(document.fom1.assunto.value == "")
	alert ("O campo Assuto não pode ser Nulo");
	
	}

</script>

</head>

<body>
<div>
<form id="form1" name="form1" method="post" onsubmit="valida()" action="envia.php">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <td>Nome</td>
      <td>
        <input name="nome" type="text" id="nome" value="<?php echo $_SESSION['kt_login_user']; ?>" readonly="readonly" />
      </td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="email" type="text" id="email" value="<?php echo $row_funcionario['email']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Assunto</td>
      <td><input name="assunto" type="text" id="assunto" size="100" maxlength="100" onkeyup="maiusculo(this)" /></td>
    </tr>
    <tr>
      <td valign="top">Mensagem</td>
      <td><textarea name="mensagem" cols="100" rows="6" id="mensagem" onkeyup="maiusculo(this)"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><div align="center">
        <input type="submit" name="send" id="send" value="Enviar" />
        <input type="button" name="cancela" id="cancela" value="cancelar" onclick="sair()"/>
      </div></td>
      </tr>
  </table>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($funcionario);
?>
