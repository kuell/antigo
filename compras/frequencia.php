<?php
    require_once 'core/ProdutoPedido.php';
    require_once '../includes/fpdf/fpdf.php';
    
    class PDF extends FPDF {
        
   function Header() {
      $this->Image("../img/Logo.jpg", 15,15, 40, 20, "JPG");
      $this->Cell(60,15,"","LT",0,"L");
      $this->SetFont("Arial","B",25);
      $this->Cell(130,10,"Frizelo Frigorificos Ltda.","TR",0,"L");
      $this->Ln();
      $this->Cell(60,18,"","LB",0,"L");
      $this->SetFont("Arial","B",10);
      $this->Cell(130,18,"Frequencia de Compras. ","BR",0,"L");
      $this->Ln();
      $fill=0;
    }

     function Footer() {
      $this->SetY(-15);
      $this->SetFont("Arial","I",8);
      $this->Cell(0,4,utf8_decode("Página ").$this->PageNo()." | Gerado em: ".date("d/m/Y"),0,0,"C");
    }
    
    function select($where=''){
        $freq = new ProdutoPedido();
        $sql = "Select * from freqCompra where ultimoRecebimento is not null and 1=1 %s";
        $rs = sprintf($sql, $where);
                
        return $freq->RunSelect($rs);
    }
    function somaData($data,$dias){
        if($data == ""){
            return "";
        }
        else{
            return date('d/m/Y',strtotime($data." + ".$dias." DAY"));
        }
    }
    function Dados() {
        $freq = new ProdutoPedido();
        !empty($_GET['setor']) ? $setor = " and idSetor = ".$_GET['setor']: $setor = "";
        !empty($_GET['freq']) ? $frequencia = " and frequencia >= ".$_GET['freq']: $frequencia = "";
              
        $rs = $this->select($setor.$frequencia);
        $w = array(12, 72, 30, 20);
        $f = true;
        $this->SetFont("Arial",'',7);
        $this->SetFillColor(200);
        
        $this->Cell($w[0],4, 'Cod', 1, 0, 'C', 1);
        $this->Cell($w[1],4, 'Produto', 1, 0, 'C', 1);
        $this->Cell($w[0],4, 'Freq.', 1, 0, 'C', 1);
        $this->Cell($w[0],4, 'Qtd.', 1, 0, 'C', 1);
        $this->Cell($w[0],4, 'P.M.C.', 1, 0, 'C', 1);
        $this->Cell($w[3],4, 'Ultimo rec.', 1, 0, 'C', 1);
        $this->Cell($w[3],4, $freq->converteTexto('Projeção'), 1, 0, 'C', 1);
        $this->Cell($w[2],4, 'setor', 1, 0, 'C', 1);
        
        $this->Ln();
        $this->SetFillColor(230);

        foreach ($rs as $row){
                $data = $this->somaData($row['ultimoRecebimento'], $row['PMC']);                    
                
                if( $freq->dbData($data) < date("Y-m-d")){
                    
                    $this->SetTextColor(250,10,10);
                }
                else{
                    $this->SetTextColor();
                }
            
            $this->Cell($w[0], 4, $row['idProduto'],"L", 0, 'C', $f);
            $this->Cell($w[1], 4, $freq->limitaTexto($row['produto'],45) ,0, 0, 'L', $f);
            $this->Cell($w[0], 4, $row['frequencia'],0, 0, 'C', $f);
            $this->Cell($w[0], 4, $freq->viewNum($row['QtdMedPedido']),0, 0, 'R', $f);
            $this->Cell($w[0], 4, $row['PMC'],0, 0, 'C', $f);
            $this->Cell($w[3], 4, $freq->viewData($row['ultimoRecebimento']),0, 0, 'C', $f);
            $this->Cell($w[3], 4, $this->somaData($row['ultimoRecebimento'], $row['PMC']),0, 0, 'C', $f);
            $this->Cell($w[2], 4, $freq->limitaTexto($row['setor'],15),"R", 0, 'L', $f);
            $f = !$f;
            $this->Ln();
        }    
            $this->Cell(190, 1, '',"T", 0, 'C', $f);
    }
   }
  $pdf=new PDF("P","mm","A4");
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Dados();
  $pdf->Output();
  
?>
