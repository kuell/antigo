<?php require_once ('../../Connections/conn.php');?>
<?php
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc()?stripslashes($theValue):$theValue;
		}

		$theValue = function_exists("mysql_real_escape_string")?mysql_real_escape_string($theValue):mysql_escape_string($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "")?"'".$theValue."'":"NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "")?intval($theValue):"NULL";
				break;
			case "double":
				$theValue = ($theValue != "")?doubleval($theValue):"NULL";
				break;
			case "date":
				$theValue = ($theValue != "")?"'".$theValue."'":"NULL";
				break;
			case "defined":
				$theValue = ($theValue != "")?$theDefinedValue:$theNotDefinedValue;
				break;
		}
		return $theValue;
	}
}

mysql_select_db($database_conn, $conn);
$query_abate     = "SELECT * FROM rh_info WHERE mes = '".$_REQUEST['mes']."' and ano = '".$_REQUEST['ano']."'";
$abate           = mysql_query($query_abate, $conn) or die(mysql_error());
$row_abate       = mysql_fetch_assoc($abate);
$totalRows_abate = mysql_num_rows($abate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../js/jquery.min.js"></script>
<script src="../../bibliotecas/mascara.js" type="text/javascript"></script>
<script src="../../js/muda.js" type="text/javascript"></script>
<script type="text/javascript">
	function meses(){
		mes = document.getElementById('mes').value
		if(mes > 12){
			alert("O mes não pode ser maior que 12")
			document.getElementById('mes').style.background = "#F00"
			document.getElementById('mes').focus()
			}
		}
	function busca(pagina){
		mes = document.getElementById('mes').value
		ano = document.getElementById('ano').value

		window.open(pagina+'?mes='+mes+'&ano='+ano, 'Busca', 'channelmode=1,scrollbars=yes')
		}

	function informar(){
		document.getElementById('mes_abate').value = document.getElementById('mes').value
		document.getElementById('ano_abate').value = document.getElementById('ano').value
		form2.submit()



		}

</script>
</head>

<body>
<div class="acao_pagina">Movimentação do Balanço RH</div>
<form id="form1" name="form1" method="get" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Ref. ao mês:</th>
      <td><label>
        <input name="mes" type="text" class="numero" id="mes" dir="rtl" onblur="meses()" value="<?php
if ($_REQUEST['mes'] == 0) {
	echo date('m');
} else {
	echo $_REQUEST['mes'];
}
?>" size="5" />
      </label>
        de
        <label>
          <input name="ano" type="text" id="ano" value="<?php if (empty($_REQUEST['ano'])) {
	echo date('Y');
} else {
	echo $_REQUEST['ano'];
}
?>" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><div align="center">
        <input type="submit" name="button3" id="button3" value="Informações Adicionais" />
        <input type="button" name="Button" id="button" value="Digitar Movimento" onclick="busca('bal_mov.php')" />
		<input type="button" name="Button" id="button" value="Fechamento Internos" onclick="busca('fechamentoInternos.php')" />
      </div></th>
    </tr>
  </table>
</form>
<?php if ($_REQUEST['mes'] == "" or $_REQUEST['ano'] == "") {} else {?>
			<form action="funcao.php" method="get">
			  <p>
			    <input type="hidden" name="mes_abate" id="mes_abate" />
			    <input type="hidden" name="ano_abate" id="ano_abate" />
			  </p>
			  <p>&nbsp;</p>
			  <table width="auto%" border="0" align="center" class="KT_tngtable">
			    <tr>
			      <th colspan="2" scope="row">Informações adicionais</th>
			    </tr>
			    <tr>
			      <th scope="row">Qtd. Animais</th>
			      <td><label>
			        <input name="qtd_abate" type="text" class="numero" id="qtd_abate" value="<?php echo number_format($row_abate['qtd'], 0, ',', '.');?>" />
			      </label></td>
			    </tr>
			    <tr>
			      <th scope="row">Peso Animais</th>
			      <td><label>
			        <input name="peso_abate" type="text" class="valor" id="peso_abate" value="<?php echo number_format($row_abate['peso'], 2, ',', '.');?>" />
			      </label></td>
			    </tr>
			    <tr>
			      <th scope="row">Faturamento Bruto:</th>
			      <td scope="row"><label>
			        <input name="fat" type="text" id="fat" value="<?php echo number_format($row_abate['fat'], 2, ',', '.');?>"  class="valor"/>
			      </label></td>
			    </tr>
			    <tr>
			      <th colspan="2" scope="row"><div class="div_botoes">
			        <label>
			          <input type="submit" name="funcao" id="funcao" value="Informar" onclick="informar()" />
			        </label>
			      </div></th>
			    </tr>
			  </table>
			</form>
	<?php }?>
</body>
</html>
<?php
mysql_free_result($abate);
?>
