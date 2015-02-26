<?php
include_once('../class/fpdf/FPDF.php');

include_once("../class/PHPJasperXML.inc");

include_once ('../setting.php');

$xml = simplexml_load_file("../jrxml/relatorio_geral.jrxml"); //informe onde est� seu arquivo jrxml

$PHPJasperXML = new PHPJasperXML();

$PHPJasperXML->debugsql=false;

$data1=$_GET["data_i"]; //recebendo o par�metro descri��o

$PHPJasperXML->arrayParameter=array("data_i"=>$data1); //passa o par�metro cadastrado no iReport

$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->connect($server,$user,$pass,$db);

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);

$PHPJasperXML->outpage("I");

?> 