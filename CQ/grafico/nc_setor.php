<?php
# PHPlot Example: Pie/text-data-single
require_once ('../../bibliotecas/phplot/phplot.php');
require("../../Connections/conn.php");
	mysql_select_db($database_conn, $conn);
if($_REQUEST['data_1'] == ""){
	$dia = 1;
	$data1 = date("Y-m-".$dia."");
	}
	else{
	$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));
	}
if($_REQUEST['data_2'] == ""){
	$data2 = date('Y-m-d');
	}
	else{
	$data2 = date('Y-m-d', strtotime($_REQUEST['data_2']));
	}
	$sql = "Select
	setor.setor as setor,
			(select count(*) from `registro_controle` where `registro_controle`.`setor` = `setor`.`id_setor` and data BETWEEN '$data1' and '$data2') as itensNC,
			(SELECT sum(QUANTIDADE) from `registro_controle` where `registro_controle`.`setor` = `setor`.`id_setor` and data BETWEEN '$data1' and '$data2') as qtd_total
		from
			`registro_controle` INNER join setor on(`registro_controle`.`setor` = `setor`.`id_setor`)	
		where
			data BETWEEN '$data1' and '$data2'   
		group by
			`setor`.setor
		order by
			qtd_total desc";
		$qr = mysql_query($sql) or die (mysql_error());
# The data labels aren't used directly by PHPlot. They are here for our
# reference, and we copy them to the legend below.
while($campo = mysql_fetch_assoc($qr)){
$data[] = array(wordwrap($campo['setor'], 10, "\n"), round($campo['itensNC'],2),round($campo['qtd_total'],2));
}



$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain'); // Improves presentation in the manual
$plot->SetPlotType('linepoints');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);
$plot->SetTitle(utf8_decode("Não Conformidades por Setor")
							."\n de ".date('d-m-Y', strtotime($data1))." a ".date('d-m-Y', strtotime($data2)));

# Turn on Y data labels:
$plot->SetYDataLabelPos('plotin');
$plot->SetLegend(array(utf8_decode('Quantidade de Itens Não Conformes'), utf8_decode('Quantidade de Não Conformidades')));
# Turn on X data label lines (drawn from X axis up to data point):
$plot->SetDrawXDataLabelLines(True);

# With Y data labels, we don't need Y ticks, Y tick labels, or grid lines.
$plot->SetYTickLabelPos('none');
$plot->SetYTickPos('none');
$plot->SetDrawYGrid(False);
# X tick marks are meaningless with this data:
$plot->SetXTickPos('none');
$plot->SetXTickLabelPos('none');

$plot->SetOutputFile('Teste.pdf');

$plot->DrawGraph();

/*$plot = new PHPlot(1600, 1000);
# Main plot title:
$plot->SetTitle(utf8_decode("Não Conformidades por setor \n De: ".date('d/m/Y', strtotime($data1))." a ".date('d/m/Y', strtotime($data2)).""));
$plot->SetLegend(array('Pat. Custo', 'Part. Registro'));
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->SetPlotAreaWorld(0);
$plot->SetYTickPos('none');
$plot->SetXTickPos('none');
$plot->SetXTickLabelPos('none');
$plot->SetXDataLabelPos('plotin');
$plot->SetDrawXGrid(FALSE);
$plot->SetShading(2);
$plot->SetDataValues($data);
$plot->SetDataType('text-data-yx');
$plot->SetPlotType('bars');
$plot->SetXTickLabelPos('none');
$plot->SetImageBorderType('plain');

$plot->DrawGraph(); */
?>