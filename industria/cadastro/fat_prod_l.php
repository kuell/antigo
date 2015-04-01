<?php
require "../../Connections/conect_mysqli.php";
require "../class/FatProduto.class.php";

$p = new FatProduto();

$produtos = $p->lista(null);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Untitled Document</title>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="../../js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
function ver(id){
	open('fat_view.php?id='+id, 'Print', 'channelmode=true, width=400, height=500, left=400');
}

</script>

</head>

<body>
<div class="col-md-12">
  <div class="well">
    <h3>Controle de Produtos para Faturamento</h3>
  </div>
    <table class="table table-hover table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Descrição</th>
          <th>Cod. Faturamento</th>
          <th><a href="fatProdForm.php" class="btn btn-primary">Adicionar</a></th>
        </tr>
      </thead>
	<tbody>
<?php while ($val = $produtos->fetch_object()) {?>
			<tr class="accordion-group">
				<td><a href="fatProdForm.php?id=<?php echo $val->id;?>"><?php echo $val->id;
	?></a></td>
		     	<td><?php echo utf8_decode($val->descricao);?></td>
		      	<td><?php echo $val->cod_fat;?></td>
				<td>
					<button class="btn btn-info" onclick="ver(<?php echo $val->id?>)">
						Visualizar
					</button>
				</td>
			</tr>
	<?php }?>
</tbody>
</table>
</div>
</body>
</html>
