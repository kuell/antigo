<?php

require ('../../Connections/conect_mysqli.php');
require ('../../Connections/connect_pgsql.php');
require ('../../class/CustoProducao.class.php');
require ('../../class/Interno.class.php');
require ("../../bibliotecas/fpdf/fpdf.php");

class PDF extends FPDF {
	function Header() {
		//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
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
		$d = explode('-', $data);

		return $d[2].'-'.$d[1].'-'.$d[0];
	}

	function Dados($datai, $dataf) {

		$custo = new CustoProducao($this->getData($datai), $this->getData($dataf));

		$this->SetFont("times", "", 7);
		$this->SetFillColor(200);
		$this->SetDrawColor(230);

		$this->Cell(50, 3.5, "QTD. ABATE", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->abateQtd, 2, ',', '.'), 1, 0, "R");
		$this->Ln();

		$this->Cell(50, 3.5, "PESO ABATE", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->abatePeso, 2, ',', '.'), 1, 0, "R");
		$this->Ln(5);

		$this->Cell(50, 3.5, "KG. PRODUZIDO", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->kgProduzido, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, "RENDIMENTO", 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->rendimento, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("PREÇO MÉDIO"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->precoMedio, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("KG MÉDIO POR CABEÇA"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->kgMedioPorCabeca, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("KG MÉDIO PRODUZIDO POR CABEÇA"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->kgMedioProduzidoPorCabeca, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("VALOR MÉDIO PRODUZIDO POR CABEÇA"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->valorMedioProduzidoPorCabeca, 2, ',', '.'), 1, 0, "R");
		$this->Ln();
		$this->Cell(50, 3.5, utf8_decode("VALOR DA PRODUÇÃO CORRENTE"), 0, 0, "L", 1);
		$this->Cell(50, 3.5, number_format($custo->valorProducaoCorrente, 2, ',', '.'), 1, 0, "R");
		$this->Ln(5);

		$this->Cell(60, 3.5, utf8_decode("ITENS"), 0, 0, "L", 1);
		$this->Cell(30, 3.5, utf8_decode("CUSTO TOTAL"), 0, 0, "L", 1);
		$this->Cell(30, 3.5, strtoupper(utf8_decode("custo unit./ abate")), 0, 0, "L", 1);
		$this->Cell(35, 3.5, strtoupper(utf8_decode("custo unit./ produÇÃo")), 0, 0, "L", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("taxas")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->taxas, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->taxas/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->taxas/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("custo comercial (frete/seguro/icms)")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->custoComercial, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->custoComercial/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->custoComercial/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("mÃo de obra direta")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->maoDeObraDireta, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->maoDeObraDireta/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->maoDeObraDireta/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		arsort($custo->rh['DIRETO']);

		foreach ($custo->rh['DIRETO'] as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$custo->abatePeso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("consumo material produtivo")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->consumoMaterialProdutivo, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->consumoMaterialProdutivo/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->consumoMaterialProdutivo/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		foreach ($custo->almox['DIRETO'] as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$custo->abatePeso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("energia")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->energia, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->energia/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->energia/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("subtotal custo direto")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->subTotalDireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->subTotalDireto/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->subTotalDireto/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln(5);

		$this->Cell(60, 3.5, strtoupper(utf8_decode("mÃo de obra indireta")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->maoDeObraIndireta, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->maoDeObraIndireta/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->maoDeObraIndireta/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		arsort($custo->rh['INDIRETO']);

		foreach ($custo->rh['INDIRETO'] as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$custo->abatePeso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("consumo diversos")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->consumoDiversos, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->consumoDiversos/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->consumoDiversos/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		foreach ($custo->almox['INDIRETO'] as $key => $val) {
			$this->Cell(60, 3.5, strtoupper(utf8_decode($key)), 1, 0, "L", 0);
			$this->Cell(30, 3.5, number_format($val, 2, ',', '.'), 1, 0, "R");
			$this->Cell(30, 3.5, number_format($val/$custo->abatePeso, 3, ',', '.'), 1, 0, "R");
			$this->Cell(35, 3.5, number_format($val/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R");

			$this->Ln();
		}

		$this->Cell(60, 3.5, strtoupper(utf8_decode("serviÇos")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->servicosGerais, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->servicosGerais/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->servicosGerais/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("oleo diesel")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->oleoDiesel, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->oleoDiesel/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->oleoDiesel/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("Subtotal custo indireto")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->subTotalIndireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format($custo->subTotalIndireto/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format($custo->subTotalIndireto/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln(5);

		$this->Cell(60, 3.5, strtoupper(utf8_decode("custo total")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->subTotalIndireto+$custo->subTotalDireto, 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format(($custo->subTotalIndireto+$custo->subTotalDireto)/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format(($custo->subTotalIndireto+$custo->subTotalDireto)/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

		$this->Cell(60, 3.5, strtoupper(utf8_decode("margem")), 1, 0, "L", 1);
		$this->Cell(30, 3.5, number_format($custo->valorProducaoCorrente-($custo->subTotalIndireto+$custo->subTotalDireto), 2, ',', '.'), 1, 0, "R", 1);
		$this->Cell(30, 3.5, number_format(($custo->valorProducaoCorrente-($custo->subTotalIndireto+$custo->subTotalDireto))/$custo->abatePeso, 3, ',', '.'), 1, 0, "R", 1);
		$this->Cell(35, 3.5, number_format(($custo->valorProducaoCorrente-($custo->subTotalIndireto+$custo->subTotalDireto))/$custo->kgProduzido, 3, ',', '.'), 1, 0, "R", 1);
		$this->Ln();

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

	// Instanciamos a classe
	$objPHPExcel = new PHPExcel();
	$custo       = new CustoProducao('2014-12-01', '2014-12-31');

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
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $custo->abateQtd);
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, 'PESO ABATE');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, $custo->abatePeso);
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 6, 'KG PRODUZIDO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 6, $custo->kgProduzido);
	$linha++;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 7, $custo->rendimento);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, $custo->precoMedio);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 9, $custo->kgMedioPorCabeca);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 10, $custo->kgMedioProduzidoPorCabeca);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 11, $custo->valorProducaoCorrente);

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 14, $custo->taxas);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 14, ($custo->taxas/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 14, ($custo->taxas/$custo->kgProduzido));

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 15, $custo->custoComercial);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 15, ($custo->custoComercial/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 15, ($custo->custoComercial/$custo->kgProduzido));

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 16, $custo->maoDeObraDireta);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 16, ($custo->maoDeObraDireta/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 16, ($custo->maoDeObraDireta/$custo->kgProduzido));

	$linha = 17;

	foreach ($custo->rh['DIRETO'] as $key => $val) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abatePeso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->kgProduzido);
		$linha++;

	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'CONSUMO MATERIAL PRODUTIVO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->consumoMaterialProdutivo);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->consumoMaterialProdutivo/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->consumoMaterialProdutivo/$custo->kgProduzido));
	$linha++;

	foreach ($custo->almox['DIRETO'] as $key => $val) {

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abatePeso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->kgProduzido);

		$linha++;
	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'ENERGIA');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->energia);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->energia/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->energia/$custo->kgProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'SUBTOTAL CUSTO DIRETO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->subTotalDireto);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->subTotalDireto/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->subTotalDireto/$custo->kgProduzido));
	$linha++;
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'MÃO DE OBRA INDIRETA');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->maoDeObraIndireta);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->maoDeObraIndireta/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->maoDeObraIndireta/$custo->kgProduzido));
	$linha++;

	foreach ($custo->rh['INDIRETO'] as $key => $val) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abatePeso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->kgProduzido);
		$linha++;
	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'CONSUMO DIVERSOS');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->consumoDiversos);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->consumoDiversos/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->consumoDiversos/$custo->kgProduzido));
	$linha++;

	foreach ($custo->almox['INDIRETO'] as $key => $val) {

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_decode($key));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $val);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $val/$custo->abatePeso);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $val/$custo->kgProduzido);

		$linha++;
	}

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'SERVIÇOS GERAIS');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->servicosGerais);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->servicosGerais/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->servicosGerais/$custo->kgProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'OLEO DIESEL');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->oleoDiesel);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->oleoDiesel/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->oleoDiesel/$custo->kgProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'SUBTOTAL CUSTO INDIRETO');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->subTotalIndireto);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, ($custo->subTotalIndireto/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, ($custo->subTotalIndireto/$custo->kgProduzido));
	$linha++;
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'CUSTO TOTAL');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $custo->subTotalIndireto+$custo->subTotalDireto);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, (($custo->subTotalIndireto+$custo->subTotalDireto)/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, (($custo->subTotalIndireto+$custo->subTotalDireto)/$custo->kgProduzido));
	$linha++;

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'MARGEM');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, ($custo->valorProducaoCorrente-($custo->subTotalIndireto+$custo->subTotalDireto)));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, (($custo->valorProducaoCorrente-($custo->subTotalIndireto+$custo->subTotalDireto))/$custo->abatePeso));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, (($custo->valorProducaoCorrente-($custo->subTotalIndireto+$custo->subTotalDireto))/$custo->kgProduzido));
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