<?php

class cuenta {

    public $id_cuenta;
    public $id_usuario;
    public $id_empresa;
    public $id_cuenta_padre;
    public $id_cuenta_contrapartida;
    public $codigo;
    public $cuenta;
    public $tipo_cuenta;
    

/*
        id_cuenta
	id_usuario
        id_empresa
	id_cuenta_padre
        id_cuenta_contrapartida
	codigo
	cuenta
	tipo_cuenta
*/

    public $usuario;

    public $icono;        
    public $texto_buscar;
    public $buscar_por;
    public $pagina;
    public $registros_por_pagina;
    public $paginas_botones;
    public $id_usuario_activo;
    public $tabla;
    
    function __construct() {
        $this->box = new mensaje();
        $this->db = new db();             
        $this->icono = new icon();
        $this->usuario = new usuario();
        $this->tabla = "cuentas";
        $this->pagina = 0;
        $this->registros_por_pagina = 100;
        $this->paginas_botones=10;
        $this->id_usuario_activo = $this->usuario->usuario_activo("id_usuario");
        $this->id_empresa = $this->usuario->usuario_activo("id_empresa");
    }
    
    private function tomar_post() {
            $areas=explode("/",$_SERVER["REQUEST_URI"]);
            $vaccion=$areas[1];
            
            if ($vaccion=="cuentas_agregar") {
                $this->id_cuenta_padre = $areas[2];
            } else {
                $this->id_cuenta_padre = 0;
            }

            if ($vaccion=="cuentas") {
                $this->pagina=$areas[2];
                if ($this->pagina < 1) {
                    $this->pagina=0;
                }
            }

            
        if (isset($_REQUEST["id_cuenta"])) {
            $this->id_cuenta = $_REQUEST["id_cuenta"]; }
        if (isset($_REQUEST["id_usuario"])) {
            $this->id_usuario = $_REQUEST["id_usuario"]; }
        if (isset($_REQUEST["id_empresa"])) {
            $this->id_empresa = $_REQUEST["id_empresa"]; }
        if (isset($_REQUEST["id_cuenta_padre"])) {
            $this->id_cuenta_padre = $_REQUEST["id_cuenta_padre"]; }
        if (isset($_REQUEST["id_cuenta1"])) {
                $this->id_cuenta_contrapartida = $_REQUEST["id_cuenta1"];
            } else {
                $this->id_cuenta_contrapartida = 0;
            }
        if (isset($_REQUEST["codigo"])) {
            $this->codigo = $_REQUEST["codigo"]; }
        if (isset($_REQUEST["cuenta"])) {
            $this->cuenta = $_REQUEST["cuenta"]; }
        if (isset($_REQUEST["tipo_cuenta"])) {
            $this->tipo_cuenta = $_REQUEST["tipo_cuenta"]; }

            
        if (isset($_REQUEST["texto_buscar"])) {
            $this->texto_buscar = $_REQUEST["texto_buscar"]; }                        
        if (isset($_REQUEST["buscar_por"])) {
            $this->buscar_por = $_REQUEST["buscar_por"]; }            
            
}


        public function cargar_registro(){
                $this->id_cuenta = $this->db->campo("id_cuenta");
                $this->id_usuario = $this->db->campo("id_usuario");
                $this->id_empresa = $this->db->campo("id_empresa");
                $this->id_cuenta_padre = $this->db->campo("id_cuenta_padre");
                $this->id_cuenta_contrapartida = $this->db->campo("id_cuenta_contrapartida");
                $this->codigo = $this->db->campo("codigo");
                $this->cuenta = $this->db->campo("cuenta");
                $this->tipo_cuenta = $this->db->campo("tipo_cuenta");

                
        }

        public function limpiar_registro(){
                $this->id_cuenta = 0;
                $this->id_usuario = 0;
                $this->id_cuenta_padre = 0;
                $this->id_cuenta_contrapartida = 0;
                $this->codigo = "";
                $this->cuenta = "";
                $this->tipo_cuenta = "";
                                
        }
        
        
        public function proximo_codigo($id_cuenta_padre) {
            $aritmetica = new aritmetica();
                        
            $this->db->sql = "select * from " . $this->tabla . " \n";
            $this->db->sql.= "where id_cuenta_padre=" . $id_cuenta_padre . " \n";
            $this->db->sql.= "and id_empresa=" . $this->id_empresa . " \n";
            $this->db->sql.= "order by codigo desc limit 1 \n";
            // print "SQL: " . $this->db->sql . "<br>";
            
            if ($this->db->query_db()) {
                
                $codigo .= $aritmetica->completar_zero($this->extraer_ultimo_codigo($this->db->campo("codigo")) + 1,2);
                // print "codigo: " . $codigo . "<br>";
                
                $this->db->sql = "select * from " . $this->tabla . " \n";
                $this->db->sql.= "where id_cuenta=" . $id_cuenta_padre . " \n";
                $this->db->sql.= "and id_empresa=" . $this->id_empresa . " \n";
                $this->db->sql.= "limit 1 \n";
                
                // print "SQL: " . $this->db->sql . "<br>";
                
                if ($this->db->query_db()) {
                    $codigo_ret="";
                    if($id_cuenta_padre>0){
                        $codigo_ret = $this->db->campo("codigo") . ".";
                    }
                    $codigo_ret = $codigo_ret . $codigo;
                    return $codigo_ret;
                } else {
                    return $codigo;
                }
                
                
            } else {

                
                $this->db->sql = "select * from " . $this->tabla . " \n";
                $this->db->sql.= "where id_cuenta=" . $id_cuenta_padre . " \n";
                $this->db->sql.= "and id_empresa=" . $this->id_empresa . " \n";
                // print "SQL: " . $this->db->sql . "<br>";
                if ($this->db->query_db()) {
                    $codigo_ret = $this->db->campo("codigo") . ".";
                }
                $codigo_ret = $codigo_ret . "01";
                return $codigo_ret;
                
            }
            
            
            
            
        }

        public function extraer_ultimo_codigo($codigo){
            $areas=explode(".",$codigo);
            $ultimo_index = count($areas)-1;
            $codigo=$areas[$ultimo_index];
            return $codigo;
        }
        
        

        public function show_formulario_agregar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Cuentas");
            $cuenta = new cuenta();
            // $this->limpiar_registro();
            $formulario->text_view("id","asignacion automatica","");
            $boton_texto="Agregar Cuenta";
                        
            if($this->id_cuenta_padre=="") {
                $this->id_cuenta_padre=0;
            }
            
            $formulario->text_view("Cuenta Padre:", $cuenta->que($this->id_cuenta_padre,"cuenta"), "");
            
            $this->codigo=$this->proximo_codigo($this->id_cuenta_padre);
                
            $formulario->text_view("Codigo", $this->codigo, "");
            $formulario->text_oculto("codigo", $this->codigo);
            $formulario->text_oculto("id_cuenta_padre", $this->id_cuenta_padre);
            
            $formulario->text_box("Cuenta","cuenta",40,75,$this->cuenta,"");
            $formulario->combo_opciones("Tipo de cuenta","tipo_cuenta",array("debito","credito"),$this->tipo_cuenta);
            print "
                <div class='detalle_asiento'>Cuenta contrapartida:<br>
                  <input id='cuenta_ajax' name='cuenta_ajax' type='text' size='50' maxlength='100' />
                  <input type='hidden' name='id_cuenta1' id='id_cuenta1' value=''>
                </div>
                <br>
                <div id='cuenta_detalle'></div>

            ";            
            $formulario->abrir_renglon();
            $formulario->boton($boton_texto);
            $formulario->cerrar_renglon();
            $this->barra_menu();
            $formulario->cerrar_formulario();
  }


   public function agregar($id_cuenta_padre=0) {
          $this->tomar_post();

          /*
          if ($this->validacion()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }
          */
          if ($id_cuenta_padre>0) {
              $this->id_cuenta_padre = $id_cuenta_padre;
          }
          
          if($this->id_cuenta_contrapartida=="") {
              $this->id_cuenta_contrapartida=0;
          }
          
          $this->armar_sql("nuevo");
          
          // print $this->db->sql . "<br>";
          
          $this->db->query_db();
          if (!$this->db->insertado()) {
                $this->box->mensaje="Hubo un erro al intentar agregar la cuenta";
                $this->box->show_error();
          }

  }

  public function validacion() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if ($this->cuenta==""){
                print "La cuenta no puede estar vacia.<br>";
                $devolucion=true;
          }

          
          // para campos que no deben estar repetidos en la tabla por ejemplo DNI
          
          $this->db->sql = "select * from " . $this->tabla . " where cuenta='" . $this->ciudad . "' ";
          $this->db->sql.= " and id_empresa=" . $this->id_empresa;
          $this->db->sql.= " limit 1";
          if ($this->db->query_db()) {
                print "Ya existe esa cuenta en la tabla.<br>";
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
            
            $this->db->sql .= "id_usuario=". $this->id_usuario_activo . ", \n";
            $this->db->sql .= "id_empresa=". $this->id_empresa . ", \n";
            $this->db->sql .= "id_cuenta_padre=". $this->id_cuenta_padre . ", \n";
            $this->db->sql .= "id_cuenta_contrapartida=". $this->id_cuenta_contrapartida . ", \n";
            $this->db->sql .= "codigo='". $this->codigo . "', \n";        
            $this->db->sql .= "cuenta='". $this->cuenta . "', \n";
            $this->db->sql .= "tipo_cuenta='". $this->tipo_cuenta . "' \n";

            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_cuenta=" . $this->id_cuenta . "\n";
            }
            
          }
          
          
  public function modificar() {
          $this->tomar_post();

          if ($this->validacion_modificar()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }
          
          $this->armar_sql("modificar");
          // print $this->db->sql;
          
          $this->db->query_db();
          if ( $this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se modifico correctamente la ciudad.";
              $this->box->show_ok();
          }
          $this->barra_menu();
  }
  
  public function validacion_modificar() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if ($this->ciudad==""){
                $devolucion=true;
          }

          return $devolucion;
  }
  

   public function confirmar_borrar() {
          $this->tomar_post();
          
          if (!$this->buscar($this->id_ciudad)) {
                print "Error de seguridad esta Ciudad no te pertenece<br>";
                exit;
          }
          
          $formulario = new formulario();
          $formulario->abrir("Ciudades");
          $formulario->text_view("id",$this->id_ciudad,"");
          $formulario->text_oculto("id_ciudad",$this->id_ciudad);
          $formulario->text_view("Ciudad",$this->ciudad,"");
          $formulario->text_view("Estado",$this->estado->que($this->id_estado, "estado"),"");
          $formulario->text_view("Codigo Postal",$this->codigo_postal,"");

          $formulario->abrir_renglon();
          $formulario->boton("Confirma borrar ciudad");
          $formulario->cerrar_renglon();
          $formulario->cerrar_formulario();
          $this->barra_menu();
    }


    


    
   public function borrar() {
          $this->tomar_post();
          $this->db->sql = "DELETE FROM " . $this->tabla . " where id_ciudad=" . $this->id_ciudad;
          $this->db->sql.= " and id_usuario=" . $this->id_usuario_activo;
          // print "SQL: " . $this->db->sql . "<br>";
          $this->db->query_db();
          if ($this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se borro correctamente la ciudad.";
              $this->box->show_ok();
          } else {
              $this->box->mensaje="NO borro correctamente la ciudad. Puede tener datos asociados.";
              $this->box->show_error();
          }
          $this->barra_menu();
   }

   
   
        public function show_formulario_buscar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Buscar Ciudades");
            
            $formulario->text_box("Buscar","texto_buscar",40,75,$this->texto_buscar,"");
            $formulario->combo_opciones("Por","buscar_por",array("Ciudad"),$this->buscar_por);
            
            $formulario->abrir_renglon();
            $formulario->boton("Buscar ciudades");
            $formulario->cerrar_renglon();
            $this->barra_menu();
            $formulario->cerrar_formulario();
            
  }

   
    public function buscar_show() {    

            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Buscar Ciudades");
            
            $formulario->abrir_renglon();
            
            if ($this->texto_buscar<>"") {


                $buscar_por = "";
                
                switch ($this->buscar_por) {          
                     case "Ciudad":
                            $buscar_por = "ciudad";
                          break;
                }            
                

                
                $this->db->sql = "select * from " . $this->tabla . " where " . $buscar_por . " LIKE '%" . $this->texto_buscar . "%' ";
                $this->db->sql.= "and id_usuario=" . $this->id_usuario_activo;
                
                // print "SQL: " . $this->db->sql;
                
                if($this->db->query_db()){
                    $this->view_listado();
                } else {
                    print "No se encotraron categorias socio para esa busqueda.<br>";
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
            $formulario->combo_opciones("Por", "campo_indice", array("id_ciudad", "id_estado","ciudad"), $this->campo_indice);            
            $formulario->cerrar ("Listado ordenado de ciudades");
            $this->barra_menu();
   }


   
   public function show_listado() {
        $this->tomar_post();
        $formulario = new formulario();
        $formulario->abrir("Cuentas");

        $formulario->encabezado("");
        $formulario->abrir_renglon();
       
            $this->tomar_post();
            
            if ($this->pagina > 0) {
                $hasta = $this->pagina * $this->registros_por_pagina;
            } else {
                $hasta = 0;
            }
            
            $this->db->sql="select * from " . $this->tabla; // . " order by apellidoynombre ";
            $this->db->sql.= " where id_empresa=" . $this->id_empresa;
            $this->db->sql.= " order by codigo";
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
        
        $formulario->abrir("Listado de Cuentas");
        
        $formulario->abrir_renglon();

        $formulario->tabla_open(920,array("Accion", "Codigo","Cuenta","Tipo"));
       
        $icon = new icon();

        $venlace=$_SERVER["PHP_SELF"];

        do {
            
            /*
                "<a href='/editar_cuenta/" . $this->db->campo("id_cuenta") . "'>" . 
                $icon->icono("editar",16) . " Editar" . "</a> " .
                "<a href='/borrar_cuenta/" . $this->db->campo("id_cuenta") . "'>" . 
                $icon->icono("borrar",16) . " Borrar" . "</a> ", 
        */
            
              $formulario->tabla_line(array(

                "<a href='/cuentas_agregar/" . $this->db->campo("id_cuenta") . "'>" . 
                $icon->icono("agregar",16) . " Agregar cuenta" . "</a> ", 

                $this->db->campo("codigo"),
                $this->db->campo("cuenta"),
                $this->db->campo("tipo_cuenta")));
              
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
                print "<a href='/cuentas/" . ($pagina_activa - 1) . "' class='Prev'>&lt; Anterior</a>";    
            } else {
                print "<span class='AtStart'>&lt; Anterior</span>";
            }
            
            for ($i = $inicio; $i <= $final; $i++) {
                if ($pagina_activa<>$i) {
                    print "<a href='/cuentas/" . $i . "'>" . $i . "</a>";
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
                print "<a href='/ciudades/" . ($pagina_activa + 1) . "' class='Next'>Siguiente &gt;</a>";
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
        $this->icono->agregar("agregar",16,"/cuentas_agregar","Agregar nueva cuenta");
        $this->icono->agregar("buscar",16,"/cuentas_buscar","Buscar cuenta");
        $this->icono->agregar("subir",16,"/cuentas","Cuentas");
        // $this->icono->agregar("volver",16,"/admin","Adminitraci�n");
        
        print "<br><br>";

   }

   public function que($id_cuenta ,$campo) {
          $this->db->sql="select * from " . $this->tabla . " where id_cuenta=" . $id_cuenta;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }

   public function buscar_id($cuenta, $id_empresa) {
          $this->db->sql ="select * from " . $this->tabla . " where cuenta='" . $cuenta . "'";
          $this->db->sql.=" and id_empresa=" . $id_empresa;
          
          // print "SQL: " . $this->db->sql . "<br>";
          if ($this->db->query_db()) {
              return $this->db->campo("id_cuenta");
          } else {
              return 0;
          }

    }
    
    
    public function buscar($id_ciudad) {    
          $this->db->sql="select * from " . $this->tabla . " where id_ciudad=" . $id_ciudad;
          $this->db->sql.= " and id_usuario=" . $this->id_usuario_activo;
          if ($this->db->query_db()) {
            $this->cargar_registro();
            return true;
          } else {
              return false;
          }    
    }

    public function buscar_where($sql_where) {    
          $this->db->sql="select * from " . $this->tabla . " " . $sql_where;
          $this->db->sql.= " and id_empresa=" . $this->id_empresa;
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
         
    
   public function buscar_cuenta($term, $id_cuenta_padre=0) {
        $db2 = new db();
        $db3 = new db();
        $aritmetica = new aritmetica();
                
        $datos = array();
          
        $sql_where="";
          
        $sql_where ="(cuenta LIKE '%" . $term . "%' or codigo Like  '%" . $term . "%') ";
        $sql_where.=" and id_empresa=" . $this->id_empresa;
        
        if ($id_cuenta_padre>0) {
            // $sql_where.=" and id_cuenta_padre=" . $id_cuenta_padre;
        }
        
        $sql_where.=" limit 10";
          
          $this->db->sql = "select * from cuentas where " . $sql_where;
          
          if($this->db->query_db()) {
               do {
                   
                       $cuenta = $this->db->campo("codigo") . " - ". $this->db->campo("cuenta");
                       $search  = array(chr(209), 'ñ', 'á', 'é', 'í', 'ó', 'ú');
                       $replace = array('N', 'n', 'a', 'e', 'i', 'o', 'u');
                       // $razon_social = str_replace ( chr(209) , "N" , $razon_social );
                       $cuenta = str_replace ( $search , $replace , $cuenta );
                       
                       $db2->sql = "select sum(importe) as importe from asientos where id_cuenta=" . $this->db->campo("id_cuenta");
                       $db2->sql.= " and id_empresa=" . $this->id_empresa;
                       $db2->sql.= " and tipo_asiento='debito'";
                       $db2->query_db();
                       $total_debito=$db2->campo("importe");
                       
                       $db2->sql = "select sum(importe) as importe from asientos where id_cuenta=" . $this->db->campo("id_cuenta");
                       $db2->sql.= " and id_empresa=" . $this->id_empresa;
                       $db2->sql.= " and tipo_asiento='credito'";
                       $db2->query_db();
                       $total_credito=$db2->campo("importe");                       

                       
                       $db2->sql = "select * from asientos where id_cuenta=" . $this->db->campo("id_cuenta");
                       $db2->sql.= " and id_empresa=" . $this->id_empresa;
                       $db2->sql.= " order by id_asiento desc limit 8";
                       
                       $tabla = "";
                       if ($db2->query_db()) {
                            $tabla .= "Ultimos movimientos de esta cuenta:<br>";
                            $tabla .= "<table width='720' border='0'>";
                            $tabla .= "<tr class='fondo_formulario_tabla_titulo'>";
                            $tabla .= "<td>Fecha</td>";
                            $tabla .= "<td>Detalle</td>";
                            $tabla .= "<td>Credito</td>";
                            $tabla .= "<td>Debito</td>";
                            $tabla .= "<td>Saldo</td>";
                            $tabla .= "</tr>";
                                                        
                           do {
                               
                                $tabla .= "<tr>";
                                $tabla .= "<td>" . "<div align='left'>" . $db2->campo("fecha") . "</div></td>";
                                $tabla .= "<td>" . "<div align='left'>" . $db2->campo("detalle") . "</div></td>";
                                
                                $debito=0;
                                $credito=0;
                                
                                if($db2->campo("tipo_asiento")=="credito") {
                                    $credito = $db2->campo("importe");
                                } else {
                                    $debito = $db2->campo("importe");
                                }
                                
                                $tabla .= "<td>"  . "<div align='right'>" . $aritmetica->formato_numero($credito,2) . "</div></td>";
                                $tabla .= "<td>"  . "<div align='right'>" . $aritmetica->formato_numero($debito,2) . "</div></td>";
                                $tabla .= "<td>"  . "<div align='right'></div></td>";
                                $tabla .= "</tr>";
                               
                           } while ($db2->reg_siguiente());
                           
                           $saldo=$total_credito - $total_debito;
                                $tabla .= "<tr class='fondo_formulario_tabla_titulo'>";
                                $tabla .= "<td></td>";
                                $tabla .= "<td>"  . "<div align='right'><b>TOTALES</div></td>";
                                $tabla .= "<td>"  . "<div align='right'><b>" . $aritmetica->formato_numero($total_credito,2) . "</b></div></td>";
                                $tabla .= "<td>"  . "<div align='right'><b>" . $aritmetica->formato_numero($total_debito,2) . "</b></div></td>";
                                $tabla .= "<td>"  . "<div align='right'><b>" . $aritmetica->formato_numero($saldo,2) . "</b></div></td>";
                                $tabla .= "</tr>";
                           
                           
                           $tabla .= "</table>";
                       }
                       
                       $cuenta_contrapartida="no hay cuenta contrapartida";
                       
                       $db3->sql = "select * from cuentas where id_cuenta=" . $this->db->campo("id_cuenta_contrapartida");
                       $db3->sql.= " and id_empresa=" . $this->id_empresa;
                       $db3->sql.= " limit 1";
                       
                       if ($db3->query_db()) {
                           $cuenta_contrapartida=$db3->campo("codigo") . " - " . $db3->campo("cuenta");
                       }
                       
                       
                        $datos[] = array ( "value" => $cuenta ,
                                            "id_cuenta" => $this->db->campo("id_cuenta"),
                                            "codigo" => $this->db->campo("codigo"),
                                            "tipo_cuenta" => $this->db->campo("tipo_cuenta"),
                                            "tabla" => $tabla,
                                            "id_cuenta_contrapartida" => $this->db->campo("id_cuenta_contrapartida"),
                                            "cuenta_contrapartida" => $cuenta_contrapartida
                        );
                        
                } while ($this->db->reg_siguiente());              
                
                
                
          }
          return $datos;
   }
    
         

}

?>
