<?php
define('FPDF_FONTPATH', 'font/');
require('fpdf/fpdf.php');

// bd.php deve conter as funções para se conectar no banco de dados
include("../Connections/conn.php");
// busca os dados no banco de dados
$busca = mysql_query("SELECT * FROM ordem_externa_vew");
$total = mysql_query("SELECT SUM(preco_servico) as total FROM ordem_externa_vew");
$pdf = new FPDF();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(4, 5, 'ID', 1);
$pdf->SetX(15);
$pdf->Cell(6, 5, 'DATA',1);
$pdf->SetX(30);
$pdf->Cell(40, 5, 'Requisitante');
$pdf->SetX(66);
$pdf->Cell(40, 5, 'Setor');
while ($resultado = mysql_fetch_array($busca)) {
$pdf->ln();
$pdf->Cell(40, 5, $resultado['id_OSE']);
$pdf->SetX(15);
$pdf->Cell(60, 5, $resultado['data_envio']);
$pdf->SetX(30);
$pdf->Cell(40, 5, $resultado['requisitante']);
$pdf->SetX(65);
$pdf->Cell(40, 5, $resultado['setor']);
}
while ($resultado2 = mysql_fetch_array($total)) {
$pdf->ln();
$pdf->Cell(40, 5, $resultado2['total']);
$pdf->SetX(35);

}
$pdf->Output();
?>