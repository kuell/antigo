<?php require_once('../../Connections/conn.php'); ?>
<?php
$colname_rsOs = "-1";
if (isset($_GET['id_OSE'])) {
  $colname_rsOs = (get_magic_quotes_gpc()) ? $_GET['id_OSE'] : addslashes($_GET['id_OSE']);
}
mysql_select_db($database_conn, $conn);
$query_rsOs = sprintf("SELECT * FROM ordem_externa_vew WHERE id_OSE = %s", $colname_rsOs);
$rsOs = mysql_query($query_rsOs, $conn) or die(mysql_error());
$row_rsOs = mysql_fetch_assoc($rsOs);
$totalRows_rsOs = mysql_num_rows($rsOs);

$colname_RsEmpresa = "-1";
if (isset($_GET['id_empresa'])) {
  $colname_RsEmpresa = (get_magic_quotes_gpc()) ? $_GET['id_empresa'] : addslashes($_GET['id_empresa']);
}
mysql_select_db($database_conn, $conn);
$query_RsEmpresa = sprintf("SELECT * FROM empresas WHERE id_empresa = %s", $colname_RsEmpresa);
$RsEmpresa = mysql_query($query_RsEmpresa, $conn) or die(mysql_error());
$row_RsEmpresa = mysql_fetch_assoc($RsEmpresa);
$totalRows_RsEmpresa = mysql_num_rows($RsEmpresa);

mysql_select_db($database_conn, $conn);
$query_master1acao = "SELECT * FROM acao WHERE id_acao IS NULL ORDER BY id_acao";
$master1acao = mysql_query($query_master1acao, $conn) or die(mysql_error());
$row_master1acao = mysql_fetch_assoc($master1acao);
$totalRows_master1acao = mysql_num_rows($master1acao);

mysql_select_db($database_conn, $conn);
$query_detail2acao = "SELECT * FROM acao WHERE id_acao=12345 ORDER BY id_acao";
$detail2acao = mysql_query($query_detail2acao, $conn) or die(mysql_error());
$row_detail2acao = mysql_fetch_assoc($detail2acao);
$totalRows_detail2acao = mysql_num_rows($detail2acao);

$colname_rsEquip = "-1";
if (isset($_GET['id_equip'])) {
  $colname_rsEquip = (get_magic_quotes_gpc()) ? $_GET['id_equip'] : addslashes($_GET['id_equip']);
}
mysql_select_db($database_conn, $conn);
$query_rsEquip = sprintf("SELECT * FROM view_equipamentos WHERE id_equipamento = %s", $colname_rsEquip);
$rsEquip = mysql_query($query_rsEquip, $conn) or die(mysql_error());
$row_rsEquip = mysql_fetch_assoc($rsEquip);
$totalRows_rsEquip = mysql_num_rows($rsEquip);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="file:///Z|/Diversos/projetos/Scripts php/sistemaos/sistema/css/style.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript">
self.print ();
  </script>
 <style type="text/css">
<!--
.style7 {
	font-size: 1.5em;
	font-weight: bold;
}
.style9 {font-size: .7; font-weight: bold; }
.style10 {font-size: .7}
-->
 </style>
</head>
<body>
<table width="100%" border="1" align="center" cellpadding="4" cellspacing=" 0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellspacing=" 0" cellpadding="0">
      <tr bgcolor="#FFFFCC">
        <td width="151" height="52" valign="top"><img src="../logo/Logo.png" alt="" width="150" height="50" /></td>
        <td align="left" bgcolor="#FFFFCC" valign="top"><div align="center">Peri Alimentos Ltda.<br />
          BR 262 - KM 375 , TERENOS/MS - CEP - 79190-000<br />
          Fone: 3246-8100 E-mail: contato@perialimentos.com.br </div></td>
      </tr>
    </table></td>
  </tr>
  <tr bgcolor="#999999">
    <td><div align="center"><strong>Dados da Ordem de Servi&ccedil;o</strong></div></td>
  </tr>
  <tr>
    <td><div>
      <div align="center"><strong>Ordem de servi&ccedil;o No. </strong><span class="style9"><?php echo $row_rsOs['id_OSE']; ?>
        </span> </div>
      <table width="100%" border="0">
        <tr>
          <td width="50%">Equipamento: <span class="style9"><?php echo $row_rsOs['equipamento']; ?></span></td>
          <td width="50%">Setor do equipamento: <strong><?php echo $row_rsEquip['setor']; ?></strong></td>
        </tr>
        <tr>
          <td><span class="style10">Empresa:</span><span class="style9"><strong> <?php echo $row_rsOs['empresa']; ?></strong></span></td>
          <td>Data de envio: <strong><?php echo $row_rsOs['data_envio']; ?></strong></td>
        </tr>
        <tr>
          <td>Servi&ccedil;o prestado: <strong><?php echo $row_rsOs['acao']; ?></strong></td>
          <td>Requisitante: <strong><?php echo $row_rsOs['requisitante']; ?></strong></td>
        </tr>
        <tr>
          <td colspan="2">Descri&ccedil;&atilde;o: <strong><?php echo $row_rsOs['descricao']; ?></strong></td>
          </tr>
      </table>
    </div></td>
  </tr>
  <tr bgcolor="#999999">
    <td><div align="center"><strong>Dados do Or&ccedil;amento: </strong></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%">No. do Or&ccedil;amento: <strong><?php echo $row_rsOs['Num_orcamento']; ?></strong></td>
        <td width="50%">Valor do Or&ccedil;amento: <span class="style7"><?php echo $row_rsOs['preco_servico']; ?></span></td>
      </tr>
    </table></td>
  </tr>
</table><br />
<table width="16%" border="0" id="textfield1">
  <tr>
    <td width="22%" height="44">Aprovado:</td>
    <td width="78%"><p align="center"><strong>Sim (  			   )</strong><br />
        <strong>Não ( ) </strong></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsOs);

mysql_free_result($RsEmpresa);

mysql_free_result($master1acao);

mysql_free_result($detail2acao);

mysql_free_result($rsEquip);
?>
