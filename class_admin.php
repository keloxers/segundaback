<?php

class admin {
   
    public $id_usuario;
    public $id_articulo;
    
    private $db;

    function __construct() {
        $this->db = new db();
    }


    private function tomar_post() {
        if (isset($_REQUEST["id_usuario"])) {
            $this->id_usuario=$_REQUEST["id_usuario"]; }
        if (isset($_REQUEST["id_articulo"])) {
            $this->id_articulo=$_REQUEST["id_articulo"]; }            
   }

    public function ver_menu() {
        
        $formulario = new formulario();
        $formulario->abrir("Admin");

        $formulario->encabezado("Tablas");
        $formulario->abrir_renglon();
        $formulario->boton("Choferes");
        $formulario->boton("Depositos");
        $formulario->boton("Proveedor Categoria");
        $formulario->boton("Proveedores");
        $formulario->cerrar_renglon();
        
        $formulario->cerrar_formulario();
        
    }

    

}
?>
