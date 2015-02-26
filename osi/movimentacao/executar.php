<?php require_once('../../Connections/conn.php');

$id_osi = $_GET['id_osi'];
mysql_select_db($database_conn, $conn);
$query_ordem = sprintf("SELECT * FROM ordem_interna_vew WHERE id_osi = $id_osi");
$ordem = mysql_query($query_ordem, $conn) or die(mysql_error());
$row_ordem = mysql_fetch_assoc($ordem);
$totalRows_ordem = mysql_num_rows($ordem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<script src="../../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
		   $("#print button").click(function(){
											 $(this).css("display","none")
											 window.print() });
		   });
</script>
<style type="text/css">
.subTitulo{
	background:#666;
	color:#FFF;
	border:1px solid #000;
}

</style>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body onblur="window.location.href = 'mov_list.php';">
<div class="acao_pagina">Informar prazo de entrega</div>
<br />
<table border="0" align="center" class="KT_tngtable">
  <tr>
    <th width="17%">Emiss&atilde;o:</th>
    <td width="33%"><?php echo date('d-m-Y', strtotime($row_ordem['data_pedido'])); ?></td>
    <th width="16%">Responsavel:</th>
    <td width="34%"><?php echo $row_ordem['responsavel']; ?></td>
  </tr>
  <tr>
    <th>Solicitante:</th>
    <td><?php echo $row_ordem['requisitante']; ?></td>
    <th>Servi&ccedil;o:</th>
    <td><?php echo $row_ordem['acao']; ?></td>
  </tr>
  <tr>
    <th>Equipamento:</th>
    <td><?php echo $row_ordem['equipamento']; ?></td>
    <th>Setor:</th>
    <td><?php echo $row_ordem['setor']; ?></td>
  </tr>
  <tr>
    <td style="border:#000 1px solid;" colspan="4"><div align="center" class="MXW_ICT_visual_alert_div">Descri&ccedil;&atilde;o do Servi&ccedil;o</div></td>
  </tr>
  <tr style="font:10px Verdana, Geneva, sans-serif;">
    <td colspan="4" ><?php echo $row_ordem['obs']; ?></td>
  </tr>
  <tr style="font:10px Verdana, Geneva, sans-serif;">
    <th>Prazo para conclus&atilde;o:</th>
    <td colspan="3" ><?php echo $row_ordem['prazo_conclusao']; ?> dias</td>
  </tr>
</table>
<br />
<div align="center">
  <form id="form1" name="form1" method="POST" action="funcao.php?action=executar" onreset="window.close()">
    <div id="KT_selAll">
      <input name="id_osi" type="hidden" id="id_osi" value="<?php echo $id_osi ;?>" />
      <table width="auto%" border="0" class="KT_tngtable">
        <tr>
          <td><label>
            <select name="executante" id="executante">
            <option value="">Selecione ... </option>
            <?php 
			$sql = "SELECT * FROM requisitante";
			$qr = mysql_query($sql) or die (mysql_error());
			while($res = mysql_fetch_assoc($qr)){
				?>
                <option value="<?php echo $res['id_requisitante'];?>"><?php echo $res['nome']; ?></option>
                <?php } ?>
            </select>
          </label></td>
        </tr>
        <tr>
          <td><div id="KT_tngdeverror" align="center">
            <label>
              <input name="inform" type="submit" id="inform" value="Informar executante" />
            </label>
          </div></td>
        </tr>
      </table>
    </div>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
