<?php
	require ('../bibliotecas/adodb/adodb.inc.php');
	
	class conexao
	{
	var	$tipo_banco		=	"mysql";
	var	$servidor		=	"tiago-pc";
	var	$usuario		=	"root";
	var	$senha			=	"";
	var	$banco			=	"sig";
			
			function conecao()
			{
			$this->banco = NewADOConnection($this->tipo_banco);
			$this->banco->dialect	= 3;
			$this->banco->debug 	= true;
			$this->banco->Connect($this->servidor, $this->usuario,$this->senha);
			}
	}
	
	$con =  new conexao();

	if($con)
	print "Conectado";
	else
	print "Não Conectou";
?>