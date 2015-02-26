<?php

require_once '../includes/fpdf/fpdf.php';

abstract class Relatorio extends FPDF {

    public function Header($orientacao="P") {
        
        if($orientacao == "L"){
            $l = 250;
        }
        else{
            $l = 130;
        }
        
        $this->Image("../logo/Logo.jpg", 13, 13, 40, 20, "JPG");
        $this->Cell(60, 15, "", "LT", 0, "L");
        $this->SetFont("Arial", "B", 25);
        $this->Cell(130, 15, "Frizelo Frigorificos Ltda.", "TR", 0, "C");
        $this->Ln();
        $this->Cell(60, 10, "", "LB", 0, "C");
        $this->SetFont("Arial", "B", 10);
        $this->Cell(130, 10, "Fechamento de Taxas", "BR", 0, "C");
        $this->Ln();
        $this->Ln(2);
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont("Arial", "I", 8);
        $this->Cell(0, 4, utf8_decode("PÃ¡gina ") . $this->PageNo() . " | Gerado em: " . date("d/m/Y")." as ".date("H:i"), 0, 0, "C");
    }    
}
?>
