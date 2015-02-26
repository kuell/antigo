<?php
    require_once 'core/ProdutoPedido.php';
    require_once '../includes/fpdf/fpdf.php';
    
    class PDF extends FPDF {
        
   function Header() {
      $this->Image("../logo/Logo.jpg", 15,15, 40, 20, "JPG");
      $this->Cell(60,15,"","LT",0,"L");
      $this->SetFont("Arial","B",25);
      $this->Cell(220,10,"Frizelo Frigorificos Ltda.","TR",0,"L");
      $this->Ln();
      $this->Cell(60,18,"","LB",0,"L");
      $this->SetFont("Arial","B",10);
      $this->Cell(220,18,"Produtos por Status ","BR",0,"L");
      $this->Ln();
      $this->Ln(2);
    }    
    
    function Dados() {
        $prod = new ProdutoPedido();  
        !empty($_GET['setor'])? $setor = " and e.id_setor =". $_GET['setor'] : $setor = "";
        !empty($_GET['status']) ? $status = " and a.status = '". $_GET['status']."'" : $status = "";
        !empty($_GET['prod']) ? $produto = " and a.prodId = '". $_GET['prod']."'" : $produto = "";
        
            
         if($_GET['status'] == ""){
                $data = "";
           }
         else
             {            
            if($_GET['status'] == "COMPRADO"){
                $data = " and a.dataCompra";
            }
            if($_GET['status'] == "REQUISITADO"){
                $data = " and d.data";
            }
            if($_GET['status'] == "RECEBIDO"){
                $data = " and a.dataRecebimento";
            }
              $data .= " between '".$prod->dbData($_GET['datai'])."' and '".$prod->dbData($_GET['dataf'])."'";    
            }

        $rs = $prod->select($setor.$status.$produto.$data);
        
        
        $w = array(10, 75, 32, 25);
        $f = true;
        $this->SetFont("Arial",'',7);
        $this->SetFillColor(150);
        
            $this->Cell($w[0], 4, "Pedido",0, 0, 'C', $f);
            $this->Cell($w[2],4, "Ped/Comp/Rec",0,0,'C',$f);
            $this->Cell($w[1], 4, "Cod - Produto" ,0, 0, 'C', $f);
            $this->Cell($w[3], 4, "Qtd.",0, 0, 'C', $f);
            $this->Cell($w[2], 4, "Solicitante",0, 0, 'C', $f);
            $this->Cell($w[3], 4, "Setor",0, 0, 'C', $f);
            $this->Cell($w[3], 4, "Status",0, 0, 'C', $f);
            $this->Cell($w[3], 4, "Recebido",0, 0, 'C', $f);
            $this->Cell($w[3], 4, 'OBS.',0, 0, 'C', $f);
        
        $this->Ln();
        
        $this->SetFillColor(200);
        foreach ($rs as $row){
            $this->Cell($w[0], 4, $row['pcId'],0, 0, 'C', $f);
            $this->Cell($w[2],4,$prod->viewData($row['data'],false).' - '.$prod->viewData($row['dataCompra'],false).' - '.$prod->viewData($row['dataRecebimento'], false),0,0,'L',$f);
            $this->Cell($w[1], 4, $row['prodId']." - ".$prod->limitaTexto($row['produto'],45) ,0, 0, 'L', $f);
            $this->Cell($w[2], 4, $prod->viewNum($row['qtd']).' - '.$row['unidade'],0, 0, 'R', $f);
            $this->Cell($w[2], 4, $row['solicitante'],0, 0, 'L', $f);
            $this->Cell($w[3], 4, $prod->limitaTexto($row['setor'],15),0, 0, 'L', $f);
            $this->Cell($w[3], 4, $row['status'],0, 0, 'C', $f);
            $this->Cell($w[3], 4, "SIM(   )", "LR", 0, "C", $f);
            $this->Cell($w[3], 4, '___________',"L", 0, 'C', $f);
            
            $f = !$f;
            $this->Ln();
        }        
    }
    function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()." | Gerado em: ".date("d/m/Y"),0,0,"C");
    }
   }
  $pdf=new PDF("L","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
  
?>
