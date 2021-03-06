<?php
   error_reporting(0);
  require_once("../../Connections/conn.php");
  mysql_select_db($database_conn, $conn);
  $cData =strftime("%d/%m/%Y" );
  require("../../bibliotecas/fpdf/fpdf.php");
  class PDF extends FPDF {
    function Header() {
      $this->Image("../../logo/Logo.JPG",10,10,30,20,"JPG");
      $this->SetFont("Arial","B",20);
      $this->Cell(275,10,"Peri Alimentos Ltda.","LRT",0,"C");
      $this->Ln();
      $this->SetFont("Arial","B",10);
      $this->Cell(275,10,"Relatorio de Auditoria de procedimentos","LBR",0,"C");
	  $this->Ln();
	  $this->SetTextColor(0);
      $this->SetFont("Arial","IB",8);
	  $this->Cell(60,10,"Setor: ".$_REQUEST['setor'], 'LBR', '0', 'C');
	  $this->Cell(215,10, 'Periodo: '.$_REQUEST['data_1']." � ".$_REQUEST['data_2'], 'LBR', '0', 'C');
	  $this->Ln();
	  $this->Line;
      $fill=0;
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,"P�gina ".$this->PageNo()."/{nb} Gerado �s ".date('h:i'),0,0,"C");
    }

    function Dados() {
		$data_1a = date("Y-m-01");
		$data_2a = date("Y-m-d");
		$mes1 = date("m", strtotime($_REQUEST['data_1']));
		$mes2 = date("m", strtotime($_REQUEST['data_2']));
		$ultimo_dia = cal_days_in_month(CAL_GREGORIAN,$mes2,date("Y", strtotime($_REQUEST['data_2'])));
		
		$data1 = date('Y-m-01');
	if(isset($_REQUEST['data_1'])){
		$data1 = date('Y-m-d', strtotime($_REQUEST['data_1']));
		$data_1a = date("Y-$mes1-01");
		}
	if($_REQUEST['data_2'] == ""){
		$data2 = date('Y-m-d');
	}else{
		$data2 = date('Y-m-d', strtotime($_REQUEST['data_2']));
		$data_2a = date("Y-m-$ultimo_dia", strtotime($_REQUEST['data_2']));
		}
	if($_REQUEST['setor'] == ""){
		$setor = '100';
	}else{
		$setor = $_REQUEST['setor'];
		}

      $this->SetTextColor(0);
	  $sqlSetor = "select SETOR from c_registro_controle where setor like '$setor' and data between '$data1' and '$data2' group by setor";
	  $qrSetor = mysql_query($sqlSetor) or die (mysql_error());
	  while($setor = mysql_fetch_assoc($qrSetor)){

// Corpo do Relatorio
	$header=array("Item", "Descri��o da N�o Conformidade", "Qtd.");
      $this->SetFillColor(200);
      $this->SetTextColor(0);
      $this->SetDrawColor(120,120,120);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","B",7);
      $w=array(100,100,50);
      for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],4,$header[$i],1,0,"C",1);
      $this->Ln(4);
		$sql = " select *, 
					(Select count(*) from c_registro_controle where setor = '".$setor['SETOR']."' and data between '$data1' and '$data2') as qtd_nc ,
					(select count(*) from itens inner join setor on(setor.id_setor = itens.setor) where setor.setor =  '".$setor['SETOR']."') as qtd_itens,
					(Select count(*) from c_registro_controle where setor = '".$setor['SETOR']."' and data between '$data_1a' and '$data_2a') as acumulado_nc,
					(select sum(quantidade) from c_registro_controle where setor = '".$setor['SETOR']."' and data between '$data1' and '$data2') as quantidade_nc
				from 
					c_registro_controle 
				where 
					setor = '".$setor['SETOR']."' and data between '$data1' and '$data2'";
      $qr=mysql_query($sql) or die ("Erro(1):".$sql."<br>".mysql_error());
      $this->SetDrawColor(200,200,200);
      $this->SetLineWidth(.1);
      $this->SetFont("Arial","",5);
	  $w=array(100, 100,50);
      $fill=0;
      while ($res=mysql_fetch_array($qr)) {
		$this->SetFillColor(240,270,243);
        $this->Cell($w[0],4,$res["DESC_ITEM"],"LRTB",0,"L",$fill);
		$this->Cell($w[1],4,$res["DESC_NC"],"LRTB",0,"L",$fill);
		$this->Cell($w[2],4,$res["QUANTIDADE"],"LRTB",0,"L",$fill);

		$qtd_nc= $res['qtd_nc'];
		$qtd_itens = $res['qtd_itens'];
		$dias_uteis = $_REQUEST['dias_uteis'];
		$acumulado = $res['acumulado_nc'];
		$qtd_aval = ($dias_uteis * $qtd_itens);
		$qtd_nc_acumulado = $res['acumulado_nc'];
		$quantidade_nc = $res['quantidade_nc'];
		$this->Ln();
        $fill=!$fill;
      } //while registros
	  
	   $w=array(50,30,50,50,30);
	  
	  // Totais de itens n�o conformes
	  
	  $this->SetFont("helvetica",'B', 8);
	  $this->Line(10,10,10,10);
	  $this->Ln(10);
	  $this->Cell($w[0], 4, 'Total de Itens N�o-Conformes', 'TLR','C');
	  $this->Cell($w[1], 4,$qtd_nc ,'LTRB', '' ,'C');
	  $this->Cell($w[2], 4, '');
	  
	  
	  // Total de N�o conformidades

	  $this->Cell($w[0], 4, 'Total de N�o-Conformidades', 'TLRB','C');
	  $this->Cell($w[1], 4,$quantidade_nc ,'LTRB', '' ,'C');
	  $this->Ln();
	  $this->Cell($w[0], 4,'' ,'BRL');
	  $this->Cell($w[1], 4,round((($qtd_nc*100)/($qtd_itens)),2).' %' ,'LTRB', '', 'C');
	  $this->Cell($w[0], 4,'' );
  	  $this->Cell($w[0], 4, 'Media (Qtd. N.C. / Itens N.C.)', 'TLRB','C');
	  $this->Cell($w[1], 4,round(($quantidade_nc / $qtd_itens),2)."  (nc/item)",'LTRB', '' ,'C');	  
	  $this->Ln();
	  
	  
	  // Acumulado do M�s
	 
	  $this->SetFont("helvetica",'B', 8);
	  $this->Ln();
	  $this->Cell($w[0], 4, 'Acumulado do M�s', 'TLR','C');
	  $this->Cell($w[1], 4,$qtd_nc_acumulado ,'LTRB', '' ,'C');
	  $this->Ln();
	  $this->Cell($w[0], 4,'' ,'BRL');
	  $this->Cell($w[1], 4, (round(($qtd_nc_acumulado * 100) / ($qtd_aval), 2)).' %' ,'LTRB','' ,'C');
	  $this->Ln(30);
	  
	  /* exibe o valor das Variaveis
	  $this->Cell($w[0], 4, '$qtd_nc = '.$qtd_nc, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$qtd_itens = '.$qtd_itens, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$acumulado = '.$acumulado, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$qtd_aval = '.$qtd_aval, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$qtd_nc_acumulado = '.$qtd_nc_acumulado, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$quantidade_nc = '.$quantidade_nc, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$data_1a = '.$data_1a, 'TLR','C');
	  $this->Ln();
	  $this->Cell($w[0], 4, '$data_2a = '.$data_2a, 'TLR','C');
	  */
	  } //while setor
	  } //fun��o
  } // classe

  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

