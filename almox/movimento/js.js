	function acao(tipo){
		
		data = document.getElementById('data').value
		grupo = document.getElementById('grupo').value
		
		
		switch (tipo){
			case 'entrada':
			     qtd = document.getElementById('qtd_entrada').value
				 valor = document.getElementById('val_entrada').value
				if(qtd == '' || valor == ''){
					alert("O valor é nulo")
					return false
					}
					
					location = 'funcao.php?funcao=incluir&data='+data+'&grupo='+grupo+'&tipo='+tipo+'&qtd='+qtd+'&valor='+valor
				
				back;
			case 'deventrada':
			     qtd = document.getElementById('qtd_devEntrada').value
				 valor = document.getElementById('val_devEntrada').value
				if(qtd == '' || valor == ''){
					alert("O valor é nulo")
					return false
					}
					
					location = 'funcao.php?funcao=incluir&data='+data+'&grupo='+grupo+'&tipo='+tipo+'&qtd='+qtd+'&valor='+valor
				
				back;
			case 'devsaida':
			     qtd = document.getElementById('qtd_devSaida').value
				 valor = document.getElementById('val_devSaida').value
				if(qtd == '' || valor == ''){
					alert("O valor é nulo")
					return false
					}
					
					location = 'funcao.php?funcao=incluir&data='+data+'&grupo='+grupo+'&tipo='+tipo+'&qtd='+qtd+'&valor='+valor
				
				back;
			case 'saida':
			     qtd = document.getElementById('qtd_saida').value
				 valor = document.getElementById('val_saida').value
				if(qtd == '' || valor == ''){
					alert("O valor é nulo")
					return false
					}
					
					location = 'funcao.php?funcao=incluir&data='+data+'&grupo='+grupo+'&tipo='+tipo+'&qtd='+qtd+'&valor='+valor
				
				back;
			case 'ctf':
			     qtd = document.getElementById('qtd_ctf').value
				 valor = document.getElementById('val_ctf').value
				if(qtd == '' || valor == ''){
					alert("O valor é nulo")
					return false
					}
					
					location = 'funcao.php?funcao=incluir&data='+data+'&grupo='+grupo+'&tipo='+tipo+'&qtd='+qtd+'&valor='+valor
				
				back;
			
			
			}		
		}

	function busca(id){
		data = 
		location = '?id='+id+'&data='+document.getElementById('data').value
		}
	function excluir(tipo){

		data = document.getElementById('data').value
		grupo = document.getElementById('grupo').value
		location = 'funcao.php?data='+data+'&tipo='+tipo+'&grupo='+grupo+'&funcao=excluir'

		
		}
	function calcula(){
		
		estoque_atual = parseFloat(((document.getElementById('estoque_atual').value).replace('.','')).replace(',','.'))
		valor_atual = parseFloat((((document.getElementById('valor_atual').value).replace('.','')).replace(',','.')).replace('R$',""))
		alert(valor_atual)
		
		qtd_entrada = parseFloat(((document.getElementById('qtd_entrada').value).replace('.','')).replace(',','.'))
		val_entrada = parseFloat(((document.getElementById('val_entrada').value).replace('.','')).replace(',','.'))
		alert(val_entrada)
		
		qtd_devEntrada = parseFloat(((document.getElementById('qtd_devEntrada').value).replace('.','')).replace(',','.'))
		val_devEntrada = parseFloat(((document.getElementById('val_devEntrada').value).replace('.','')).replace(',','.'))
		alert(val_devEntrada)
		
		estoque = parseFloat(estoque_atual+qtd_entrada-qtd_devEntrada)
		valor = parseFloat(valor_atual + val_entrada-val_devEntrada)
		alert(valor)
		
		document.getElementById('estoque').value = (estoque*100)/100
		document.getElementById('valor').value = valor
		
	
		
		}