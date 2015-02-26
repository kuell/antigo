<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery.min.js" language="javascript"></script>
<script src="../bibliotecas/mascara.js" language="javascript"></script>
<script type="text/javascript">
	$(function (){
				$(".data").mask('99-99-9999');
				$("table").css("width","400px");
				$("table th").css("font-size","20px");
				$("button").css("font-size","20px");
				})
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
<div class="acao_pagina">Relatorios Gerenciais</div>
<form id="form1" name="form1" method="post" action="">
  <table width="auto%" border="0" align="center" class="KT_tngtable">
    <tr>
      <th>Periodo</th>
      <td rowspan="2"><label>
        <input type="text" name="data1" id="data1" class="data" value="<?php echo date('01-m-Y')?>"/>
      </label>
        a
        <label>
          <input type="text" name="data2" id="data2" class="data" value="<?php echo date('d-m-Y')?>"/>
        </label></td>
    </tr>

  </table>
  <br />
  <table border="0" align="center" class="KT_tngtable">
    <tr class="acao_pagina">
      <th colspan="2">Analise de Corretores</th>
    </tr>
    <tr>
      <td><label>
        <input type="button" name="Rendimento / Corretor" id="Rendimento / Corretor" value="Rendimento / Corretor" onclick="abre('rend_cor.php')" />
      </label></td>
      <td><input type="button" name="Rendimento / Corretor2" id="Rendimento / Corretor2" value="Balanço Fiscal / Corretor" onclick="abre('rend_balFiscal.php')" /></td>
    </tr>
    <tr>
      <td><input type="button" name="Rendimento / Corretor3" id="Rendimento / Corretor3" value="Resultado / Corretor" onclick="abre('rend_resultado.php')" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table border="0" align="center" class="KT_tngtable">
    <tr class="acao_pagina">
      <th colspan="3">Industria e Faturamento</th>
    </tr>
    <tr>
      <td><input type="button" name="Rendimento / Corretor4" id="Rendimento / Corretor4" value="Analise de Rendimento" onclick="abre('ind_analiseRend.php')" /></td>
      <td><input type="button" name="Custos de Produção" id="Custos de Produção" value="Custos de Produção  (mensal)" onclick="abre('apuracao_custo_prod.php')" /></td>
	  <td><input type="button" name="Custos de Produção" id="Custos de Produção" value="Custos de Produção  (diario)" onclick="abre('apuracao_custo_prod_diario.php')" /></td>
    </tr>
  </table>
  <table border="0" align="center" class="KT_tngtable">
    <tr class="acao_pagina">
      <th colspan="4">Recursos Humanos</th>
    </tr>
    <tr>
      <td><input type="button" name="Rendimento / Corretor5" id="Rendimento / Corretor5" value="Balanço RH" onclick="abre('rh_balanco_geral.php')" /></td>
	  <td><input type="button" name="Quadro de Funcionarios" id="Quadro de Funcionarios" value="Quadro de Funcionarios" onclick="abre('rh/quadro_funcionarios.php')" /></td>
	  <td><input type="button" name="matriz" id="matriz" value="Matriz do Balanço" onclick="abre('rh/matriz_balanco.php')" /></td>
    <td>
      <input type="button" name="analiseGlobal" id="analiseGlobal" value="Analise Global" onclick="abreParametro('rh/rh_balanco_analise_global.php', 'setor')" /><br />
      <select id="setor">
        <option value="">Selecione um setor ...</option>
<?php
$conn = new mysqli('localhost', 'root', 'aporedux', 'sig');
$sql  = "select * from setor where rh = 1";
$qr   = $conn->query($sql) or die('Erro na obtensao dos dados'.$sql);
while ($res = $qr->fetch_object()) {
	?>
								   <option value="<?php echo $res->id_setor;?>"><?php echo $res->setor;
	?></option>
	<?php
}
?>
      </select>
    </td>
    </tr>
  </table>
  <p></p>

</form>
</body>
</html>