<?php
   /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../../bibliotecas/fpdf/fpdf.php");
  class PDF extends FPDF {
    function Header() {
      $this->Image("../../logo/Logo.JPG",10,10,30,20,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(191,10,"Peri Alimentos Ltda.","LRT",0,"C");
      $this->Ln();
      $this->SetFont("Arial","B",10);
      $this->Cell(191,10,"Fechamento de taxas","LBR",0,"C");
	  
	//  $this->Cell(191,10,$sql,"LBR",0,"C");

	  $this->Ln();
	  $this->SetTextColor(0);
      $this->SetFont("Arial","IB",8);
	  $this->Cell(91,10,"Acumulado", 'LBR', '0', 'C');
	  $this->Cell(100,10, utf8_decode('Periodo: '.$_REQUEST['data_1']." à ".$_REQUEST['data_2']), 'LBR', '0', 'C');
	  $this->Ln(20);
	  
      $fill=0;
	  
	   $header=array("Corretor", "Acumulado");
      $this->SetFillColor(250);
      $this->SetTextColor(0);
      $this->SetDrawColor(120,120,120);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",8);
      $w=array(80,111);
      for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],4,$header[$i],1,0,"C",1);
	  $this->Ln();
      $fill=0;
	  
	  
	  
	  
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,"Página ".$this->PageNo()."/{nb}",0,0,"C");
    }

    function Dados() {
			$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));
			$data2 = date('Y-m-d', strtotime($_REQUEST['data_2']));
			
      $sql = "Select * from taxaDoc Where data between '$data1' and '$data2' group by tipo order by tipo";
      $qr=mysql_query($sql) or die (mysql_error());
     
	  $this->SetDrawColor(200,200,300);
	  
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",7);
      $w=array(80,37,37,37);
      $this->SetFillColor(250);
      $this->SetFont("Arial","I",8);
      $fill=1;	   
	   while ($res=mysql_fetch_array($qr)) {
// Se for tipo do item for animal	
	switch($res['tipo'])
	{
	Case "ANIMAL":
		$this->SetFillColor(150);
        $this->Cell($w[0],4, $res["tipo"],"LRTB",0,"L",$fill);
		$this->Cell($w[1],4, 'Quantidade',"LRTB",0,"L",$fill);
		$this->Cell($w[2],4, 'Peso',"LRTB",0,"L",$fill);
		$this->Cell($w[3],4, 'Unidade',"LRTB",0,"L",$fill);
				$this->Ln();
			$sqlItens = "Select 
								item as item, 
								sum(peso) as peso, 
								sum(qtd) as qtd,
								(select sum(qtd) from taxaDoc where tipo = '".$res['tipo']."'  and data between '$data1' and '$data2') as total_qtd,
								(select sum(peso) from taxaDoc where tipo = '".$res['tipo']."' and data between '$data1' and '$data2') as total_peso
							from 
								taxaDoc 
							where 
								tipo = '".$res['tipo']."' and
								data between '$data1' and '$data2'
								group by item";
			$query = mysql_query($sqlItens);
			while($item = mysql_fetch_assoc($query)){
				$this->Cell($w[0],4, $item["item"],"LRTB",0,"L",0);
				$this->Cell($w[1],4, number_format($item["qtd"],0,',','.'),"LRTB",0,"R",0);
				$this->Cell($w[2],4, number_format($item["peso"], 2, ',', '.'),"LRTB",0,"R",0);
				$this->Cell($w[3],4, $item["unidade"],"LRTB",0,"C",0);
				$this->Ln();
				$totalQtd  = $item["total_qtd"];
				$totalPeso = $item["total_peso"];
				}
				$this->Cell($w[0],4, "Total","LRTB",0,"L",1);
				$this->Cell($w[1],4, number_format($totalQtd, 0, ',', '.'),"LRTB",0,"R",1);
				$this->Cell($w[2],4, number_format($totalPeso,2,',','.'),"LRTB",0,"R",1);
				$this->Cell($w[3],4, "",0,"BT","C",1);
				$this->Ln();
				break;
	Case "ITEM" :
		$this->SetFillColor(150);
        $this->Cell($w[0],4, $res["tipo"],"LRTB",0,"L",$fill);
		
		$w=array(80,28,28,28,27);
		$this->Cell($w[1],4, 'Unidade',"LRTB",0,"L",$fill);
		$this->Cell($w[1],4, 'Peso',"LRTB",0,"L",$fill);
		$this->Cell($w[2],4, 'A Receber',"LRTB",0,"L",$fill);
		$this->Cell($w[3],4, 'A Pagar',"LRTB",0,"L",$fill);
				$this->Ln();		
		$sqlItens = "Select 
						item as item1,
						tipo_movimento,
						sum(qtd) as qtd, 
						sum(valor) as valor ,
						sum(peso) as peso,
						(select SUM(valor)from 	taxaDoc where tipo_movimento = 2 and data between '$data1' and '$data2' and item = item1) as A_Pagar,
						(select SUM(valor)from 	taxaDoc where tipo_movimento = 1 and data between '$data1' and '$data2' and item = item1) as A_Receber,
						(select sum(valor) from taxaDoc where tipo = '".$res['tipo']."' and data between '$data1' and '$data2' and tipo_movimento = 2 ) as totalReceber,
						(select sum(valor) from taxaDoc where tipo = '".$res['tipo']."' and data between '$data1' and '$data2' and tipo_movimento = 1 ) as totalPagar
					from 
						taxaDoc 
					where 
						tipo = '".$res['tipo']."'  and
						data between '$data1' and '$data2'
				group by item1";
					
			$query = mysql_query($sqlItens);
	//		$this->Ln();
		//		$this->MultiCell(200,4, $sqlItens,"LRTB",0,"L",0);
		//		$this->Ln();
			
			
			while($item = mysql_fetch_assoc($query)){
				$this->Cell($w[0],4, utf8_decode($item["item1"]),"LRTB",0,"L",0);
				$this->Cell($w[1],4, number_format($item["qtd"],0,',','.'),"LRTB",0,"R",0);
				$this->Cell($w[2],4, number_format($item["peso"],2,',','.'),"LRTB",0,"R",0);
				
				$debito = '0,00';
				$credito = '0,00';
							if($item['tipo_movimento'] == "DEBITO"){
								$debito = $item['A_Pagar'];
							}else{
								$credito = $item['valor'];
							}
				$this->Cell($w[3],4,'R$ '.number_format($item['A_Pagar'],2,',','.'),"LRTB",0,"R",0);
				$this->Cell($w[4],4,'R$ '.number_format($item['A_Receber'],2,',','.'),"LRTB",0,"R",0);
				
				$totalReceber = $item['totalReceber'];
				$totalPagar   = $item['totalPagar'];
				
				$this->Ln();
				}
									
				$this->Cell($w[0],4, '',"LRTB",0,"L",1);
				$this->Cell($w[1],4, "",0,"BT","C",1);
				$this->Cell($w[1],4, "TOTAL",0,"BT","L",1);
				$this->Cell($w[2],4,'R$ '. number_format($totalReceber, 2,',','.'),"LRTB",0,"R",1);
				$this->Cell($w[3],4,'R$ '. number_format($totalPagar,2,',','.'),"LRTB",0,"R",1);
					
			break;
	// Se o tipo do Item for
	Case "EXPED":
	$this->Ln();
	$w=array(80,37,37,37);
		$this->SetFillColor(150);
        $this->Cell($w[0],4, utf8_decode('ROMANEIO DE EXPEDIÇÃO'),"LRTB",0,"L",$fill);
			
		$this->Cell($w[1],4, 'Quantidade',"LRTB",0,"C",$fill);
		$this->Cell($w[2],4, 'Peso',"LRTB",0,"C",$fill);
		$this->Cell($w[3],4, 'Unidade',"LRTB",0,"C",$fill);
				$this->Ln();
			$sqlItens = "Select 
								*, 
								sum(peso) as peso, 
								sum(qtd) as qtd,
								(select sum(qtd) from taxaDoc where tipo = 'EXPED'  and data between '$data1' and '$data2') as total_qtd,
								(select sum(peso) from taxaDoc where tipo = 'EXPED' and data between '$data1' and '$data2') as total_peso
							from 
								taxaDoc 
							where 
								tipo = '".$res['tipo']."' and
								data between '$data1' and '$data2'
								group by item";
			$query = mysql_query($sqlItens);
			while($item = mysql_fetch_assoc($query)){
				$this->Cell($w[0],4, utf8_decode($item["item"]),"LRTB",0,"L",0);
				$this->Cell($w[1],4, number_format($item["qtd"],0,',','.'),"LRTB",0,"R",0);
				$this->Cell($w[2],4, number_format($item["peso"], 2, ',', '.'),"LRTB",0,"R",0);
				$this->Cell($w[3],4, $item["unidade"],"LRTB",0,"C",0);
				$this->Ln();
				$totalQtdExped  = $item["total_qtd"];
				$totalPesoExped = $item["total_peso"];
				}
				$this->Cell($w[0],4, "Total","LRTB",0,"L",1);
				$this->Cell($w[1],4, number_format($totalQtdExped, 2, ',', '.'),"LRTB",0,"R",1);
				$this->Cell($w[2],4, number_format($totalPesoExped,2,',','.'),"LRTB",0,"R",1);
				$this->Cell($w[3],4, "",0,"BT","C",1);
				$this->Ln();
		break;
	
	
	}
					$this->Ln();
      }
	  $this->Ln(10);
	  $this->Cell($w[0],4, "Saldo Pagar/Receber","",0,"R",1);
	  $this->Cell($w[1],4, "","",0,"C",1);
	  $this->Cell($w[2],4, "","",0,"C",1);
	  $this->Cell($w[3],4, 'R$ '.number_format(($totalReceber - $totalPagar),2,',','.'),"",0,"R",1);
	  $this->Ln(10);
	  
	  $this->MultiCell($w[4],4, 'Qualquer duvida ligar para (67) 3246-8100, ou acessar sua conta em http://sistema.perialimentos.com.br.',"",0,"L",0);
    }

	
  }

  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetAuthor("rstuma@gmail.com");
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

