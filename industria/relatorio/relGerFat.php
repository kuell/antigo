<?php
   error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  require("../../bibliotecas/fpdf/fpdf.php");
define("datai", date('Y-m-d', strtotime($_REQUEST['data1'])));
define("dataf", date('Y-m-d', strtotime($_REQUEST['data2'])));

class PDF extends FPDF {
	
	function Header() {
//      $this->Image("../../logo/Logo.JPG",6,5,35,15,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(1);
	  $this->Cell(40,11,"","TLR",0,"C");
      $this->Cell(250,11,"Frizelo Frigorificos Ltda. ","TLR",0,"C");
      $this->Ln(10);
      $this->Cell(1);
	  $this->SetFont("Arial","B",12);
  	  $this->Cell(40,11,"","BLR",0,"C");
      $this->Cell(250,11,utf8_decode("Relatorio de Controle de Faturamento Referente ao dia: ".date('d/m/Y',strtotime(datai)).' - '.date('d/m/Y', strtotime(dataf))),"RLB",0,"C");
	  $this->Ln(15);
      $fill=0;   
   }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()."/{nb} \ Processado em ".date('d-m-Y H-1:i'),0,0,"C");
    }

    function Dados() {
		for($cont = 1; $cont <=3; $cont++){
			switch ($cont){
				case '1' :
					$tipo = 'MIUDOS';
				break;
				case '2' :
					$tipo = 'SUBPRODUTOS';
				break;
				case '3' :
					$tipo = 'TRIPARIA';
				break;			
			}
			
			
			
		$sql = "Select 
					`fat_produto`.`cod_fat`,
					`fat_produto`.`descricao`,
					`ind_produtos`.`tipo`
					
				from
					`fat_produto` left outer join `ind_produtos` on(`fat_produto`.`cod_prod` = `ind_produtos`.`cod`)
				where
					`fat_produto`.`ativo` = 1 and
					ind_produtos.tipo = '$tipo'
				group by 
					cod_fat
				order by 
					fat_produto.cod_fat
						";
		$qr = mysql_query($sql) or die (mysql_error());
		//Formatação dos titulos da tabela
		$w = array(10,50,20,20,20,20,20,20,20,20,30,20,20);
		
		$this->SetFont('Arial','I',8);
		$this->SetFillColor(170);
		$this->SetDrawColor(220);
		
		$fundo = 0;
		$this->Cell(290,5,$tipo,1,0,'C',0);
		$this->Ln();
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
		
		
			$qtd = 0;
			$peso =0;
			$preco = 0;
			$totalVenda = 0;
			$frete = 0;
			$seguro = 0;
			$imposto = 0;
			$comissao = 0;
			$bonificacao = 0;
			$doacao = 0;
			$refeitorio = 0;
		

		while($produto = mysql_fetch_assoc($qr)){
			$this->SetFont('Arial','',7);
			$this->SetFillColor(230);		
			$this->Cell($w[0],4,$produto['cod_fat'],0,0,"C",$fundo);
			$this->Cell($w[1],4,$produto['descricao'],0,0,"L",$fundo);
			
			$sqlValor = "Select 
								sum(qtd) as qtd,
								sum(peso) as peso,
								(sum(total_venda)/sum(peso)) as preco,
								sum(total_venda) as total_venda,
								sum(frete) as frete,
								sum(seguro) as seguro,
								sum(imposto) as imposto,
								sum(comissao) as comissao,
								sum(bonificacao) as bonificacao,
								sum(doacao) as doacao,
								sum(refeitorio) as refeitorio
								from 
									faturamento 
								where 
									produto = '".$produto['cod_fat']."' and
									data between '".datai."' and '".dataf."' 
								group by
									produto
									";
									
			$qrValor = mysql_query($sqlValor) or die (mysql_error());

			$valor = mysql_fetch_assoc($qrValor);
				// Valores
			$this->Cell($w[2],4,number_format($valor['qtd'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[3],4,number_format($valor['peso'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[4],4,number_format($valor['preco'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[5],4,'R$ '.number_format($valor['total_venda'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[6],4,"R$ ".number_format($valor['frete'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[7],4,"R$ ".number_format($valor['seguro'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[8],4,"R$ ".number_format($valor['imposto'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[9],4,"R$ ".number_format($valor['comissao'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[10],4,"R$ ".number_format($valor['bonificacao'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[11],4,"R$ ".number_format($valor['doacao'],2,',','.'),0,0,"R",$fundo);
			$this->Cell($w[12],4,"R$ ".number_format($valor['refeitorio'],2,',','.'),0,0,"R",$fundo);
			
			//Fim dos valores	
			$qtd = $valor['qtd'] + $qtd;
			$peso = $valor['peso'] + $peso;
			$preco = $valor['preco'] + $preco;
			$totalVenda = $valor['total_venda'] + $totalVenda;
			$frete = $valor['frete'] + $frete;
			$seguro = $valor['seguro']+$seguro;
			$imposto = $valor['imposto'] + $imposto;
			$comissao = $valor['comissao']+$comissao;
			$bonificacao = $valor['bonificacao']+$bonificacao;
			$doacao = $valor['doacao']+$doacao;
			$refeitorio = $valor['refeitorio']+$refeitorio;
		
			$this->Ln();
			$fundo = !$fundo;
			}
			
		$this->SetDrawColor(100);	
			// fim itens	
		
		$this->Cell($w[0],4,"",'TB',0,"R",1);
		$this->Cell($w[1],4,"TOTAL PARCIAL",'TB',0,"R",1);
		$this->Cell($w[2],4,number_format($qtd,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[3],4,number_format($peso,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[4],4,'-','TB',0,"C",1);
		$this->Cell($w[5],4,'R$ '.number_format($totalVenda,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[6],4,"R$ ".number_format($frete,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[7],4,"R$ ".number_format($seguro,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[8],4,"R$ ".number_format($imposto,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[9],4,"R$ ".number_format($comissao,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[10],4,"R$ ".number_format($bonificacao,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[11],4,"R$ ".number_format($doacao,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[12],4,"R$ ".number_format($refeitorio,2,',','.'),'TB',0,"R",1);
		$this->Ln(8);
		
			$qtdt = $qtd + $qtdt;
			$pesot = $peso + $pesot;
			$precot = $preco + $precot;
			$totalVendat = $totalVenda + $totalVendat;
			$fretet = $frete + $fretet;
			$segurot = $seguro+$segurot;
			$impostot = $imposto + $impostot;
			$comissaot = $comissao+$comissaot;
			$bonificacaot = $bonificacao+$bonificacaot;
			$doacaot = $doacao+$doacaot;
			$refeitoriot = $refeitorio+$refeitoriot;
		

}  
		$this->Cell($w[0],4,"",'TB',0,"R",1);
		$this->Cell($w[1],4,"TOTAL PARCIAL",'TB',0,"R",1);
		$this->Cell($w[2],4,number_format($qtdt,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[3],4,number_format($pesot,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[4],4,'-','TB',0,"C",1);
		$this->Cell($w[5],4,'R$ '.number_format($totalVendat,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[6],4,"R$ ".number_format($fretet,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[7],4,"R$ ".number_format($segurot,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[8],4,"R$ ".number_format($impostot,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[9],4,"R$ ".number_format($comissaot,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[10],4,"R$ ".number_format($bonificacaot,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[11],4,"R$ ".number_format($doacaot,2,',','.'),'TB',0,"R",1);
		$this->Cell($w[12],4,"R$ ".number_format($refeitoriot,2,',','.'),'TB',0,"R",1);
		$this->Ln(8);
}  
  }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->SetMargins(3, 2, 3, 1);
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

