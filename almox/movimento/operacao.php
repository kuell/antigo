<?php
require ('../../Connections/conect_mysqli.php');
require "../../class/Almoxarifado.php";

$almox = new Almoxarifado();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimentação</title>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.js"></script>

<script type="text/javascript" src="../../js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../../js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="../../js/scripts.js"></script>
<script type="text/javascript" src="js.js"></script>

<script type="text/javascript">
	function envia(tipo, grupo){
		date = '<?php echo $_GET['data'];?>'
		qtd = $('#qtd'+tipo+''+grupo).val()
		valor = $('#valor'+tipo+''+grupo).val()

		$.post('funcao.php', {'funcao':'incluir',
								grupo: grupo,
								tipo: tipo,
								data: date,
								qtd: qtd,
								valor: valor},
			function(data) {
				$('#'+tipo).addClass('invisible');
		});

	}
	function exclui(tipo, grupo){
		dt = '<?php echo $_GET['data'];?>'

		$.post('funcao.php', {funcao: 'delete',
							  grupo: grupo,
							  tipo: tipo,
							  data: dt
		}, function(data){
				$('#'+tipo).addClass('invisible');
		})
	}

</script>

</head>

<body>
<div class="acao_pagina">Movimentação Almoxarifado <?php echo $_REQUEST['data'];?></div>
<?php foreach ($almox->getMovimentos(implode('-', array_reverse(explode('/', $_GET['data'])))) as $grupo) {?>
<?php $valor = $almox->getValores($grupo->id, implode('-', array_reverse(explode('/', $_GET['data']))));?>
	<div class="col-md-9">
			<div class="label label-info col-md-12">
				<h4><?php echo $grupo->descricao?></h4>
			</div>
		<table class="table table-bordered">
		<thead>
			<tr>
				<th></th>
				<th>Quantidade</th>
				<th>Financeiro</th>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Entrada</td>
				<td><input type="text" class="form-control qtd" id="qtdentrada<?php echo $grupo->id;?>" value="<?php echo $valor->qtdEntrada;?>"></td>
				<td><input type="text" class="form-control valor" value="<?php echo $valor->valorEntrada;?>" id="valorentrada<?php echo $grupo->id;?>"></td>
				<td>
					<?php if ($valor->qtdEntrada != 0):?>
						<button id="entrada" type="button" class="btn btn-danger" onclick="exclui('entrada', <?php echo $grupo->id;?>)">
							exclui
						</button>
					<?php  else :?>
						<button id="entrada" type="button" class="btn btn-success" onclick="envia('entrada', <?php echo $grupo->id;?>)">
							envia
						</button>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td>Devolução de Entrada</td>
				<td><input type="text" class="form-control qtd" value="<?php echo $valor->qtdDevEntrada;?>" id="qtddevEntrada<?php echo $grupo->id;?>"></td>
				<td><input type="text" class="form-control valor" value="<?php echo $valor->valorDevEntrada;?>" id="valordevEntrada<?php echo $grupo->id;?>"></td>
				<td>
					<?php if ($valor->qtdDevEntrada != 0 && $valor->valorDevEntrada != 0):?>
						<button id="devEntrada" type="button" class="btn btn-danger" onclick="exclui('devEntrada', <?php echo $grupo->id;?>)">
							exclui
						</button>
					<?php  else :?>
						<button id="devEntrada" type="button" class="btn btn-success" onclick="envia('devEntrada', <?php echo $grupo->id;?>)">
							envia
						</button>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td>Saida</td>
				<td><input type="text" class="form-control qtd" value="<?php echo $valor->qtdSaida;?>" id="qtdsaida<?php echo $grupo->id;?>"></td>
				<td><input type="text" class="form-control valor" value="<?php echo $valor->valorSaida;?>" id="valorsaida<?php echo $grupo->id;?>"></td>
				<td>
				<?php if ($valor->qtdSaida != 0 && $valor->valorSaida != 0):?>
					<button id="saida" type="button" class="btn btn-danger" onclick="exclui('saida', <?php echo $grupo->id;?>)">
						exclui
					</button>
				<?php  else :?>
					<button id="saida" type="button" class="btn btn-success" onclick="envia('saida', <?php echo $grupo->id;?>)">
						envia
					</button>
				<?php endif;?>
				</td>
			</tr>
			<tr>
				<td>Devolução de Saida</td>
				<td><input type="text" class="form-control qtd" value="<?php echo $valor->qtdDevSaida;?>" id="qtddevSaida<?php echo $grupo->id;?>"></td>
				<td><input type="text" class="form-control valor" value="<?php echo $valor->valorDevSaida;?>" id="valordevSaida<?php echo $grupo->id;?>"></td>
				<td>
					<?php if ($valor->qtdDevSaida != 0 && $valor->valorDevEntrada != 0):?>
						<button id="devSaida" type="button" class="btn btn-danger" onclick="exclui('devSaida', <?php echo $grupo->id;?>)">
							exclui
						</button>
					<?php  else :?>
						<button id="devSaida" type="button" class="btn btn-success" onclick="envia('devSaida', <?php echo $grupo->id;?>)">
							envia
						</button>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td>Contagem Física</td>
				<td><input type="text" class="form-control qtd" value="<?php echo $valor->qtdCtf;?>" id="qtdctf<?php echo $grupo->id;?>"></td>
				<td><input type="text" class="form-control valor" value="<?php echo $valor->valorCtf;?>" id="valorctf<?php echo $grupo->id;?>"></td>
				<td>
					<?php if ($valor->qtdCtf != 0 && $valor->qtdCtf != 0):?>
						<button id="ctf" type="button" class="btn btn-danger" onclick="exclui('ctf', <?php echo $grupo->id;?>)">
							exclui
						</button>
						<?php else : ?>
						<button id="ctf" type="button" class="btn btn-success" onclick="envia('ctf', <?php echo $grupo->id;?>)">
							envia
						</button>
					<?php endif;?>
				</td>
			</form>
			</tr>
				</tbody>
			</table>
		</div>
<?php }?>
</body>
</html>
