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
$formValidation->addField("setor", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_setor = new tNG_multipleInsert($conn_conn);
$tNGs->addTransaction($ins_setor);
// Register triggers
$ins_setor->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_setor->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_setor->registerTrigger("END", "Trigger_Default_Redirect", 99, "setor_list.php");
// Add columns
$ins_setor->setTable("setor");
$ins_setor->addColumn("setor", "STRING_TYPE", "POST", "setor");
$ins_setor->addColumn("encarregado", "STRING_TYPE", "POST", "encarregado");
$ins_setor->setPrimaryKey("id_setor", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_setor = new tNG_multipleUpdate($conn_conn);
$tNGs->addTransaction($upd_setor);
// Register triggers
$upd_setor->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_setor->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_setor->registerTrigger("END", "Trigger_Default_Redirect", 99, "setor_list.php");
// Add columns
$upd_setor->setTable("setor");
$upd_setor->addColumn("setor", "STRING_TYPE", "POST", "setor");
$upd_setor->addColumn("encarregado", "STRING_TYPE", "POST", "encarregado");
$upd_setor->setPrimaryKey("id_setor", "NUMERIC_TYPE", "GET", "id_setor");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rssetor = $tNGs->getRecordset("setor");
$row_rssetor = mysql_fetch_assoc($rssetor);
$totalRows_rssetor = mysql_num_rows($rssetor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
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
<div class="KT_tng">
  <div class="acao_pagina">
    <?php 
// Show IF Conditional region1 
if (@$_GET['id_setor'] == "") {
?>
      <?php echo NXT_getResource("Incluir"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Atualizar"); ?>
      <?php } 
// endif Conditional region1
?>
    Setor </div>
  <div class="KT_tngform">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" class="controle_form" id="form1">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rssetor > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable" align="center">
          <tr>
            <td class="KT_th"><label for="setor_<?php echo $cnt1; ?>">Setor:</label></td>
            <td><input type="text" name="setor_<?php echo $cnt1; ?>" id="setor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssetor['setor']); ?>" size="30" maxlength="30" />
              <?php echo $tNGs->displayFieldHint("setor");?> <?php echo $tNGs->displayFieldError("setor", "setor", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="encarregado_<?php echo $cnt1; ?>">Encarregado:</label></td>
            <td><input type="text" name="encarregado_<?php echo $cnt1; ?>" id="encarregado_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssetor['encarregado']); ?>" size="30" maxlength="30" />
              <?php echo $tNGs->displayFieldHint("encarregado");?> <?php echo $tNGs->displayFieldError("setor", "encarregado", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_setor_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rssetor['kt_pk_setor']); ?>" />
        <?php } while ($row_rssetor = mysql_fetch_assoc($rssetor)); ?>
      <div class="KT_bottombuttons">
        <div class="div_botoes">
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id_setor'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Incluir"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input name="KT_Update1" type="submit" id="KT_Update1" value="<?php echo NXT_getResource("Atualizar"); ?>" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, 'setor_list.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>
  <?php
	echo $tNGs->getErrorMsg();
?>
</p>
</body>
</html>