<?php

error_reporting(0);
require_once("../../Connections/conn.php");
mysql_select_db($database_conn, $conn);
require("../../bibliotecas/fpdf/fpdf.php");

define("mes", date('m'), strtotime($_GET['data1']));
define("ano", date('Y', strtotime($_REQUEST['data1'])));

class PDF extends FPDF {

    function Header() {
        date_default_timezone_set("Brazil/East");
        define('hora', date("H") - 1);
//        $this->Image("../../logo/Logo.JPG", 6, 5, 35, 15, "JPG");
        $this->SetFont("Arial", "B", 20);
        $this->Cell(1);
        $this->Cell(40, 11, "", "TLR", 0, "C");
        $this->Cell(250, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
        $this->Ln(10);
        $this->Cell(1);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(40, 11, "", "BLR", 0, "C");
        $this->Cell(250, 11, utf8_decode("Relatorio de Analise de Rendimento || Mes: " . mes . '/' . ano), "RLB", 0, "C");
        $this->Ln(15);
        $fill = 0;
    }
    function abateMes($ano){
        $sql = "Select 
                    MONTH(a.`data`) as mes,
                    sum(b.`peso`) as PesoAbate
                from
                    `taxa` a
                    inner join `taxaitens` b on(a.`id` = b.`idTaxa`)
                    inner join `taxa_item` c on(b.`idItem` = c.`id`)
                where
                    c.`grupo` = 1 and
                    YEAR(a.`data`) = $ano
                group by 
                    month(a.`data`)";
        
        $qr = mysql_query($sql) or die($sql);
        
        while ($rs = mysql_fetch_object($qr)){
            $res[$rs->mes] = $rs->PesoAbate;
        }        
        return $res;
        }
    function Dados() {
        $this->SetFillColor(170);
        $this->SetDrawColor(220);

        $w = array(15, 60, 15);
        $this->Ln(4.5);
        $this->SetFont('Arial', 'i', 6);

        $sql = "Select 
                            a.cod,
                            a.`descricao` as produto, 
                            a.tipo,
                            month(b.data_producao) as mes,
                            YEAR(b.data_producao) as ano,
                            sum(b.peso) as producao
                        from 
                            `ind_produtos` a 
                            inner join `ind_producao` b on(a.`cod` = b.`produto`)
                        where
                            year(b.data_producao) = " . ano . "
                        group by 
                            a.cod,MONTH(b.data_producao), YEAR(b.data_producao)
                        order by 
                            a.tipo, a.descricao";

        $qr = mysql_query($sql) or die(mysql_error());
        
        $abate = $this->abateMes(ano);

        while ($res = mysql_fetch_object($qr)) {            
            $rs[$res->tipo][$res->cod.' - '.$res->produto][$res->mes] = ($res->producao/$abate[$res->mes])*100;
                empty($total[$res->tipo][$res->mes]) ? $total[$res->tipo][$res->mes] = 0 : $total[$res->tipo][$res->mes] = $total[$res->tipo][$res->mes];
            $total[$res->tipo][$res->mes] = $total[$res->tipo][$res->mes] + (($res->producao/$abate[$res->mes])*100);
        }

        //Formatação dos titulos da tabela
        foreach ($rs as $tipo=>$prod) {
             $f = 0;
            $this->AddPage();
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(265, 3.5, $tipo, 1, 0, "C", 0);
            $this->setFillColor(100,100,100);
            $this->Ln();
                        $this->Cell($w[1],3.5,utf8_decode("Produtos"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Jan"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Fev"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Mar"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Abr"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Mai"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Jun"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Jul"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Ago"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Set"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Out"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Nov"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Dez"),1,0,"C",1);
			$this->Cell($w[2],3.5,utf8_decode("Media"),1,0,"C",1);
                        $this->Ln();
            foreach ($prod as $prd=>$mes){
                $this->setFillColor(200,200,200);
                $this->SetFont('Arial', '', 6.5);
                
                $this->Cell($w[1],3.5,$prd,1,0,"L",$f);
                $this->Cell($w[2],3.5,number_format($mes[1],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[2],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[3],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[4],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[5],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[6],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[7],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[8],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[9],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[10],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[11],3,',','.')." %",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($mes[12],3,',','.')." %",1,0,"R",$f);
                    $media = array_sum($prod[$prd]) / count($prod[$prd]);
                $this->Cell($w[2],3.5,number_format($media,3,',','.')." %",1,0,"R",1);
                $f = !$f;
                $this->Ln();
            }
                $this->Cell($w[1],3.5,"Total Parcial",1,0,"R",$f);
                $this->Cell($w[2],3.5,number_format($total[$tipo][1],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][2],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][3],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][4],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][5],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][6],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][7],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][8],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][9],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][10],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][11],3,',','.')." %",1,0,"R",1);
                $this->Cell($w[2],3.5,number_format($total[$tipo][12],3,',','.')." %",1,0,"R",1);
        }
    }
    function Footer() {
        $this->SetFont("Arial", "I", 7);
        $this->Cell(90, 50, utf8_decode("Página ") . $this->PageNo() . " Processado em " . date('d-m-Y ' . hora . ':i'), 0, 0, "C");
    }

}

$pdf = new PDF("L", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(1, 1, 1, 1);
$pdf->Dados();
$pdf->Output();
?>

