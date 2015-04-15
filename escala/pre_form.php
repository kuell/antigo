<form class="form form-horizontal" action="funcao.php?action=grava" method="POST">
<div class="panel panel-primary">
<div class="panel-heading">
	<div class="panel-titel">
		Novo Lote
	</div>
</div>
<div class="panel-body">
	<input type="hidden" value="<?php echo $data?>" name="data">

	<div class="col-md-12">
			<label>Corretor: </label>
			<select class="form-control" name="corretor">
				<option>Selecione ...</option>
<?php foreach ($cor->lista('and cor_ativo = 1') as $corretor) {
	echo "<option value=".$corretor->cor_id.">".$corretor->cor_cod." - ".utf8_encode($corretor->cor_nome)."</option>";
}?>
			</select>
	</div>

		<label>Pecuarista: </label>
		<input class="form-control" name="pecuarista" placeholder="Nome do Pecuarista" type="text"></input>
		<div class="row">
			<div class="col-md-3">
				<label>Qtd. Boi</label>
				<input class="form-control int" name="qtdBoi" type="number" min="0" value="0"></input>
			</div>
			<div class="col-md-3">
				<label>Qtd. Vaca</label>
				<input class="form-control int" name="qtdVaca" type="number" min="0" value="0"></input>
			</div>
			<div class="col-md-3">
				<label>Qtd. Novilha</label>
				<input class="form-control int" name="qtdNov" type="number" min="0" value="0"></input>
			</div>
			<div class="col-md-3">
				<label>Qtd. Touro</label>
				<input class="form-control int" name="qtdTouro" type="number" min="0" value="0"></input>
			</div>
		</div>

</div>
<div class="panel-footer">
	<button type="submit" class="btn btn-success">Gravar</button>
</div>
</div>
</form>