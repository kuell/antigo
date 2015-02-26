<?php
  /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  error_reporting(0);
  require_once("../conexao.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../fpdf.php");
  class PDF extends FPDF {
    function Header() {
      $this->Image("../../logo/logo.jpg",10,9,20,10,"JPG");
      $this->SetFont("Arial","B",14);
      $this->Cell(60);
      $this->Cell(15,6,"PERI ALIMENTOS LTDA.",0,0,"C");
      $this->Ln(6);
       $this->Cell(63);
      $this->SetFont("Arial","B",10);
      $this->Cell(1,5,"Relatorio de Ordens Externas",0,1,"C");
	   $this->Cell(18);
      $this->SetFont("Arial","I",8);
      $this->Cell(1,5,"Data do relatorio:".date('d/m/Y'),0,1,"C");

      $header=array("total");
      $this->SetFillColor(205);
      $this->SetTextColor(0);
      $this->SetDrawColor(1,10,10);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",6);
      $w=array(8,15,30,51,30,30,50,35,20,15);
      for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],4,$header[$i],1,0,"L",1);
      $this->Ln(4);
      $fill=0;
}

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,"Página ".$this->PageNo()."/{nb}",0,0,"C");
	  $this->SetY(0);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,"Teste",0,0,"C");	 
    }

    function Dados() {
$status = "%";
	if (isset($_REQUEST['status'])) {
  	$status = $_REQUEST['status'];
	}	  
$equip = "%";
	if (isset($_REQUEST['equip'])) {
 	 $equip = $_REQUEST['equip'];
	}	
$empresa = "%";
	if (isset($_REQUEST['empresa'])) {
	$empresa = $_REQUEST['empresa'];
	}
$requisit = "%";
	if (isset($_REQUEST['requisit'])) {
	$requisit = $_REQUEST['requisit'];
	}
$setor = "%";
	if (isset($_REQUEST['setor'])) {
	$setor = $_REQUEST['setor'];
	}

	  $sql = "SELECT SUM(preco_servico) as Total
FROM ordem_externa_vew
WHERE status LIKE '$status' AND equipamento LIKE '$equip' AND empresa LIKE '$empresa' AND requisitante LIKE '$requisit' AND setor LIKE '$setor'
ORDER BY id_ose
";
      $qr=mysql_query($sql) or die ("Erro(1):".$sql."<br>".mysql_error());
      $this->SetDrawColor(200,200,200);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",8);
      $w=array(8,15,30,51,30,30,50,35,20,15);
      $this->SetFillColor(243,243,243);
      $this->SetTextColor(0);
      $this->SetFont("Arial","",6);

while ($res=mysql_fetch_array($qr)) {
        $this->Cell($w[0],4,$res["Total"],"LR",0,"L",$fill);
		$this->Cell($w[0],4,$res["id_ose"],"LR",0,"L",$fill);
        $this->Ln();
	}
    }
	}

  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetAuthor("rstuma@gmail.com");
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>
