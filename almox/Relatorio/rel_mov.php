<?php
   /* Script gerado pelo GERADOR PHP Versão 2.04a
     de: 31/07/2006 - Romes Tuma ( rstuma@gmail.com )  */
  error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  define('datai', date('Y-m-d',strtotime($_REQUEST['data1'])));
  define('dataf', date('Y-m-d',strtotime($_REQUEST['data2'])));
  
  $dataPass = date("t/m/Y", strtotime("-1 Month",strtotime($_REQUEST['data1'])));
  define('data0', $dataPass);
  
  
  
  
  require("../../bibliotecas/fpdf/fpdf.php");
  class PDF extends FPDF {
    function Header() {
			
//      $this->Image("../../logo/Logo.JPG",10,10,30,20,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(280,10,"Frizelo Frigorificos Ltda.","LRT",0,"C");
      $this->Ln();
      $this->SetFont("Arial","B",10);
      $this->Cell(280,10,utf8_decode("Movimentação Almoxarifado ref. periodo: ".date('d/m/Y', strtotime(datai)).' a '.date('d/m/Y', strtotime(dataf))),"LBR",0,"C");
	  
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
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,utf8_decode("Página ").$this->PageNo()."/{nb}",0,0,"R");
    }

    function Dados() {
	
	$w=array(6,35,34);
	
	
	$sqlGrupo = " 
		SELECT
			g.`id` as codGrupo,
			g.`descricao`,
			ifnull((SELECT estoque_anterior from mov_almox where grupo = codGrupo and data BETWEEN '".datai."' and '".dataf."' order by data asc LIMIT	1),0) as estoque_inicial,
			ifnull((SELECT valor_anterior from mov_almox where grupo = codGrupo and data BETWEEN '".datai."' and '".dataf."' order by data asc LIMIT	1),0) as valor_inicial,
			
			COALESCE((select sum(qtd) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'entrada'),0) as entrada,
			COALESCE((select sum(valor) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'entrada'),0) as valEntrada,
			
			coalesce((select sum(qtd) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'deventrada'),0) as devEntrada,
			coalesce((select sum(valor) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'deventrada'),0) as valDevEntrada,
				
			coalesce((select sum(qtd) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'saida'),0) as saida,
			coalesce((select sum(valor) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'saida'),0) as valSaida,
				
			coalesce((select sum(qtd) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'devsaida'),0) as devSaida,
			coalesce((select sum(valor) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'devsaida'),0) as valDevSaida,
				
			coalesce((select sum(qtd) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'ctf'),0) as difCont,
			coalesce((select sum(valor) from `mov_almox` where grupo = codGrupo and data between '".datai."' and '".dataf."' and tipo = 'ctf'),0) as valDifCont,
	
			coalesce((Select quantidade from grupo where id = g.id ),0) as estoque_final,
			coalesce((Select valor from grupo where id = g.id),0) as valor_final
		from
			grupo g
		group by 
			codGrupo";
	$qrGrupo = mysql_query($sqlGrupo) or die (mysql_error());
	
//Informa��es
        	$this->SetFillColor(220);
	$this->SetDrawColor(200);
	$this->SetFont("Arial","B",8);
	
	$this->Cell($w[0],4, utf8_decode(''),0,0,"C",0);
	$this->Cell($w[1],4, utf8_decode(''),0,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Estoque Anterior'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Entrada'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Dev. Entrada'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Saida'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Dev. Saida'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Contagem Fisica'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Estoque Atual'),"LRTB",0,"C",1);
	$this->Ln();
	$w=array(6,42,17);
	$this->Cell($w[0],4, utf8_decode('Cod'),1,0,"C",0);
	$this->Cell($w[1],4, utf8_decode('Descrição'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	
	
	$this->Ln();
	$fill = 0;
	
	while($grupo = mysql_fetch_assoc($qrGrupo)){
		$this->SetFillColor(240);
		$this->SetDrawColor(200);
		$this->SetFont("Arial","",7);
		
		if($grupo['codGrupo'] != 23 || $grupo['codGrupo'] != 24 || $grupo['codGrupo'] != 25){
		$this->Cell($w[0],4, utf8_decode($grupo['codGrupo']),"LRTB",0,"C",$fill);
		$this->Cell($w[1],4, utf8_decode($grupo['descricao']),"LRTB",0,"L",$fill);
		$this->Cell($w[2],4, number_format($grupo['estoque_inicial'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4, 'R$ '.number_format($grupo['valor_inicial'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['entrada'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valEntrada'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['devEntrada'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valDevEntrada'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['saida'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valSaida'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['devSaida'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valDevSaida'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['difCont'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['valDifCont'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,number_format($grupo['estoque_final'],2,',','.') ,1,0,"R",1);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valor_final'],2,',','.'),1,0,"R",1);
		$this->Ln();
	$fill = !$fill;
		
		$estoqueAnterior  = $grupo['estoque_inicial'] + $estoqueAnterior;
		$valorAnterior  = $grupo['valor_inicial'] + $valorAnterior;
		
		$entrada = $grupo['entrada']+$entrada;
		$valEnt = $grupo['valEntrada']+$valEnt;
		
		$devEnt = $grupo['DevEnt']+$devEnt;
		$valDevEnt = $grupo['valDevEnt']+$valDevEnt;
		
		$saida = $grupo['saida']+$saida;
		$valSaida = $grupo['valSaida']+$valSaida;
		
		$devSaida = $grupo['devSaida']+$devSaida;
		$devValSaida = $grupo['valDevSaida']+$devValSaida;
		
		$estoqueAtual = $grupo['estoque_final'] + $estoqueAtual;
		$valorAtual = $grupo['valor_final'] + $valorAtual;
		
                }
	//repetição	
    }
        $this->Ln();
	
        
// Rodape Informa��es
        $this->SetFillColor(220);
	$this->SetDrawColor(200);
	$this->SetFont("Arial","B",8);
	
	$this->Cell($w[0],4, utf8_decode(''),0,0,"C",0);
	$this->Cell($w[1],4, utf8_decode(''),0,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Estoque Anterior'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Entrada'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Dev. Entrada'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Saida'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Dev. Saida'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Contagem Fisica'),"LRTB",0,"C",1);
	$this->Cell($w[2],4, utf8_decode('Estoque Atual'),"LRTB",0,"C",1);
	$this->Ln();
	$w=array(6,42,17);
	$this->Cell($w[0],4, utf8_decode('Cod'),1,0,"C",0);
	$this->Cell($w[1],4, utf8_decode('Descrição'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Qtd'),1,0,"C",0);
	$this->Cell($w[2],4, utf8_decode('Valor'),1,0,"C",0);
	
	
	$this->Ln();
	$fill = 0;
	
	while($grupo = mysql_fetch_assoc($qrGrupo)){
		$this->SetFillColor(240);
		$this->SetDrawColor(200);
		$this->SetFont("Arial","",7);
		
		if($grupo['codGrupo'] == 23 || $grupo['codGrupo'] == 24 || $grupo['codGrupo'] == 25){
		$this->Cell($w[0],4, utf8_decode($grupo['codGrupo']),"LRTB",0,"C",$fill);
		$this->Cell($w[1],4, utf8_decode($grupo['descricao']),"LRTB",0,"L",$fill);
		$this->Cell($w[2],4, number_format($grupo['estoque_inicial'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4, 'R$ '.number_format($grupo['valor_inicial'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['entrada'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valEntrada'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['devEntrada'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valDevEntrada'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['saida'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valSaida'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['devSaida'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valDevSaida'],2,',','.'),"R",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['difCont'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4, number_format($grupo['valDifCont'],2,',','.'),"L",0,"R",$fill);
		$this->Cell($w[2],4,number_format($grupo['estoque_final'],2,',','.') ,1,0,"R",1);
		$this->Cell($w[2],4,'R$ '. number_format($grupo['valor_final'],2,',','.'),1,0,"R",1);
		$this->Ln();
	$fill = !$fill;
		
		$estoqueAnterior  = $grupo['estoque_inicial'] + $estoqueAnterior;
		$valorAnterior  = $grupo['valor_inicial'] + $valorAnterior;
		
		$entrada = $grupo['entrada']+$entrada;
		$valEnt = $grupo['valEntrada']+$valEnt;
		
		$devEnt = $grupo['DevEnt']+$devEnt;
		$valDevEnt = $grupo['valDevEnt']+$valDevEnt;
		
		$saida = $grupo['saida']+$saida;
		$valSaida = $grupo['valSaida']+$valSaida;
		
		$devSaida = $grupo['devSaida']+$devSaida;
		$devValSaida = $grupo['valDevSaida']+$devValSaida;
		
		$estoqueAtual = $grupo['estoque_final'] + $estoqueAtual;
		$valorAtual = $grupo['valor_final'] + $valorAtual;
		
                }
	//repetição	
    }
	$this->SetFillColor(200);
	$this->SetFont("Arial","B",7);
	
	$this->Cell($w[0],4,"",'TBL',0,"R",1);
	$this->Cell($w[1],4,"Totais",1,0,"R",1);
	$this->Cell($w[2],4,number_format($estoqueAnterior,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'R$ '.number_format($valorAnterior,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,number_format($entrada,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'R$ '.number_format($valEnt,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,number_format($devEnt,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'R$ '.number_format($valDevEnt,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,number_format($saida,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'R$ '.number_format($valSaida,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,number_format($devSaida,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'R$ '.number_format($devValSaida,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'',1,0,"R",1);
	$this->Cell($w[2],4,'',1,0,"R",1);
	$this->Cell($w[2],4,number_format($estoqueAtual,2,',','.'),1,0,"R",1);
	$this->Cell($w[2],4,'R$ '.number_format($valorAtual,2,',','.'),1,0,"R",1);
	$this->Ln();
	}
	
	}

  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetMargins(3, 2, 3, 1);
  $pdf->Dados();
  $pdf->Output();
?>
