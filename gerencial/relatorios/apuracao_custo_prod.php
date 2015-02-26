<?php

require ('/var/www/sigAntigo/sig2/class/CustoProducao.class.php');
require ("/var/www/sigAntigo/sig2/bibliotecas/fpdf/fpdf.php");

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

$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->SetMargins(3, 2, 3, 1);
$pdf->AddPage();

$pdf->Dados($_GET['data1'], $_GET['data2']);
$pdf->Output();

?>