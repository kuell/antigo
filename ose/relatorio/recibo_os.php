<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('../../bibliotecas/phpjasper/class/fpdf/fpdf.php');
include_once("../../bibliotecas/phpjasper/class/PHPJasperXML.inc");
include_once ('../../bibliotecas/phpjasper/setting.php');


$xml =  simplexml_load_file("rg01.jrxml");


$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$dia1 = $_REQUEST['data_1'];
$dia2 = $_REQUEST['data_2'];
$data1 = date('Y-m-d', strtotime($dia1));
$data2 = date('Y-m-d', strtotime($dia2));

$PHPJasperXML->arrayParameter=array("data_1"=>$data1, "data_2"=>$data2);
$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


?>