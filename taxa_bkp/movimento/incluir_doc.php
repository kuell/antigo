<?php require('../../Connections/conn.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox.js"></script>
<script type="text/javascript">
$(function(){		   
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' />", // Loading text
				closeTxt: "<button onclick='window.location.reload()'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
	
});
		function abrir(pagina){
			window.open(pagina,'Print','whidt=800, heigt=600,toolbar=yes,channelmode=yes');
			
			}


</script>
</head>
<body>
<div class="acao_pagina">Incluir documento referente</div>
<?php
	$cor = $_REQUEST['cor'];
	$mes = $_REQUEST['mes'];
	$ano = $_REQUEST['ano'];
?>

<form id="form1" name="form1" method="post" action="">
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="row">Corretor:</th>
    <td>
   <label>
      <select name="cor" id="cor" >
      	<?php
	if(!$_REQUEST['cor']){
			$sql = "Select * from corretor";
	}else{
			$sql = "Select * from corretor where cor_id ='".$_REQUEST['cor']."'";
	}
			$query	= mysql_query($sql) or die(musql_error());
			while($res = mysql_fetch_assoc($query)){
		?>
        <option value="<?php echo $res['cor_id']; ?>"><?php echo $res['cor_cod']; ?> - <?php echo $res['cor_nome'] ;?></option>
      <?php } ?>
      </select>
    </label>
      </td>
  </tr>
  <?php if($_REQUEST['cor'] != ""){ ?>
  <tr>
    <th scope="row">Referente ao M&ecirc;s:</th>
    <td><label>
      <select name="mes" id="mes">
        <option value="" <?php if ((strcmp("", "teste"))) {echo "selected=\"selected\"";} ?> <?php if (!(strcmp("", $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Selecione ...</option>
        <option value="01" <?php if (!(strcmp(01, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Janeiro</option>
        <option value="02" <?php if (!(strcmp(02, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Fevereiro</option>
        <option value="03" <?php if (!(strcmp(03, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Mar&ccedil;o</option>
        <option value="04" <?php if (!(strcmp(04, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Abril</option>
        <option value="05" <?php if (!(strcmp(05, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Maio</option>
        <option value="06" <?php if (!(strcmp(06, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Junho</option>
        <option value="07" <?php if (!(strcmp(07, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Julho</option>
        <option value="08" <?php if (!(strcmp(08, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Agosto</option>
        <option value="09" <?php if (!(strcmp(09, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Setembro</option>
        <option value="10" <?php if (!(strcmp(10, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Outubro</option>
        <option value="11" <?php if (!(strcmp(11, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Novembro</option>
        <option value="12" <?php if (!(strcmp(12, $_REQUEST['mes']))) {echo "selected=\"selected\"";} ?>>Dezembro</option>
      </select>
      <input type="text" name="ano" id="ano" value="<?php echo date('Y');?>" />
    </label>
    </td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="2" scope="row"><div align="center">
      <label>
        <input type="submit" value="Buscar" />
      </label>
    </div></th>
    </tr>
</table>
<?php if($_REQUEST['cor'] != "" && $_REQUEST['mes'] != ""){ ?>
<table width="auto%" border="0" align="center" class="KT_tngtable">
  <tr>
    <th scope="col">M&ecirc;s</th>
    <th scope="col">Descri&ccedil;&atilde;o do Item</th>
    <th scope="col">Print</th>
    <th scope="col">INC</th>
    <th scope="col">ENV</th>
  </tr>
  <?php 
  	$sql = "Select * from taxaDoc where corretor = '".$_REQUEST['cor']."' and 
										tipo = 'item' and 
										month(data) = '".$_REQUEST['mes']."' and 
										year(data) = '".$_REQUEST['ano']."'group by item";
  	$query = mysql_query($sql) or die (mysql_error());
	while($res = mysql_fetch_assoc($query)){
  ?> 
  
  <tr>
    <td scope="row"><?php echo date('m-Y', strtotime($res['data']));?></td>
    <td><?php echo $res['item']?></td>

	<?php if(!$res['doc']){ ?>
    <td><div align="center"><img src="../../img/bloqueado.png" width="16" height="16" /></div></td>
    <?php }else{ ?>    
    <td><div align="center"><a href="#" onclick="abrir('<?php echo $res['doc'] ?>')"><img src="../../img/print.png" alt="" width="16" height="16" title="Visualizar" /></a></div></td>
    <?php } ?>
    <td><a href="up_doc.php?cor=<?php echo $cor.'&mes='.$mes.'&ano='.$ano.'&item='.$res['item'].'&idItem='.$res['prod_id']; ?>" rel="superbox[iframe][700x500]"><img src="../../img/upload.png" alt="" width="16" height="16" title="adicionar documento" /></a></td>
    <td><img src="../../img/enviar_internet.png" width="16" height="16" /></td>
  </tr>
  <?php } ?>
  <tr>
    <th scope="row">&nbsp;</th>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<?php } ?> 
</form>
</body>
</html>