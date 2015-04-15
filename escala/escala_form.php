<?php

require '../Connections/conect_mysqli.php';
require '../class/Corretor.class.php';
require 'class/Escala.php';

$cor    = new Corretor();
$escala = new Escala();

if (isset($_GET['id'])) {
	$escala->id = $_GET['id'];
	$e          = $escala->getEscala();
} else {
	$e       = $escala;
	$e->lote = $_GET['lote'];
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
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

	<script type="text/javascript">
		$(function(){
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

<div class="col-md-9">

	<form class="form form-horizontal" action="funcao.php?action=gravaEscala" method="POST">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-titel">
					Alteração do Lote de Abate
				</div>
			</div>
			<div class="panel-body">
				<input type="hidden" value="<?php echo $e->data?>" name="data">
				<input type="hidden" value="<?php echo $e->id?>" name="id">
				<input type="hidden" value="<?php echo $e->lote?>" name="lote">

				<div class="col-md-12">
						<label>Corretor: </label>
						<select class="form-control" name="corretor">
							<option value="">Selecione ...</option>
<?php foreach ($cor->lista('and cor_ativo = 1') as $corretor) {
	if ($e->corretor == $corretor->cor_id) {
		$selected = 'selected';
	} else {
		$selected = "";
	}

	echo "<option value='".$corretor->cor_id."'".$selected." >".$corretor->cor_cod." - ".utf8_encode($corretor->cor_nome)."</option>";
}?>
						</select>
				</div>

					<label>Pecuarista: </label>
					<input class="form-control" name="pecuarista" placeholder="Nome do Pecuarista" type="text" value="<?php echo $e->pecuarista?>"></input>
					<div class="row">
						<div class="col-md-3">
							<label>Qtd. Boi</label>
							<input class="form-control int" name="qtdBoi" type="number" min="0" value="<?php echo $e->qtdBoi?>"></input>
						</div>
						<div class="col-md-3">
							<label>Qtd. Vaca</label>
							<input class="form-control int" name="qtdVaca" type="number" min="0" value="<?php echo $e->qtdVaca?>"></input>
						</div>
						<div class="col-md-3">
							<label>Qtd. Novilha</label>
							<input class="form-control int" name="qtdNov" type="number" min="0" value="<?php echo $e->qtdNov?>"></input>
						</div>
						<div class="col-md-3">
							<label>Qtd. Touro</label>
							<input class="form-control int" name="qtdTouro" type="number" min="0" value="<?php echo $e->qtdTouro?>"></input>
						</div>
					</div>

			</div>
			<div class="panel-footer">
				<button type="submit" class="btn btn-success">Gravar</button>
				<a href="escala.php?data=<?php echo $e->data?>" class="btn btn-danger">Voltar</a>
			</div>
		</div>
	</form>

</div>
</body>
</html>