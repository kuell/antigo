<?php  
class PDF extends FPDF {

   function Header() {
      $this->SetFont("Arial","B",20);
      $this->Cell(275,10,"Peri Alimentos Ltda Ltda.","LRT",0,"C");
      $this->Ln();
      $this->SetFont("Arial","B",10);
      $this->Cell(275,10,"Escala de Abate","LBR",0,"C");
	  $this->Ln();
	  $this->SetFont("Arial","B",5);
	  $this->Cell(0,4,"Em: ".date('d/m/Y'),0,1,"R");
	  $this->Ln(6);
      $fill=0;
    }

     function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("PÃ¡gina ").$this->PageNo()."/{nb}",0,0,"C");
    }
}
?>