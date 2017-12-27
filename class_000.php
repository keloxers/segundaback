<?php

class chofer {

    public $id_chofer;
    public $apellidoynombre;
    public $dni;
    public $estado;
    public $icono;    


/*
    id_chofer
    apellidoynombre
    dni
    estado
*/


    
    public $texto_buscar;
    public $buscar_por;
    public $pagina;
    public $registros_por_pagina;
    public $paginas_botones;
    
    public $tabla;
    

    function __construct() {
        $this->box = new mensaje();
        $this->db = new db();             
        $this->icono = new icon();
        $this->tabla = "choferes";
        $this->pagina = 0;
        $this->registros_por_pagina = 10;
        $this->paginas_botones=10;
    }
    
    private function tomar_post() {
            $areas=explode("/",$_SERVER["REQUEST_URI"]);
            $vaccion=$areas[1];
            if ($vaccion=="editar_chofer" or $vaccion=="borrar_chofer") {
                $this->id_chofer=$areas[2];
            }

            if ($vaccion=="Choferes") {
                $this->pagina=$areas[2];
                if ($this->pagina < 1) {
                    $this->pagina=0;
                }
            }
            
        if (isset($_REQUEST["id_chofer"])) {
            $this->id_chofer=$_REQUEST["id_chofer"]; }
        if (isset($_REQUEST["apellidoynombre"])) {
            $this->apellidoynombre=$_REQUEST["apellidoynombre"]; }
        if (isset($_REQUEST["dni"])) {
            $this->dni = $_REQUEST["dni"]; }
        if (isset($_REQUEST["estado"])) {
            $this->estado = $_REQUEST["estado"]; }            
            

        if (isset($_REQUEST["texto_buscar"])) {
            $this->texto_buscar = $_REQUEST["texto_buscar"]; }                        
        if (isset($_REQUEST["buscar_por"])) {
            $this->buscar_por = $_REQUEST["buscar_por"]; }            
            
}


        public function cargar_registro(){
                $this->id_chofer = $this->db->campo("id_chofer");
                $this->apellidoynombre = $this->db->campo("apellidoynombre");
                $this->dni = $this->db->campo("dni");
                $this->estado = $this->db->campo("estado");
        }

        public function limpiar_registro(){
                $this->id_chofer = 0;
                $this->apellidoynombre = "";
                $this->dni = "";
                $this->estado = "activo";
        }

        

        public function show_formulario_agregar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Choferes");
            
                if ($this->id_chofer > 0 ){
                    $formulario->text_view("id",$this->id_chofer,"");
                    $formulario->text_oculto("id_chofer",$this->id_chofer);
                    $this->buscar($this->id_chofer);
                    $boton_texto="Modificar chofer";    
                } else {
                    $this->limpiar_registro();
                    $formulario->text_view("id","asignación automática","");
                    $boton_texto="Agregar chofer";
                }

            $formulario->text_box("Apellido y Nombre","apellidoynombre",40,75,$this->apellidoynombre,"");
            $formulario->text_box("DNI","dni",15,8,$this->dni,"");
            $formulario->combo_opciones("Estado","estado",array("activo","inactivo"),$this->estado);
            
            $formulario->abrir_renglon();
            $formulario->boton($boton_texto);
            $formulario->cerrar_renglon();
            $this->barra_menu();
            $formulario->cerrar_formulario();
  }

  
  

   public function agregar() {
          $this->tomar_post();
          
          if ($this->validacion()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }

          $this->armar_sql("nuevo");
          
          // print $this->db->sql . "<br>";
          
          $this->db->query_db();
          if ($this->db->insertado()) {
                $this->box->mensaje="Se agregó correctamente el chofer";
                $this->box->show_ok();
          }
          $this->barra_menu();
  }

  public function validacion() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if ($this->apellidoynombre==""){
                $devolucion=true;
          }
          
          // para campos que no deben estar repetidos en la tabla por ejemplo DNI
          
          $this->db->sql = "select * from " . $this->tabla . " where dni=" . $this->dni . " limit 1";
          if ($this->db->query_db()) {
                $devolucion=true;
          }
      
          return $devolucion;
  }
  
  
  
   private function armar_sql($accion) {
            if ($accion=="nuevo"){
                $this->db->sql = "INSERT INTO \n";
            } else {
                $this->db->sql = "UPDATE \n";
            }
            $this->db->sql .= $this->tabla . " SET \n";
            
            $this->db->sql .= "apellidoynombre='". $this->apellidoynombre . "', \n";
            $this->db->sql .= "dni='". $this->dni . "', \n";
            $this->db->sql .= "estado='". $this->estado . "' \n";

            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_chofer=" . $this->id_chofer . "\n";
            }
          }

          
          
          
  public function modificar() {
          $this->tomar_post();

          if ($this->validacion_modificar()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }
          
          $this->armar_sql("modificar");
          
          $this->db->query_db();
          if ( $this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se modificó correctamente el chofer.";
              $this->box->show_ok();
          }
          $this->barra_menu();
  }
  
  public function validacion_modificar() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if ($this->apellidoynombre==""){
                $devolucion=true;
          }

          return $devolucion;
  }
  

   public function confirmar_borrar() {
          $this->tomar_post();
          
          $this->buscar($this->id_chofer);
          
          $formulario = new formulario();
          $formulario->abrir("Choferes");
          $formulario->text_view("id",$this->id_chofer,"");
          $formulario->text_oculto("id_chofer",$this->id_chofer);
          $formulario->text_view("Apellido y Nombre",$this->apellidoynombre,"");
          $formulario->text_view("DNI",$this->dni,"");
          $formulario->text_view("Estado",$this->estado,"");

          $formulario->abrir_renglon();
          $formulario->boton("Confirma Borrar chofer");
          $formulario->cerrar_renglon();
          $formulario->cerrar_formulario();
          $this->barra_menu();
    }

  
  
   public function borrar() {
          $this->tomar_post();
          $this->db->sql = "DELETE FROM " . $this->tabla . " where id_chofer=" . $this->id_chofer;
          // print "SQL: " . $this->db->sql . "<br>";
          $this->db->query_db();
          if ($this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se borró correctamente el chofer.";
              $this->box->show_ok();
          } else {
              $this->box->mensaje="NO borró correctamente el chofer. Puede tener datos asociados.";
              $this->box->show_error();
          }
          $this->barra_menu();

   }

   
   
        public function show_formulario_buscar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Buscar Choferes");
            
            $formulario->text_box("Buscar","texto_buscar",40,75,$this->texto_buscar,"");
            $formulario->combo_opciones("Por","buscar_por",array("Apellido y nombre","Dni"),$this->buscar_por);
            
            $formulario->abrir_renglon();
            $formulario->boton("Buscar chofer");
            $formulario->cerrar_renglon();
            $this->barra_menu();
            $formulario->cerrar_formulario();
            
  }

   
    public function buscar_show() {    

            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Buscar Choferes");
            
            $formulario->abrir_renglon();
            
            if ($this->texto_buscar<>"") {


                $buscar_por = "";
                
                switch ($this->buscar_por) {          
                     case "Apellido y nombre":
                            $buscar_por = "apellidoynombre";
                          break;
                     case "Dni":
                            $buscar_por = "dni";
                          break;
                }            
                
                $this->db->sql = "select * from " . $this->tabla . " where " . $buscar_por . " LIKE '%" . $this->texto_buscar . "%'";
                if($this->db->query_db()){
                    $this->view_listado();
                } else {
                    print "No se encotraron choferes para esa busqueda.<br>";
                }
                
            } else {
                print "No hay nada que buscar.<br>";
            }
            $this->barra_menu();
            $formulario->cerrar_renglon();
            $formulario->cerrar_formulario();
        
    }
   
   
          
  public function show_form_filtro_listado() {
            $formulario = new formulario();
            $formulario->abrir("Filtro para Listado",400);
            $formulario->combo_opciones("Por", "campo_indice", array("id_chofer", "apellidoynombre","estado"), $this->campo_indice);
            $formulario->cerrar ("Listado ordenado de choferes");
            $this->barra_menu();
   }

          
   public function show_listado() {
        $this->tomar_post();
        $formulario = new formulario();
        $formulario->abrir("Admin");

        $formulario->encabezado("");
        $formulario->abrir_renglon();
       
            $this->tomar_post();
            
            if ($this->pagina > 0) {
                $hasta = $this->pagina * $this->registros_por_pagina;
            } else {
                $hasta = 0;
            }
            
            $this->db->sql="select * from " . $this->tabla; // . " order by apellidoynombre ";
                $this->db->sql .= " limit " . $hasta . "," . $this->registros_por_pagina;
            if ($this->db->query_db()) {
                $this->view_listado();    
                $this->paginador("select count(*) as total from " . $this->tabla, $this->pagina);
                
            } else {
                $this->barra_menu();
                print "no hay nada que mostrar...<br>";
                exit;
            }
            
        $formulario->cerrar_renglon();
        
        $formulario->cerrar_formulario();
            
          }

   public function view_listado() {
        $this->tomar_post();
        $formulario = new formulario();
        
        $formulario->abrir("Listado de Choferes");
        
        $formulario->abrir_renglon();

        $formulario->tabla_open(920,array("Accion", "Id","Apellido y Nombre","Dni","Estado"));
       
       $icon = new icon();
       
       $venlace=$_SERVER["PHP_SELF"];

       do {
              $formulario->tabla_line(array(
                    
                     "<a href='/editar_chofer/" . $this->db->campo("id_chofer") . "'>" . 
                     $icon->icono("editar",16) . " Editar" . "</a> " .
                     "<a href='/borrar_chofer/" . $this->db->campo("id_chofer") . "'>" . 
                     $icon->icono("borrar",16) . " Borrar" . "</a> ", 

                     $this->db->campo("id_chofer"),
                     
                     $this->db->campo("apellidoynombre"),
                     
                     $this->db->campo("dni"),
                 
		             $this->db->campo("estado")));
        } while ($this->db->reg_siguiente());

        $formulario->tabla_close();        

        $formulario->cerrar_renglon();

        $formulario->abrir_renglon();
        
        $this->barra_menu();
        
        $formulario->cerrar_renglon();
        $formulario->cerrar_formulario();
        
}

   public function paginador($sql, $pagina_activa) {
            $this->db->sql=$sql;
            
            if ($this->db->query_db()) {
                $total_registros = $this->db->campo("total");
                $total_paginas = $total_registros / $this->registros_por_pagina;
            }
            
            print "<br>";
            
            $inicio = $pagina_activa - ($this->paginas_botones / 2);
            $final = $pagina_activa + ($this->paginas_botones / 2);
            
            if ($final > $total_paginas) {
                $final = $total_paginas;
            }
            
            if ($inicio < 0) {
                $inicio = 0;
            }
            
            print "<div class='PagesFlickr'>";
            print "    <div class='Paginator'>";

            if (($pagina_activa - 1) >=0) {
                print "<a href='/Choferes/" . ($pagina_activa - 1) . "' class='Prev'>&lt; Anterior</a>";    
            } else {
                print "<span class='AtStart'>&lt; Anterior</span>";
            }
            
            for ($i = $inicio; $i <= $final; $i++) {
                if ($pagina_activa<>$i) {
                    print "<a href='/Choferes/" . $i . "'>" . $i . "</a>";
                } else {
                    print "<span class='this-page'>" . $i . "</span>";
                }
            }            

            // print "            <span class='break'>...</span>";
            
            // print "pagina_activa: " . $pagina_activa . "<br>";
            // print "final: " . $final . "<br>";
            
            // print "i: " . $i . "<br>";
            // print "final: " . $final . "<br>";
            // print "pagina_activa: " . $pagina_activa . "<br>";
            
            
            if ($pagina_activa < ($i - 1) ) {
                print "<a href='/Choferes/" . ($pagina_activa + 1) . "' class='Next'>Siguiente &gt;</a>";
            } else {
                print "<span class='AtStart'>Siguiente &gt</span>";
            }
            
            
            
            print "        <div class='results'></div>";
            print "    </div>";
            print "</div>";
            
            
            print "<br>";
            
            
   }




   public function barra_menu() {
        print "<br>";
        $this->icono->agregar("agregar",16,"/chofer_agregar","Agregar nuevo chofer");
        $this->icono->agregar("buscar",16,"/chofer_buscar","Buscar chofer");
        $this->icono->agregar("subir",16,"/Choferes","Choferes");
        // $this->icono->agregar("volver",16,"/admin","Adminitración");
        
        print "<br><br>";

   }

   public function que($id_chofer,$campo) {
          $this->db->sql="select * from " . $this->tabla . " where id_chofer=" . $id_chofer;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }

    public function buscar($id_chofer) {    
          $this->db->sql="select * from " . $this->tabla . " where id_chofer=" . $id_chofer;
          if ($this->db->query_db()) {
            $this->cargar_registro();
            return true;
          } else {
              return false;
          }    
    }
    
        
    public function form_filtro_listado(){
            $formulario = new formulario();
            $formulario->abrir("Listado Maestro de Choferes",400,"nueva");
            $formulario->combo_box("Desde chofer","id_busqueda1","choferes","chofer","id_chofer", $this->id_busqueda1);
            $formulario->combo_box(" Hasta chofer","id_busqueda2","choferes","chofer","id_chofer", $this->id_busqueda2);
            $formulario->text_oculto("mostrar_menu",false);
            $formulario->cerrar("Listado Maestro");
            $this->barra_menu();
 }


 public function mostrar_listado() {
            $this->tomar_post();
            $chofer = new chofer();

            $this->db->sql .= "select * from " . $this->tabla . " \n";
            $this->db->sql .= "order by apellidoynombre";

            $this->db->query_db();
            $this->num=$this->db->reg_total;
            $reporte = new reporte("vertical","LISTADO MAESTRO DE CHOFERES","Desde: " . $chofer->que($this->id_busqueda1, "apellidoynombre") . "  Hasta: " . $chofer->que($this->id_busqueda2, "apellidoynombre"));
            $reporte->col_xPos = array ( 2,4,6,12);
            $reporte->col_tamanos = array (2,10,5,5);
            $reporte->col_nombres_columnas = array ("Id Chofer","Apellido y Nombre", "Dni", "Estado");
            $reporte->col_alineacion = array("right", "left", "left","left");
            $reporte->inicializar();
            $ciudad = false;
            do {
                if ( $this->db->campo("id_chofer")==$this->id_busqueda1) {
                    $chofer = true;
                }

                    if ($chofer) {
                        
                        $reporte->renglon = array (
                        $this->db->campo("id_chofer"),
                        $this->db->campo("apellidoynombre"),
                        $this->db->campo("dni"),
                        $this->db->campo("estado")
                        
                     );
                        $reporte->imprimir_renglon();
                     }
                    if ( $this->db->campo("id_chofer")==$this->id_busqueda2) {
                        $chofer = false;
                    }
            } while ($this->db->reg_siguiente());
            $reporte->renglon = array ("","","","");
            $reporte->imprimir_renglon();
            $reporte->mostrar();

         }
         
    
    
         

}

?>
