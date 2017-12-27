<?php

class icon {
    
    public $base_dir;
        
        
    function __construct() {
        $this->base_dir="/imagenes/icons/";
    }
        

    
        public function agregar($imagen="", $tamano=32, $url_link="", $url_texto="") {
          
            $imagen_tag="<img src='" . $this->base_dir;

            switch ($imagen) {
                case "":
                    $imagen_tag .= "";
                    break;
                case "agregar":
                    $imagen_tag  .= "Add.png";
                    break;                    
                case "editar":
                    $imagen_tag .= "pencil_32.png";
                    break;
                case "borrar":
                    $imagen_tag .= "trash_32.png";
                    break;
                case "buscar":
                    $imagen_tag .= "search_32.png";
                    break;                    
                case "volver":
                    $imagen_tag .= "left_32.png";
                    break;                    
                case "documento":
                    $imagen_tag .= "document_32.png";
                    break;                    
                case "subir":
                    $imagen_tag .= "up_32.png";
                    break;                    
                case "procesar":
                    $imagen_tag .= "gear_32.png";
                    break;                    


            }            

            $imagen_tag .= "' width='" . $tamano . "' height='" . $tamano . "' border='0'>";
            if ($url_link<>"") {
                print "<a href='" . $url_link . "'>";
            }
            
            print $imagen_tag;
            
            if ($url_texto<>"") {
                print  " " . $url_texto;
            }
            
            if ($url_link<>"") {
                print  "</a> ";
            }
            
        }


    
        public function icono($imagen="",$tamano=32) {
          
            $imagen_tag="<img src='" . $this->base_dir;

            switch ($imagen) {
                case "":
                    $imagen_tag .= "";
                    break;
                case "agregar":
                    $imagen_tag  .= "Add.png";
                    break;                    
                case "editar":
                    $imagen_tag .= "pencil_32.png";
                    break;
                case "borrar":
                    $imagen_tag .= "trash_32.png";
                    break;
                case "buscar":
                    $imagen_tag .= "search_32.png";
                    break;                    
                case "volver":
                    $imagen_tag .= "left_32.png";
                    break;                    
                case "seleccionar":
                    $imagen_tag .= "document_16.png";
                    break;                    
                case "subir":
                    $imagen_tag .= "up_32.png";
                    break;                    
                case "documento":
                    $imagen_tag .= "document_32.png";
                    break;                    
                case "procesar":
                    $imagen_tag .= "gear_32.png";
                    break;                    

                    
                    
            }            

            $imagen_tag .= "' width='" . $tamano . "' height='" . $tamano . "' border='0'>";
            return $imagen_tag;
            
        }
        
        
        
        
        
        
}


?>
