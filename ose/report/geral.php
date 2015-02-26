<?php
   error_reporting(0);
  require_once("../../Connections/conn.php");

  mysql_select_db($database_conn, $conn);
  require("../../bibliotecas/fpdf/fpdf.php");
  class PDF extends FPDF {
    function Header() {
      $this->Image("../logo/Logo.JPG",10,4,25,15,"JPG");
      $this->SetFont("Arial","B",14);
      $this->Cell(60);
      $this->Cell(90,6,"Frizelo Frigorificos Ltda.",0,0,"C");
      $this->Ln(6);
      $this->Cell(75);
      $this->SetFont("Arial","B",10);
      $this->Cell(60,5,"Relatorio Geral de Ordens Externas",0,1,"C");
      $fill=0;
    }

  function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,10,"Página ".$this->PageNo()."/{nb}",0,0,"C");
    }

  function inf($where){
    	$sql = "Select
        					  a.`id_OSE`,
        				    DATE_FORMAT(a.`data_envio`,'%d/%m/%Y') as data,
        				    b.`nome` as empresa,
        				    c.`nome` as requisitante,
        				    d.`equipamento`, 
        				    e.`setor`,
        				    f.`acao`,
        				  	a.`num_orc`,
        				   a.`data_recebimento` as data_recebimento,
        				    a.`num_nota`,
        					  a.`preco_servico`,
                    g.status
        				    
        				from
        					 `ordem_externa` a 
        				    inner join `empresas` b on(a.`id_prestadora` = b.`id_empresa`)
        				    inner join `requisitante` c on (a.`id_Requisitante` = c.`id_requisitante`)
        				    inner join `equipamento` d on(a.`id_Equipamento` = d.`id_equipamento`)
        				    inner join `setor` e on(e.`id_setor` = d.`setor`)
        				    inner join `acao` f on(a.`id_servico` = f.`id_acao`)
                    inner join `status` g on(a.status = g.id_status)
                where
                    1=1 $where";
	//die($sql);

		$query = mysql_query($sql) or die ("Erro na importação dos dados: ".mysql_error);
		  
         while ($v = mysql_fetch_assoc($query)) {
            $res[$v['status']][] = array(
                                        'id'=> $v['id_OSE'],
                                        'dataEnvio'=> $v['data'],
                                        'empresa'=> $v['empresa'],
                                        'req'=> $v['requisitante'],
                                        'equip'=> $v['equipamento'],
                                        'setor'=> $v['setor'],
                                        'servico'=> $v['acao'],
                                        'orc'=> $v['num_orc'],
                                        'dataReceb'=> $v['data_recebimento'],
                                        'nf'=> $v['num_nota'],
                                        'preco'=> $v['preco_servico']
                                        );
         }
        return $res;
    }
  function dataBanco($data){
            $date = explode("/", $data);

            $d = $date[2]."-".$date[1]."-".$date[0];

            return $d;
        }

  function Dados() {

     $datai = $this->dataBanco($_GET['datai']);
     $dataf = $this->dataBanco($_GET['dataf']);
      
      $filtro = " and a.`data_envio` between '$datai' and '$dataf'";


      !empty($_GET['status']) ? $filtro .= " and a.status =".$_GET['status'] : "";
      !empty($_GET['setor']) ? $filtro .= " and d.setor =".$_GET['setor'] : "";
      !empty($_GET['req']) ? $filtro .= " and a.id_requisitante =".$_GET['req'] : "";
      !empty($_GET['equip']) ? $filtro .= " and a.id_Equipamento =".$_GET['equip'] : "";
      if($_GET['status'] == 5){
        $filtro = "and a.`data_recebimento` between '$datai' and '$dataf' and a.status =".$_GET['status'];
      }


		   $inf =  $this->inf($filtro);

       $w = array(9,15, 10, 20, 60, 29 );

       foreach ($inf as $status => $value) {
        $this->setFont('Arial','B',9);
        $this->setFillColor(200,200,200);
          
          $this->Cell(0,4,$status,0,1,"C",1);
          $this->Ln(0);
          
          $this->setFont('Arial','B',8);
          $this->Cell($w[0],4,"#","BTL",0,"C",0);  
          $this->Cell($w[1],4,"Data/Envio","BTL",0,"C",0);
          $this->Cell($w[4],4,"Empresa","BTL",0,"C",0);    
          $this->Cell($w[5],4,"Requisitante","BTL",0,"C",0);  
          $this->Cell($w[4],4,"Equipamento","BTL",0,"C",0);   
          $this->Cell($w[5],4,"Setor","BTL",0,"C",0);  
          $this->Cell($w[5],4,utf8_decode("Serviço"),"BTL",0,"C",0);  
          $this->Cell($w[2],4,utf8_decode("Nº Orç"),"BTL",0,"C",0);
          $this->Cell($w[1],4,"Data/Ret.","BTL",0,"C",0); 
          $this->Cell($w[2],4,"NF","BTLR",0,"C",0);     
          $this->Cell($w[2],4,"Valor","BTR",0,"C",0);  
          $this->Ln();
          $f = true;
          foreach ($value as $val) {
            $this->setFont('Arial','',6.5);

              $this->Cell($w[0],4,$val['id'],"BTL",0,"C",$f);
              $this->Cell($w[1],4,$val['dataEnvio'],"BT",0,"C",$f);
              $this->Cell($w[4],4,$val['empresa'],"BT",0,"L",$f);
              $this->Cell($w[5],4,substr($val['req'],0,15),"BT",0,"L",$f);
              $this->Cell($w[4],4,substr($val['equip'],0,40),"BT",0,"L",$f);
              $this->Cell($w[5],4,substr($val['setor'],0, 15),"BT",0,"L",$f);
              $this->Cell($w[5],4,substr($val['servico'],0,16),"BT",0,"L",$f);
              $this->Cell($w[2],4,substr($val['orc'],0,16),"BT",0,"L",$f);
              $this->Cell($w[1],4,date('d/m/Y', strtotime($val['dataReceb'])),"BT",0,"C",$f);
              $this->Cell($w[2],4,$val['nf'],"BT",0,"L",$f); 
              $this->Cell($w[2],4,$val['valor'],"BTR",0,"C",$f); 
            $this->Ln();
            $f = !$f;
          }
          
       }

  	}
}
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
?>

