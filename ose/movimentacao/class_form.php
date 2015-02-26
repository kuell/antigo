<?php require_once('../../Connections/conn.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_conn = new KT_connection($conn, $database_conn);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

$colname_Recordset1 = "-1";
if (isset($_GET['id_OSE'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['id_OSE'] : addslashes($_GET['id_OSE']);
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM ordem_externa_vew WHERE id_OSE = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['id_equip'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_GET['id_equip'] : addslashes($_GET['id_equip']);
}
mysql_select_db($database_conn, $conn);
$query_Recordset2 = sprintf("SELECT * FROM equipamento WHERE id_equipamento = %s", $colname_Recordset2);
$Recordset2 = mysql_query($query_Recordset2, $conn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an update transaction instance
$upd_ordem_externa = new tNG_update($conn_conn);
$tNGs->addTransaction($upd_ordem_externa);
// Register triggers
$upd_ordem_externa->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_ordem_externa->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_ordem_externa->registerTrigger("END", "Trigger_Default_Redirect", 99, "class_list.php");
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="funcao.js"></script>
<script type="text/javascript">
function pergunta(acao){
	if(confirm("Deseja "+acao+" a Ordem Externa?")){
		return doPost('form1', acao)
		}
	return false
	}

</script>
</head>

<body>
<div align="center" class="acao_pagina">Classificação das Ordens de Serviço Externas</div>
  <form id="form1" name="form1" method="post" action="funcao.php">
 <div dir="ltr"> <table width="100%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th><div align="center">DADOS DA ORDEM DE SERVI&Ccedil;O </div></th>
    </tr>
    <tr>
      <td><table width="100%" border="0" align="center" class="KT_asc">
        <tr>
          <th width="23%"><span>No. da Ordem:</span></th>
          <td width="31%"><?php echo $row_Recordset1['id_OSE']; ?>
            
              <input name="id_OSE" type="hidden" id="id_OSE" value="<?php echo $row_Recordset1['id_OSE']; ?>" />
            <input type="hidden" name="action" id="action" /></td>
          <th width="17%">Data de envio:</th>
          <td width="29%"><?php echo date('d/m/Y', strtotime($row_Recordset1['data_envio'])); ?></td>
          </tr>
        <tr>
          <th><span >Equipamento:</span></th>
          <td><?php echo $row_Recordset1['equipamento']; ?></td>
          <th>Setor:</th>
          <td><?php echo $row_Recordset1['setor']; ?></td>
          </tr>
        <tr>
          <th>Servi&ccedil;o:</th>
          <td><?php echo $row_Recordset1['acao']; ?></td>
          <th>Dias/Ap&oacute;s:</th>
          <td><?php echo $row_Recordset1['Dias_Apos']; ?></td>
        </tr>
        <tr>
          <th>Empresa:</th>
          <td colspan="3"><?php echo $row_Recordset1['empresa']; ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <th class="MXW_disabled"><div align="center">Dados do Or&ccedil;amento </div></th>
      </tr>
    <tr>
      <td><table width="100%" border="0" align="center">
        <tr>
          <th width="25%" scope="1">No. Or&ccedil;amento:</th>
          <td width="25%"><?php echo $row_Recordset1['Num_orcamento']; ?></td>
          <th width="25%">Pre&ccedil;o do Servi&ccedil;o:</th>
          <td width="25%"><?php echo $row_Recordset1['preco_servico']; ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
    <th><div align="center">
      <label>
        <input type="button" name="Aprova" id="Aprova" value="Aprovar Servi&ccedil;o" onclick="pergunta('aprovar')" />
         <input type="button" name="reprova" id="reprova" value="Reprovar Servi&ccedil;o" onclick="pergunta('reprovar')" />

      </label>
    </div></th>
    </tr>
</table></div>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>