<?php
$corretor = $cor->getCorretor($escala->corretor);

?>
<tr style="background: <?php echo $cor->cor?>">
	<td><?php echo $escala->lote;?></td>
	<td><?php echo $corretor->codigo_interno.' - '.$corretor->nome?></td>
	<td><?php echo $escala->pecuarista?></td>
	<td><?php echo $escala->qtdBoi?></td>
	<td><?php echo $escala->qtdVaca?></td>
	<td><?php echo $escala->qtdNov?></td>
	<td><?php echo $escala->qtdTouro?></td>
	<td>
		<a href="escala_form.php?id=<?php echo $escala->id?>"><i class="glyphicon glyphicon-pencil"></i></a>
<?php if ($escala->lote == 1 && $max != 1) {?>
		<a href="funcao.php?action=ordenar&ordem=-1&lote=<?php echo $escala->lote?>&data=<?php echo $data?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
	<?php } else if ($max == $escala->lote && $max != 1) {?>
		<a href="funcao.php?action=ordenar&ordem=1&lote=<?php echo $escala->lote?>&data=<?php echo $data?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
	<?php } else if ($max == 1) {
} else {?>
		<a href="funcao.php?action=ordenar&ordem=1&lote=<?php echo $escala->lote?>&data=<?php echo $data?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
		<a href="funcao.php?action=ordenar&ordem=-1&lote=<?php echo $escala->lote?>&data=<?php echo $data?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
	<?php }?>
	<a href="funcao.php?action=deleteEscala&id=<?php echo $escala->id?>&data=<?php echo $data?>&lote=<?php echo $escala->lote?>&pe=<?php echo $escala->pre_escala?>"><i class="glyphicon glyphicon-remove"></i></a>
	</td>
</tr>