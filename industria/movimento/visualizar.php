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
      $this->Cell(163,11,"Peri Alimentos Ltda. ","TLR",0,"C");
      $this->Ln(10);
      $this->Cell(1);
	  $this->SetFont("Arial","B",12);
  	  $this->Cell(40,11,"","BLR",0,"C");
      $this->Cell(163,11,utf8_decode("Relatorio de Produção Industrial  Referente ao dia: ".date('d/m/Y',strtotime(data))),"RLB",0,"C");
	  $this->Ln(15);
      $fill=0;
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()."/{nb} - Processado em ".date('d-m-Y '.hora.':i'),0,0,"C");
    }

    function Dados() {
		
		$sql = "Select 
					`ind_produtos`.`id`,
					`ind_produtos`.cod,
					`ind_produtos`.`descricao`,
					`ind_produtos`.`tipo`,
					sum(peca) as peca,
					sum(peso) as peso,
					sum(qtd) as qtd,
					((sum(qtd))*100/(Select SUM(qtd) from `taxaDoc` WHERe tipo = 'ANIMAL' and data between '".datai."' and '".dataf."')) as rendimento,
					valor_unitario,
					(peso*valor_unitario) as faturado,		
					(Select SUM(qtd) from `taxaDoc` WHERe tipo = 'ANIMAL' and especie = 'BOI'  and data between '".datai."' and '".dataf."')as boi,
					(Select SUM(qtd) from `taxaDoc` WHERe tipo = 'ANIMAL' and especie = 'VACA' and data between '".datai."' and '".dataf."')as vaca,
					(Select SUM(qtd) from `taxaDoc` WHERe tipo = 'ANIMAL' and data between '".datai."' and '".dataf."')as qtdAbate,
					(Select SUM(peso) from `taxaDoc` WHERe tipo = 'ANIMAL' and especie = 'BOI'  and data between '".datai."' and '".dataf."') as pesoBoi,
					(Select SUM(peso) from `taxaDoc` WHERe tipo = 'ANIMAL' and especie = 'VACA' and data between '".datai."' and '".dataf."') as pesoVaca,
					(Select SUM(peso) from `taxaDoc` WHERe tipo = 'ANIMAL' and data between '".datai."' and '".dataf."') as totalPeso
				from 
					`ind_produtos` LEFT outer join `ind_producao` on (`ind_produtos`.`cod` = `ind_producao`.`produto`)
				where
					ativo = 1 and
					data_producao ='".data."'
				group by
					id
				order by
					id
						";
		$qr = mysql_query($sql) or die (mysql_error());
		//Formatação dos titulos da tabela
		$this->SetFont('Arial','I',9);
		
		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		$w = array(10,50,20,20,20,20,20,20);
		
			$this->Cell($w[0],4,"",0,0,"C");
			$this->Cell($w[0],4,"Cod",1,0,"C",1);
			$this->Cell($w[1],4,"Produto",1,0,"C",1);
			$this->Cell($w[2],4,utf8_decode("Peça"),1,0,"C",1);
			$this->Cell($w[3],4,"Qtd",1,0,"C",1);
			$this->Cell($w[4],4,"Peso",1,0,"C",1);
			$this->Cell($w[5],4,"Rendimento",1,0,"C",1);
			$this->Cell($w[6],4,utf8_decode("Preço"),1,0,"C",1);
			$this->Cell($w[7],4,"Faturado",1,0,"C",1);
			$this->Ln();
			$fundo = 0;
		while($produto = mysql_fetch_assoc($qr)){
			$this->SetFont('Arial','',7);
			$this->SetFillColor(230);
			$this->Cell($w[0],4,"",0,0,"C");
			$this->Cell($w[0],4,$produto['cod'],'L',0,"C",$fundo);
			$this->Cell($w[1],4,utf8_decode($produto['descricao']),0,0,"L",$fundo);
			$this->Cell($w[2],4,number_format($produto['peca'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[3],4,number_format($produto['qtd'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[4],4,number_format($produto['peso'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[5],4,number_format($produto['rendimento'],2,',','.').' %',0,0,"R",$fundo);
			$this->Cell($w[6],4,'R$ '.number_format($produto['valor_unitario'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[7],4,'R$ '.number_format($produto['faturado'],2,',','.'),'R',0,"R",$fundo);
			$this->Ln();
			$fundo = !$fundo;	
			
			$faturado = $produto['faturado'] + $faturado;

			$rend = $produto['rendimento'] + $rend;
			
			define('qtdAbate', $produto['qtdAbate']);
			define('vaca', $produto['vaca']);
			define('boi', $produto['boi']);
			define('totalPeso', $produto['totalPeso']);
			define('pesoVaca', $produto['pesoVaca']);
			define('pesoBoi', $produto['pesoBoi']);
			}
		$this->Ln(5);
		define('faturado', $faturado);
		define('rendimento', $rend); 
			$this->Cell($w[0],4,"",0);
			$this->Cell($w[1],4,"TOTAIS","LBT",0,"C",1);
			$this->Cell($w[2],4,"QUATIDADE","RBT",0,"C",1);
			$this->Cell($w[3],4,"PESO","RBT",0,"C",1);
			$this->Ln();
			$this->Cell($w[0],4,"",0);
			$this->Cell($w[1],4,"TOTAL BOI","LBT");
			$this->Cell($w[2],4,number_format(boi,0,',','.'),1,0,"C");
			$this->Cell($w[3],4,number_format(pesoBoi,2,',','.'),1,0,"R");
			$this->Ln();			
			$this->Cell($w[0],4,"",0);
			$this->Cell($w[1],4,"TOTAL VACA","LBT");
			$this->Cell($w[2],4,number_format(vaca,0,',','.'),1,0,"C");
			$this->Cell($w[3],4,number_format(pesoVaca,2,',','.'),"RBT",0,"R");
			$this->Ln();
			$this->Cell($w[0],4,"",0);
			$this->Cell($w[1],4,"TOTAL ABATIDO","LBT",0,'L',1);
			$this->Cell($w[2],4,number_format(qtdAbate,0,',','.'),1,0,'C',1);
			$this->Cell($w[3],4,number_format(totalPeso,2,',','.'),"RBT",0,"R",1);
			$this->Ln(5);
			$this->Cell($w[0],4,"",0);
			$this->Cell($w[1],4,"TOTAL PRODUZIDO","LBT",0,'L',1);
			$this->Cell($w[2],4,number_format(faturado,2,',','.').' Kg',1,0,'C',1);
			$this->Cell($w[3],4,number_format(rendimento,2,',','.').' %',"RBT",0,"R",1);
			
			$this->Ln();
		/* $this->Cell($w[0],4,datai,"LBT");
		$this->Ln();
		$this->Cell($w[1],4,dataf,"LBT"); */
		
  }
  }
  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetMargins(3, 2, 3, 1);
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

