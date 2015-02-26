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
				*,
				setor.*,
				(select count(*) from registro_controle where `registro_controle`.`ITEM` = `itens`.`ID_ITEM` and `registro_controle`.`setor` = `setor`.`id_setor`
							  and data between '$data1' and '$data2') as quantidade
			from
				setor inner join itens on(`setor`.`id_setor` = `itens`.`setor`)
			where
				setor.id_setor = '".$_REQUEST['setor']."'
			order by 
				quantidade desc
			limit 10";
		$qr = mysql_query($sql) or die (mysql_error());
# The data labels aren't used directly by PHPlot. They are here for our
# reference, and we copy them to the legend below.
while($campo = mysql_fetch_assoc($qr)){
$data[] = array(wordwrap($campo['DESC_ITEM'], 10, "\n"), round($campo['quantidade'],2));
$setor = $campo['setor'];
}



$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain'); // Improves presentation in the manual
$plot->SetPlotType('linepoints');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);
$plot->SetTitle(utf8_decode("Não Conformidades no Setor de ").$setor
							."\n de ".date('d-m-Y', strtotime($data1))." a ".date('d-m-Y', strtotime($data2)));

# Turn on Y data labels:
$plot->SetYDataLabelPos('plotin');

# Turn on X data label lines (drawn from X axis up to data point):
$plot->SetDrawXDataLabelLines(True);

# With Y data labels, we don't need Y ticks, Y tick labels, or grid lines.
$plot->SetYTickLabelPos('none');
$plot->SetYTickPos('none');
$plot->SetDrawYGrid(False);
# X tick marks are meaningless with this data:
$plot->SetXTickPos('none');
$plot->SetXTickLabelPos('none');

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

<button>Imprimir</button>
