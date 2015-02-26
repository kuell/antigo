<?php
  /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  error_reporting(0);
  @session_start();
  require_once("conexao.php");
  require_once("includes/tNG_functions.inc.php");
  mysql_select_db($database_conn, $conn);
  if (isset($_REQUEST["op"])) {
    $op=$_REQUEST["op"];
  } else { $op = "NOVO";   }
  if ((!isset($op)) || (isset($_REQUEST["MM_novo"]))) {
    $op = "NOVO";
  }
  if (!isset($_REQUEST["id_OSE"])) {
    $id_OSE = "-1";
  } else { $id_OSE = $_REQUEST["id_OSE"]; }

  if (isset($_POST["MM_insert"])) {

    $sql = sprintf("insert into ordem_externa_vew(id_OSE,data_envio,acao,empresa,preco_servico,data_receb,requisitante,status,equipamento,Num_orcamento,setor) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);",Formata($_POST["id_OSE"],"t"),Formata($_POST["data_envio"],"t"),Formata($_POST["acao"],"t"),Formata($_POST["empresa"],"t"),Formata($_POST["preco_servico"],"t"),Formata($_POST["data_receb"],"t"),Formata($_POST["requisitante"],"t"),Formata($_POST["status"],"t"),Formata($_POST["equipamento"],"t"),Formata($_POST["Num_orcamento"],"t"),Formata($_POST["setor"],"t"));
    $result = mysql_query($sql) or die(mysql_error());
    echo "<SCRIPT LANGUAGE=\"JavaScript\">alert(\"O cadastro foi inserido com sucesso!\");</script>";
    echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.location=\"ordem_externa_vew_lista.php?pgn=".$pgn."\";</script>";
  }
  if (isset($_POST["MM_delete"])) {
     $sql = sprintf("delete from ordem_externa_vew  where id_OSE= %s ",Formata($_POST["id_OSE"],"t"));
    $result = mysql_query($sql) or die(mysql_error());
    echo "<SCRIPT LANGUAGE=\"JavaScript\">alert(\"O cadastro foi excluido com sucesso!\");</script>";
    echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.location=\"ordem_externa_vew_lista.php?pgn=".$pgn."\";</script>";
  }
  if (isset($_POST["MM_atualiza"])) {

    $sql = sprintf("update ordem_externa_vew set data_envio= %s,acao= %s,empresa= %s,preco_servico= %s,data_receb= %s,requisitante= %s,status= %s,equipamento= %s,Num_orcamento= %s,setor= %s
     where id_OSE= %s ",Formata($_POST["data_envio"],"t"),Formata($_POST["acao"],"t"),Formata($_POST["empresa"],"t"),Formata($_POST["preco_servico"],"t"),Formata($_POST["data_receb"],"t"),Formata($_POST["requisitante"],"t"),Formata($_POST["status"],"t"),Formata($_POST["equipamento"],"t"),Formata($_POST["Num_orcamento"],"t"),Formata($_POST["setor"],"t"),Formata($_POST["id_OSE"],"t"));
    $result = mysql_query($sql) or die(mysql_error());
    echo "<SCRIPT LANGUAGE=\"JavaScript\">alert(\"O cadastro foi atualizado com sucesso!\");</script>";
    echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.location=\"ordem_externa_vew_lista.php?pgn=".$pgn."\";</script>";
    $id_OSE = $_POST["id_OSE"];
  }
  if ($op == "EDITA") {
    $sql = sprintf("SELECT id_OSE,data_envio,acao,empresa,preco_servico,data_receb,requisitante,status,equipamento,Num_orcamento,setor
      FROM ordem_externa_vew WHERE id_OSE = %s ",Formata($id_OSE,"t"));
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: Cadastro ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/estilo05.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="funcoes.js" type="text/javascript"></script>

</head>
<body>

<table width="100%" border="0" cellpadding="2" cellspacing="1" class="tableGeral" id="Nxt_tNG" align="center">
<tr><td bgcolor="#FFFFFF">

<table border="0" cellpadding="2" cellspacing="1" class="table00" id="Nxt_tNG" align="center">
<tr valign="baseline">
<td width="443" align="center" valign="bottom" class="td00">:: Cadastro ordem_externa_vew :: </td>
</tr>
</table>
<form name="frmCadastro" method="POST">
  <table border="0" cellpadding="2" cellspacing="1" class="table00" id="Nxt_tNG" align="center">
  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">id_OSE:</td>
    <td class="td0_1" align="left">
       <input type="text" name="id_OSE" class="inputbox" value="<?php echo $row["id_OSE"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">data_envio:</td>
    <td class="td0_1" align="left">
       <input type="text" name="data_envio" class="inputbox" value="<?php echo $row["data_envio"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">acao:</td>
    <td class="td0_1" align="left">
       <input type="text" name="acao" class="inputbox" value="<?php echo $row["acao"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">empresa:</td>
    <td class="td0_1" align="left">
       <input type="text" name="empresa" class="inputbox" value="<?php echo $row["empresa"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">preco_servico:</td>
    <td class="td0_1" align="left">
       <input type="text" name="preco_servico" class="inputbox" value="<?php echo $row["preco_servico"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">data_receb:</td>
    <td class="td0_1" align="left">
       <input type="text" name="data_receb" class="inputbox" value="<?php echo $row["data_receb"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">requisitante:</td>
    <td class="td0_1" align="left">
       <input type="text" name="requisitante" class="inputbox" value="<?php echo $row["requisitante"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">status:</td>
    <td class="td0_1" align="left">
       <input type="text" name="status" class="inputbox" value="<?php echo $row["status"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">equipamento:</td>
    <td class="td0_1" align="left">
       <input type="text" name="equipamento" class="inputbox" value="<?php echo $row["equipamento"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">Num_orcamento:</td>
    <td class="td0_1" align="left">
       <input type="text" name="Num_orcamento" class="inputbox" value="<?php echo $row["Num_orcamento"];?>" size="50" maxlength="50">
    </td>  </tr>

  <tr valign="baseline">
    <td nowrap align="right" class="td0_0">setor:</td>
    <td class="td0_1" align="left">
       <input type="text" name="setor" class="inputbox" value="<?php echo $row["setor"];?>" size="50" maxlength="50">
    </td>  </tr>

    <tr valign="baseline"><td height="28" valign="top" class="td0_2"><a href="ordem_externa_vew_lista.php?pgn=<?php echo $pgn;?>"><img src="images/lista.png" alt="Lista" border="0"></a>
</td>      <td nowrap colspan="2" align="right" class="td0_2">
      <?php if ($op == "NOVO") { ?>
        <input type="hidden" name="MM_insert" value="1">
        <input type="submit" name="btnInsert" value="Salva" class="back_button">
      <?php } ?>
      <?php if ($op == "EDITA") { ?>
        <input type="hidden" name="MM_atualiza" value="1">
        <input type="submit" name="btnAtualiza" value="Atualiza" class="back_button">
        <input type="submit" name="MM_delete" value="Apaga" onClick="return confirm('Apaga Realmente?');" class="back_button">

        <input type="button" name="MM_novo" value="Novo" class="back_button" onClick="window.location='ordem_externa_vew.php?pgn=<?php echo $pgn;?>&op=NOVO'">
      <?php } ?>
    </td></tr>
</table>

</form>

 </td>
 </tr>
</table>

</body>
</html>

<div align="center"><br>
  <font size="1" face="Verdana, Arial, Helvetica, sans-serif">Powered by GeradorPHP  v2.0</font>
</div>

