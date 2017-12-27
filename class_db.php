<?php

class db {
    private $host;
    private $user;
    private $pass;
    private $database;
    public $db;
    public $sql;
    public $result;
    public $reg_actual;
    public $reg_total;
    public $reg_afectados;


//*    
    
    function __construct($database="admin_svirasoro") {
        $this->host="localhost";
        $this->user="admin_svirasoro";
        $this->pass="TErqQnlgpc";

        $this->database=$database;
        $this->conectar();

 }

// */    

/*    
    function __construct($database="cuentas") {
        $this->host="localhost";
        $this->user="root";
        $this->pass="";

        $this->database=$database;
        $this->conectar();
    }

*/   
 
 
    private function conectar() {
        $this->db = mysql_connect($this->host, $this->user,$this->pass);
        mysql_select_db($this->database,$this->db);
    }
    public function query_db() {
        $this->result=mysql_query($this->sql);
        if (eregi ("select", $this->sql)) {
            $this->reg_total=mysql_numrows($this->result);
        }
        if (mysql_affected_rows($this->db)) {
                $this->reg_afectados=mysql_affected_rows($this->db);
        } else {
                $this->reg_afectados=0;
        }
        if ($this->reg_total > 0) {
            $this->reg_actual=0;
            return true;
        } else {
            $this->reg_actual = -1;
            return false;
        }
    }


    public function campo($campo) {
        mysql_select_db($this->database,$this->db);
        return mysql_result($this->result, $this->reg_actual, $campo);
        
    }

    public function insertado() {
        mysql_select_db($this->database,$this->db);
        if (mysql_insert_id()) {
            return mysql_insert_id();
        } else {
            return 0;
        }
    }

    public function reg_siguiente() {
        if ($this->reg_actual < ($this->reg_total-1)) {
            $this->reg_actual++;
            return true;
        } else {
            return false;
        }
    }

    public function reg_anterior() {
        if ($this->reg_actual > 0) {
            $this->reg_actual--;
            return true;
        } else {
            return false;
        }
    }

    public function reg_inicio() {
        $this->reg_actual=0;
    }

    public function reg_fin() {
        $this->reg_actual=$this->reg_total-1;
    }

    public function reg_eof() {
        if ($this->reg_actual == ($this->reg_total-1)) {
            return true;
        } else {
            return false;
        }
    }

    public function reg_bof() {
        if ($this->reg_actual == 0) {
            return true;
        } else {
            return false;
        }
    }

    
        // funciones de transacciones nuevas en esta clase.
      public function begin() {
          $this->sql="BEGIN";
          $this->result=mysql_query($this->sql);
          return $this->result;
      }
      
      public function commit() {
          $this->sql="COMMIT";
          $this->result=mysql_query($this->sql);
          return $this->result;
      }
      

      public function rollback() {
          $this->sql="ROLLBACK";
          $this->result=mysql_query($this->sql);
          return $this->result;
      }
      
      
}
?>
