<?php require_once('../../../../../relatorios/Connections/conn.php'); ?>
<?php
// Load the common classes
require_once('../../../../../relatorios/includes/common/KT_common.php');

// Load the tNG classes
require_once('../../../../../relatorios/includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../../");

// Make unified connection variable
$conn_conn = new KT_connection($conn, $database_conn);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM setor";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conn, $conn);
$query_Recordset2 = "SELECT * FROM equipamento";
$Recordset2 = mysql_query($query_Recordset2, $conn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_conn);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Custom1");
$customTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$customTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "../relatorio_geral.php");
// Add columns
$customTransaction->addColumn("Setor", "STRING_TYPE", "POST", "Setor");
$customTransaction->addColumn("Equipamento", "STRING_TYPE", "POST", "Equipamento");
// End of custom transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../../../../relatorios/includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../../../../relatorios/includes/common/js/base.js" type="text/javascript"></script>
<script src="../../../../../relatorios/includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../../../../relatorios/includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table width="50%" cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="Setor">Setor:</label></td>
      <td><select name="Setor" id="Setor">
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset1['id_setor']?>"<?php if (!(strcmp($row_Recordset1['id_setor'], $row_rscustom['Setor']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['setor']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("custom", "Setor"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="Equipamento">Equipamento:</label></td>
      <td><select name="Equipamento" id="Equipamento">
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset2['id_equipamento']?>"<?php if (!(strcmp($row_Recordset2['id_equipamento'], $row_rscustom['Equipamento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['equipamento']?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("custom", "Equipamento"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Custom1" id="KT_Custom1" value="Filtrar" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
