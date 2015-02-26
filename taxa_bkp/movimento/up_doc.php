<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php $item = $_REQUEST['idItem']; ?>
<div class="acao_pagina">Upload de Documentos</div>
<div class="KT_tngtable" align="center">
  <div class="ewFooterRow"><form action="funcao.php?cor=<?php echo $_REQUEST['cor']; ?>&
  													mes=<?php echo $_REQUEST['mes']; ?>&
                                                    ano=<?php echo $_REQUEST['ano']; ?>&
                                                    item=<?php echo $_REQUEST['item'];?>&
                                                    idItem=<?php echo $item;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <label>
      <input name="doc" type="file" id="doc" size="100" accept="application/rtf" />
      <br />
      <input type="submit" name="action" id="action" value="Upload" />
    </label>
  </form></div>
  
</div><div class="ewHighlightSearch" id="superbox-container">
	<h1>Arquivo referente ao mês <?php echo $_REQUEST['mes'].'/'.$_REQUEST['ano']; ?>:<br />
    Item = <?php echo $_REQUEST['item']; ?>
    </h1>
</div>
<p align="center">Atenção!!! Enviar somente arquivos 'PDF', pois estes serão posteriormente enviados a internet.<br />
É de extrema responsabilidade do usuario conferir os documentos que seão enviados.</p>
</body>
</html>