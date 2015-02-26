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
$formValidation->addField("nome", true, "text", "", "", "", "");
$formValidation->addField("setor", true, "numeric", "", "", "", "");
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
$query_setor = "Select * from setor";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);

// Make an insert transaction instance
$ins_requisitante = new tNG_multipleInsert($conn_conn);
$tNGs->addTransaction($ins_requisitante);
// Register triggers
$ins_requisitante->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_requisitante->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_requisitante->registerTrigger("END", "Trigger_Default_Redirect", 99, "resquisit_list.php");
// Add columns
$ins_requisitante->setTable("requisitante");
$ins_requisitante->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_requisitante->addColumn("setor", "NUMERIC_TYPE", "POST", "setor");
$ins_requisitante->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_requisitante->addColumn("celular", "STRING_TYPE", "POST", "celular");
$ins_requisitante->addColumn("ramal", "NUMERIC_TYPE", "POST", "ramal");
$ins_requisitante->setPrimaryKey("id_requisitante", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_requisitante = new tNG_multipleUpdate($conn_conn);
$tNGs->addTransaction($upd_requisitante);
// Register triggers
$upd_requisitante->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_requisitante->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_requisitante->registerTrigger("END", "Trigger_Default_Redirect", 99, "resquisit_list.php");
// Add columns
$upd_requisitante->setTable("requisitante");
$upd_requisitante->addColumn("nome", "STRING_TYPE", "POST", "nome");
$upd_requisitante->addColumn("setor", "NUMERIC_TYPE", "POST", "setor");
$upd_requisitante->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_requisitante->addColumn("celular", "STRING_TYPE", "POST", "celular");
$upd_requisitante->addColumn("ramal", "NUMERIC_TYPE", "POST", "ramal");
$upd_requisitante->setPrimaryKey("id_requisitante", "NUMERIC_TYPE", "GET", "id_requisitante");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsrequisitante = $tNGs->getRecordset("requisitante");
$row_rsrequisitante = mysql_fetch_assoc($rsrequisitante);
$totalRows_rsrequisitante = mysql_num_rows($rsrequisitante);
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
<script src="../../js/muda.js" type="text/javascript"></script>
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
if (@$_GET['id_requisitante'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Requisitante </div>
  <div class="KT_tngform">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" class="controle_form" id="form1">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsrequisitante > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="nome_<?php echo $cnt1; ?>">Nome:</label></td>
            <td><input type="text" name="nome_<?php echo $cnt1; ?>" id="nome_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsrequisitante['nome']); ?>" size="70" maxlength="50" onkeyup="maiusculo(this)" />
              <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("requisitante", "nome", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="setor_<?php echo $cnt1; ?>">Setor:</label></td>
            <td><select name="setor_<?php echo $cnt1; ?>" id="setor_<?php echo $cnt1; ?>">
              <option value="" <?php if (!(strcmp("", $row_rsrequisitante['setor']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Selecione"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_setor['id_setor']?>"<?php if (!(strcmp($row_setor['id_setor'], $row_rsrequisitante['setor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_setor['setor']?></option>
              <?php
} while ($row_setor = mysql_fetch_assoc($setor));
  $rows = mysql_num_rows($setor);
  if($rows > 0) {
      mysql_data_seek($setor, 0);
	  $row_setor = mysql_fetch_assoc($setor);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("requisitante", "setor", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label></td>
            <td><input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsrequisitante['email']); ?>" size="100" maxlength="100" onkeyup="minusculo(this)"/>
              <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("requisitante", "email", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="celular_<?php echo $cnt1; ?>">Celular:</label></td>
            <td><input type="text" name="celular_<?php echo $cnt1; ?>" id="celular_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsrequisitante['celular']); ?>" size="13" maxlength="13" />
              <?php echo $tNGs->displayFieldHint("celular");?> <?php echo $tNGs->displayFieldError("requisitante", "celular", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ramal_<?php echo $cnt1; ?>">Ramal:</label></td>
            <td><input type="text" name="ramal_<?php echo $cnt1; ?>" id="ramal_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsrequisitante['ramal']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("ramal");?> <?php echo $tNGs->displayFieldError("requisitante", "ramal", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_requisitante_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsrequisitante['kt_pk_requisitante']); ?>" />
        <?php } while ($row_rsrequisitante = mysql_fetch_assoc($rsrequisitante)); ?>
      <div class="KT_bottombuttons">
        <div class="div_botoes">
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id_requisitante'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Incluir"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Atualizar"); ?>" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancelar"); ?>" onclick="return UNI_navigateCancel(event, 'resquisit_list.php')" />
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
<?php
mysql_free_result($setor);
?>
