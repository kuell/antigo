<?php
require ("../../Connections/conn.php");

if ($_REQUEST["data"] == "") {
	$data = date('d-m-Y');
} else {
	$data = date('d-m-Y', strtotime($_REQUEST['data']));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimentação Almoxarifado</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../css/calendario.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.js"></script>
<script type="text/javascript"  src="../../js/jquery.maskedinput.js"></script>
<script type="text/javascript"  src="../../js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="../../js/scripts.js"></script>
<script type="text/javascript">
	function func(){
		data = document.getElementById('data').value
		window.open('operacao.php?data='+data+'&id=0', 'Print', 'channelmode=yes')
		}
</script>
</head>

<body>
<div class="acao_pagina">Movimentação do Almoxarifado</div>
<div><form id="form1" name="form1" method="post" action="?data=<?php echo $data?>&">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th scope="row">Data:</th>
      <td><label>
        <input name="data" type="text" class="data" id="data" value="<?php echo $data;?>" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2" scope="row"><label>
        <input type="submit" name="button" id="button" value="Busca" />
      	<input type="button" name="button2" id="button2" value="Adicionar" onclick="func()" />
        </label></th>
    </tr>
  </table>
  </form>
</div>
</body>
</html>