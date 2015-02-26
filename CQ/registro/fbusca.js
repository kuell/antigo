$(document).ready(function(){
			$("select[name=avaliacao]").blur(function(){
					$("select[name=categoria]").html("<option value='0'>Carregando ...</option>");
			$.post("funcao.php?action=busca_categ",
				   {avaliacao:$(this).val()},
				   function(valor){
					   $("select[name=categoria]").html(valor);})
														}) 
			$("select[name=procedimento]").blur(function(){
					$("select[name=categoria]").html("<option value='0'>Carregando ...</option>");
			$.post("funcao.php?action=busca_categ",
				   {procedimento:$(this).val()},
				   function(valor){
					   $("select[name=categoria]").html(valor);})
														})
			$("select[name=categoria]").blur(function(){
					$("select[name=sub]").html("<option value='0'>Carregando ...</option>");
			$.post("funcao.php?action=busca_sub",
				   {categoria:$(this).val()},
				   function(valor){
					   $("select[name=sub]").html(valor);})
														})
			$("select[name=setor]").blur(function(){
					$("select[name=itens]").html("<option value='0'>Carregando ...</option>");
			$.post("funcao.php?action=busca_item",
				   {setor:$(this).val()},
				   function(valor){
					   $("select[name=itens").html(valor);})
														})
			
							  					  })