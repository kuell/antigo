<?php

require ('../../Connections/conect_mysqli.php');
require ('../../Connections/connect_pgsql.php');
require ('../../class/Abate.class.php');
require ('./../../industria/class/IndProducao.class.php');
require ('./../../industria/class/Faturamento.class.php');
require ('../../class/Taxa.class.php');
require ('./../../almox/class/Almoxarifado.class.php');
require ('../../class/CustoProducao.class.php');
require ('../../class/Interno.class.php');
require ('../../rh/class/Produtividade.class.php');
require ('../../rh/class/Balanco.class.php');
require ('../../class/Setor.class.php');
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {
	function Header() {
		$this->Image("../../logo/Logo.jpg", 6, 5, 35, 15, "JPG");
		$this->SetFont("Arial", "B", 20);
		$this->Cell(1);
		$this->Cell(40, 11, "", "TLR", 0, "C");
		$this->Cell(163, 11, "Frizelo Frigorificos Ltda. ", "TLR", 0, "C");
		$this->Ln(10);
		$this->Cell(1);
		$this->SetFont("Arial", "B", 12);
		$this->Cell(40, 11, "", "BLR", 0, "C");
		$this->Cell(163, 11, utf8_decode("Relatorio de Apuração de custos de produção ref: ").$_GET['data1']." / ".$_GET['data2'], "RLB", 0, "C");
		$this->Ln(13);
		$fill = 0;
	}

	function Footer() {
		$this->SetY(-10);
		$this->SetFont("Arial", "I", 7);
		$this->Cell(0, 3.5, utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'), 0, 0, "C");
	}

	function getData($data) {
		$d = explode('/', $data);

		return $d[2].'-'.$d[1].'-'.$d[0];
	}

	function Dados($datai, $dataf) {
		$datai = $this->getData($_GET['data1']);
		$dataf = $this->getData($_GET['data2']);

		$custo = new CustoProducao($datai, $dataf);
		$valor = $custo->apuracaoPorData();

		$this->SetFont("Arial", "", 7);
		$this->SetFillColor(200);
		$this->SetDrawColor(230);

		$this->Cell(50, 3.5, "QTD. ABATE", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->abate->qtd, 2, ',', '.'), 1, 0, "R");
		$this->Ln();

		$this->Cell(50, 3.5, "PESO ABATE", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->abate->peso, 2, ',', '.'), 1, 0, "R");
		$this->Ln(5);

		$this->Cell(50, 3.5, "KG PRODUZIDO", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->pesoProduzido, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, "RENDIMENTO", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->rendimento, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("PREÇO MÉDIO"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->valorMedio, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("PESO MÉDIO POR ANIMAL"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->pesoMedioPorAnimal, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("PESO MÉDIO PRODUZIDO POR ANIMAL"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->pesoMedioProduzidoPorAnimal, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("VALOR MÉDIO POR ANIMAL"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->valorMedioPorAnimal, 2, ',', '.'), 1, 0, "R");
		$this->Ln();

		$this->Cell(50, 3.5, utf8_decode("VALOR DA PRODUÇÃO CORRENTE"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($valor->producao->vpc, 2, ',', '.'), 1, 0, "R");
		$this->Ln(5);

		$this->Cell(60, 3.5, utf8_decode("ITENS"), 0, 0, "L", 1);
		$this->Cell(30, 3.5, utf8_decode("CUSTO TOTAL"), 0, 0, "L", 1);
		$this->Cell(30, 3.5, strtoupper(utf8_decode("custo unit./ abate")), 0, 0, "L", 1);
		$this->Cell(35, 3.5, strtoupper(utf8_decode("custo unit./ produÇÃo")), 0, 0, "L", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("taxas")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->taxa->taxas, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->taxa->taxas/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->taxa->taxas/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("custo comercial (frete/seguro/icms)")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->faturamento->custoComercial, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->faturamento->custoComercial/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->faturamento->custoComercial/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("mÃo de obra direta")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->rh->maoDeObraDireta, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->rh->maoDeObraDireta/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->rh->maoDeObraDireta/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		arsort($valor->rh->direto);

		foreach ($valor->rh->direto as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$valor->abate->peso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("consumo material produtivo")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->consumoMaterialProdutivo, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->consumoMaterialProdutivo/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->almox->consumoMaterialProdutivo/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		arsort($valor->almox->produtivo);

		foreach ($valor->almox->produtivo as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$valor->abate->peso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("energia")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->energia, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->almox->energia/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->almox->energia/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("subtotal custo direto")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->subTotalDireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->subTotalDireto/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->subTotalDireto/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln(5);

		$this->Cell(60, 3.5, strtoupper(utf8_decode("mÃo de obra indireta")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->rh->maoDeObraIndireta, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->maoDeObraIndireta/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->maoDeObraIndireta/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		arsort($valor->rh->indireto);

		foreach ($valor->rh->indireto as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$valor->abate->peso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("consumo diversos")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->consumoDiversos, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->consumoDiversos/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->almox->consumoDiversos/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		arsort($valor->almox->diversos);

		foreach ($valor->almox->diversos as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$valor->abate->peso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("serviÇos")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->servicos, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->servicos/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->almox->servicos/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("oleo diesel")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->oleoDiesel, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->almox->oleoDiesel/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->almox->oleoDiesel/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("Subtotal custo indireto")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->subTotalIndireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($valor->subTotalIndireto/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($valor->subTotalIndireto/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln(5);

		$this->Cell(60, 3.5, strtoupper(utf8_decode("custo total")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->subTotalIndireto+$valor->subTotalDireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format(($valor->subTotalIndireto+$valor->subTotalDireto)/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format(($valor->subTotalIndireto+$valor->subTotalDireto)/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("margem")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($valor->producao->vpc-($valor->subTotalIndireto+$valor->subTotalDireto), 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format(($valor->producao->vpc-($valor->subTotalIndireto+$valor->subTotalDireto))/$valor->abate->peso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format(($valor->producao->vpc-($valor->subTotalIndireto+$valor->subTotalDireto))/$valor->producao->pesoProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		/*










	 */
	}
}

// IF
if ($_GET['tipoArquivo'] == 'pdf') {

	$pdf = new PDF("P", "mm", "A4");
	$pdf->AliasNbPages();
	$pdf->SetMargins(3, 2, 3, 1);
	$pdf->AddPage();

	$pdf->Dados($_GET['data1'], $_GET['data2']);
	$pdf->Output();

}

// ELSE
 else if ($_GET['tipoArquivo'] == 'xls') {

	include ('../../bibliotecas/PHPExcel/PHPExcel.php');

	$datai = implode('-', array_reverse(explode('/', $_GET['data1'])));
	$dataf = implode('-', array_reverse(explode('/', $_GET['data2'])));

	// Instanciamos a classe
	$objPHPExcel = new PHPExcel();
	$custos      = new CustoProducao($datai, $dataf);
	$custo       = $custos->apuracaoPorData();

	// Definimos o estilo da fonte
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

	// Criamos as colunas
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Frizelo Frigorificos Ltda')
	            ->setCellValue('A3', "QTD. ABATE ")
	            ->setCellValue("A4", "PESO ABATE")
	            ->setCellValue("A6", "KG PRODUZIDO")
	            ->setCellValue("A7", "RENDIMENTO")
	            ->setCellValue("A8", "PREÇO MEDIO")
	            ->setCellValue("A9", "KG MEDIO POR CABEÇA")
	            ->setCellValue("A10", "KG MEDIO PRODUZIDO POR CABEÇA")
	            ->setCellValue("A11", "VALOR DA PRODUÇÃO CORRENTE")
	            ->setCellValue("A13", "ITENS")
	            ->setCellValue("B13", "CUSTO TOTAL")
	            ->setCellValue("C13", "CUSTO UNIT./ ABATE")
	            ->setCellValue("D13", "CUSTO UNIT./ PRODUÇÃO")
	            ->setCellValue("A14", "TAXAS")
	            ->setCellValue("A15", "CUSTO COMERCIAL (FRETE/SEGURO/ICMS)")
	            ->setCellValue("A16", "MÃO DE OBRA DIRETA");
	// Podemos configurar diferentes larguras paras as colunas como padrão
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);

	// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'QTD ABATE');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $custo->abate->qtd);
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, 'PESO ABATE');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, $custo->abate->peso);
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 6, 'KG PRODUZIDO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 6, $custo->producao->pesoProduzido);
	$linha++;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 7, $custo->producao->rendimento);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, $custo->producao->valorMedio);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 9, $custo->producao->pesoPorAnimal);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 10, $custo->producao->pesoMedioProduzidoPorAnimal);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 11, $custo->producao->vpc);

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 14, $custo->taxa->taxas);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 14, ($custo->taxa->taxas/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 14, ($custo->taxa->taxas/$custo->producao->pesoProduzido));

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 15, $custo->faturamento->custoComercial);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 15, ($custo->faturamento->custoComercial/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 15, ($custo->faturamento->custoComercial/$custo->producao->pesoProduzido));

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 16, $custo->rh->maoDeObraDireta);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 16, ($custo->rh->maoDeObraDireta/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 16, ($custo->rh->maoDeObraDireta/$custo->producao->pesoProduzido));

	$linha = 17;

	foreach ($custo->rh->direto as $key => $val) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abate->peso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->producao->pesoProduzido);
		$linha++;

	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'CONSUMO MATERIAL PRODUTIVO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->consumoMaterialProdutivo);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->consumoMaterialProdutivo/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->consumoMaterialProdutivo/$custo->producao->pesoProduzido));
	$linha++;

	foreach ($custo->almox->produtivo as $key => $val) {

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abate->peso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->producao->pesoProduzido);

		$linha++;
	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'ENERGIA');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->almox->energia);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->almox->energia/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->almox->energia/$custo->producao->pesoProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'SUBTOTAL CUSTO DIRETO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->subTotalDireto);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->subTotalDireto/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->subTotalDireto/$custo->producao->pesoProduzido));
	$linha++;
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'MÃO DE OBRA INDIRETA');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->maoDeObraIndireta);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->maoDeObraIndireta/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->maoDeObraIndireta/$custo->producao->pesoProduzido));
	$linha++;

	foreach ($custo->rh->indireto as $key => $val) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abate->peso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->producao->pesoProduzido);
		$linha++;
	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'CONSUMO DIVERSOS');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->consumoDiversos);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->consumoDiversos/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->consumoDiversos/$custo->producao->pesoProduzido));
	$linha++;

	foreach ($custo->almox->diversos as $key => $val) {

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abate->peso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->producao->pesoProduzido);

		$linha++;
	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'SERVIÇOS GERAIS');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->almox->servicos);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->almox->servicos/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->almox->servicos/$custo->producao->pesoProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'OLEO DIESEL');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->almox->oleoDiesel);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->almox->oleoDiesel/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->almox->oleoDiesel/$custo->producao->pesoProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'SUBTOTAL CUSTO INDIRETO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->subTotalIndireto);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->subTotalIndireto/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->subTotalIndireto/$custo->producao->pesoProduzido));
	$linha++;
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'CUSTO TOTAL');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->subTotalIndireto+$custo->subTotalDireto);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, (($custo->subTotalIndireto+$custo->subTotalDireto)/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, (($custo->subTotalIndireto+$custo->subTotalDireto)/$custo->producao->pesoProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'MARGEM');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, ($custo->producao->vpc-($custo->subTotalIndireto+$custo->subTotalDireto)));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, (($custo->producao->vpc-($custo->subTotalIndireto+$custo->subTotalDireto))/$custo->abate->peso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, (($custo->producao->vpc-($custo->subTotalIndireto+$custo->subTotalDireto))/$custo->producao->pesoProduzido));
	$linha++;

	// Exemplo inserindo uma segunda linha, note a diferença no segundo parâmetro
	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Beltrano");
	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, " da Silva Sauro");
	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "beltrando@exemplo.com.br");

	// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
	$objPHPExcel->getActiveSheet()->setTitle('Credenciamento para o Evento');

	// Cabeçalho do arquivo para ele baixar
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="apuracao custo de producao ref ('.$_GET['data1'].' - '.$_GET['data2'].').xls"');
	header('Cache-Control: max-age=0');
	// Se for o IE9, isso talvez seja necessário
	header('Cache-Control: max-age=1');

	// Acessamos o 'Writer' para poder salvar o arquivo
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

	// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
	$objWriter->save('php://output');

	exit;
}
// FIM IF
?>