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
$formValidation->addField("responsavel", true, "text", "", "", "", "");
$formValidation->addField("endereco", true, "text", "", "", "", "");
$formValidation->addField("bairro", true, "text", "", "", "", "");
$formValidation->addField("cidade", true, "text", "", "", "", "");
$formValidation->addField("estado", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_empresas = new tNG_multipleInsert($conn_conn);
$tNGs->addTransaction($ins_empresas);
// Register triggers
$ins_empresas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_empresas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_empresas->registerTrigger("END", "Trigger_Default_Redirect", 99, "empresa_list.php");
// Add columns
$ins_empresas->setTable("empresas");
$ins_empresas->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_empresas->addColumn("responsavel", "STRING_TYPE", "POST", "responsavel");
$ins_empresas->addColumn("endereco", "STRING_TYPE", "POST", "endereco");
$ins_empresas->addColumn("bairro", "STRING_TYPE", "POST", "bairro");
$ins_empresas->addColumn("complemento", "STRING_TYPE", "POST", "complemento");
$ins_empresas->addColumn("cidade", "STRING_TYPE", "POST", "cidade");
$ins_empresas->addColumn("estado", "STRING_TYPE", "POST", "estado");
$ins_empresas->addColumn("telefone_comercial", "STRING_TYPE", "POST", "telefone_comercial");
$ins_empresas->addColumn("telefone_celular", "STRING_TYPE", "POST", "telefone_celular");
$ins_empresas->addColumn("telefone_fax", "NUMERIC_TYPE", "POST", "telefone_fax");
$ins_empresas->addColumn("cnpj_cpf", "STRING_TYPE", "POST", "cnpj_cpf");
$ins_empresas->addColumn("inscricao_estadual", "STRING_TYPE", "POST", "inscricao_estadual");
$ins_empresas->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_empresas->addColumn("cep", "STRING_TYPE", "POST", "cep");
$ins_empresas->setPrimaryKey("id_empresa", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_empresas = new tNG_multipleUpdate($conn_conn);
$tNGs->addTransaction($upd_empresas);
// Register triggers
$upd_empresas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_empresas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_empresas->registerTrigger("END", "Trigger_Default_Redirect", 99, "empresa_list.php");
// Add columns
$upd_empresas->setTable("empresas");
$upd_empresas->addColumn("nome", "STRING_TYPE", "POST", "nome");
$upd_empresas->addColumn("responsavel", "STRING_TYPE", "POST", "responsavel");
$upd_empresas->addColumn("endereco", "STRING_TYPE", "POST", "endereco");
$upd_empresas->addColumn("bairro", "STRING_TYPE", "POST", "bairro");
$upd_empresas->addColumn("complemento", "STRING_TYPE", "POST", "complemento");
$upd_empresas->addColumn("cidade", "STRING_TYPE", "POST", "cidade");
$upd_empresas->addColumn("estado", "STRING_TYPE", "POST", "estado");
$upd_empresas->addColumn("telefone_comercial", "STRING_TYPE", "POST", "telefone_comercial");
$upd_empresas->addColumn("telefone_celular", "STRING_TYPE", "POST", "telefone_celular");
$upd_empresas->addColumn("telefone_fax", "NUMERIC_TYPE", "POST", "telefone_fax");
$upd_empresas->addColumn("cnpj_cpf", "STRING_TYPE", "POST", "cnpj_cpf");
$upd_empresas->addColumn("inscricao_estadual", "STRING_TYPE", "POST", "inscricao_estadual");
$upd_empresas->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_empresas->addColumn("cep", "STRING_TYPE", "POST", "cep");
$upd_empresas->setPrimaryKey("id_empresa", "NUMERIC_TYPE", "GET", "id_empresa");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsempresas = $tNGs->getRecordset("empresas");
$row_rsempresas = mysql_fetch_assoc($rsempresas);
$totalRows_rsempresas = mysql_num_rows($rsempresas);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div align="center" class="acao_pagina">
  <?php 
// Show IF Conditional region1 
if (@$_GET['id_empresa'] == "") {
?>
  <?php echo NXT_getResource("Incluir"); ?>
  <?php 
// else Conditional region1
} else { ?>
  <?php echo NXT_getResource("Atualizar"); ?>
  <?php } 
// endif Conditional region1
?>
  Empresa prestadora de servi&ccedil;o</div>

<table width="102%" border="0">
  <tr align="center">
    <td align="left"><div class="form_controle" id="apDiv1">  <div class="KT_tngform">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" class="relatorio_titulo" id="form1">
            <?php $cnt1 = 0; ?>
            <?php do { ?>
              <?php $cnt1++; ?>
              <?php 
// Show IF Conditional region1 
if (@$totalRows_rsempresas > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td colspan="3" class="KT_th"><label for="nome_<?php echo $cnt1; ?>">Nome:</label><br />
                    <input type="text" name="nome_<?php echo $cnt1; ?>" id="nome_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['nome']); ?>" size="100" maxlength="40" onkeyup="maiusculo(this)" />
                    <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("empresas", "nome", $cnt1); ?> </td>
                  </tr>
                <tr>
                  <td class="KT_th"><label for="responsavel_<?php echo $cnt1; ?>">Responsavel:</label><br />
                    <input type="text" name="responsavel_<?php echo $cnt1; ?>" id="responsavel_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['responsavel']); ?>" size="50" maxlength="20" onkeyup="maiusculo(this)" />
                    <?php echo $tNGs->displayFieldHint("responsavel");?> <?php echo $tNGs->displayFieldError("empresas", "responsavel", $cnt1); ?> </td>
                  <td width="220" class="KT_th">Cnpj:<br />
                    <input type="text" name="cnpj_cpf_<?php echo $cnt1; ?>" id="cnpj_cpf_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['cnpj_cpf']); ?>" size="32" maxlength="18" onkeyup="CNPJ(this)" />
                    <?php echo $tNGs->displayFieldHint("cnpj_cpf");?> <?php echo $tNGs->displayFieldError("empresas", "cnpj_cpf", $cnt1); ?></td>
                  <td width="212" class="KT_th">Incri&ccedil;&atilde;o Estadual:<br /> <input type="text" name="inscricao_estadual_<?php echo $cnt1; ?>" id="inscricao_estadual_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['inscricao_estadual']); ?>" size="32" maxlength="13" />
                    <?php echo $tNGs->displayFieldHint("inscricao_estadual");?> <?php echo $tNGs->displayFieldError("empresas", "inscricao_estadual", $cnt1); ?></td>
                </tr>
                <tr class="KT_bottombuttons">
                  <td colspan="3" class="KT_th"><div align="center">LOCALIDADE</div></td>
                </tr>
                <tr>
                  <td colspan="3" class="KT_th"><label for="endereco_<?php echo $cnt1; ?>">Endereco:</label><br />
                    <input type="text" name="endereco_<?php echo $cnt1; ?>" id="endereco_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['endereco']); ?>" size="100" maxlength="100" onkeyup="maiusculo(this)" />
                    <?php echo $tNGs->displayFieldHint("endereco");?> <?php echo $tNGs->displayFieldError("empresas", "endereco", $cnt1); ?> </td>
                  </tr>
                <tr>
                  <td class="KT_th"><label for="bairro_<?php echo $cnt1; ?>">Bairro:</label><br />
                    <input type="text" name="bairro_<?php echo $cnt1; ?>" id="bairro_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['bairro']); ?>" size="50" maxlength="40" onkeyup="maiusculo(this)" />
                    <?php echo $tNGs->displayFieldHint("bairro");?> <?php echo $tNGs->displayFieldError("empresas", "bairro", $cnt1); ?> </td>
                  <td class="KT_th">Complemento:<br /><input type="text" name="complemento_<?php echo $cnt1; ?>" id="complemento_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['complemento']); ?>" size="32" maxlength="40" onkeyup="maiusculo(this)" />
                    <?php echo $tNGs->displayFieldHint("complemento");?> <?php echo $tNGs->displayFieldError("empresas", "complemento", $cnt1); ?> <br /></td>
                  <td class="KT_th">Cep:<br />
                    <input type="text" name="cep_<?php echo $cnt1; ?>" id="cep_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['cep']); ?>" size="32" maxlength="10" onkeyup="CEP(this)" />
                    <?php echo $tNGs->displayFieldHint("cep");?> <?php echo $tNGs->displayFieldError("empresas", "cep", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cidade_<?php echo $cnt1; ?>">Cidade:<br />
                    <input type="text" name="cidade_<?php echo $cnt1; ?>" id="cidade_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['cidade']); ?>" size="30" maxlength="30" onkeyup="maiusculo(this)" />
                    <?php echo $tNGs->displayFieldHint("cidade");?> <?php echo $tNGs->displayFieldError("empresas", "cidade", $cnt1); ?></label></td>
                  <td class="KT_th"><label for="label"> </label>
                    Estado:<br />
                    <input type="text" name="estado_<?php echo $cnt1; ?>" id="estado_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['estado']); ?>" size="2" maxlength="2" onkeyup="maiusculo(this)" />
                    <label for="estado_<?php echo $cnt1; ?>"></label>
                    <?php echo $tNGs->displayFieldHint("estado");?> <?php echo $tNGs->displayFieldError("empresas", "estado", $cnt1); ?> </td>
                  <td class="KT_th">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" class="KT_th">
                    <div align="center">CONTATO:</div>                </td>
                  </tr>
                <tr>
                  <td class="KT_th"><label for="telefone_comercial_<?php echo $cnt1; ?>">Telefone_comercial:</label><BR />
                    <input type="text" name="telefone_comercial_<?php echo $cnt1; ?>" id="telefone_comercial_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['telefone_comercial']); ?>" size="32" maxlength="13" onkeypress="telefone(this)" />
                    <?php echo $tNGs->displayFieldHint("telefone_comercial");?> <?php echo $tNGs->displayFieldError("empresas", "telefone_comercial", $cnt1); ?> </td>
                  <td class="KT_th">Telefone_celular:<BR />
                    <input type="text" name="telefone_celular_<?php echo $cnt1; ?>" id="telefone_celular_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['telefone_celular']); ?>" size="32" maxlength="13" onkeypress="telefone(this)" />
                    <?php echo $tNGs->displayFieldHint("telefone_celular");?> <?php echo $tNGs->displayFieldError("empresas", "telefone_celular", $cnt1); ?> </td>
                  <td class="KT_th">FAX:<BR />
                    <input name="telefone_fax_<?php echo $cnt1; ?>" type="text" id="telefone_fax_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['telefone_fax']); ?>" size="32" maxlength="13" onkeypress="telefone(this)" />
                    <?php echo $tNGs->displayFieldHint("telefone_fax");?> <?php echo $tNGs->displayFieldError("empresas", "telefone_fax", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td colspan="3" class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label>
                    <input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsempresas['email']); ?>" size="100" maxlength="100" />
                    <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("empresas", "email", $cnt1); ?> </td>
                  </tr>
              </table>
              <input type="hidden" name="kt_pk_empresas_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsempresas['kt_pk_empresas']); ?>" />
              <?php } while ($row_rsempresas = mysql_fetch_assoc($rsempresas)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['id_empresa'] == "") {
      ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Incluir"); ?>" />
                  <?php 
      // else Conditional region1
      } else { ?>
                  <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Atualizar"); ?>" />
                  <?php }
      // endif Conditional region1
      ?>
                <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, 'empresa_list.php')" />
              </div>
            </div>
          </form>
        </div>
        </div>
        <br class="clearfixplain" />
      </div></td>
  </tr>
</table>
<p>
  <?php
	echo $tNGs->getErrorMsg();
?>
</p>
</body>
</html>
