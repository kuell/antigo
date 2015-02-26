$(document).ready(function(){
			$("select[name=avaliacao]").change(function(){
					$("select[name=categoria]").html("<option value='0'>Carregando ...</option>");
			$.post("../funcao.php?action=busca_categ",
				   {avaliacao:$(this).val()},
				   function(valor){
					   $("select[name=categoria]").html(valor);})
														}) 
			$("select[name=procedimento]").change(function(){
					$("select[name=categoria]").html("<option value='0'>Carregando ...</option>");
			$.post("../funcao.php?action=busca_categ",
				   {procedimento:$(this).val()},
				   function(valor){
					   $("select[name=categoria]").html(valor);})
														})
			$("select[name=categoria]").change(function(){
					$("select[name=sub]").html("<option value='0'>Carregando ...</option>");
			$.post("../funcao.php?action=busca_sub",
				   {categoria:$(this).val()},
				   function(valor){
					   $("select[name=sub]").html(valor);})
			
														})
			$("select[name=setor]").change(function(){
					$("select[name=categ]").html("<option value='0'>Carregando ...</option>");
			$.post("../funcao.php?action=busca_categoria",
				   {setor:$(this).val()},
				   function(valor){
					   $("select[name=categ]").html(valor);})
			
														})
			$("select[name=categ]").change(function(){
					$("select[name=posto]").html("<option value='0'>Carregando ...</option>");
			$.post("../funcao.php?action=busca_posto",
				   {categ:$(this).val()},
				   function(valor){
					   $("select[name=posto]").html(valor);})
			
														})
			
			
							  					  })
$(document).ready(function(){
				$("select").ready(function(){
					$("select").css('width', '300px')
										   
										   })

						   })