<?php
  /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */

 error_reporting(0);
  require_once("../conexao.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../fpdf.php");
 $pdf=new PDF("L","mm","A4");
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

      $header=array("COD","DATA-ENVIO","SERVIÇO","EMPRESA","REQUISITANTE","STATUS","EQUIPAMENTO","SETOR","ORÇAMENTO","VALOR");
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

	  $sql = "SELECT o2.id_OSE, o2.data_envio, o2.acao, o2.empresa, o2.preco_servico, o2.data_receb, o2.requisitante, o2.status, o2.equipamento, o2.setor, o2.Num_orcamento
FROM ordem_externa_vew o2
WHERE status LIKE '$status' AND equipamento LIKE '$equip' AND empresa LIKE '$empresa' AND requisitante LIKE '$requisit' AND setor LIKE '$setor'
ORDER BY id_ose
";
	/*lista*/
	  $qr=mysql_query($sql) or die ("Erro(1):".$sql."<br>".mysql_error());
      $this->SetDrawColor(200,200,200);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",8);
      $w=array(8,15,30,51,30,30,50,35,20,15);
      $this->SetFillColor(243,243,243);
      $this->SetTextColor(0);
      $this->SetFont("Arial","",6);
      $fill=0;
      while ($res=mysql_fetch_array($qr)) {
        $this->Cell($w[0],4,$res["id_OSE"],"LR",0,"L",$fill);
        $this->Cell($w[1],4,$res["data_envio"],"LR",0,"L",$fill);
        $this->Cell($w[2],4,$res["acao"],"LR",0,"L",$fill);
        $this->Cell($w[3],4,$res["empresa"],"LR",0,"L",$fill);
        $this->Cell($w[4],4,$res["requisitante"],"LR",0,"L",$fill);
        $this->Cell($w[5],4,$res["status"],"LR",0,"L",$fill);
        $this->Cell($w[6],4,$res["equipamento"],"LR",0,"L",$fill);
        $this->Cell($w[7],4,$res["setor"],"LR",0,"L",$fill);
        $this->Cell($w[8],4,$res["Num_orcamento"],"LR",0,"L",$fill);
		$this->Cell($w[9],4,$res["preco_servico"],"LR",0,"L",$fill);
        $this->Ln();
        $fill=!$fill;
	}
	}
  }

  $pdf->AliasNbPages();
  $pdf->SetAuthor("rstuma@gmail.com");
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

