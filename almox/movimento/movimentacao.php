<?php
require ("../../Connections/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimentação Almoxarifado</title>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../css/calendario.css"/>

<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.js"></script>
<script type="text/javascript"  src="../../js/jquery.maskedinput.js"></script>
<script type="text/javascript"  src="../../js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="../../js/scripts.js"></script>
<script type="text/javascript">
	function func(){
		data = document.getElementById('data').value
		window.open('operacao.php?data='+data, 'Print', 'channelmode=yes, scrollbars=yes')
		}
</script>
</head>

<body>
<div class="well">
  <h3>
    Movimentação do Almoxarifado
  </h3>
</div>
<div class="col-md-10">
      <div class="active">
        Data:
        <input name="data" type="text" class="data" id="data" value="<?php echo date('d/m/Y'); ?>" />
      </div>
      <button type="button" class="btn btn-primary" onclick="func()">
        Adicionar
      </button>
</div>
</body>
</html>