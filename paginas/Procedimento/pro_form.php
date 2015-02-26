<?php require_once('../../Connections/conn.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_conn = new KT_connection($conn, $database_conn);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("ID_AVAL", true, "numeric", "", "", "", "");
$formValidation->addField("PROC_DESC", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

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
$query_rs_aval = "Select * from avaliacao";
$rs_aval = mysql_query($query_rs_aval, $conn) or die(mysql_error());
$row_rs_aval = mysql_fetch_assoc($rs_aval);
$totalRows_rs_aval = mysql_num_rows($rs_aval);

// Make an insert transaction instance
$ins_procedimento = new tNG_multipleInsert($conn_conn);
$tNGs->addTransaction($ins_procedimento);
// Register triggers
$ins_procedimento->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_procedimento->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_procedimento->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_procedimento->setTable("procedimento");
$ins_procedimento->addColumn("ID_AVAL", "NUMERIC_TYPE", "POST", "ID_AVAL");
$ins_procedimento->addColumn("PROC_DESC", "STRING_TYPE", "POST", "PROC_DESC");
$ins_procedimento->setPrimaryKey("PROC_ID", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_procedimento = new tNG_multipleUpdate($conn_conn);
$tNGs->addTransaction($upd_procedimento);
// Register triggers
$upd_procedimento->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_procedimento->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_procedimento->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_procedimento->setTable("procedimento");
$upd_procedimento->addColumn("ID_AVAL", "NUMERIC_TYPE", "POST", "ID_AVAL");
$upd_procedimento->addColumn("PROC_DESC", "STRING_TYPE", "POST", "PROC_DESC");
$upd_procedimento->setPrimaryKey("PROC_ID", "NUMERIC_TYPE", "GET", "PROC_ID");

// Make an instance of the transaction object
$del_procedimento = new tNG_multipleDelete($conn_conn);
$tNGs->addTransaction($del_procedimento);
// Register triggers
$del_procedimento->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_procedimento->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_procedimento->setTable("procedimento");
$del_procedimento->setPrimaryKey("PROC_ID", "NUMERIC_TYPE", "GET", "PROC_ID");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsprocedimento = $tNGs->getRecordset("procedimento");
$row_rsprocedimento = mysql_fetch_assoc($rsprocedimento);
$totalRows_rsprocedimento = mysql_num_rows($rsprocedimento);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: false,
  show_as_grid: false,
  merge_down_value: false
}
</script>
</head>

<body>
<div class="pgn_acao" align="center">
    <?php 
// Show IF Conditional region1 
if (@$_GET['PROC_ID'] == "") {
?>
      <?php echo NXT_getResource("Incluir novo"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Alterar"); ?>
      <?php } 
// endif Conditional region1
?>
  Procedimento 
  <div class="frm_pesquisa">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsprocedimento > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="ID_AVAL_<?php echo $cnt1; ?>">Avaliação:</label></td>
            <td><select name="ID_AVAL_<?php echo $cnt1; ?>" id="ID_AVAL_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rs_aval['ID_AVAL']?>"<?php if (!(strcmp($row_rs_aval['ID_AVAL'], $row_rsprocedimento['ID_AVAL']))) {echo "SELECTED";} ?>><?php echo $row_rs_aval['DESC_AVAL']?></option>
              <?php
} while ($row_rs_aval = mysql_fetch_assoc($rs_aval));
  $rows = mysql_num_rows($rs_aval);
  if($rows > 0) {
      mysql_data_seek($rs_aval, 0);
	  $row_rs_aval = mysql_fetch_assoc($rs_aval);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("procedimento", "ID_AVAL", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="PROC_DESC_<?php echo $cnt1; ?>">PROC_DESC:</label></td>
            <td><input type="text" name="PROC_DESC_<?php echo $cnt1; ?>" id="PROC_DESC_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsprocedimento['PROC_DESC']); ?>" size="32" maxlength="50" />
              <?php echo $tNGs->displayFieldHint("PROC_DESC");?> <?php echo $tNGs->displayFieldError("procedimento", "PROC_DESC", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_procedimento_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsprocedimento['kt_pk_procedimento']); ?>" />
        <?php } while ($row_rsprocedimento = mysql_fetch_assoc($rsprocedimento)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['PROC_ID'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_aval);
?>
