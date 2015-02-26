<?php

class Conecction{
    private $hostname_conn = "127.0.0.1";
    private $database_conn = "sig";
    private $username_conn = "root";
    private $password_conn = "";
    private $conn ; 

    public function Connect(){
        $this->conn = new PDO("mysql:host=$this->hostname_conn;dbname=$this->database_conn", 
                                                                      $this->username_conn,
                                                                      $this->password_conn);
                                                      return $this->conn;
    }
    public function RunQuery($sql){
        $sta = $this->Connect()->prepare($sql);
        $sta = $sta->execute();
            
            $id = $this->conn->lastInsertId();
            
                $result = array("id"=>$id);
            return $result;
    }
    public function RunSelect($sql){
        $sta = $this->Connect()->prepare($sql);
        $sta->execute();
    
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
    
}


?>
