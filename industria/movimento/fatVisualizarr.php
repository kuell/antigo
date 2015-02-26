<?php
   error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../../bibliotecas/fpdf/fpdf.php");
define("data", date('Y-m-d', strtotime($_REQUEST['data'])));
define("datai", date('Y-m-01', strtotime($_REQUEST['data'])));
define("dia", cal_days_in_month( CAL_GREGORIAN, date('m',strtotime($_REQUEST['data'])), date('Y',strtotime($_REQUEST['data']))));
define("dataf", date('Y-m-'.dia, strtotime($_REQUEST['data'])));
class PDF extends FPDF {
	
	function Header() {
		date_default_timezone_set("Brazil/East");
		define('hora', date("H")-1);
      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(1);
	  $this->Cell(40,11,"","TLR",0,"C");
      $this->Cell(250,11,"Peri Alimentos Ltda. ","TLR",0,"C");
      $this->Ln(10);
      $this->Cell(1);
	  $this->SetFont("Arial","B",12);
  	  $this->Cell(40,11,"","BLR",0,"C");
      $this->Cell(250,11,utf8_decode("Relatorio de Controle de Faturamento Referente ao dia: ".date('d/m/Y',strtotime(data))),"RLB",0,"C");
	  $this->Ln(15);
      $fill=0;
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y '.hora.':i'),0,0,"C");
    }

    function Dados() {
		// Pega os itens
		$sql = "Select *
				from 
					fat_produto 
				where 
					ativo = 1
						";
		$qr = mysql_query($sql) or die (mysql_error());
		//Formatação dos titulos da tabela
		$this->SetFont('Arial','I',8);
		
		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10,50,20,20,20,20,20,20,20,20,30,20,20);
		
			$this->Cell($w[0],4,"Cod",1,0,"C",1);
			$this->Cell($w[1],4,"Produto",1,0,"L",1);
			$this->Cell($w[2],4,"Quantidade",1,0,"R",1);
			$this->Cell($w[3],4,"Peso em Kg",1,0,"R",1);
			$this->Cell($w[4],4,utf8_decode("Preço Venda"),1,0,"R",1);
			$this->Cell($w[5],4,"Total Venda",1,0,"R",1);
			$this->Cell($w[6],4,'Fretes (-)',1,0,"R",1);
			$this->Cell($w[7],4,'Seguros (-)',1,0,"R",1);
			$this->Cell($w[8],4,'Impostos (-)',1,0,"R",1);
			$this->Cell($w[9],4,utf8_decode('Comissões (-)'),1,0,"R",1);
			$this->Cell($w[10],4,utf8_decode('Bonifucações (-)'),1,0,"R",1);
			$this->Cell($w[11],4,utf8_decode('Doações (-)'),1,0,"R",1);
			$this->Cell($w[12],4,'Refeitorio (-)',1,0,"R",1);
			$this->Ln();
			$fundo = 0;
		while($produto = mysql_fetch_assoc($qr)){
			$this->SetFont('Arial','',7);
			$this->SetFillColor(230);
			$this->Cell($w[0],4,$produto['cod_fat'],0,0,"C",$fundo);
			$this->Cell($w[1],4,$produto['descricao'],0,0,"L",$fundo);
			
			define('qtdAbate', $produto['qtdAbate']);
			define('vaca', $produto['vaca']);
			define('boi', $produto['boi']);
			define('totalPeso', $produto['totalPeso']);
			define('pesoVaca', $produto['pesoVaca']);
			define('pesoBoi', $produto['pesoBoi']);
			
			$sqlValor = "Select 
								qtd,
								peso,
								preco,
								total_venda,
								frete,
								seguro,
								imposto,
								comissao,
								bonificacao,
								doacao,
								refeitorio
								from 
									faturamento 
								where 
									produto = '".$produto['cod_fat']."' and
									data = '".data."'";
			$qrValor = mysql_query($sqlValor) or die (mysql_error());
			if(mysql_num_rows($qrValor) == 0){
				
			$this->Cell($w[2],4,'0,00',0,0,"R",$fundo);
			$this->Cell($w[3],4,'0,00',0,0,"R",$fundo);
			$this->Cell($w[4],4,'0,00',0,0,"R",$fundo);
			$this->Cell($w[5],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[6],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[7],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[8],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[9],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[10],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[11],4,'R$ 0,00',0,0,"R",$fundo);
			$this->Cell($w[12],4,'R$ 0,00',0,0,"R",$fundo);

			$this->Ln();
				}else{
			while($valor = mysql_fetch_assoc($qrValor)){
				// Valores
			$this->Cell($w[2],4,number_format($valor['qtd'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[3],4,number_format($valor['qtd'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[4],4,number_format($valor['peso'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[5],4,'R$ '.number_format($valor['total_venda'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[6],4,"R$ ".number_format($valor['frete'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[7],4,"R$ ".number_format($valor['seguro'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[8],4,"R$ ".number_format($valor['imposto'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[9],4,"R$ ".number_format($valor['comissao'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[10],4,"R$ ".number_format($valor['bonificacao'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[11],4,"R$ ".number_format($valor['doacao'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[12],4,"R$ ".number_format($valor['refeitorio'],2,',','.'),0,0,"R",$fundo);
			$this->Ln();
			
			//Fim dos valores	
			}
			$qtdAbate = $produto['qtdAbate'];
			}
			$fundo = !$fundo;			
			// fim itens
			}
		$this->Ln(5);

		
  }
  }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetMargins(3, 2, 3, 1);
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

