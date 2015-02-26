<?php
   error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../../bibliotecas/fpdf/fpdf.php");

	define("datai", date('Y-m-d', strtotime($_REQUEST['data1'])));
	define("dataf", date('Y-m-d', strtotime($_REQUEST['data2'])));

class PDF extends FPDF {
	
	function Header() {
		date_default_timezone_set("Brazil/East");
		define('hora', date("H")-1);
//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(1);
	  $this->Cell(40,11,"","TLR",0,"C");
      $this->Cell(250,11,"Frizelo Frigorificos Ltda. ","TLR",0,"C");
      $this->Ln(10);
      $this->Cell(1);
	  $this->SetFont("Arial","B",12);
  	  $this->Cell(40,11,"","BLR",0,"C");
      $this->Cell(250,11,utf8_decode("Relatorio de Balanço Fiscal / Corretor Periodo: ".date('d-m-Y',strtotime(datai))." a ".date('d-m-Y', strtotime(dataf))),"RLB",0,"C");
	  $this->Ln(15);
      $fill=0;
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",7);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'),0,0,"C");
    }

    function Dados() {
		// Pega os itens
		$sql = "	
				SELECT 
				  `corretor`.`cor_id`,
				  corretor.cor_cod,
				  corretor.cor_nome,
				  sum(txdoc.peso) AS romExp,
				  (SELECT	sum(peso) from `taxa` inner join `txdoc` on(`taxa`.`Cod` = `txdoc`.`id_tx`) inner join `txproduto` on(`txdoc`.`item` = `txproduto`.`prod_id`) where `txproduto`.`prod_especie` = 'romaneio' and `taxa`.`cor` = `corretor`.`cor_id` and `taxa`.`data` between '".datai."' and '".dataf."') as romFisc,
				  (SELECT	sum(valor) from `taxa` inner join `txdoc` on(`taxa`.`Cod` = `txdoc`.`id_tx`) inner join `txproduto` on(`txdoc`.`item` = `txproduto`.`prod_id`) where `txproduto`.`prod_especie` = 'romaneio' and `taxa`.`cor` = `corretor`.`cor_id` and `taxa`.`data` between '".datai."' and '".dataf."') as  icms,
				  txproduto.prod_tipo
				FROM
				  txdoc
				  INNER JOIN taxa ON (txdoc.id_tx = taxa.Cod)
				  INNER JOIN txproduto ON (txdoc.item = txproduto.prod_id)
				  INNER JOIN corretor ON (taxa.corretor = corretor.cor_id)
				WHERE
				  `corretor`.`cor_ativo` = 1 and
				  txproduto.prod_tipo = 'exped' and
				 `taxa`.`data` between '".datai."' and '".dataf."'
				GROUP BY
				  `corretor`.`cor_id`
				order by
					`corretor`.`cor_nome`
		";
		$qr = mysql_query($sql) or die (mysql_error());
		//$rend = mysql_fetch_assoc($qr);
		//Formatação dos titulos da tabela
		$this->SetFont('Arial','I',8);
		
		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10,60,40,35,30,30,30,30);
		
			$this->Cell($w[0],5,"",0,0);
			$this->Cell($w[1],5,"Cod/Corretor",1,0,"C",1);
			$this->Cell($w[2],5,utf8_decode("Romaneio de Expedição (KG)"),1,0,"C",1);
			$this->Cell($w[3],5,"Romaneio Fiscal (KG)",1,0,"C",1);
			$this->Cell($w[4],5,"ICMS",1,0,"C",1);
			$this->Cell($w[5],5,"Pauta Fiscal (KG)",1,0,"C",1);
			$this->Cell($w[6],5,"Saldo (KG)",1,0,"C",1);
			$this->Cell($w[7],5,"Corte (%)",1,0,"C",1);
			
			$this->Ln();
			$fundo = 0;
		while($res = mysql_fetch_assoc($qr)){
			$this->SetFont('Arial','',7);
			$this->SetFillColor(230);

			$this->Cell($w[0],5,"",0,0);
			$this->Cell($w[1],4,$res['cor_cod'].' - '.$res['cor_nome'],0,0,"L",$fundo);
			$this->Cell($w[2],4,number_format($res['romExp'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[3],4,number_format($res['romFisc'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[4],4,'R$ '.number_format($res['icms'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[5],4,number_format(($res['icms']/$res['romFisc']),2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[6],4,number_format(($res['romFisc']-$res['romExp']),2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[7],4,number_format((($res['romFisc']-$res['romExp'])/$res['romExp'])*100,2,',','.').' %',0,0,"R",$fundo);
			
			$fundo = !$fundo;
			
			$totalExp = $res['romExp'] + $totalExp;
			$totalFisc   = $res['romFisc'] + $totalFisc;
			$totalIcms = $res['icms'] + $totalIcms;
			
		$this->Ln(5);
  }
	$fundo = 1;
			$this->Cell($w[0],5,"",0,0);
			$this->Cell($w[1],4,'TOTAL',0,0,"L",$fundo);
			$this->Cell($w[2],4,number_format($totalExp,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[3],4,number_format($totalFisc,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[4],4,'R$ '.number_format($totalIcms,2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[5],4,number_format(($totalIcms/$totalExp),2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[6],4,number_format(($totalFisc-$totalExp),2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[7],4,number_format((($totalFisc-$totalExp)/$totalExp)*100,2,',','.').' %',0,0,"R",$fundo);
  }
  }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetMargins(3, 2, 3, 1);
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

