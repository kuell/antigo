<?php
   /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  define('datai', $_REQUEST['data1']);
  define('dataf', $_REQUEST['data2']);
  
  require("../../bibliotecas/fpdf/fpdf.php");
  class PDF extends FPDF {
    function Header() {
			
//      $this->Image("../../logo/Logo.JPG",10,10,30,20,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(191,10,"Peri Alimentos Ltda.","LRT",0,"C");
      $this->Ln();
      $this->SetFont("Arial","B",10);
      $this->Cell(191,10,utf8_decode("Fixa Kardex ref. periodo: ".date('d/m/Y', strtotime(datai)).' a '.date('d/m/Y', strtotime(dataf))),"LBR",0,"C");
	  
      $fill=0;
      $this->SetFillColor(250);
      $this->SetTextColor(0);
      $this->SetDrawColor(120,120,120);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",8);
      $w=array(80,111);
      for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],4,$header[$i],1,0,"R",1);
	  $this->Ln(15);
      $fill=0;
	  
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",6);
      $this->Cell(0,10,"Página ".$this->PageNo()."/{nb}",0,0,"R");
    }

    function Dados() {
	$sqlGrupo = "
					Select 
						grupo.id,
						grupo.`descricao` as grupo
					from
						mov_almox left  join grupo on(`mov_almox`.`grupo` = grupo.id)
					where
						data between '".date('Y-m-d', strtotime(datai))."' and '".date('Y-m-d', strtotime(dataf))."' and
						grupo.descricao like '%".$_REQUEST['prod']."%'
					group by 
						grupo.id";
	
	$qrGrupo = mysql_query($sqlGrupo) or die (mysql_error());
	
	while($grupo = mysql_fetch_assoc($qrGrupo)){
	$this->SetFont("Arial","I",6);
	$this->SetFillColor(150);
	$this->SetTextColor(250);
	$this->SetDrawColor(200);
		  
		$this->Cell(191,4, utf8_decode($grupo['grupo']),"LRTB",0,"C",1);
		$this->Ln();
	
      $sql = "Select 
					a.id as cod, 
					a.data as data, 
					b.descricao as grupo, 
					a.tipo as tipo, 
					a.qtd as qtd, 
					a.`estoque_anterior` as qtd_anterior, 
					a.`estoque_atual` as qtd_atual, 
					a.valor as valor, 
					a.valor_anterior as valor_anterior, 
					a.valor_atual as valor_atual 
				from 
					mov_almox a
					left join grupo b on(a.grupo = b.id) 
				where 
					a.data between '".date('Y-m-d', strtotime(datai))."' and '".date('Y-m-d', strtotime(dataf))."' and 
					a.grupo = '".$grupo['id']."'";
	 	  
      $qr=mysql_query($sql) or die (mysql_error());
    
      $this->SetFont("Arial",'',6);
      $w=array(20,45,45,21);
	  $this->SetTextColor(0);

      $fill=1;	 
	
	$this->SetFillColor(190);
	
	$this->Cell($w[0],3, utf8_decode('Data'),"LRTB",0,"C",1);
	$this->Cell($w[1],3, utf8_decode('Tipo do Movimento'),"LRTB",0,"C",1);
	$this->Cell($w[3],3, utf8_decode('Qtd.Mov'),"LRTB",0,"C",1);
	$this->Cell($w[3],3, utf8_decode('Val.Mov'),"LRTB",0,"C",1);
	$this->Cell($w[3],3, utf8_decode('Est.Anterior'),"LRTB",0,"C",1);
	$this->Cell($w[3],3, utf8_decode('Val.Anterior'),"LRTB",0,"C",1);
	$this->Cell($w[3],3, utf8_decode('Est.Atual'),"LRTB",0,"C",1);
	$this->Cell($w[3],3, utf8_decode('Val.Atual'),"LRTB",0,"C",1);
	  $this->Ln(3);
	   while ($res=mysql_fetch_array($qr)) {
	   $this->SetFont("Arial","I",6);
	   $this->SetFillColor(240);

	   
	   if($res['tipo'] == 'deventrada'){
			$tipo = 'Devolução da Entrada';}
		elseif($res['tipo'] == 'devsaida'){
			$tipo = 'Devolução de Saida';}
		elseif($res['tipo']== 'ctfe'){
			$tipo = 'Contagem Fisica / Entrada';}
		elseif($res['tipo'] == 'ctfs'){
			$tipo = 'Contagem Fisica / Saida';}
		else{
			$tipo = $res['tipo'];
		}
	   
		$this->Cell($w[0],3, date('d/m/Y', strtotime($res['data'])),'T',0,"L",$fill);	
        $this->Cell($w[1],3, utf8_decode($tipo),'T',0,"L",$fill);
		$this->Cell($w[3],3, utf8_decode($res['qtd']),'T',0,"C",$fill);
		$this->Cell($w[3],3, utf8_decode($res['valor']),'T',0,"R",$fill);
		$this->Cell($w[3],3, utf8_decode($res['qtd_anterior']),'T',0,"R",$fill);
		$this->Cell($w[3],3, utf8_decode($res['valor_anterior']),'T',0,"R",$fill);
		$this->Cell($w[3],3, utf8_decode($res['qtd_atual']),'T',0,"R",$fill);
		$this->Cell($w[3],3, utf8_decode($res['valor_atual']),'T',0,"R",$fill);
		$this->Ln();
		$fill = !$fill;
      }
	  $this->Ln();
	  
    }
}
	
  }

  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>
