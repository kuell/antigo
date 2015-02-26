<?php
    session_start();
abstract class Configuracao {
        private $usuario = null;
        private $data;

        public function sqlNumero($txt){
            if(is_numeric($txt)){
                return $txt;
            }
            else{
                return "'".$txt."'";
            }
        }
        
        public function alerta($msg="Passou aqui")
        {
            echo "<script>alert('$msg')</script>";
        }

        public function dataHora($dataHora, $hora=true)
        {
            if($hora){
                $dh = date("d/m/Y H:i", strtotime($dataHora));
            }
            else{
                $dh = date("d/m/Y", strtotime($dataHora));
            }
            return $dh;
        }
        
        public function dbData($data="")
        {
            if(empty($data)){
                $d = date('Y-m-d');
            }
            else{
                $dh = explode('/', $data);
                $d = $dh[2].'-'.$dh[1].'-'.$dh[0];
            }
            
            return $d;
        }
        
        public function viewData($data,$ano=true)
        {
            if (!empty($data)) {
                if ($ano) {
                    $d = date('d/m/Y', strtotime($data));
                } else {
                    $d = date('d/m', strtotime($data));
                }
                
                }
                else{
                    $d = "";
                }
            
            return $d;
        }
        
        public function limitaTexto($texto, $qtdCar)
        {
            $tx = substr($texto, 0, $qtdCar);
            return $tx;
        }
        
        public function converteTexto($texto)
        {
            $tx = utf8_decode($texto);
            return $tx;
        }
        
        public function nomeMes($mes)
        {
            switch ($mes) {
            case 1:
                $m = "Janeiro";
                break;
            case 2:
                $m = "Fevereiro";
                break;
            case 3:
                $m = "Março";
                break;
            case 4:
                $m = "Abril";
                break;
            case 5:
                $m = "Maio";
                break;
            case 6:
                $m = "Junho";
                break;
            case 7:
                $m = "Julho";
                break;
            case 8:
                $m = "Agosto";
                break;
            case 9:
                $m = "Setembro";
                break;
            case 10:
                $m = "Outubro";
                break;
            case 11:
                $m = "Novembro";
                break;
            case 12:
                $m = "Dezembro";
                break;
            default :
                $this->alerta("Mês não informado!");
                return false;
                break;
        }
        return $m;
        }

        public function viewNum($num)
        {
            $n = number_format($num, 2,",", ".");
             return $n;
        }
        
        public function dbNum($num)
        {
            $n = str_replace(".", "", $num);
            $numero = str_replace(",", ".", $n);
            
            return $numero;
        }
        
        public function getUsuario() 
        {
            $this->setUsuario();
            return $this->usuario;
        }

        public function setUsuario() 
        {
            $this->usuario = $_SESSION['kt_login_user'];
        }

        public function getData() 
        {
            $this->setData();
            return $this->data;
        }

        public function setData() 
        {
            $this->data = "current_timestamp";
        }
    }
?>
