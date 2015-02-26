<?php
   require_once("../../Connections/conn.php");
   require("../../bibliotecas/fpdf/fpdf.php");
   mysql_select_db("sig");
class PDF extends FPDF {
	
	function Header(){
//      $this->Image("../../logo/Logo.JPG",13,13,35,15,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(1);
	  $this->Cell(40,11,"","TLR",0,"C");
      $this->Cell(149,11,"Frizelo Frigorificos Ltda. ","TLR",0,"C");
      $this->Ln(10);
      $this->Cell(1);
	  $this->SetFont("Arial","B",12);
  	  $this->Cell(40,11,"","BLR",0,"C");
      $this->Cell(149,11,utf8_decode("Relatorio Balanço RH: ".$setor),"RLB",0,"C");
	  $this->Ln(15);
      $fill=0;
    }
    function Footer(){
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
	  $this->SetDrawColor(200);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo(),0,0,"C");
    }	
	function getSetor(){
		$sql = "Select 
					* 
				from 
					setor 
				where 
						id_setor in(Select setor from rh_balanco)";
						
		$qr = mysql_query($sql) or die(mysql_error(). "\n Erro na aquisição dos setores");
		while($s = mysql_fetch_assoc($qr)){
			$setor[] = $s;
		}
		return $setor;
	}
	function getInfo($anoi, $anof, $mesi, $mesf){
		$sql = "Select 
					* 
				from 
					rh_info a
				where 
					a.mes between '".$anoi."' and '".$mesi."' and
					a.ano between '".$anof."' and '".$mesf."'";
					
		$qr = mysql_query($sql) or die(mysql_error(). "<br /> Erro na aquisição das Informações Adicionais<br />".$sql);
		
		$inf = mysql_fetch_object($qr);
		return $inf;
	}
	function getItem(){
		$sql = "Select 
					* 
				from 
					rh_item
				where
					por_setor = 'sim'";

		$qr = mysql_query($sql) or die(mysql_error(). "<br /> Erro na aquisição dos Items<br />".$sql);
		
		while($i = mysql_fetch_object($qr)){
			$inf[$i->id] = $i->descricao;
		}
		return $inf;
	
	}
	function getInfAdic($setor, $anoi, $anof, $mesi, $mesf){
		$sql = "Select 
					*
				from 
					rh_balanco a
					left join rh_item b on(a.item = b.id)
				where
					a.ano between ".$anoi." and ".$anof." and
					a.mes between ".$mesi." and ".$mesf;

		$qr = mysql_query($sql) or die(mysql_error(). "<br /> Erro na aquisição das Itens<br />".$sql);
		
		$item = $this->getItem();
		
		while($i = mysql_fetch_assoc($qr)){
			$inf[] = array($i['descricao'] => $i['valor'] );
		}
		return $inf;
	}
	function getValor($anoi, $anof, $mesi, $mesf){
		$sql = "Select 
					a.setor,
					a.item,
					sum(valor) as valor
				from 
					rh_balanco a
				where 
					a.mes between '".$anoi."' and '".$mesi."' and
					a.ano between '".$anof."' and '".$mesf."'
				group by 
					a.setor, a.item";

		$qr = mysql_query($sql) or die(mysql_error(). "<br /> Erro na aquisição dos Valores<br />".$sql);
		
		while($v = mysql_fetch_assoc($qr)){
			$inf[$v['setor']][$v['item']] = $v['valor'];
		}
		return $inf;
	}
    function divide($dividendo, $divisor){
		if($dividendo == 0 or $divisor ==0 or $dividendo == null or $divisor == nul){
			return 0;
		}
		else{
			return $dividendo / $divisor;
		}
	}
	function Dados() {
		
		$w = array(100,20);
		//Informações Gerais
		
			$mi = date('m', strtotime($_GET['data1'])); 
			$mf = date('m', strtotime($_GET['data2']));
			$ai = date('Y', strtotime($_GET['data1']));
			$af = date('Y', strtotime($_GET['data2']));
			
			$i = $this->getInfo($mi, $ai, $mf, $af);
			$valor = $this->getValor($mi, $ai, $mf, $af);
			
		foreach ($this->getSetor() as $setor)
		{
			$this->AddPage();
			$this->SetFont("Arial","B",9);
			$this->SetFillColor(180);
			$this->SetDrawColor(230);
			$this->SetFillColor(200);
			$this->Ln(7);
			
				$this->Cell(190,6,utf8_decode($setor['setor']),1,0,'C',1);
			$this->Ln();
			$this->SetFillColor(230);
				$this->Cell(190,4,utf8_decode('INDICADORES GERAIS'),1,0,'C',1);
				$this->Ln();
			$this->SetFillColor(249);
				$this->Cell($w[0],5,'Qtd. Abate','LBT',0,'L',1);
				$this->Cell($w[1],5,number_format($i->qtd,2,',','.'),'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,'Peso Abate','LBT',0,'L',1);
				$this->Cell($w[1],5,number_format($i->peso,2,',','.'),'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,'Faturamento Bruto','LBT',0,'L',1);
				$this->Cell($w[1],5,number_format($i->fat,2,',','.'),'RBT',0,'R',0);
			$this->Ln();
		
			$this->SetFont('Arial','I',9);
			
					foreach($this->getItem() as $key => $item){
						$this->Cell($w[0],5,$item,'LBT',0,'L',1);
						$this->Cell($w[1],5,number_format($valor[$setor['id_setor']][$key],2,',','.'),'RBT',0,'R',0);
						$this->Ln();						
					}		
			$this->Ln();
			$this->SetFillColor(230);
			$this->SetFont('Arial','B',9);
				$this->Cell(190,4,utf8_decode('INDICADORES TEMPORAIS'),1,0,'C',1);
			$this->Ln();
			
			$this->SetFont('Arial','I',9);
				$this->Cell($w[0],5,utf8_decode('TAXA DE OCUPAÇÃO DE HORAS'),'LBT',0,'L',0);
				$this->Cell($w[1],5, number_format($this->divide($valor[$setor['id_setor']][1], $valor[$setor['id_setor']][2])*100,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('TAXA DE DESOCUPAÇÃO DE HORAS'),'LBT',0,'L',0);
				$this->Cell($w[1],5, number_format($this->divide(($valor[$setor['id_setor']][2] - $valor[$setor['id_setor']][1]) , $valor[$setor['id_setor']][2])*100,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('FALTAS'),'LBT',0,'L',0);
					$faltas = $this->divide($valor[$setor['id_setor']][4] , $valor[$setor['id_setor']][2])*100;
				$this->Cell($w[1],5, number_format($faltas,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('ACIDENTES E AFASTAMENTOS'),'LBT',0,'L',0);
					$acid = $this->divide($valor[$setor['id_setor']][5] , $valor[$setor['id_setor']][2])*100;
				$this->Cell($w[1],5, number_format($acid,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('FERIAS'),'LBT',0,'L',0);
					$ferias = $this->divide($valor[$setor['id_setor']][6] , $valor[$setor['id_setor']][2])*100;
				$this->Cell($w[1],5, number_format($ferias,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('ABSENTEISMO TOTAL'),'LBT',0,'L',0);
				$this->Cell($w[1],5, number_format($ferias+$acid+$faltas,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('TAXA DE SUBSTITUIÇÃO DO ABSENTEISMO'),'LBT',0,'L',0);
				$this->Cell($w[1],5, number_format(0,2,',','.')." %" ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('TAXA DE REMUNERAÇÃO HORA'),'LBT',0,'L',0);
				$this->Cell($w[1],5, "R$ ".number_format($this->divide(($valor[$setor['id_setor']][12]) , $valor[$setor['id_setor']][1]),2,',','.') ,'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('TAXA DE HORAS SUPLEMENTARES'),'LBT',0,'L',0);
				$this->Cell($w[1],5, "R$ ".number_format($this->divide(($valor[$setor['id_setor']][3]) , $valor[$setor['id_setor']][1])*100 ,2,',','.')." %" ,'RBT',0,'R',0);
		
			$this->Ln();
			$this->Ln();
			$this->SetFillColor(230);
			$this->SetFont('Arial','B',9);
				$this->Cell(190,4,utf8_decode('INDICADORES DIMENSIONAIS'),1,0,'C',1);
			$this->Ln();
		$this->SetFont("Arial","I",9);
			$this->Cell($w[0],5,utf8_decode('TAXA DE ADMISSÂO'),'LBT',0,'L',0);
				$this->Cell($w[1],5,number_format($this->divide(($valor[$setor['id_setor']][10]) , $valor[$setor['id_setor']][7])*100,2,',','.').' %','RBT',0,'R',0);
				$this->Ln();
			$this->Cell($w[0],5,utf8_decode('TAXA DE DEMISSÃO'),'LBT',0,'L',0);
				$this->Cell($w[1],5,number_format($this->divide(($valor[$setor['id_setor']][11]) , $valor[$setor['id_setor']][7])*100,2,',','.').' %','RBT',0,'R',0);
				$this->Ln();
			$this->Cell($w[0],5,utf8_decode('TAXA DE REPOSIÇÃO'),'LBT',0,'L',0);
				$this->Cell($w[1],5,number_format($this->divide(($valor[$setor['id_setor']][10] - $valor[$setor['id_setor']][11]) , $valor[$setor['id_setor']][7])*100,2,',','.').' %','RBT',0,'R',0);
				$this->Ln();
		$this->Ln();
			$this->Ln();
			$this->SetFillColor(230);
			$this->SetFont('Arial','B',9);
				$this->Cell(190,4,utf8_decode('INDICADORES DE PRODUTIVIDADE'),1,0,'C',1);
			$this->Ln();
			$this->SetFont("Arial","I",9);
			$this->Cell($w[0],5,utf8_decode('TAXA FOLHA/FATURAMENTO'),'LBT',0,'L',0);
				$this->Cell($w[1],5,number_format(($valor[$setor['id_setor']][12]/$i->fat)*100,2,',','.') .' %','RBT',0,'R',0);
				$this->Ln();
			$this->Cell($w[0],5,utf8_decode('SALARIO POR KG'),'LBT',0,'L',0);
				$this->Cell($w[1],5,'R$ '.number_format(($valor[$setor['id_setor']][12]/$i->peso),5,',','.'),'RBT',0,'R',0);
			$this->Ln();
				$this->Cell($w[0],5,utf8_decode('SALARIO MEDIO POR SETOR'),'LBT',0,'L',0);
				$this->Cell($w[1],5,'R$ '.number_format($this->divide($valor[$setor['id_setor']][12], ($valor[$setor['id_setor']][10]+$valor[$setor['id_setor']][8]+$valor[$setor['id_setor']][9])),2,',','.'),'RBT',0,'R',0);
		}
		
/*						
	############# -----Indicadores de produtividade -----#############
				$this->SetFont("Arial","B",9);
				$this->SetFillColor(230);
				$this->Cell(190,5,utf8_decode('INDICADORES DE PRODUTIVIDADE'),1,0,'C',1);
				$this->SetFillColor(249);
				$this->SetFont("Arial","I",9);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('TAXA FOLHA/FATURAMENTO'),'LBT',0,'L',0);
				$this->Cell($w[1],5,number_format(($val['rem_br']/faturamento)*100,2,',','.') .' %','RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('SALARIO POR KG'),'LBT',0,'L',0);
				$this->Cell($w[1],5,'R$ '.number_format(($val['rem_br']/pesoAbate),5,',','.'),'RBT',0,'R',0);
				$this->Ln();
				$this->Cell($w[0],5,utf8_decode('SALARIO MEDIO POR SETOR'),'LBT',0,'L',0);
				$this->Cell($w[1],5,'R$ '.number_format($val['rem_br']/($val['fun_reg']+$val['fun_reg_temp']+$val['prest_serv']),2,',','.'),'RBT',0,'R',0);
			*/
		$this->Ln();
		
		
		}
  }
  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();

  $pdf->Dados();
  $pdf->Output();
?>
