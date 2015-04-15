<?php
$corretor = $cor->getCorretor($pre->corretor);

?>

<tr>
	<td><?php echo $corretor->nome.' - '.$corretor->codigo_interno?></td>
	<td><?php echo $pre->pecuarista?></td>
	<td><?php echo $pre->qtdBoi?></td>
	<td><?php echo $pre->qtdVaca?></td>
	<td><?php echo $pre->qtdNov?></td>
	<td><?php echo $pre->qtdTouro?></td>
	<td>

<?php if ($pre->situacao == 'e') {?>
	<i class="glyphicon glyphicon-lock"></i>
	<?php } else {?>

				<a href="funcao.php?action=delete&id=<?php echo $pre->id?>" title="Excluir"><i class="glyphicon glyphicon-remove"></i></a>
				<a href="funcao.php?action=confirma&id=<?php echo $pre->id?>&data=<?php echo $data?>" title="Confirmar"><i class="glyphicon glyphicon-ok"></i></a>
	<?php }?>
</td>
</tr>