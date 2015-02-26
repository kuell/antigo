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

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords(&$tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg("Could not create account.");
  $myThrowError->setField("senha");
  $myThrowError->setFieldErrorMsg("The two passwords do not match.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nome", true, "text", "", "", "", "");
$formValidation->addField("cargo", true, "text", "", "", "", "");
$formValidation->addField("setor", true, "numeric", "", "", "", "");
$formValidation->addField("login", true, "text", "", "", "", "");
$formValidation->addField("senha", true, "text", "", "", "", "");
$formValidation->addField("nivel", true, "numeric", "", "", "", "");
$formValidation->addField("email", true, "text", "email", "", "", "");
$formValidation->addField("ativo", true, "numeric", "", "", "", "");
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

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

mysql_select_db($database_conn, $conn);
$query_setor = "Select * from setor";
$setor = mysql_query($query_setor, $conn) or die(mysql_error());
$row_setor = mysql_fetch_assoc($setor);
$totalRows_setor = mysql_num_rows($setor);

// Make an insert transaction instance
$ins_funcionario = new tNG_multipleInsert($conn_conn);
$tNGs->addTransaction($ins_funcionario);
// Register triggers
$ins_funcionario->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_funcionario->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_funcionario->registerTrigger("END", "Trigger_Default_Redirect", 99, "usuario_list.php");
$ins_funcionario->registerConditionalTrigger("{POST.senha} != {POST.re_senha}", "BEFORE", "Trigger_CheckPasswords", 50);
// Add columns
$ins_funcionario->setTable("funcionario");
$ins_funcionario->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_funcionario->addColumn("cargo", "STRING_TYPE", "POST", "cargo");
$ins_funcionario->addColumn("setor", "NUMERIC_TYPE", "POST", "setor");
$ins_funcionario->addColumn("ramal", "STRING_TYPE", "POST", "ramal");
$ins_funcionario->addColumn("celular", "STRING_TYPE", "POST", "celular");
$ins_funcionario->addColumn("login", "STRING_TYPE", "POST", "login");
$ins_funcionario->addColumn("senha", "STRING_TYPE", "POST", "senha");
$ins_funcionario->addColumn("nivel", "NUMERIC_TYPE", "POST", "nivel");
$ins_funcionario->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_funcionario->addColumn("ativo", "NUMERIC_TYPE", "POST", "ativo");
$ins_funcionario->setPrimaryKey("id_funcionario", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_funcionario = new tNG_multipleUpdate($conn_conn);
$tNGs->addTransaction($upd_funcionario);
// Register triggers
$upd_funcionario->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_funcionario->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_funcionario->registerTrigger("END", "Trigger_Default_Redirect", 99, "usuario_list.php");
$upd_funcionario->registerConditionalTrigger("{POST.senha} != {POST.re_senha}", "BEFORE", "Trigger_CheckPasswords", 50);
$upd_funcionario->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);
// Add columns
$upd_funcionario->setTable("funcionario");
$upd_funcionario->addColumn("nome", "STRING_TYPE", "POST", "nome");
$upd_funcionario->addColumn("cargo", "STRING_TYPE", "POST", "cargo");
$upd_funcionario->addColumn("setor", "NUMERIC_TYPE", "POST", "setor");
$upd_funcionario->addColumn("ramal", "STRING_TYPE", "POST", "ramal");
$upd_funcionario->addColumn("celular", "STRING_TYPE", "POST", "celular");
$upd_funcionario->addColumn("login", "STRING_TYPE", "POST", "login");
$upd_funcionario->addColumn("senha", "STRING_TYPE", "POST", "senha");
$upd_funcionario->addColumn("nivel", "NUMERIC_TYPE", "POST", "nivel");
$upd_funcionario->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_funcionario->addColumn("ativo", "NUMERIC_TYPE", "POST", "ativo");
$upd_funcionario->setPrimaryKey("id_funcionario", "NUMERIC_TYPE", "GET", "id_funcionario");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsfuncionario = $tNGs->getRecordset("funcionario");
$row_rsfuncionario = mysql_fetch_assoc($rsfuncionario);
$totalRows_rsfuncionario = mysql_num_rows($rsfuncionario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Controle de Usuarios</title>
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
</head>

<body>
<div>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['id_funcionario'] == "") {
	echo "Incluir";
?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Atualizar"); ?>
      <?php } 
// endif Conditional region1
?>
    Funcionario </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsfuncionario > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="nome_<?php echo $cnt1; ?>">Nome:</label></td>
            <td><input type="text" name="nome_<?php echo $cnt1; ?>" id="nome_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsfuncionario['nome']); ?>" size="32" maxlength="50" onkeyup="maiusculo(this)" />
              <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("funcionario", "nome", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cargo_<?php echo $cnt1; ?>">Cargo:</label></td>
            <td><input type="text" name="cargo_<?php echo $cnt1; ?>" id="cargo_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsfuncionario['cargo']); ?>" size="32" maxlength="100" onkeyup="maiusculo(this)" />
              <?php echo $tNGs->displayFieldHint("cargo");?> <?php echo $tNGs->displayFieldError("funcionario", "cargo", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="setor_<?php echo $cnt1; ?>">Setor:</label></td>
            <td><?php echo $tNGs->displayFieldError("funcionario", "setor", $cnt1); ?>
              <select name="setor_<?php echo $cnt1; ?>" id="setor_<?php echo $cnt1; ?>">
                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                <?php 
do {  
?>
                <option value="<?php echo $row_setor['id_setor']?>"<?php if (!(strcmp($row_setor['id_setor'], $row_rsfuncionario['setor']))) {echo "SELECTED";} ?>><?php echo $row_setor['setor']?></option>
                <?php
} while ($row_setor = mysql_fetch_assoc($setor));
  $rows = mysql_num_rows($setor);
  if($rows > 0) {
      mysql_data_seek($setor, 0);
	  $row_setor = mysql_fetch_assoc($setor);
  }
?>
              </select></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ramal_<?php echo $cnt1; ?>">Ramal:</label></td>
            <td><input type="text" name="ramal_<?php echo $cnt1; ?>" id="ramal_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsfuncionario['ramal']); ?>" size="13" maxlength="13" />
              <?php echo $tNGs->displayFieldHint("ramal");?> <?php echo $tNGs->displayFieldError("funcionario", "ramal", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="celular_<?php echo $cnt1; ?>">Celular:</label></td>
            <td><input type="text" name="celular_<?php echo $cnt1; ?>" id="celular_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsfuncionario['celular']); ?>" size="13" maxlength="13" onkeypress="telefone(this)" />
              <?php echo $tNGs->displayFieldHint("celular");?> <?php echo $tNGs->displayFieldError("funcionario", "celular", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="login_<?php echo $cnt1; ?>">Login:</label></td>
            <td><input type="text" name="login_<?php echo $cnt1; ?>" id="login_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsfuncionario['login']); ?>" size="20" maxlength="20" onkeyup="maiusculo(this)" />
              <?php echo $tNGs->displayFieldHint("login");?> <?php echo $tNGs->displayFieldError("funcionario", "login", $cnt1); ?></td>
          </tr>
          <?php 
// Show IF Conditional show_old_senha_on_update_only 
if (@$_GET['id_funcionario'] != "") {
?>
            <tr>
              <td class="KT_th"><label for="old_senha_<?php echo $cnt1; ?>">Old Senha:</label></td>
              <td><input type="password" name="old_senha_<?php echo $cnt1; ?>" id="old_senha_<?php echo $cnt1; ?>" value="" size="32" maxlength="32" onkeyup="maiusculo(this)" />
                <?php echo $tNGs->displayFieldError("funcionario", "old_senha", $cnt1); ?></td>
            </tr>
            <?php } 
// endif Conditional show_old_senha_on_update_only
?>
          <tr>
            <td class="KT_th"><label for="senha_<?php echo $cnt1; ?>">Senha:</label></td>
            <td><input type="password" name="senha_<?php echo $cnt1; ?>" id="senha_<?php echo $cnt1; ?>" value="" size="32" maxlength="32" onkeyup="maiusculo(this)" />
              <?php echo $tNGs->displayFieldHint("senha");?> <?php echo $tNGs->displayFieldError("funcionario", "senha", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="re_senha_<?php echo $cnt1; ?>">Re-type Senha:</label></td>
            <td><input type="password" name="re_senha_<?php echo $cnt1; ?>" id="re_senha_<?php echo $cnt1; ?>" value="" size="32" maxlength="32" onkeyup="maiusculo(this)" /></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="nivel_<?php echo $cnt1; ?>">Nivel:</label></td>
            <td><select name="nivel_<?php echo $cnt1; ?>" id="nivel_<?php echo $cnt1; ?>">
              <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsfuncionario['nivel'])))) {echo "selected=\"selected\"";} ?>>Administrador</option>
              <option value="2" <?php if (!(strcmp(2, KT_escapeAttribute($row_rsfuncionario['nivel'])))) {echo "selected=\"selected\"";} ?>>Usuario</option>
              <option value="3" <?php if (!(strcmp(3, KT_escapeAttribute($row_rsfuncionario['nivel'])))) {echo "selected=\"selected\"";} ?>>Supervisor</option>
            </select>
              <?php echo $tNGs->displayFieldError("funcionario", "nivel", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label></td>
            <td><input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsfuncionario['email']); ?>" size="32" maxlength="75" onkeyup="minusculo(this)" />
              <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("funcionario", "email", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ativo_<?php echo $cnt1; ?>">Ativo:</label></td>
            <td><select name="ativo_<?php echo $cnt1; ?>" id="ativo_<?php echo $cnt1; ?>">
              <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsfuncionario['ativo'])))) {echo "SELECTED";} ?>>Sim</option>
              <option value="2" <?php if (!(strcmp(2, KT_escapeAttribute($row_rsfuncionario['ativo'])))) {echo "SELECTED";} ?>>Não</option>
            </select>
              <?php echo $tNGs->displayFieldError("funcionario", "ativo", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_funcionario_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsfuncionario['kt_pk_funcionario']); ?>" />
        <?php } while ($row_rsfuncionario = mysql_fetch_assoc($rsfuncionario)); ?>
      <div class="KT_bottombuttons" align="center">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id_funcionario'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Incluir"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
      <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Atualizar"); ?>" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancelar"); ?>" onclick="location.href = 'usuario_list.php';" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</div>
</body>
</html>
<?php
mysql_free_result($setor);
?>
