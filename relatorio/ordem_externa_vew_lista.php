<?php
  /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  @session_start();
  require_once("conexao.php");
  require_once("includes/tNG_functions.inc.php");
  mysql_select_db($database_conn, $conn);
  require_once("includes/nextensio2/language/ptbr.php");
  require_once("includes/nextensio2/nxtlist.inc.php");
  $KTNL_lstordem_externa_vew = new NxtList("KTNL_lstordem_externa_vew");

  $KTNL_lstordem_externa_vew->addColumn("id_OSE", STRING_TYPE);
  $KTNL_lstordem_externa_vew->addColumn("data_envio", STRING_TYPE);
  $KTNL_lstordem_externa_vew->addColumn("acao", STRING_TYPE);
  $KTNL_lstordem_externa_vew->addColumn("empresa", STRING_TYPE);
  $KTNL_lstordem_externa_vew->addColumn("setor", STRING_TYPE);
  $KTNL_lstordem_externa_vew->setDefaultFilter("");
  $KTNL_lstordem_externa_vew->setConnection($conn, $database_conn);
  $KTNL_lstordem_externa_vew->setTable("ordem_externa_vew");
  $KTNL_lstordem_externa_vew->setPrimaryKey("id_OSE");
  $currentPage = $_SERVER["PHP_SELF"];
  $KTNL_lstordem_externa_vew->computeAll();
  $KT_WhereDef = $KTNL_lstordem_externa_vew->getWhereCondition();
  $maxRows_ordem_externa_vew = 30;
  $pgn = 0;
  if (isset($_GET["pgn"])) {
    $pgn = $_GET["pgn"];
  }
  $startRow_ordem_externa_vew = $pgn * $maxRows_ordem_externa_vew;
  $KTWhereDefParam_ordem_externa_vew = "1=1";
  if (isset($KT_WhereDef)) {
     $KTWhereDefParam_ordem_externa_vew = $KT_WhereDef;
  }

  $query_ordem_externa_vew = sprintf("select * FROM ordem_externa_vew WHERE %s order by id_OSE ASC", $KTWhereDefParam_ordem_externa_vew);
  $query_limit_ordem_externa_vew = sprintf("%s LIMIT %d, %d", $query_ordem_externa_vew, $startRow_ordem_externa_vew, $maxRows_ordem_externa_vew);
  $ordem_externa_vew = mysql_query($query_limit_ordem_externa_vew, $conn) or die(mysql_error());
  $row_ordem_externa_vew = mysql_fetch_array($ordem_externa_vew);
  if (isset($_GET["totalRows_ordem_externa_vew"])) {
    $totalRows_ordem_externa_vew = $_GET["totalRows_ordem_externa_vew"];
  } else {
    $all_ordem_externa_vew = mysql_query($query_ordem_externa_vew);
    $totalRows_ordem_externa_vew = mysql_num_rows($all_ordem_externa_vew);
  }
  $totalPages_ordem_externa_vew = ceil($totalRows_ordem_externa_vew/$maxRows_ordem_externa_vew)-1;
  $queryString_ordem_externa_vew = "";
  if (!empty($_SERVER["QUERY_STRING"])) {
    $params = explode("&", $_SERVER["QUERY_STRING"]);
    $newParams = array();
    foreach ($params as $param) {
      if (stristr($param, "pgn") == false &&
       stristr($param, "totalRows_ordem_externa_vew") == false) {
       array_push($newParams, $param);
      }
    }
    if (count($newParams) != 0) {
       $queryString_ordem_externa_vew = "&" . htmlentities(implode("&", $newParams));
    }
  }
  $queryString_ordem_externa_vew = sprintf("&totalRows_ordem_externa_vew=%d%s", $totalRows_ordem_externa_vew, $queryString_ordem_externa_vew);
  $NxtAltColor = 0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title> Listagem de ordem_externa_vew</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/estilo05.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="100%" border="0" cellpadding="2" cellspacing="1" class="tableGeral" id="Nxt_tNG" align="center">
<tr>
<td bgcolor="#FFFFFF">
<table id="NxtList" border="0" cellpadding="2" cellspacing="1" align="center" class="table00L">
<tr>
<td class="td00" align="center" nowrap colspan="3"><b> :: Listagem de ordem_externa_vew :: </b></td>
</tr>
<tr>

<th width="100" class="td0_0" valign="baseline"  align=center nowrap>id_OSE</th>
<th width="100" class="td0_0" valign="baseline"  align=center nowrap>data_envio</th>
<th width="100" class="td0_0" valign="baseline"  align=center nowrap>acao</th>
<th width="100" class="td0_0" valign="baseline"  align=center nowrap>empresa</th>
<th width="100" class="td0_0" valign="baseline"  align=center nowrap>setor</th>

</tr>
<form name="NXTFilter" method="POST" action="ordem_externa_vew_lista.php?pgn=<?php echo $pgn;?>">
  <tr>

  <td class="td0_2" nowrap align="left"><input class="inputbox" type="text" name="KTNL_lstordem_externa_vew_F[id_OSE]" value="<?php echo htmlentities(stripslashes(@$HTTP_SESSION_VARS["KTNL_lstordem_externa_vew_F"]["id_OSE"])); ?>" size="20" maxlength="20">
  </td>
  <td class="td0_2" nowrap align="left"><input class="inputbox" type="text" name="KTNL_lstordem_externa_vew_F[data_envio]" value="<?php echo htmlentities(stripslashes(@$HTTP_SESSION_VARS["KTNL_lstordem_externa_vew_F"]["data_envio"])); ?>" size="10" maxlength="10">
  </td>
  <td class="td0_2" nowrap align="left"><input class="inputbox" type="text" name="KTNL_lstordem_externa_vew_F[acao]" value="<?php echo htmlentities(stripslashes(@$HTTP_SESSION_VARS["KTNL_lstordem_externa_vew_F"]["acao"])); ?>" size="20" maxlength="20">
  </td>
  <td class="td0_2" nowrap align="left"><input class="inputbox" type="text" name="KTNL_lstordem_externa_vew_F[empresa]" value="<?php echo htmlentities(stripslashes(@$HTTP_SESSION_VARS["KTNL_lstordem_externa_vew_F"]["empresa"])); ?>" size="50" maxlength="50">
  </td>
  <td class="td0_2" nowrap align="left"><input class="inputbox" type="text" name="KTNL_lstordem_externa_vew_F[setor]" value="<?php echo htmlentities(stripslashes(@$HTTP_SESSION_VARS["KTNL_lstordem_externa_vew_F"]["setor"])); ?>" size="20" maxlength="20">
  </td>

  <td class="td0_2"><input type="submit" class="back_button" name="submit" value="<?php echo $KT_language["filter"];?>">
  </td>
  </tr>
</form>
<?php if ($totalRows_ordem_externa_vew == 0) { ?>
  <tr>
  <td class="td0_2" colspan=3><?php echo $KT_language["emptyRS"];?></td>
  </tr>
  <?php } ?>
  <?php if ($totalRows_ordem_externa_vew > 0) { ?>
  <form method="POST" name="NXTFields">
   <?php
      $td = "td0_3";
      do {
        if ($td == "td0_3") {
          $td = "td0_2";
        } else {
          $td = "td0_3";
        }
    ?>
      <tr>

      <td height="17" align=left valign="baseline" nowrap class="<?php echo $td;?>"><?php echo htmsubstr($row_ordem_externa_vew["id_OSE"],0,50);?></td>
      <td height="17" align=left valign="baseline" nowrap class="<?php echo $td;?>"><?php echo htmsubstr($row_ordem_externa_vew["data_envio"],0,50);?></td>
      <td height="17" align=left valign="baseline" nowrap class="<?php echo $td;?>"><?php echo htmsubstr($row_ordem_externa_vew["acao"],0,50);?></td>
      <td height="17" align=left valign="baseline" nowrap class="<?php echo $td;?>"><?php echo htmsubstr($row_ordem_externa_vew["empresa"],0,50);?></td>
      <td height="17" align=left valign="baseline" nowrap class="<?php echo $td;?>"><?php echo htmsubstr($row_ordem_externa_vew["setor"],0,50);?></td>

    <?php } while ($row_ordem_externa_vew = mysql_fetch_array($ordem_externa_vew)); ?>
  </form>
<?php } ?>

<tr>
<td class="td0_2" colspan=3><table cellpadding=2 cellspacing=0 border=0 width=100%>
  <tr align=right>
    <td><table border="0" width="120" align="left">
        <tr>
          <td width="23%" align="center"><?php if ($pgn > 0) { ?>
            <a class="nxta" href="<?php printf("%s?pgn=%d%s", $currentPage, 0, $queryString_ordem_externa_vew); ?>"><img src="images/nbar/First_off.gif" border=0 alt="<?php echo $KT_language["first"];?>" onMouseOver="this.src='images/nbar/First_on.gif'" onMouseOut="this.src='images/nbar/First_off.gif'"></a>
            <?php } ?>
            <?php if ($pgn == 0) { ?>
            <img src="images/nbar/First.gif" border=0>
            <?php } ?>
          </td>
          <td width="31%" align="center"><?php if ($pgn > 0) { ?>
            <a class="nxta" href="<?php printf("%s?pgn=%d%s", $currentPage, max(0, $pgn - 1), $queryString_ordem_externa_vew); ?>"><img src="images/nbar/Previous_off.gif" border=0 alt="<?php echo $KT_language["prev"];?>" onMouseOver="this.src='images/nbar/Previous_on.gif'" onMouseOut="this.src='images/nbar/Previous_off.gif'"></a>
            <?php } ?>
            <?php if ($pgn == 0) { ?>
            <img src="images/nbar/Previous.gif" border=0>
            <?php } ?>
          </td>

          <td width="23%" align="center"><?php if ($pgn < $totalPages_ordem_externa_vew) { ?>
            <a class="nxta" href="<?php printf("%s?pgn=%d%s", $currentPage, min($totalPages_ordem_externa_vew, $pgn + 1), $queryString_ordem_externa_vew); ?>"><img src="images/nbar/Next_off.gif" border=0 alt="<?php echo $KT_language["next"];?>" onMouseOver="this.src='images/nbar/Next_on.gif'" onMouseOut="this.src='images/nbar/Next_off.gif'"></a>
            <?php } ?>
            <?php if ($pgn >= $totalPages_ordem_externa_vew) { ?>
            <img src="images/nbar/Next.gif" border=0>
            <?php } ?>
          </td>
          <td width="23%" align="center"><?php if ($pgn < $totalPages_ordem_externa_vew) { ?>
            <a class="nxta" href="<?php printf("%s?pgn=%d%s", $currentPage, $totalPages_ordem_externa_vew, $queryString_ordem_externa_vew); ?>"><img src="images/nbar/Last_off.gif" border=0 alt="<?php echo $KT_language["last"];?>" onMouseOver="this.src='images/nbar/Last_on.gif'" onMouseOut="this.src='images/nbar/Last_off.gif'"></a>
            <?php } ?>
            <?php if ($pgn >= $totalPages_ordem_externa_vew) {?>
            <img src="images/nbar/Last.gif" border=0>
            <?php } ?>
          </td>
        </tr>
    </table></td>
    <form name="addNew" method="post" action="ordem_externa_vew.php?pgn=<?php echo $pgn;?>">
      <td align="right"><input class="back_button" type="submit" name="submit" value="<?php echo $KT_language["new"];?>">
          <input type="hidden" name="KT_FormState" value="VIEW">
      </td>
    </form>
   </tr>
   </table></td>
   </tr>
  </table>

 </td>
</tr>
</table>
</td>
</tr>
</table>
<div align="center"><br>
  <font size="1" face="Verdana, Arial, Helvetica, sans-serif">Powered by GeradorPHP  v2.0</font>
</div>

