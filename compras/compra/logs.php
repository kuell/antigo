<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" /> 
<link href="../../js/modal/jquery.superbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/modal/jquery.superbox-min.js"></script>
<script type="text/javascript">
$(function(){
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' /> Carregando...", // Loading text
				closeTxt: "<button>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next" // "Next" button text
};		   
	$.superbox();
});
</script>
</head>
<body>
<div class="acao_pagina">Logs de Rotina / Compras e Manuten��o</div>
<?php
// pega o endere�o do diret�rio
$diretorio = "logs"; 
// abre o diret�rio
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}
/* O que fizemos aqui, foi justamente, pegar o diret�rio, abri-lo e l�-lo.

Continuando, vamos usar:

sort: ordena os vetores (arrays), de acordo com os par�metros informados. Aqui estou ordenando por pastas e depois arquivos */
// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado � uma pasta
   		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item � vari�vel de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item � vari�vel de arquivos
			$arquivos[]=$listar;
		}
   }
}
/* Vimos acima, a express�o is_dir, indicando que as a��es devem esnt�o ser executadas, ali mesmo, no diret�rio que j� foi aberto e lido. As a��es que executamos ali, foram: ver se tem pastas, listar. Ver se tem arquivos, listar.

Agora, se houverem pastas, ser�o apresentadas antes dos arquivos, em odem alfab�tica.
Se n�o houverem, ser�o apresentados apenas os arquivos, na mesma ordem.
E se houverem os dois, ser�o mostrados igualmente. */

// lista as pastas se houverem
if ($pastas != "" ) { 
foreach($pastas as $listar){
   print "Pasta: <a href='$listar'>$listar</a><br>";}
   }
// lista os arquivos se houverem
if ($arquivos != "") {
	print "<ul>";
foreach($arquivos as $listar){
   print "<li>Data: <a href='$diretorio/$listar' rel='superbox[iframe][900x500]'>$listar</a></li>";}
   print"</ul>";
   }
?>
</body></html>
