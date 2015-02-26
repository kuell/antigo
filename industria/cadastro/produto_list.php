<?php
$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
$sql  = sprintf('Select 
							a.*,
						(select count(*) from fat_produto where cod_prod = a.cod) as qtdFat 
						from 
							ind_produtos a');
$qr   = $conn->query($sql) or die('Erro na instrução: '.$sql);

function getProdutosProducao($id) {
	$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
	$sql  = sprintf("select
                    descricao,
                    cod_fat as cod
                  from
                    fat_produto 
                  where
                    cod_prod = %s
                    ", $id);
	$res    = $conn->query($sql) or die("Erro na instrução getSetor: ".$sql);
	$return = "";
	while ($val = $res->fetch_object()) {
		$return .= '<td>'.$val->cod.'</td>';
		$return .= '<td>'.$val->descricao.'</td>';
	}

	return $return;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Untitled Document</title>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">


</script>

</head>

<body>
<div class="col-md-12">
  <div class="well">
    <h3>Controle de Produtos para Produção</h3>
  </div>
<div class="accordion" id="accordion2">
    <table class="table table-hover table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Descrição</th>
          <th>Cod. Produção</th>
          <th>Qtd. Faturamento</th>
          <th><a href="produto_form.php" class="btn btn-primary">Adicionar</a></th>
        </tr>
      </thead>
  <tbody>
	<?php while ($val = $qr->fetch_object()) {?>
    <tr class="accordion-group">
      <td><?php echo $val->id;?></td>
      <td><?php echo utf8_decode($val->descricao);?></td>
      <td><?php echo $val->cod;?></td>
      <td><?php echo $val->qtdFat;?></td>
      <td class="accordion-heading info">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $val->id;?>">
          <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Faturando
        </a>
      </td>
    </tr>
    <tr id="collapse<?php echo $val->id;?>" class="accordion-body collapse">
		<?php echo getProdutosProducao($val->cod);?>
	 </tr>
	<?php }?>
</tbody>
</table>
</div>
</body>
</html>
