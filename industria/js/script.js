// JavaScript Document
 // Validação dos campos
$(function(){
			   $(".texto").keyup(function(){
										valor = $(this).val().toUpperCase()
										$(this).val(valor)
													})
				$(".numero").bind("keyup blur focus", function(e) {            
						e.preventDefault();            
						var expre = /[A-Za-z\.\§\£\@\`\Z\^\~\'\"\!\?\#\$\%\s\¬\_\+\=\.\,\:\;\<\>\|\°\ª\º\]\[\{\}\\ \)\(\*\&\-\/\\]/g;             // REMOVE OS CARACTERES DA EXPRESSAO ACIMA            
						if ($(this).val().match(expre))               
						$(this).val($(this).val().replace(expre,''));     
						}); 
			   })

// Modal 
$(function(){
		   $.superbox.settings = {
				boxId: "superbox", // Id attribute of the "superbox" element
				boxClasses: "", // Class of the "superbox" element
				overlayOpacity: .8, // Background opaqueness
				boxWidth: "600", // Default width of the box
				boxHeight: "400", // Default height of the box
				loadTxt: "<img src='../../js/modal/doc/styles/loader.gif' /> Carregando...", // Loading text
				closeTxt: "<button align='left'>Sair</button>", // "Close" button text
				prevTxt: "Previous", // "Previous" button text
				nextTxt: "Next", // "Next" button texto
};		   
	$.superbox();
});