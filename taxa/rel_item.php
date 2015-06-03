<?php

require_once 'class/TaxaItem.class.php';

require_once '../conf/Relatorio.class.php';

class Rel extends Relatorio {
	public function Header() {
		$this->Image("../logo/Logo.jpg", 13, 13, 40, 20, "JPG");
		$this->Cell(60, 15, "", "LT", 0, "L");
		$this->SetFont("Arial", "B", 25);
		$this->Cell(130, 15, "Frizelo Frigorificos Ltda.", "TR", 0, "C");
		$this->Ln();
		$this->Cell(60, 10, "", "LB", 0, "C");
		$this->SetFont("Arial", "B", 10);
		$this->Cell(130, 10, "Relatorio por Itens periodo: ".$_GET['datai'].' até '.$_GET['dataf'], "BR", 0, "C");
		$this->Ln();
		$this->Ln(2);
	}

	function inf($datai, $dataf, $item) {
		$taxa = new TaxaItem();
		$sql  = sprintf("Select
							b.cor_nome,
							b.cor_cod,
							d.descricao,
							sum(c.peso) as peso
						from
							taxa a
							inner join corretor b on a.corretor = b.cor_id
							inner join taxaitens c on a.id = c.idTaxa
							inner join taxa_item d on c.idItem = d.id
						where
							a.data between '%s' and '%s' and
							d.id = %s
						group by
							a.corretor", $datai, $dataf, $item);
		$res = $taxa->RunSelect($sql);

		return $res;
	}

	function item($id) {

		$taxa = new TaxaItem();
		$sql  = sprintf("Select
							*
						from
							taxa_item
						where
							id = %s", $id);

		$res = $taxa->RunSelect($sql);

		return $res[0];

	}

	function data($data) {
		$d = explode("/", $data);
		return $d[2]."-".$d[1]."-".$d[0];
	}

	function Dados() {

		$datai = implode('-', array_reverse(explode('/', $_GET['datai'])));
		$dataf = implode('-', array_reverse(explode('/', $_GET['dataf'])));

		$item  = $this->item($_GET['item']);
		$dados = $this->inf($datai, $dataf, $_GET['item']);

		$this->Cell(135, 5, $item['descricao'], 'TLBR', 0, "L", 0);
		$this->Ln();

		$this->SetFont('Arial', '', '9');
		$this->SetFillColor('200');

		foreach ($dados as $item) {
			$this->Cell(95, 5, $item['cor_cod'].' - '.$item['cor_nome'], 'TLB', 0, "L", 0);
			$this->Cell(40, 5, number_format($item['peso'], 2, ',', '.'), 'TLRB', 0, "R", 0);
			$this->Ln();
			$total = $total+$item['peso'];
		}

		$this->Cell(95, 5, 'Total ', 'TLB', 0, "L", 1);
		$this->Cell(40, 5, number_format($total, 2, ',', '.'), 'TLRB', 0, "R", 1);

	}

	public function Footer() {
		parent::Footer();
	}

}
$pdf = new Rel("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Dados();
$pdf->Output();

?>
