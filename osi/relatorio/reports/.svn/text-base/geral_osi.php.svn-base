<?php
	error_reporting(0);
	require_once('../../../Connections/conn.php');
	require_once("../../../bibliotecas/fpdf/fpdf.php");
	mysql_select_db($database_conn, $conn);
	class PDF extends FPDF {
		function Header(){
			$this->Image("../../../logo/Logo.JPG",11,10,40,20,"JPG");
     		$this->SetFont("Arial","B",20);
     		$this->Cell(1);
	  		$this->Cell(40,11,"","TLR",0,"C");
      		$this->Cell(150,11,"Peri Alimentos Ltda.","TLR",0,"C");
      		$this->Ln(10);
      		$this->Cell(1);
	  		$this->SetFont("Arial","B",10);
  	  		$this->Cell(40,11,"","BLR",0,"C");
      		$this->Cell(150,11,"Relatorio de Ordem Interna","RLB",0,"C");
	  		$this->Ln(15);
      		$fill=0;			
			}
		
	 	function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,utf8_decode("Página ").$this->PageNo()."/{nb}",0,0,"C");
    }
		
		function Dados(){
			$data1 = '2011-01-01';
				if(isset($_REQUEST['data_1'])){
						$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));  
								   }
			$data2 = date("Y-m-d");
				if(isset($_REQUEST['data_2'])){
						$data2 = date("Y-m-d", strtotime($_REQUEST["data_2"]));  
								   }
			if($_REQUEST['status'] == ""){
				$paramStatus = '%';
				}else{
					$paramStatus = $_REQUEST['status'];
					}
			if($_REQUEST['responsavel'] == ""){
				$paramResponsavel = '%';
				}else{
					$paramResponsavel = $_REQUEST['responsavel'];
					}
						
			$status = "Select status from ordem_interna_vew where status like '%$paramStatus%' and responsavel like '%$paramResponsavel%' group by status";
			$qrStatus = mysql_query($status) or die(mysql_error);
			
			if(mysql_num_rows($qrStatus) == 0){
				$this->Cell($w[0], 4, utf8_decode('Não Existetm registros'), 1, 0, "C");
				
				}			
			while($grupo = mysql_fetch_assoc($qrStatus)){
				
			$this->SetTextColor(300);
			$this->SetFillColor(50);
			$this->SetFont("Arial", "B", 10);
			$this->Cell(185,6,$grupo['status'],"TLR",0,"C", 1);
			$this->Ln();
			$header=array("Cod","Responsavel",utf8_decode("Serviço"),"Equipamento","Setor","Data/Pedido");
			  $this->SetFillColor(0);
			  $this->SetTextColor(500);
			  $this->SetDrawColor(250,250,250);
			  $this->SetLineWidth(.1);
			  $this->SetFont("Arial","B",9);
			  $w=array(15,30,30,50,30,30,60);
			  for($i=0;$i<count($header);$i++)
			  $this->Cell($w[$i],4,$header[$i],1,0,"C", 1);
			  $this->Ln(4);
			
			$sql = "Select *, (select count(*) from ordem_interna_vew where status = '".$grupo['status']."' and data_pedido between '$data1' and '$data2' and responsavel like '%$paramResponsavel%') as total  from ordem_interna_vew where status = '".$grupo['status']."' and data_pedido between '$data1' and '$data2' and responsavel like '%$paramResponsavel%'";
			$qr = mysql_query($sql) or die (mysql_error());
			
			$this->SetTextColor(0);
			$this->SetFont("Arial", "", 5);
			$this->SetFillColor(240);
			$bg = 0;
			
			while($linha = mysql_fetch_assoc($qr)){
				$w=array(15,30,30,50,30,30,60);
				$this->Cell($w[0], 4, $linha['id_osi'], 1, 0, "C", $bg);
				$this->Cell($w[1], 4, $linha['responsavel'], 1, 0, "L", $bg);
				$this->Cell($w[2], 4, $linha['acao'], 1, 0, "L", $bg);
				$this->Cell($w[3], 4, $linha['equipamento'], 1, 0, "L", $bg);
				$this->Cell($w[4], 4, $linha['setor'], 1, 0, "L", $bg);
				$this->Cell($w[5], 4, date("d/m/Y", strtotime($linha['data_pedido'])), 1, 0, "L", $bg);
				$this->Ln();		
				$total = $linha['total'];
				$bg = !$bg;
						}
				$this->SetFillColor(150);
			$this->Cell($w[0], 4, "", 1, 0, "C", 1);
			$this->Cell($w[1], 4, "", 1, 0, "C", 1);
			$this->Cell($w[2], 4, "", 1, 0, "C", 1);
			$this->Cell($w[3], 4, "", 1, 0, "C", 1);
			$this->Cell($w[4], 4, "Total Registros", 1, 0, "C", 1);
			$this->Cell($w[5], 4, $total , 1, 0, "C", 1);
			$this->Ln();
			
			}
			
		}
		}
	
  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();
//  $pdf->SetAutoPageBreak(true, 1);
  $pdf->SetAuthor("rstuma@gmail.com");
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>