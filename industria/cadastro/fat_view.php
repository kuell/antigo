<?php
require "../../Connections/conect_mysqli.php";
require "../class/FatProduto.class.php";

$p = new FatProduto();
$p->setId($_GET['id']);

$fat = $p->produto()->fetch_object();

?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>Visualizar</title>
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
 </head>
 <body>
 <div class="col-md-12 well">
 	<h3>Visualização de produto do Faturamento</h3>
 </div>
<div class="col-md-10">
	 <div class="col-md-12">
	 	Descrição: <?php echo $fat->descricao?>
	 </div>
	 <div class="col-md-12">
	 	Codigo de Faturamento: <?php echo $fat->cod_fat?>
	 </div>
	 <div class="col-md-12">
	 	Codigo de Produção: <?php echo $fat->cod_prod?>
	</div>
	<div class="col-md-12">
	 	Grupo Intercarnes: <?php echo $fat->grupo_intercarnes?>
</div>
 </div>

 <div class="col-md-12">
<div class="well well-sm">Produtos Produzidos</div>

 	<table class="table table-bordered">
 		<thead>
 			<tr>
 				<th>Produto</th>
 				<th>Tipo</th>
 				<th>Ativo</th>
 			</tr>
 		</thead>
 		<tbody>
<?php foreach ($p->producao($fat->cod_prod) as $val) {?>
									<tr>
						 				<td><?php echo $val['descricao']?></td>
						 				<td><?php echo $val['tipo']?></td>
						 				<td><?php echo $val['ativo']?></td>
						 			</tr>
	<?php }?>
 		</tbody>
 	</table>
 </div>
 </body>
 </html>