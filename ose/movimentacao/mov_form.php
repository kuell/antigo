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
$formValidation->addField("id_Requisitante", true, "numeric", "", "", "", "");
$formValidation->addField("id_Equipamento", true, "numeric", "", "", "", "");
$formValidation->addField("id_prestadora", true, "numeric", "", "", "", "");
$formValidation->addField("id_servico", true, "numeric", "", "", "", "");
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
$query_REQUISITANTE = "SELECT * FROM requisitante";
$REQUISITANTE = mysql_query($query_REQUISITANTE, $conn) or die(mysql_error());
$row_REQUISITANTE = mysql_fetch_assoc($REQUISITANTE);
$totalRows_REQUISITANTE = mysql_num_rows($REQUISITANTE);

mysql_select_db($database_conn, $conn);
$query_EQUIPAMENTO = strtolower("SELECT * FROM EQUIPAMENTO order by equipamento");
$EQUIPAMENTO = mysql_query($query_EQUIPAMENTO, $conn) or die(mysql_error());
$row_EQUIPAMENTO = mysql_fetch_assoc($EQUIPAMENTO);
$totalRows_EQUIPAMENTO = mysql_num_rows($EQUIPAMENTO);

mysql_select_db($database_conn, $conn);
$query_PRESTADORA = strtolower("SELECT * FROM EMPRESAS");
$PRESTADORA = mysql_query($query_PRESTADORA, $conn) or die(mysql_error());
$row_PRESTADORA = mysql_fetch_assoc($PRESTADORA);
$totalRows_PRESTADORA = mysql_num_rows($PRESTADORA);

mysql_select_db($database_conn, $conn);
$query_SERVICO = strtolower("SELECT * FROM ACAO");
$SERVICO = mysql_query($query_SERVICO, $conn) or die(mysql_error());
$row_SERVICO = mysql_fetch_assoc($SERVICO);
$totalRows_SERVICO = mysql_num_rows($SERVICO);

// Make an insert transaction instance
$ins_ordem_externa = new tNG_multipleInsert($conn_conn);
$tNGs->addTransaction($ins_ordem_externa);
// Register triggers
$ins_ordem_externa->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_ordem_externa->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_ordem_externa->registerTrigger("END", "Trigger_Default_Redirect", 99, "mov_list.php");
// Add columns
$ins_ordem_externa->setTable("ordem_externa");
$ins_ordem_externa->addColumn("id_Requisitante", "NUMERIC_TYPE", "POST", "id_Requisitante");
$ins_ordem_externa->addColumn("id_Equipamento", "NUMERIC_TYPE", "POST", "id_Equipamento");
$ins_ordem_externa->addColumn("id_prestadora", "NUMERIC_TYPE", "POST", "id_prestadora");
$ins_ordem_externa->addColumn("id_servico", "NUMERIC_TYPE", "POST", "id_servico");
$ins_ordem_externa->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_ordem_externa->setPrimaryKey("id_OSE", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_ordem_externa = new tNG_multipleUpdate($conn_conn);
$tNGs->addTransaction($upd_ordem_externa);
// Register triggers
$upd_ordem_externa->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_ordem_externa->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_ordem_externa->registerTrigger("END", "Trigger_Default_Redirect", 99, "mov_list.php");
// Add columns
$upd_ordem_externa->setTable("ordem_externa");
$upd_ordem_externa->addColumn("id_Requisitante", "NUMERIC_TYPE", "POST", "id_Requisitante");
$upd_ordem_externa->addColumn("id_Equipamento", "NUMERIC_TYPE", "POST", "id_Equipamento");
$upd_ordem_externa->addColumn("id_prestadora", "NUMERIC_TYPE", "POST", "id_prestadora");
$upd_ordem_externa->addColumn("id_servico", "NUMERIC_TYPE", "POST", "id_servico");
$upd_ordem_externa->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_ordem_externa->setPrimaryKey("id_OSE", "NUMERIC_TYPE", "GET", "id_OSE");

// Make an instance of the transaction object
$del_ordem_externa = new tNG_multipleDelete($conn_conn);
$tNGs->addTransaction($del_ordem_externa);
// Register triggers
$del_ordem_externa->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_ordem_externa->registerTrigger("END", "Trigger_Default_Redirect", 99, "mov_list.php");
// Add columns
$del_ordem_externa->setTable("ordem_externa");
$del_ordem_externa->setPrimaryKey("id_OSE", "NUMERIC_TYPE", "GET", "id_OSE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsordem_externa = $tNGs->getRecordset("ordem_externa");
$row_rsordem_externa = mysql_fetch_assoc($rsordem_externa);
$totalRows_rsordem_externa = mysql_num_rows($rsordem_externa);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script src="../../js/muda.js"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: false,
  show_as_grid: false,
  merge_down_value: false
}
</script>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: 744px;
	top: 59px;
}
-->
</style>
</head>
<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1 align="center">
    <?php 
// Show IF Conditional region1 
if (@$_GET['id_OSE'] == "") {
?>
      <?php echo NXT_getResource("Incluir")." Ordem externa"; ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Atualizar")."Ordem externa No. ".$row_rsordem_externa['id_OSE']; ?>
      <?php } 
// endif Conditional region1
?>
  </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsordem_externa > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="id_Requisitante_<?php echo $cnt1; ?>">Requisitante:</label></td>
            <td><select name="id_Requisitante_<?php echo $cnt1; ?>" id="id_Requisitante_<?php echo $cnt1; ?>">
              <option value="" <?php if (!(strcmp("", $row_rsordem_externa['id_Requisitante']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Selecione"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_REQUISITANTE['id_requisitante']?>"<?php if (!(strcmp($row_REQUISITANTE['id_requisitante'], $row_rsordem_externa['id_Requisitante']))) {echo "selected=\"selected\"";} ?>><?php echo $row_REQUISITANTE['nome']?></option>
              <?php
} while ($row_REQUISITANTE = mysql_fetch_assoc($REQUISITANTE));
  $rows = mysql_num_rows($REQUISITANTE);
  if($rows > 0) {
      mysql_data_seek($REQUISITANTE, 0);
	  $row_REQUISITANTE = mysql_fetch_assoc($REQUISITANTE);
  }
?>
            </select>
            <?php echo $tNGs->displayFieldError("ordem_externa", "id_Requisitante", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="id_Equipamento_<?php echo $cnt1; ?>">Equipamento:</label></td>
            <td><select name="id_Equipamento_<?php echo $cnt1; ?>" id="id_Equipamento_<?php echo $cnt1; ?>">
              <option value="" <?php if (!(strcmp("", $row_rsordem_externa['id_Equipamento']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Selecione"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_EQUIPAMENTO['id_equipamento']?>"<?php if (!(strcmp($row_EQUIPAMENTO['id_equipamento'], $row_rsordem_externa['id_Equipamento']))) {echo "selected=\"selected\"";} ?>><?php echo $row_EQUIPAMENTO['equipamento']?></option>
              <?php
} while ($row_EQUIPAMENTO = mysql_fetch_assoc($EQUIPAMENTO));
  $rows = mysql_num_rows($EQUIPAMENTO);
  if($rows > 0) {
      mysql_data_seek($EQUIPAMENTO, 0);
	  $row_EQUIPAMENTO = mysql_fetch_assoc($EQUIPAMENTO);
  }
?>
            </select>
            <?php echo $tNGs->displayFieldError("ordem_externa", "id_Equipamento", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="id_prestadora_<?php echo $cnt1; ?>">Prestadora:</label></td>
            <td><select name="id_prestadora_<?php echo $cnt1; ?>" id="id_prestadora_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Selecione"); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_PRESTADORA['id_empresa']?>"<?php if (!(strcmp($row_PRESTADORA['id_empresa'], $row_rsordem_externa['id_prestadora']))) {echo "SELECTED";} ?>><?php echo $row_PRESTADORA['nome']?></option>
              <?php
} while ($row_PRESTADORA = mysql_fetch_assoc($PRESTADORA));
  $rows = mysql_num_rows($PRESTADORA);
  if($rows > 0) {
      mysql_data_seek($PRESTADORA, 0);
	  $row_PRESTADORA = mysql_fetch_assoc($PRESTADORA);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("ordem_externa", "id_prestadora", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="id_servico_<?php echo $cnt1; ?>">Servico:</label></td>
            <td><select name="id_servico_<?php echo $cnt1; ?>" id="id_servico_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Selecione"); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_SERVICO['id_acao']?>"<?php if (!(strcmp($row_SERVICO['id_acao'], $row_rsordem_externa['id_servico']))) {echo "SELECTED";} ?>><?php echo $row_SERVICO['acao']?></option>
              <?php
} while ($row_SERVICO = mysql_fetch_assoc($SERVICO));
  $rows = mysql_num_rows($SERVICO);
  if($rows > 0) {
      mysql_data_seek($SERVICO, 0);
	  $row_SERVICO = mysql_fetch_assoc($SERVICO);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("ordem_externa", "id_servico", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="descricao_<?php echo $cnt1; ?>">Descricao:</label></td>
            <td><textarea onkeyup="maiusculo(this)" name="descricao_<?php echo $cnt1; ?>" cols="100" rows="5" id="descricao_<?php echo $cnt1; ?>"><?php echo KT_escapeAttribute($row_rsordem_externa['descricao']); ?></textarea>
            <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("ordem_externa", "descricao", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_ordem_externa_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsordem_externa['kt_pk_ordem_externa']); ?>" />
        <?php } while ($row_rsordem_externa = mysql_fetch_assoc($rsordem_externa)); ?>
      <div class="KT_bottombuttons">
        <div align="center">
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id_OSE'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Incluir"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Atualizar"); ?>" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="location.href = 'mov_list.php';" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</body>
</html>
<?php
mysql_free_result($REQUISITANTE);

mysql_free_result($EQUIPAMENTO);

mysql_free_result($PRESTADORA);

mysql_free_result($SERVICO);
?>
