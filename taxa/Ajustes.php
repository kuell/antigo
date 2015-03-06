<?php
require ('../Connections/conect_mysqli.php');
require ('../class/Corretor.class.php');
$corretor = new Corretor($_GET['cor']);

$datai = implode('-', array_reverse(explode('/', $_GET['datai'])));
$dataf = implode('-', array_reverse(explode('/', $_GET['datai'])));

$dados = $corretor->getTaxaAjustes($datai, $dataf);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Ajustes</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.ui.js"></script>

	<script type="text/javascript" src="../js/mascara.js"></script>
	<script type="text/javascript" src="../js/scripts.js"></script>

	<style type="text/css">
		body {
			  min-height: 2000px;
			  padding-top: 70px;
			}
	</style>
	<script type="text/javascript">
		function gravar(id){
			url = 'funcao.php';
			qtd = document.getElementById('qtd'+id).value
			valor = document.getElementById('valor'+id).value
			peso = document.getElementById('peso'+id).value
			tipo = document.getElementById('tipo'+id).value

			$.post(url, {'qtd':qtd, 'valor':valor, 'peso':peso, 'tipo':tipo, 'id':id, 'funcao': 'ajuste'}, function(data){
				alert(data);
			});
		}
	</script>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="nav-header">
	<p class="navbar-brand">
		Corretor: <?php echo $corretor->nome.' - '.$corretor->codigo_interno;?><br />
		Ajustes Ref: <?php echo $_GET['datai'].' a '.$_GET['dataf']?>
</p>
</div>
</nav>
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row col-md-12">
<?php foreach ($dados as $data => $val) {?>
									<div class="well">

										<div class="label-danger"><?php echo $data;?></div>

	<?php foreach ($val as $grupo => $v) {?>
															<div class="label-info" style="text-align: center"><?php echo $grupo;?></div>
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th>Descrição</th>
																		<th>Qtde.</th>
																		<th>Peso</th>
																		<th>Valor</th>
																		<th>Tipo</th>
																		<th></th>
																	</tr>
																</thead>
																<tbody>
		<?php foreach ($v as $item) {?>
																					<tr>
																						<td><?php echo $item->descricao;?></td>
																						<td><input type="text" id="qtd<?php echo $item->id;?>" class="form-control int" value="<?php echo $item->qtd;?>"></td>
																						<td><input type="text" id="peso<?php echo $item->id;?>" class="form-control qtd" value="<?php echo $item->peso;?>"></td>
																						<td><input type="text" id="valor<?php echo $item->id;?>" class="form-control valor" value="<?php echo $item->valor;?>"></td>
																						<td>
																							<select id="tipo<?php echo $item->id;?>" class="form-control">
																								<option value="c" <?php if ($item->tipo == 'c') {echo 'selected';
			}
			?>>A PAGAR</option>
																								<option value="d" <?php if ($item->tipo == 'd') {echo 'selected';
			}
			?>>A RECEBER</option>
																								<option value="i" <?php if ($item->tipo == 'i') {echo 'selected';
			}
			?>>INFORMATIVO</option>
																							</select>
																						<td>
																							<button class="btn btn-primary" onclick='gravar(<?php echo $item->id;?>)'>Ajustar</button>
																						</td>
																					</tr>
			<?php }?>
		</tbody>
															</table>
		<?php }?>
	</div>
	<?php }?>
		</div>
	</div>
</div>


</body>
</html>