
<?php
include_once('../class/fpdf/fpdf.php');

include_once("../class/PHPJasperXML.inc");

include_once ('../setting.php');

$xml = simplexml_load_file("../jrxml/recibo1.jrxml"); //informe onde est� seu arquivo jrxml

$PHPJasperXML = new PHPJasperXML();

$PHPJasperXML->debugsql=false;

$descricao=$_GET["descricao"]; //recebendo o par�metro descri��o

$PHPJasperXML->arrayParameter=array("descricao"=>$descricao); //passa o par�metro cadastrado no iReport

$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->connect($server,$user,$pass,$db);

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);

$PHPJasperXML->outpage("I");

?> 