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
	$sql = "select `setor`.`setor` as setor,     
		(select count(*) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') as registros_setor, 
		(select (((select count(*) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2')* 100)/(select count(*) from `ordem_externa_vew` where data_envio between '$data1' and '$data2' ))) as part_registro,     
		(Select	sum(preco_servico) from	`ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') as custo_setor,     
		((Select sum(preco_servico) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') * 100 / (select sum(preco_servico) from ordem_externa_vew where data_envio between '$data1' and '$data2')) as part_setor,
		(select count(*) FROM ordem_externa_vew where data_envio between '$data1' and '$data2') as total_registros,
		(select sum(preco_servico) from ordem_externa_vew where data_envio between '$data1' and '$data2') as total_custos
	from  	
		`setor` join ordem_externa_vew on(`setor`.`setor` = `ordem_externa_vew`.`setor`) 
	group by 	
		`setor`.`setor`
	order by
		part_setor";
		$qr = mysql_query($sql) or die (mysql_error());
# The data labels aren't used directly by PHPlot. They are here for our
# reference, and we copy them to the legend below.
while($campo = mysql_fetch_assoc($qr)){
$data[] = array($campo['setor'], round($campo['part_setor'],2),round($campo['part_registro'],2));
}
$plot = new PHPlot(1600, 1000);
# Main plot title:
$plot->SetTitle(utf8_decode("Participação Custo/Registro \n De: ".date('d/m/Y', strtotime($data1))." a ".date('d/m/Y', strtotime($data2)).""));
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

$plot->DrawGraph();
?>

<button>Imprimir</button>
