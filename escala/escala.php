<?php
require ("../Connections/conect_mysqli.php");
require ("class/Escala.php");
require ("class/PreEscala.php");
require ('../class/Corretor.class.php');

if (empty($_GET['data'])) {
	$data = date('Y-m-d');
} else {
	$data = implode('-', array_reverse(explode('/', $_GET['data'])));
}

$escala = new Escala($data);
$cor    = new Corretor();

$max              = count($escala->lista());
$_SESSION['data'] = $data;

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Escala de Abate</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.11.4/jquery-ui.css">
	<script src="../js/jquery-ui-1.11.4/external/jquery/jquery.js" type="text/javascript"></script>
	<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
	<script src="../js/jquery.maskMoney.js" type="text/javascript"></script>
	<script src="../js/jquery-ui-1.11.4/jquery-ui.js" type="text/javascript"></script>


	<script src="../js/chosen_v1.4.1/chosen.jquery.js" type="text/javascript"></script>
	<script src="../js/chosen_v1.4.1/docsupport/prism.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../js/chosen_v1.4.1/chosen.min.css">
	<script src="../js/scripts.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(function(){
			$("#busca").click(function() {
				data = $(".data").val()
				window.location = '?data='+data
			});

			$('#print').click(function(){
				data = $("input[name=data]").val()
				hora = $('input[name=hora]').val()
				window.open('rel_escala.php?data='+data+'&hora='+hora, 'print', 'channelmode=1')
			})
		})

	</script>

</head>
<body>

<!-- Aqui começa o conteudo -->
		<div id="conteudo" class="col-md-10">
			<div class="panel panel-info">
				<div class="panel-heading clearfix">
					<div class="panel-titel pull-left">
						<h4>Escala de Abate
							<span id="data"><?php echo date('d/m/Y', strtotime($data))?></span>
						</h4>
					</div>
					<div class="btn-group pull-right">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="col-md-3">
									<label>Data: </label>
								</div>
								<div class="col-md-9">
									<input type="text" name="data" class="form-control input-sm data" value="<?php echo date('d/m/Y', strtotime($data))?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-4">
									<label>Horario: </label>
								</div>
								<div class="col-md-6">
									<input type="time" name="hora" class="form-control input-sm" value="05:00">
								</div>
								<div class="col-md-2">
									<button class="btn btn-sm btn-info" id="busca"><i class="glyphicon glyphicon-search"></i> Busca</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">

	<div class="well col-md-12">
		<div class="col-md-6">
			<h4>
				Total Animais: <span id="totalAbate"></span>
			</h4>
			<h4>
				Qtde Lotes: <span id="qtdLote"></span>
			</h4>
		</div>
		<div class="col-md-6">
			<button id="print" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Imprimir Escala</button>
			<a href="escala_form.php?lote=<?php echo $max+1?>" class="btn btn-info"> <i class="glyphicon glyphicon-plus"></i> Incluir Lote</a>
		</div>
	</div>

					<table class="table table-hover">
						<thead>
							<th>Lote</th>
							<th>Corretor</th>
							<th>Pecuarista</th>
							<th>Qtd. Boi</th>
							<th>Qtd. Vaca</th>
							<th>Qtd. Nov</th>
							<th>Qt/d. Touro</th>

						</thead>
						<tbody>
<?php foreach ($escala->lista() as $escala) {
	include ("escala_lista.php");

	$totalBoi[]   = $escala->qtdBoi;
	$totalVaca[]  = $escala->qtdVaca;
	$totalNov[]   = $escala->qtdNov;
	$totalTouro[] = $escala->qtdTouro;

}?>
</tbody>
<tfoot class="well">
							<tr class="info">
								<td></td>
								<td colspan="2">Totais</td>
								<td><?php echo array_sum($totalBoi)?></td>
								<td><?php echo array_sum($totalVaca)?></td>
								<td><?php echo array_sum($totalNov)?></td>
								<td><?php echo array_sum($totalTouro)?></td>
							</tr>
</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
<!-- Fim do conteudo -->

</div>

<script type="text/javascript">
	$(function(){
		$('#totalAbate').html('<?php echo array_sum($totalBoi)+array_sum($totalVaca)+array_sum($totalNov)+array_sum($totalTouro);?>')
		$("#qtdLote").html('<?php echo $escala->lote?>')
	})

</script>
</body>
</html>