<?php require_once('../../../Connections/conn.php'); ?>
<?php
// Load the common classes
require_once('../../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../../");

// Make unified connection variable
$conn_conn = new KT_connection($conn, $database_conn);

// Start trigger
$formValidation = new tNG_FormValidation();
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

$colname_Recordset1 = "-1";
if (isset($_GET['id_OSE'])) {
  $colname_Recordset1 = $_GET['id_OSE'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM ordem_externa_vew WHERE id_OSE = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// Make an update transaction instance
$upd_ordem_externa = new tNG_update($conn_conn);
$tNGs->addTransaction($upd_ordem_externa);
// Register triggers
$upd_ordem_externa->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_ordem_externa->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_ordem_externa->registerTrigger("END", "Trigger_Default_Redirect", 99, "../class_list.php");
// Add columns
$upd_ordem_externa->setTable("ordem_externa");
$upd_ordem_externa->addColumn("status", "NUMERIC_TYPE", "POST", "status");
$upd_ordem_externa->setPrimaryKey("id_OSE", "NUMERIC_TYPE", "GET", "id_OSE");

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Cod: <br />
          <span class="MXW_disabled"><?php echo $row_Recordset1['id_OSE']; ?></span></td>
    </tr>
    <tr>
      <td class="KT_th">Data do envio:<br />
        <span class="MXW_disabled"><?php echo $row_Recordset1['data_envio']; ?></span></td>
      <td class="KT_th">Serviço:<br />
        <span class="MXW_disabled"><?php echo $row_Recordset1['acao']; ?></span></td>
    </tr>
    <tr>
      <td class="KT_th">Requisitante:<br />
        <span class="MXW_disabled"><?php echo $row_Recordset1['requisitante']; ?></span></td>
      <td class="KT_th">Empresa:<br />
        <span class="MXW_disabled"><?php echo $row_Recordset1['empresa']; ?></span></td>
    </tr>
    <tr>
      <td class="KT_th">No. Orçamento:<br /><?php echo $row_Recordset1['Num_orcamento']; ?></td>
      <td class="KT_th">Descrição:<br /><?php echo $row_Recordset1['descricao']; ?></td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th"><label for="status">Status:</label><br />
        <select name="status" id="status">
          <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsordem_externa['status'])))) {echo "SELECTED";} ?>>ESPERANDO ORÇAMENTO</option>
        </select>
      <?php echo $tNGs->displayFieldError("ordem_externa", "status"); ?></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Update record" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
