<?php
require ("../Connections/conect_mysqli.php");
require ("class/Escala.php");
require ("class/PreEscala.php");
require ('../class/Corretor.class.php');

$p   = new PreEscala();
$cor = new Corretor();

if (empty($_GET['data'])) {
	if (!empty($_GET['dt'])) {
		$data = $_GET['dt'];
	} else {
		$data = date('Y-m-d');
	}

} else {
	$data = $p->tratarData($_GET['data']);
}

$p->data = $data;
session_start();

$_SESSION['data'] = $p->data;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title></title>

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

	<style type="text/css">
	*{
		font-size: 12px;
	}
	</style>

<script>
	$(function() {
		$("#print").click(function(){
			window.open('view_preEscala.php?data=<?php echo date("d/m/Y", strtotime($data))?>', 'Print', 'channelmode=1');
		})

	    $( "#calendario" ).datepicker({
	        inline: true,
			dateFormat: "yy-mm-dd",
			defaultDate: "<?php echo $_SESSION['data']?>",
			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
			dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		});

		$('#busca').click(function(event) {
			var currentDate = $( "#calendario" ).datepicker( "getDate" );
			window.location = '?data='+currentDate;
		});

		$('#adicionar').click(function() {
			$('.hidden').removeClass('hidden');
		});

		$('select[name=corretor]').chosen(
	            {
	              allow_single_deselect:true,
	              no_results_text: "Nenhum valor encontrado para o nome: ",
	              allow_single_deselect: true
	            });

		$('input[name=pecuarista]').autocomplete({
			source: function( request, response ) {
		        $.ajax({
		            url: "funcao.php",
		            dataType:"json",
		            data: {
		                action: "buscaPecuarista",
		                pecuarista: request.term
		            },
		            success: function( data ) {
		                response( $.map( data, function( item ) {
		                    return {
		                        value: item
		                    }
		                }));
		            }
		        });
			}
		})

	});
</script>

</head>
<body>

<div class="wrapper" role="main">
	<div class="container">
		<div class="row">
<!-- Aqui e a area do sidebar -->
	<div id="sidebar" class="col-md-3">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div>
					<!--input type="date" name="dataPre" class="form-control"-->
				</div>
				<div id="calendario"></div>
			</div>
			<div class="panel-footer">
				<button id="busca" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Busca</button>
				<button id="print" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Visualizar</button>
			</div>

			<div>
				<h4>
					Total de animais:
					<span id="totalDia" class="alert h3">
					</span>
				</h4>
			</div>
		</div>
	</div>
<!-- Aqui termina o sidebar -->

<!-- Aqui começa o conteudo -->
		<div id="conteudo" class="col-md-9">
			<div class="panel panel-info">
				<div class="panel-heading clearfix">
					<div class="panel-titel pull-left">
						<h4>Pré Escala de Abate
							<span id="data"><?php echo date('d/m/Y', strtotime($data))?></span>
						</h4>
					</div>
						<div class="btn-group pull-right">

						</div>
				</div>
				<div class="panel-body">

					<div>
<?php include ('pre_form.php');?>
</div>


					<table class="table table-hover">
						<thead>
							<th>Corretor</th>
							<th>Pecuarista</th>
							<th>Qtd. Boi</th>
							<th>Qtd. Vaca</th>
							<th>Qtd. Nov</th>
							<th>Qtd. Touro</th>

						</thead>
						<tbody>
<?php foreach ($p->lista() as $pre) {
	include ("pre_lista.php");

	$totalBoi[]   = $pre->qtdBoi;
	$totalVaca[]  = $pre->qtdVaca;
	$totalNov[]   = $pre->qtdNov;
	$totalTouro[] = $pre->qtdTouro;

}?>
</tbody>
<tfoot class="well">
							<tr>
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
		$("#totalDia").html('<?php echo (array_sum($totalBoi)+array_sum($totalVaca)+array_sum($totalNov)+array_sum($totalTouro))?>')

	});

</script>

</body>
</html>