<?php require_once ('Connections/conn.php');?>
<?php
// Load the common classes
require_once ('includes/common/KT_common.php');

// Load the tNG classes
require_once ('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_conn = new KT_connection($conn, $database_conn);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("kt_login_user", true, "text", "", "", "", "");
$formValidation->addField("kt_login_password", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make a login transaction instance
$loginTransaction = new tNG_login($conn_conn);
$tNGs->addTransaction($loginTransaction);
// Register triggers
$loginTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "kt_login1");
$loginTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "{kt_login_redirect}");
// Add columns
$loginTransaction->addColumn("kt_login_user", "STRING_TYPE", "POST", "kt_login_user");
$loginTransaction->addColumn("kt_login_password", "STRING_TYPE", "POST", "kt_login_password");
$loginTransaction->addColumn("kt_login_rememberme", "CHECKBOX_1_0_TYPE", "POST", "kt_login_rememberme", "0");
// End of login transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom           = $tNGs->getRecordset("custom");
$row_rscustom       = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="includes/skins/mxkollection1.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/muda.js" type="text/javascript"></script>

<?php echo $tNGs->displayValidationRules();?>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:442px;
	height:185px;
	z-index:1;
	top: 20px;
	border:1px solid #00F;
	left: 30%;
}
</style>
</head>
<body>
<div id="conteudo">
<form method="post" id="form1" class="KT_tngformerror" action="<?php echo KT_escapeAttribute(KT_getFullUri());?>"></p>
  <div id="apDiv1" align="center">
    <h1>Acesso ao Sistema</h1>
    <table cellpadding="2" cellspacing="0" class="KT_tngtable" align="center">
      <tr>
        <td class="KT_th"><label for="kt_login_user">Usuario:</label></td>
        <td><input type="text" name="kt_login_user"  onkeyup="maiusculo(this)" id="kt_login_user" value="<?php echo KT_escapeAttribute($row_rscustom['kt_login_user']);?>" size="32" />
<?php echo $tNGs->displayFieldHint("kt_login_user");
?> <?php echo $tNGs->displayFieldError("custom", "kt_login_user");
?></td>
      </tr>
      <tr>
        <td class="KT_th"><label for="kt_login_password">Senha:</label></td>
        <td><input type="password" name="kt_login_password" id="kt_login_password" onkeyup="maiusculo(this)" value="" size="32" />
<?php echo $tNGs->displayFieldHint("kt_login_password");
?> <?php echo $tNGs->displayFieldError("custom", "kt_login_password");
?></td>
      </tr>
      <tr>
        <td class="KT_th"><label for="kt_login_rememberme">Relembrar-me:</label></td>
        <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rscustom['kt_login_rememberme']), "1"))) {echo "checked";}?>type="checkbox" name="kt_login_rememberme" id="kt_login_rememberme" value="1" />
<?php echo $tNGs->displayFieldError("custom", "kt_login_rememberme");?></td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="2"><input type="submit" name="kt_login1" id="kt_login1" value="Login" /></td>
      </tr>
    </table>
  </div>
<?php
echo $tNGs->getLoginMsg();
?>
  <?php
echo $tNGs->getErrorMsg();
?>
</form>
</div>
</body>
</html>