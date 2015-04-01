<!DOCTYPE html>
<html>
<head>
	<title>SIG::Intercarnes</title>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../css/calendario.css">
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.ui.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="../../js/jquery.maskMoney.js"></script>
	<script type="text/javascript" src="../../js/scripts.js"></script>
	<script type="text/javascript">
		function digitar(){
			data = $('#data').val()

			open('intercarnes_movimento.php?data='+data, 'Digitar', '');
		}

	</script>
</head>
<body>
<div class="col-md-12">
	<div class="col-md-12 well well-sm">
		<h3>Digitação Intercarnes</h3>
	</div>
	<div class="col-md-1">
		Data da Digitação:
	</div>
	<div class="col-md-2">
		<input name="data" id="data" class="data form-control">
	</div>
	<div class="col-md-12">
		<button class="btn btn-primary" onclick="digitar()">
			Digitar
		</button>
	</div>
</div>
</body>
</html>