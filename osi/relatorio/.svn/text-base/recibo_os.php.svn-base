<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('../../bibliotecas/phpjasper/class/fpdf/fpdf.php');
include_once("../../bibliotecas/phpjasper/class/PHPJasperXML.inc");
include_once ('../../bibliotecas/phpjasper/setting.php');


$xml =  simplexml_load_file("jasper/recibo_osi.jrxml");


$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$id = $_REQUEST['id_osi'];
$PHPJasperXML->arrayParameter=array("id"=>$id);
$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


?>