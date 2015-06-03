<?php
require ("class/TaxaItens.class.php");

$item = new TaxaItens();

$itens = $item->RunSelect('Select * from taxa_item');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>Untitled Document</title>
<link href="../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../css/calendario.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript" src="../js/jquery.ui.js"></script>
<script type="text/javascript" src="../js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../js/scripts.js"></script>
  <link rel="stylesheet" type="text/css" href="../js/chosen_v1.4.1/chosen.css">

  <script src="../js/chosen_v1.4.1/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="../js/chosen_v1.4.1/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<body>

<div class="col-md-8">
	<form class="form-horizontal">
		<fieldset>
			<legend>Relatorio por itens</legend>
		  		<div class="control-group">
		    		<label class="control-label">Item: </label>
			    	<div class="controls">
				        <select name="item" id="item">

<?php foreach ($itens as $it) {?>
			<option value="<?php echo $it['id']?>"><?php echo utf8_decode($it['descricao'])?></option>
	<?php }?>

				        </select>
			    	</div>
		  		</div>

				<div class="control-group">
				    <label class="control-label">Data: </label>
				    <div class="controls">
				        <input type="text" id="dataI" class="data" value="{$smarty.now|date_format:"01/%m/%Y"}"> até
				        <input type="text" id="dataF" class="data" value="{$smarty.now|date_format:"%d/%m/%Y"}">
				    </div>
				</div>

				<div class="control-group">
				    <div class="controls well">
				        <button type="button" name="buscar" class="btn btn-primary">Buscar</button>
				    </div>
				</div>

		</fieldset>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		$('#item').chosen()
		$('#buscar').bind('click',  function() {
			datai = $('#datai').val()
			dataf = $('#dataf').val()
		});

	})
</script>

</body>
</html>