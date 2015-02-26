
<?php
  /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  error_reporting(0);
  require_once("../../report/conexao.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../../report/fpdf.php");
  class PDF extends FPDF {
    function Header() {
      $this->Image("../logo/Logo.JPG",10,4,25,15,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(60);
      $this->Cell(10,6,"Peri Alimentos Ltda",0,0,"C");
      $this->Ln(6);
      $this->Cell(60);
      $this->SetFont("Arial","B",10);
      $this->Cell(5,5,"Relatorio de Custo por Setor",0,1,"C");

      $header=array("Setor","Registro/Setor","Part./Setor","Custo/Setor", "Part./Setor");
      $this->SetFillColor(255);
      $this->SetTextColor(0);
      $this->SetDrawColor(120,120,120);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",8);
      $w=array(50,25,25,25, 25);
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
		if($_REQUEST['data_1'] == ""){
	$dia = 1;
	$data1 = date("Y-m-".$dia."");
	}
	else{
	$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));
	}
if($_REQUEST['data_2'] == ""){
	$data2 = date('Y-m-d');
	}
	else{
	$data2 = date('Y-m-d', strtotime($_REQUEST['data_2']));
	}
      $sql = "select `setor`.`setor` as setor,     
		(select count(*) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') as registros_setor, 
		(select (((select count(*) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2')* 100)/(select count(*) from `ordem_externa_vew` where data_envio between '$data1' and '$data2' ))) as par_registro,     
		(Select	sum(preco_servico) from	`ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') as custo_setor,     
		((Select sum(preco_servico) from `ordem_externa_vew` where `ordem_externa_vew`.`setor` = `setor`.`setor` AND data_envio between '$data1' and '$data2') * 100 / (select sum(preco_servico) from ordem_externa_vew where data_envio between '$data1' and '$data2')) as part_setor,
		(select count(*) FROM ordem_externa_vew where data_envio between '$data1' and '$data2') as total_registros,
		(select sum(preco_servico) from ordem_externa_vew where data_envio between '$data1' and '$data2') as total_custos
	from  	
		`setor` join ordem_externa_vew on(`setor`.`setor` = `ordem_externa_vew`.`setor`) 
	group by 	
		`setor`.`setor`";
      $qr=mysql_query($sql) or die ("Erro(1):".$sql."<br>".mysql_error());
      $this->SetDrawColor(200,200,300);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",7);
      $w=array(50,25,25,25, 25);
      $this->SetFillColor(243,243,243);
      $this->SetTextColor(0);
      $this->SetFont("Arial","I",8);
      $fill=0;
	   while ($res=mysql_fetch_array($qr)) {
        $this->Cell($w[0],4,$res["setor"],"LR",0,"L",$fill);
        $this->Cell($w[1],4,$res["registros_setor"],"LR",0,"C",$fill);
        $this->Cell($w[2],4,((round($res["par_registro"], 2)).' %'),"LR",0,"C",$fill);
        $this->Cell($w[3],4,('R$ '.(number_format($res["custo_setor"], 2, ",", "."))),"LR",0,"R",$fill);
		$this->Cell($w[4],4,((round($res["part_setor"], 2)).' %'),"LR",0,"C",$fill);
		$total_registros = $res["total_registros"];
		$total_custo = $res["total_custos"];
        $this->Ln();
       // $fill=!$fill;
      }
	  $this->SetDrawColor(200,200,200);
      $this->SetLineWidth(0);
      $this->SetFont("Arial","B",10);
	  $w=array(50,25,25,25, 25);
	  $this->Cell($w[0],4,"","T",0,"",$fill);
	  $this->Cell($w[1],4,"Total Reg. = ","T",0,"","C");
	  $this->Cell($w[3],4,$total_registros,"T",0,"",$fill);
	  $this->Cell($w[4],4,"Total Custo = ","T",0,"",$fill);
	  $this->Cell($w[5],4,('R$ '.number_format($total_custo, 2, ',', '.')),"T",0,"");
    //  $this->Cell(array_sum($w),0,"","T");
    }
  }

  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetAuthor("rstuma@gmail.com");
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

