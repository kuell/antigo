<?php require_once('../../Connections/conn.php'); ?>
<?php
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

$colname_ordem = "-1";
if (isset($_GET['id_osi'])) {
  $colname_ordem = $_GET['id_osi'];
}
mysql_select_db($database_conn, $conn);
$query_ordem = sprintf("SELECT * FROM ordem_interna_vew WHERE id_osi = %s", GetSQLValueString($colname_ordem, "int"));
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
.KT_tngtable td{
	text-align:left;
	}

</style>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body><div class="relatorio_corpo">
<table width="90%" border="0" align="center" class="KT_tngtable" style="border:#000 solid 1px;">
  <tr>
    <td width="150" rowspan="3"><img src="../../logo/Logo.JPG" width="125" height="75" align="absbottom" /></td>
    <td width="450" rowspan="3" align="center" valign="top" style="border:1px #000 solid; text-align:center"><h1>Ordem de Servi&ccedil;o</h1>
      (Manuten&ccedil;&atilde;o e conserva&ccedil;&atilde;o Industrial)<br /></td>
  </tr>
  <tr>
    <td  style="border:1px #000 solid;">No. de Controle</td>
  </tr>
  <tr>
    <td valign="top" align="center" style="border:1px #000 solid;">Ordem de servi&ccedil;o:<br />
      <strong><?php echo $row_ordem['id_osi']; ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><div>
      <table width="100%" border="0" class="KT_tngtable">
        <tr>
          <th>Emiss&atilde;o:</th>
          <td width="33%"><?php echo $row_ordem['data_pedido']; ?></td>
          <th>Responsavel:</th>
          <td width="34%"><?php echo $row_ordem['responsavel']; ?></td>
        </tr>
        <tr>
          <th>Solicitante:</th>
          <td><?php echo $row_ordem['requisitante']; ?></td>
          <th>Prazo:</th>
          <td><?php echo $row_ordem['prazo_conclusao']; ?> dia(s)</td>
        </tr>
        <tr>
          <th>Servi&ccedil;o:</th>
          <td><?php echo $row_ordem['acao']; ?></td>
          <th>Equipamento</th>
          <td><?php echo $row_ordem['equipamento']; ?></td>
        </tr>
        <tr>
          <th>Setor:</th>
          <td><?php echo $row_ordem['setor']; ?></td>
          <th>Data/Conclus&atilde;o</th>
          <td>
          <?php 
		  $data = date('d/m/Y',mktime(0,0,0, date('m'), date('d')+$row_ordem['prazo_conclusao'], date('Y')));
				//date('d/m/Y',mktime(0,0,0,date('m'),date('d')+5,date('Y'));							   

		  echo $data;
		  ?>
          </td>
        </tr>
        <tr>
          <th colspan="4"><div align="center">Descri&ccedil;&atilde;o do Servi&ccedil;o</div></th>
          </tr>
        <tr style="font:10px Verdana, Geneva, sans-serif;">
          <td width="34%" colspan="4" style="border-bottom: #000 solid 1px;"><p><?php echo $row_ordem['obs']; ?></p></td>
        </tr>
        </table>
    </div></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0">
      <tr align="center" style="font:10px Arial, Helvetica, sans-serif;">
        <td><br />
          __________________________________<br />
          Supervisor do Setor</td>
        <td><br />
          __________________________________<br />
          Gerente Industrial</td>
        <td><br />
          __________________________________<br />
          Responsavel</td>
      </tr>
    </table></td>
  </tr>
</table></div><div class="relatorio_corpo">
<br />
<table width="90%" border="0" align="center" class="KT_tngtable" style="border:#000 solid 1px;">
  <tr>
    <td width="150" rowspan="3"><img src="../../logo/Logo.JPG" alt="" width="125" height="75" align="absbottom" /></td>
    <td width="450" rowspan="3" align="center" valign="top" style="border:1px #000 solid; text-align:center"><h1>Ordem de Servi&ccedil;o</h1>
      (Manuten&ccedil;&atilde;o e conserva&ccedil;&atilde;o Industrial)<br /></td>
  </tr>
  <tr>
    <td  style="border:1px #000 solid;">No. de Controle</td>
  </tr>
  <tr>
    <td valign="top" align="center" style="border:1px #000 solid;">Ordem de servi&ccedil;o:<br />
      <strong><?php echo $row_ordem['id_osi']; ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><div style="border:1px #000 solid;">
      <table width="100%" border="0" class="KT_tngtable">
        <tr>
          <th>Emiss&atilde;o:</th>
          <td width="33%"><?php echo $row_ordem['data_pedido']; ?></td>
          <th>Responsavel:</th>
          <td width="34%"><?php echo $row_ordem['responsavel']; ?></td>
        </tr>
        <tr>
          <th>Solicitante:</th>
          <td><?php echo $row_ordem['requisitante']; ?></td>
          <th>Prazo:</th>
          <td><?php echo $row_ordem['prazo_conclusao']; ?> dia(s)</td>
        </tr>
        <tr>
          <th>Servi&ccedil;o:</th>
          <td><?php echo $row_ordem['acao']; ?></td>
          <th>Equipamento</th>
          <td><?php echo $row_ordem['equipamento']; ?></td>
        </tr>
        <tr>
          <th>Setor:</th>
          <td><?php echo $row_ordem['setor']; ?></td>
          <th>Data/Conclus&atilde;o</th>
          <td><?php 
		  $data = date('d/m/Y',mktime(0,0,0, date('m'), date('d')+$row_ordem['prazo_conclusao'], date('Y')));
				//date('d/m/Y',mktime(0,0,0,date('m'),date('d')+5,date('Y'));							   

		  echo $data;
		  ?></td>
        </tr>
        <tr>
          <th colspan="4"><div align="center">Descri&ccedil;&atilde;o do Servi&ccedil;o</div></th>
        </tr>
        <tr style="font:10px Verdana, Geneva, sans-serif;">
          <td width="34%" colspan="4" style="border-bottom: #000 solid 1px;"><p><?php echo $row_ordem['obs']; ?></p></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0">
      <tr align="center" style="font:10px Arial, Helvetica, sans-serif;">
        <td><br />
          __________________________________<br />
          Supervisor do Setor</td>
        <td><br />
          __________________________________<br />
          Gerente Industrial</td>
        <td><br />
          __________________________________<br />
          Responsavel</td>
      </tr>
    </table></td>
  </tr>
</table></div><div class="relatorio_corpo">
<br />
<table width="90%" border="0" align="center" class="KT_tngtable" style="border:#000 solid 1px;">
  <tr>
    <td width="150" rowspan="3"><img src="../../logo/Logo.JPG" alt="" width="125" height="75" align="absbottom" /></td>
    <td width="450" rowspan="3" align="center" valign="top" style="border:1px #000 solid; text-align:center"><h1>Ordem de Servi&ccedil;o</h1>
      (Manuten&ccedil;&atilde;o e conserva&ccedil;&atilde;o Industrial)<br /></td>
  </tr>
  <tr>
    <td  style="border:1px #000 solid;">No. de Controle</td>
  </tr>
  <tr>
    <td valign="top" align="center" style="border:1px #000 solid;">Ordem de servi&ccedil;o:<br />
      <strong><?php echo $row_ordem['id_osi']; ?></strong></td>
  </tr>
  <tr>
    <td colspan="3" valign="top">
      <table width="100%" border="0" class="KT_tngtable">
        <tr>
          <th>Emiss&atilde;o:</th>
          <td width="33%" align="left"><?php echo $row_ordem['data_pedido']; ?></td>
          <th>Responsavel:</th>
          <td width="34%"><?php echo $row_ordem['responsavel']; ?></td>
        </tr>
        <tr>
          <th>Solicitante:</th>
          <td><?php echo $row_ordem['requisitante']; ?></td>
          <th>Prazo:</th>
          <td><?php echo $row_ordem['prazo_conclusao']; ?> dia(s)</td>
        </tr>
        <tr>
          <th>Servi&ccedil;o:</th>
          <td><?php echo $row_ordem['acao']; ?></td>
          <th>Equipamento</th>
          <td><?php echo $row_ordem['equipamento']; ?></td>
        </tr>
        <tr>
          <th>Setor:</th>
          <td><?php echo $row_ordem['setor']; ?></td>
          <th>Data/Conclus&atilde;o</th>
          <td><?php 
		  $data = date('d/m/Y',mktime(0,0,0, date('m'), date('d')+$row_ordem['prazo_conclusao'], date('Y')));
				//date('d/m/Y',mktime(0,0,0,date('m'),date('d')+5,date('Y'));							   

		  echo $data;
		  ?></td>
        </tr>
        <tr>
          <th colspan="4"><div align="center">Descri&ccedil;&atilde;o do Servi&ccedil;o</div></th>
        </tr>
        <tr style="font:10px Verdana, Geneva, sans-serif;">
          <td width="34%" colspan="4" style="border-bottom: #000 solid 1px;"><p><?php echo $row_ordem['obs']; ?></p></td>
        </tr>
      </table>
</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0">
      <tr align="center" style="font:10px Arial, Helvetica, sans-serif;">
        <td><br />
          __________________________________<br />
          Supervisor do Setor</td>
        <td><br />
          __________________________________<br />
          Controle de Qualidade</td>
        <td><br />
          __________________________________<br />
          Responsavel</td>
      </tr>
    </table></td>
  </tr>
</table>
</div><br />

<div align="center" id="print">
  <button>Imprimir</button>
</div>
</body>
</html>
<?php
mysql_free_result($ordem);
?>
