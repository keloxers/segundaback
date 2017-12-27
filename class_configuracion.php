<?php

class configuracion {

    public $id_configuacion;
    public $id_usuario;
    public $codigo;
    public $descripcion;
    public $numero;
    public $texto;
    public $fecha;


    private $db;

    function __construct() {
        $this->db = new db();
    }

    private function tomar_post() {
        if (isset($_REQUEST["vbuscarcampo"])) {
            $this->buscar_campo=$_REQUEST["vbuscarcampo"]; }
        if (isset($_REQUEST["vbuscarvalor"])) {
            $this->buscar_valor=$_REQUEST["vbuscarvalor"]; }

        if (isset($_REQUEST["id_configuacion"])) {
            $this->id_configuacion=$_REQUEST["id_configuacion"]; }
        if (isset($_REQUEST["id_usuario"])) {
            $this->id_usuario = $_REQUEST["id_usuario"]; }
        if (isset($_REQUEST["codigo"])) {
            $this->codigo=$_REQUEST["codigo"]; }
        if (isset($_REQUEST["descripcion"])) {
            $this->descripcion=$_REQUEST["descripcion"]; }
        if (isset($_REQUEST["numero"])) {
            $this->numero=$_REQUEST["numero"]; }
        if (isset($_REQUEST["texto"])) {
            $this->texto=$_REQUEST["texto"]; }
        if (isset($_REQUEST["fecha"])) {
            $this->fecha=$_REQUEST["fecha"]; }
    }


  public function limpiar_registro() {
         $this->id_configuacion=0;
         $this->id_usuario=0;
         $this->codigo="";
         $this->descripcion="";
         $this->numero=0;
         $this->texto="";
         $this->fecha="";
  }

  public function cargar_registro() {
         $this->id_configuacion=$this->db->campo("id_configuacion");
         $this->id_usuario=$this->db->campo("id_usuario");
         $this->codigo=$this->db->campo("codigo");
         $this->descripcion=$this->db->campo("descripcion");
         $this->numero=$this->db->campo("numero");
         $this->texto=$this->db->campo("texto");
         $this->fecha=$this->db->campo("fecha");
  }

  
    public function agregar() {
            $this->tomar_post();

            $this->armar_sql("nuevo");
            // print "SQL: " . $this->db->sql . "<br>";
            $this->db->query_db();
            
            if (!$this->db->insertado()) {
                print "Error de Configuracion. Cominiquese con el administrador" . ".<br>";
                return false;
            }
            return true;
    }

  

   private function armar_sql($accion) {
            if ($accion=="nuevo"){
                $this->db->sql = "INSERT INTO \n";
            } else {
                $this->db->sql = "UPDATE \n";
            }
            
            $this->db->sql .= "configuracion SET \n";
            
            $this->db->sql .= "id_usuario=". $this->id_usuario . ", \n";
            $this->db->sql .= "codigo='". $this->codigo . "', \n";
            $this->db->sql .= "descripcion='". $this->descripcion . "', \n";
            $this->db->sql .= "numero=". $this->numero . ", \n";
            $this->db->sql .= "texto='". $this->texto . "', \n";
            $this->db->sql .= "fecha='". $this->fecha . "' \n";

            if ($accion<>"nuevo"){
                $this->db->sql .= " where id_configuacion=" . $this->id_configuacion . "\n";
            }
        
    }
  
  
  
   public function que_configuracion($codigo , $campo_return) {
        $this->db->sql="select * from configuracion where codigo='" . $codigo . "'";
        $this->db->query_db();
        if ($this->db->reg_total > 0) {
                return $this->db->campo($campo_return);
        }
    }

       public function incrementar($codigo, $campo_incrementar) {
        $this->db->sql="select * from configuracion where codigo='" . $codigo . "'";
        $this->db->query_db();
        if ($this->db->reg_total > 0) {
                $valor = $this->db->campo($campo_incrementar);
                $valor++;
                $this->db->sql = "UPDATE \n";
                $this->db->sql .= "configuracion SET \n";
                $this->db->sql .= $campo_incrementar . "=". $valor . "\n";
                $this->db->sql .= "where codigo='" . $codigo . "'";
                $this->db->query_db();

        }
    }


}
?>