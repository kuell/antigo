<?php require_once('../Connections/conn.php'); ?>
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
.style1 {color: #000000}
-->
 </style>
</head>
<body>
<table width="100%" border="1" align="center" cellpadding="4" cellspacing=" 0" bordercolor="#000000">
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing=" 0" cellpadding="0">
      <tr bgcolor="#FFFFCC">
        <td width="151" height="52" valign="top"><img src="../logo/Logo.png" alt="" width="150" height="50" /></td>
        <td align="left" bgcolor="#FFFFCC" valign="top"><div align="center"><b>Ordem Externa- No. <?php echo $row_rsOs['id_OSE']; ?><br />
          </b>Peri Alimentos Ltda.<br />
          BR 262 - KM 375 , TERENOS/MS - CEP - 79190-000<br />
          Fone: 3246-8100 E-mail: contato@perialimentos.com.br </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing=" 0" cellpadding="0">
      <tr>
        <td width="276"><b><font color="#000000">Equipamento: <?php echo $row_rsOs['equipamento']; ?></font></b><font color="#000000"><br />
          </font></td>
        <td width="176"><strong>Servi&ccedil;o: <?php echo $row_rsOs['acao']; ?></strong></td>
        <td width="176" valign="top"><strong>Data de Envio: <?php echo $row_rsOs['data_envio']; ?></strong></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="3" bordercolor="#000000" ><strong>Descri&ccedil;&atilde;o: </strong><?php echo $row_rsOs['descricao']; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left">
      <table width="100%" border="0" cellspacing=" 0" cellpadding="0">
        <tr>
          <td><div align="center"><b>DADOS 
            DA PRESTADORA </b></div></td>
        </tr>
        <tr>
          <td>
            <div align="center">
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td width="450" height="26"><b>Raz&atilde;o 
                    Social/Nome :</b><br />
                    <?php echo $row_rsOs['empresa']; ?>              </td>
                    <td><b>Endere&ccedil;o:</b> <span class="verdana"></span><span class="verdana"></span><br />                <?php echo $row_RsEmpresa['endereco']; ?></td>
                  </tr>
              </table>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td width="189"><strong>Bairro:</strong><br /> <?php echo $row_RsEmpresa['bairro']; ?></td>
                    <td width="146"><strong>Cidade:</strong><br /> <?php echo $row_RsEmpresa['cidade']; ?>/<?php echo $row_RsEmpresa['estado']; ?></td>
                    <td width="140"><strong>Telefones:<br /> <?php echo $row_RsEmpresa['telefone_celular']; ?>/<?php echo $row_RsEmpresa['telefone_comercial']; ?></strong></td>
                  </tr>
              </table>
            </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td width="50%"><div align="center">______________________________<br />
    (<?php echo $row_rsOs['requisitante']; ?>)</div></td>
    <td width="50%"><div align="center">______________________________<br />
    Representante (<?php echo $row_rsOs['empresa']; ?>)</div></td>
  </tr>
  <tr  bgcolor="#CCCCCC">
    <td colspan="2"><div align="center" class="style1">Favor enviar or&ccedil;amentos para o e-mail:<strong> almoxarifado@perialimentos.com.br </strong></div></td>
  </tr>
</table>
<hr />
<p>Corte Aqui </p>
<table width="100%" border="1" align="center" cellpadding="4" cellspacing=" 0" bordercolor="#000000">
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing=" 0" cellpadding="0">
      <tr bgcolor="#FFFFCC">
        <td width="151" height="60" valign="top"><img src="../logo/Logo.png" alt="" width="150" height="60" /></td>
        <td align="center" bgcolor="#FFFFCC" valign="top"><div align="center"><b>Ordem Externa- No. <?php echo $row_rsOs['id_OSE']; ?><br />
          </b>Peri Alimentos Ltda.<br />
          BR 262 - KM 375 , TERENOS/MS - CEP - 79190-000<br />
          Fone: 3246-8100 E-mail: contato@perialimentos.com.br </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing=" 0" cellpadding="0">
      <tr>
        <td width="276"><b><font color="#000000">Equipamento: <?php echo $row_rsOs['equipamento']; ?></font></b><font color="#000000"><br />
        </font></td>
        <td width="176"><strong>Servi&ccedil;o: <?php echo $row_rsOs['acao']; ?></strong></td>
        <td width="176" valign="top"><strong>Data de Envio: <?php echo $row_rsOs['data_envio']; ?></strong></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="3" bordercolor="#000000" ><strong>Descri&ccedil;&atilde;o: </strong><?php echo $row_rsOs['descricao']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left">
      <table width="100%" border="0" cellspacing=" 0" cellpadding="0">
        <tr>
          <td><div align="center"><b>DADOS 
            DA PRESTADORA </b></div></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="450"><b>Raz&atilde;o 
                Social/Nome :</b> <br />
                <?php echo $row_rsOs['empresa']; ?> </td>
              <td><b>Endere&ccedil;o:</b> <span class="verdana"></span><span class="verdana"></span><br />
                <?php echo $row_RsEmpresa['endereco']; ?></td>
            </tr>
          </table>
                <table width="100%" border="0" cellspacing="2" cellpadding="0">
                  <tr>
                    <td width="189"><strong>Bairro:</strong><br />
                        <?php echo $row_RsEmpresa['bairro']; ?></td>
                    <td width="146"><strong>Cidade:</strong><br />
                        <?php echo $row_RsEmpresa['cidade']; ?>/<?php echo $row_RsEmpresa['estado']; ?></td>
                    <td width="140"><strong>Telefones:<br />
                          <?php echo $row_RsEmpresa['telefone_celular']; ?>/<?php echo $row_RsEmpresa['telefone_comercial']; ?></strong></td>
                  </tr>
              </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td width="50%"><div align="center">______________________________<br />
    (<?php echo $row_rsOs['requisitante']; ?>)</div></td>
    <td width="50%"><div align="center">______________________________<br />
    Representante (<?php echo $row_rsOs['empresa']; ?>)</div></td>
  </tr>
  <tr  bgcolor="#CCCCCC">
    <td colspan="2"><div align="center" class="style1">Favor enviar or&ccedil;amentos para o e-mail:<strong> almoxarifado@perialimentos.com.br </strong></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsOs);

mysql_free_result($RsEmpresa);

mysql_free_result($master1acao);

mysql_free_result($detail2acao);
?>
