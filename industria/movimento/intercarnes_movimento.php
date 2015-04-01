<?php
require '../../Connections/conect_mysqli.php';
require '../class/FatProduto.class.php';
require '../class/FatIntercarnes.class.php';

$data = explode('/', $_GET['data']);

$p     = new FatProduto();
$inter = new FatIntercarnes();
$inter->setMes($data[1]);
$inter->setAno($data[2]);

$produtos = $p->lista('where ativo = 1');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Digitação Intercarnes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../css/calendario.css">
	<script type="text/javascript" src="../../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.ui.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="../../js/jquery.maskMoney.js"></script>
	<script type="text/javascript" src="../../js/scripts.js"></script>
	<script type="text/javascript">
		function envia(id){
			valor = $('#valor'+id).val();
			data = '<?php echo $_GET['data'];?>'

			$.post('funcao.php',{produto: id,
								 valor: valor,
								 data: data,
								 funcao: 'intercarnes_incluir'
								 },function(data){
								 	console.log(data);
								 });

		}
	</script>
</head>
<body>
<div class="well well-sm">
	<h3>Digitação Intercarnes</h3>
	<span><?php echo $_GET['data']?></span>
</div>
<div class="col-md-9">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Produto</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody>
<?php while ($produto = $produtos->fetch_array()) {?>
									<tr>
										<td><?php echo $produto['descricao'];?></td>
										<td><input type="text" value="<?php echo $inter->getValor($produto['id'])?>" class="form-control valor" id="valor<?php echo $produto['id'];?>" ></td>
										<td>
											<button class="btn btn-primary" onclick="envia(<?php echo $produto['id']?>)">
												envia
											</button>
										</td>
									</tr>
	<?php }?>
		</tbody>
	</table>
</div>
</body>
</html>