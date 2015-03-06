<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../css/calendario.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery.min.js" language="javascript"></script>
<script src="../js/jquery.ui.js" type="text/javascript"></script>
<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="../js/jquery.maskMoney.js" type="text/javascript"></script>
<script src="../js/scripts.js" type="text/javascript"></script>

<script type="text/javascript">
	function abre(pagina){
		data1 = document.getElementById('data1').value
		data2 = document.getElementById('data2').value

		window.open('relatorios/'+pagina+'?data1='+data1+'&data2='+data2, 'Imprimir','channelmode=yes')

		}
  function abreParametro(pagina, parametro){

    data1 = document.getElementById('data1').value
    data2 = document.getElementById('data2').value
    param = document.getElementById(parametro).value

    window.open('relatorios/'+pagina+'?data1='+data1+'&data2='+data2+'&'+parametro+'='+param, 'Imprimir','channelmode=yes')

    }

</script>
</head>

<body>
  <div class="well">
      <h3>  Relatorios Gerenciais</h3>
    </p>
  </div>


 <div class="col-md-9 well inverse">
          <div class="col-md-1">
            Periodo:
            </div>
            <div class="col-md-4">
              <input type="text" name="data1" id="data1" class="form-control data" value="<?php echo date('01-m-Y')?>"/>
            </div>
            <div class="col-md-4">
              <input type="text" name="data2" id="data2" class="form-control data" value="<?php echo date('d-m-Y')?>"/>
            </div>

 </div>
 <div class="col-md-9 well">
   <div class="col-md-12">
     <h4>Analise de Corretores</h4>
   </div>
   <div class="col-md-12">
    <input type="button" class="btn btn-primary btn-sm" name="Rendimento / Corretor" id="Rendimento / Corretor" value="Rendimento / Corretor" onclick="abre('rend_cor.php')" />
    <input type="button" class="btn btn-info btn-sm" name="Rendimento / Corretor2" id="Rendimento / Corretor2" value="Balanço Fiscal / Corretor" onclick="abre('rend_balFiscal.php')" />
    <input type="button" class="btn btn-danger btn-sm" name="Rendimento / Corretor3" id="Rendimento / Corretor3" value="Resultado / Corretor" onclick="abre('rend_resultado.php')" />
   </div>
 </div>

<div class="col-md-9 well">
   <div class="col-md-12">
    <div class="col-md-5">
      <h4>Industria e Faturamento</h4>
    </div>
    <div class="col-md-2">
      Tipo de Arquivo:
    </div>
    <div class="col-md-2">
      <select id='tipoArquivo' class="form-control">
        <option value="pdf">PDF</option>
        <option value="xls">Excel</option>
      </select>
    </div>
   </div>
   <div class="col-md-12">
    <input type="button" class="btn btn-warning btn-sm" name="Rendimento / Corretor4" id="Rendimento / Corretor4" value="Analise de Rendimento" onclick="abre('ind_analiseRend.php')" />
    <input type="button" class="btn btn-default btn-sm" name="Custos de Produção" id="Custos de Produção" value="Custos de Produção  (mensal)" onclick="abreParametro('apuracao_custo_prod.php', 'tipoArquivo')" />
    <input type="button" class="btn btn-primary btn-sm" name="Custos de Produção" id="Custos de Produção" value="Custos de Produção  (diario)" onclick="abre('apuracao_custo_prod_diario.php')" />
   </div>
 </div>


<div class="col-md-9 well">
   <div class="col-md-12">
    <div class="col-md-5">
      <h4>Recursos Humanos</h4>
    </div>
    <div class="col-md-2">
      Setor:
    </div>
    <div class="col-md-5">
          <select id="setor" class="form-control">
              <option value="">Selecione um setor ...</option>
<?php
$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
$sql  = "select * from setor where rh = 1";
$qr   = $conn->query($sql) or die('Erro na obtensao dos dados'.$sql);
while ($res = $qr->fetch_object()) {
	?>
																			                    <option value="<?php echo utf8_decode($res->id_setor);?>"><?php echo $res->setor;
	?></option>
	<?php }?>
      </select>
    </div>
   </div>
   <div class="col-md-12">
    <input type="button" class="btn btn-info btn-info" name="matriz" id="matriz" value="Matriz do Balanço" onclick="abre('rh/matriz_balanco.php')" />
    <input type="button" class="btn btn-default btn-sm" name="Rendimento / Corretor5" id="Rendimento / Corretor5" value="Balanço RH" onclick="abre('rh_balanco_geral.php')" />
    <input type="button" class="btn btn-primary btn-sm" name="Quadro de Funcionarios" id="Quadro de Funcionarios" value="Quadro de Funcionarios" onclick="abre('rh/quadro_funcionarios.php')" />
    <input type="button" class="btn btn-danger btn-sm" name="analiseGlobal" id="analiseGlobal" value="Analise Global" onclick="abreParametro('rh/rh_balanco_analise_global.php', 'setor')" />
   </div>
 </div>

</body>
</html>