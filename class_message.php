<?php

class message {

        public $id_mensaje;
        public $id_relacion;
        public $id_usuario_emisor;
        public $id_usuario_receptor;
        public $mensaje;
        public $estado;

        public $code;
    
        private $db;

/*

    id_mensaje
    id_relacion
    id_usuario_emisor
    id_usuario_receptor
    mensaje
    estado
 
*/

    function __construct() {
        $this->db = new db();
        $this->code = new code();
    }

    private function tomar_post() {
        if (isset($_REQUEST["id_mensaje"])) {
            $this->id_mensaje=$_REQUEST["id_mensaje"]; }
        if (isset($_REQUEST["id_relacion"])) {
            $this->id_relacion=$_REQUEST["id_relacion"]; }
        if (isset($_REQUEST["id_usuario_emisor"])) {
            $this->id_usuario_emisor=$_REQUEST["id_usuario_emisor"]; }
        if (isset($_REQUEST["id_usuario_receptor"])) {
            $this->id_usuario_receptor=$_REQUEST["id_usuario_receptor"]; }
        if (isset($_REQUEST["mensaje"])) {
            $this->mensaje=$_REQUEST["mensaje"]; }
        if (isset($_REQUEST["estado"])) {
            $this->estado=$_REQUEST["estado"]; }
            
}




  public function show_formulario_agregar() {
        $this->tomar_post();
        $usuario = new usuario();
        
        $formulario = new formulario();
        $formulario->abrir($this->code->que("enviar mensaje a") . ": " . $usuario->que($this->id_usuario_receptor,"usuario"));
        
        $formulario->text_oculto("id_usuario_receptor", $this->id_usuario_receptor);
        $formulario->text_oculto("id_usuario_emisor", $this->id_usuario_emisor);
        $formulario->text_oculto("id_relacion", $this->id_relacion);
        
        $formulario->text_area_box($this->code->que("mensaje"),"mensaje",5,65,$this->mensaje,"");

        $formulario->abrir_renglon();
        $formulario->boton($this->code->que("enviar mensaje"));
        $formulario->cerrar_renglon();
        $formulario->cerrar_formulario();
  }






   private function armar_sql() {
            
            $this->db->sql = "INSERT INTO \n";

            $this->db->sql .= "mensajes SET \n";
            $this->db->sql .= "id_relacion=". $this->id_relacion . ",\n";
            $this->db->sql .= "id_usuario_emisor=". $this->id_usuario_emisor . ",\n";
            $this->db->sql .= "id_usuario_receptor=". $this->id_usuario_receptor . ",\n";
            $this->db->sql .= "mensaje='". $this->mensaje . "',\n";
            $this->db->sql .= "estado='no leido'\n";
   
   }
          
          
          public function aceptar() {          
                
                $this->db->sql ="select * from relaciones where id_usuario=" . $this->id_usuario;
                $this->db->sql.=" and id_usuario_relacionado=" . $this->id_usuario_relacionado;
                $this->db->sql.=" and estado='espera' limit 1";

                if (!$this->db->query_db()) {
                    return false;
                }
                
                $this->db->sql ="update relaciones set estado='aceptado' where id_usuario=" . $this->id_usuario;
                $this->db->sql.=" and id_usuario_relacionado=" . $this->id_usuario_relacionado;
                $this->db->sql.=" limit 1";
                
                $this->db->query_db();
                if ($this->db->reg_afectados>1) {
                    return true;
                }
}          

          public function enviar_mensaje() {
                $this->tomar_post();
                
                $this->armar_sql();
                
                if (!$this->db->query_db()) {
                    return true;
                } else {
                    return false;
                }
          }
          
          
          public function contar_mensajes($id_usuario_emisor, $id_usuario_receptor) {

                $this->db->sql ="select count(*) as count from mensajes where id_usuario_emisor=" . $id_usuario_emisor . " \n";
                $this->db->sql.="and id_usuario_receptor=" . $id_usuario_receptor . " \n";
                $this->db->sql.="and estado='no leido' \n";
                
                if (!$this->db->query_db()) {
                    return 0;
                } else {
                    return $this->db->campo("count");
                }
          }
          
          
          
}

?>