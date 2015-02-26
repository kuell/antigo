<?php
	require("../../Connections/conn.php");
	require("../../bibliotecas/fpdf/fpdf.php");
	mysql_select_db($database_conn, $conn);
	class PDF extends FPDF {
		function Header(){
			
			$data1 = date('01-m-Y');
			if(isset($_REQUEST['data_1'])){
				$data1 = date('d-m-Y', strtotime($_REQUEST['data_1']));
							   }
							   
			$data2 = date('d-m-Y');
			if(isset($_REQUEST['data_2'])){
				$data2 = date('d-m-Y', strtotime($_REQUEST['data_2']));
							   }
			
			
	// CabeÃ§ario 
		$this->SetFont("Arial", "B", "14");
                $this->Image("../../logo/Logo.jpg",11, 10, 25, 15, "JPG");
                $this->SetFont("Arial","B",20);
                $this->Cell(1);
                $this->Cell(25,11,"","TLR",0,"C");
                $this->Cell(160,11,"Frizelo Frigorificos Ltda.","TLR",0,"C");
                $this->Ln(10);
                $this->Cell(1);
                $this->SetFont("Arial","B",10);
                $this->Cell(25,5,"","BLR",0,"C");
                $this->Cell(160,5,"Relatorio de Equipamentos","RLB",0,"C");
				$this->Ln();
				$this->SetFont("Arial", "B", 5);
				$this->Cell(26,5,"","",0,"C");
				$this->Cell(160,5,"Periodo: ".$data1." a ".$data2,"",0,"C");
                $this->Ln(7);
               
         $header=array("Cod","Equipamento","Qtd. Envios","Custo/Médio","Custo/Total");
      $this->SetFillColor(100);
      $this->SetTextColor(300);
      $this->SetDrawColor(200,200,200);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",9);
      $w=array(15,50,30,30,30);
      for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],4,$header[$i],1, "LTBR","C",1);
      $this->Ln(4);
	//Fim CabeÃ§ario
	
		}
                
 function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,"Página ".$this->PageNo()."/{nb} | Data e Hora da impressão: ".date('r'),0,0,"C");
	  
    }

    function Dados(){
	//Inicio Dados
			$data1 = date('Y-m-d', strtotime($_REQUEST['data1']));
			$data2 = date('Y-m-d', strtotime($_REQUEST['data2']));							   
				
                $sql = " Select 
							`ordem_externa`.`id_Equipamento` as cod,
							UCASE(`equipamento`.`equipamento`) as equipamento,
							(Select count(*) from `ordem_externa` where id_Equipamento = cod and data_envio between '$data1' and '$data2' ) as qtd_envio,
							(Select round(sum(preco_servico),2) from `ordem_externa` where `ordem_externa`.`id_Equipamento` = cod and data_envio between '$data1' and '$data2') as custo_total,
							ROUND((Select AVG(preco_servico) from `ordem_externa` where `ordem_externa`.`id_Equipamento` = cod and data_envio between '$data1' and '$data2'),2) as custo_media
							
						from
							`equipamento` join `ordem_externa` on(`equipamento`.`id_equipamento` = `ordem_externa`.`id_Equipamento`)
						where
							data_envio between '$data1' and '$data2'    
						group by
							cod
						order by
							qtd_envio desc";

                $qr = mysql_query($sql) or die(mylsql_error);

			   $this->SetFillColor(175);
               $this->SetFont("Arial", "", 6);
			   $w=array(15,50,30,30,30);
			   
			   $cor=0;
                while ($linha = mysql_fetch_assoc($qr)){
                    $this->Cell($w[0],3,$linha['cod'],0,0,"C", $cor);
					$this->Cell($w[1],3,$linha['equipamento'],0,"B","L", $cor);
					$this->Cell($w[2],3,$linha['qtd_envio'],0,"B","C", $cor);
                    $this->Cell($w[3],3,"R$ ".$linha['custo_media'],0,"B","L", $cor);
					$this->Cell($w[4],3,"R$ ".$linha['custo_total'],0,"B","L", $cor);
				   $this->Ln();
                   $cor=!$cor; 
                }

	// fim dados
		}
		}

$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Dados();
$pdf->output();



?>