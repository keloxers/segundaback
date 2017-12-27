<?php

class clienteproveedor {

    public $id_clienteproveedor;
    public $razon_social;
    public $id_cuenta;
    public $id_empresa;
    public $tipo;
    public $cuit;
    public $direccion;
    public $telefono;
    public $estado;
    public $config;

    /*
    
    id_clienteproveedor
    razon_social
    id_cuenta
    id_empresa
    tipo
    cuit
    direccion
    telefono
    estado
 */

    public $usuario;
    public $id_usuario_activo;

    
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
        $this->config = new configuracion();
        $this->usuario = new usuario();
        $this->tabla = "clientesproveedores";
        $this->pagina = 0;
        $this->registros_por_pagina = 10;
        $this->paginas_botones=10;
        $this->id_usuario_activo = $this->usuario->usuario_activo("id_usuario");
        $this->id_empresa = $this->usuario->usuario_activo("id_empresa");
    }
    
    private function tomar_post() {
            $areas=explode("/",$_SERVER["REQUEST_URI"]);
            $vaccion=$areas[1];
            if ($vaccion=="editar_clienteproveedor" or $vaccion=="borrar_clienteproveedor") {
                $this->id_clienteproveedor=$areas[2];
            }

            if ($vaccion=="clienteproveedor") {
                $this->pagina=$areas[2];
                if ($this->pagina < 1) {
                    $this->pagina=0;
                }
            }
            
        if (isset($_REQUEST["id_clienteproveedor"])) {
            $this->id_clienteproveedor=$_REQUEST["id_clienteproveedor"]; }
        if (isset($_REQUEST["razon_social"])) {
            $this->razon_social=$_REQUEST["razon_social"]; }
        if (isset($_REQUEST["id_cuenta"])) {
            $this->id_cuenta = $_REQUEST["id_cuenta"]; }
        if (isset($_REQUEST["tipo"])) {
            $this->tipo=$_REQUEST["tipo"]; }
        if (isset($_REQUEST["cuit"])) {
            $this->cuit = $_REQUEST["cuit"]; }
        if (isset($_REQUEST["direccion"])) {
            $this->direccion = $_REQUEST["direccion"]; }
        if (isset($_REQUEST["telefono"])) {
            $this->telefono = $_REQUEST["telefono"]; }
        if (isset($_REQUEST["estado"])) {
            $this->estado = $_REQUEST["estado"]; }
	
	
	



        if (isset($_REQUEST["texto_buscar"])) {
            $this->texto_buscar = $_REQUEST["texto_buscar"]; }                        
        if (isset($_REQUEST["buscar_por"])) {
            $this->buscar_por = $_REQUEST["buscar_por"]; }            
            
}

        public function cargar_registro(){
            $this->id_clienteproveedor = $this->db->campo("id_clienteproveedor");
            $this->razon_social = $this->db->campo("razon_social");
            $this->id_cuenta = $this->db->campo("id_cuenta");
            $this->tipo = $this->db->campo("tipo");            
            $this->cuit = $this->db->campo("cuit");
            $this->direccion = $this->db->campo("direccion");
            $this->telefono = $this->db->campo("telefono");
            $this->estado = $this->db->campo("estado");
        }

        public function limpiar_registro(){
            $this->id_clienteproveedor = 0;
            $this->razon_social = "";
            $this->id_cuenta = 0;
            $this->tipo = 0;
            $this->cuit = "";
            $this->direccion = "";
            $this->telefono = "";
            $this->estado = 0;
        }


        public function show_formulario_agregar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Clientes y Proveedores");
            
                if ($this->id_clienteproveedor > 0 ){
                    $formulario->text_view("id",$this->id_clienteproveedor,"");
                    $formulario->text_oculto("id_clienteproveedor",$this->id_clienteproveedor);
                    $this->buscar(" where id_clienteproveedor=" . $this->id_clienteproveedor );
                    $formulario->text_oculto("id_cuenta",$this->id_cuenta);
                    $boton_texto="Modificar cliente o proveedor";    
                } else {
                    $this->limpiar_registro();
                    $formulario->combo_opciones("Tipo","tipo",array("Cliente","Proveedor"),$this->tipo);
                    $boton_texto="Agregar cliente o proveedor";
                }
            
            $formulario->text_box("Razon Social","razon_social",50,35,$this->razon_social,"");
            $formulario->text_box("Cuit","cuit",40,75,$this->cuit,"");
            $formulario->text_box("Direccion","direccion",40,75,$this->direccion,"");
            $formulario->text_box("telefono","telefono",40,75,$this->telefono,"");
            $formulario->combo_opciones("Estado","estado",array("activo","inactivo"),$this->estado);
            
            $formulario->abrir_renglon();
            $formulario->boton($boton_texto);
            $formulario->cerrar_renglon();
            $this->barra_menu();
            $formulario->cerrar_formulario();
  }

  
  

   public function agregar() {
          $this->tomar_post();
          $cuenta = new cuenta();
          
          if ($this->tipo=="Cliente"){
                $id_cuenta = $this->config->que_configuracion($this->id_empresa . "_cuenta_deudoresporventa", "numero");    
          } else {
                $id_cuenta = $this->config->que_configuracion($this->id_empresa . "_cuenta_proveedores", "numero");    
          }
          
          // print "Id Cuenta padre... " . $id_cuenta . "<br>";
          
          if ($id_cuenta==0) {
              print "Falta configuracion...<br>";
              die;
          }
          
          $proximo_codigo=$cuenta->proximo_codigo($id_cuenta);
          
          $cuenta->id_usuario = $this->id_usuario_activo;
          $cuenta->id_empresa = $this->id_empresa;
          $cuenta->id_cuenta_padre = $id_cuenta;
          $cuenta->codigo = $proximo_codigo;
          $cuenta->cuenta = $this->razon_social;
          $cuenta->tipo_cuenta = "credito";

          $cuenta->agregar($id_cuenta);
          
          $this->id_cuenta = $cuenta->db->insertado();
          
          
          
          if ($this->validacion()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }

          $this->armar_sql("nuevo");
          
          // print $this->db->sql . "<br>";
          
          $this->db->query_db();
          if ($this->db->insertado()) {
                $this->box->mensaje="Se agrego correctamente";
                $this->box->show_ok();
          }
          $this->barra_menu();
  }

  public function validacion() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if ($this->razon_social==""){
                $devolucion=true;
          }

          // para campos que no deben estar repetidos en la tabla por ejemplo DNI
          
          $this->db->sql = "select * from " . $this->tabla .
                           " where razon_social='" . $this->razon_social .
                           "' limit 1";
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
    
   
            $this->db->sql .= "razon_social='". $this->razon_social . "', \n";
            $this->db->sql .= "id_cuenta=". $this->id_cuenta . ", \n";
            $this->db->sql .= "id_empresa=". $this->id_empresa . ", \n";
            if ($accion=="nuevo"){
                $this->db->sql .= "tipo='". $this->tipo . "', \n";
            }
            $this->db->sql .= "cuit='". $this->cuit . "', \n";
            $this->db->sql .= "direccion='". $this->direccion . "', \n";
            $this->db->sql .= "telefono='". $this->telefono . "', \n";
            $this->db->sql .= "estado='". $this->estado . "' \n";
		
            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_clienteproveedor = " . $this->id_clienteproveedor . "\n";
            }
          }

          
          
          
  public function modificar() {
          $this->tomar_post();

          if ($this->validacion_modificar()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }
          
          // modificando cuenta
            $this->db->sql = "UPDATE cuentas SET \n";
            $this->db->sql .= "cuenta='". $this->razon_social . "' \n";
            $this->db->sql .= "where id_cuenta=" . $this->id_cuenta . "\n";
            $this->db->query_db();
            if ( $this->db->reg_afectados < 1 ) {
                $this->box->mensaje="Ocurrio un error al intentar modificar la cuenta.";
                $this->box->show_error();
            }          
                    
          $this->armar_sql("modificar");
          
          // print "SQL: " . $this->db->sql . "<br>";
          
          $this->db->query_db();
          if ( $this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se modifico correctamente.";
              $this->box->show_ok();
          }
          $this->barra_menu();
  }
  
  
  
  public function validacion_modificar() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if ($this->razon_social==""){
                $devolucion=true;
          }

          return $devolucion;
  }
  

   public function confirmar_borrar() {
          $this->tomar_post();
          
          $this->buscar(" where id_clienteproveedor=" . $this->id_clienteproveedor);
          
          $formulario = new formulario();
          $formulario->abrir("Clientes y Proveedores");
          $formulario->text_view("id",$this->id_clienteproveedor,"");
          $formulario->text_oculto("id_clienteproveedor",$this->id_clienteproveedor);
          $formulario->text_view("Razon Social",$this->razon_social,"");
          $formulario->text_view("tipo",$this->tipo,"");
          $formulario->text_view("Direccion",$this->direccion,"");

          $formulario->abrir_renglon();
          $formulario->boton("Confirma Borrar cliente o proveedor");
          $formulario->cerrar_renglon();
          $formulario->cerrar_formulario();
          $this->barra_menu();
    }

  
   public function borrar() {
          $this->tomar_post();
          
          if (!$this->buscar(" where id_clienteproveedor=" . $this->id_clienteproveedor)) {
              Print "No existe el Cliente o proveedor seleccionado<br>";
              die;
          }
          
          
          $this->db->sql = "select * from asientos where id_clienteproveedor=" . $this->id_clienteproveedor;
          
          if ($this->db->query_db()) {
              Print "No se puede eliminar el cliente o proveedor porque tiene datos asociados";
              die;
          }

          $this->db->sql = "DELETE FROM cuentas where id_cuenta=" . $this->id_cuenta;
          $this->db->query_db();
          
          $this->db->sql = "DELETE FROM " . $this->tabla . " where id_clienteproveedor=" . $this->id_clienteproveedor;
          // print "SQL: " . $this->db->sql . "<br>";
          $this->db->query_db();
          if ($this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se borro correctamente.";
              $this->box->show_ok();
          } else {
              $this->box->mensaje="NO borro correctamente. Puede tener datos asociados.";
              $this->box->show_error();
          }
          $this->barra_menu();

   }


    
   public function buscar_clienteproveedor($term, $tipo="") {
          $db = new db();
        
          $datos = array();
          
          $sql_where="";
          
          $sql_where =" razon_social LIKE '%" . $term . "%' ";
          $sql_where.=" and id_empresa=" . $this->id_empresa . " ";
          
          if($tipo=="cliente" or $tipo=="proveedor") {
            $sql_where.=" and tipo='" . $tipo . "' ";                  
          }
          
          $sql_where.=" order by razon_social limit 10";
          
          $this->db->sql = "select * from " . $this->tabla . " where " . $sql_where;
          
          if($this->db->query_db()) {
               do {
                   
                   if (!$db->query_db()) {
                       $razon_social = $this->db->campo("razon_social") . " - ". $this->db->campo("cuit");
                       $search  = array(chr(209), 'ñ', 'á', 'é', 'í', 'ó', 'ú');
                       $replace = array('N', 'n', 'a', 'e', 'i', 'o', 'u');
                       $razon_social = str_replace ( $search , $replace , $razon_social );
                       
                        $datos[] = array ( "value" => $razon_social ,
                                            "id_clienteproveedor" => $this->db->campo("id_clienteproveedor"),
                                            "tipo" => $this->db->campo("tipo"),
                                            "id_cuenta" => $this->db->campo("id_cuenta")
                            );
                   }
                } while ($this->db->reg_siguiente());              
                
          }
          return $datos;
   }
    

   
        public function show_formulario_buscar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Buscar Clientes o Proveedores");
            
            $formulario->text_box("Buscar","texto_buscar",40,75,$this->texto_buscar,"");
            $formulario->combo_opciones("Por","buscar_por",array("Razon Social"),$this->buscar_por);
            
            $formulario->abrir_renglon();
            $formulario->boton("Buscar Clientes o Proveedores");
            $formulario->cerrar_renglon();
            $this->barra_menu();
            $formulario->cerrar_formulario();
            
  }

   
    public function buscar_show() {    

            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Buscar Clientes o Proveedores");
            
            $formulario->abrir_renglon();
            
            if ($this->texto_buscar<>"") {


                $buscar_por = "";
                
                switch ($this->buscar_por) {          
                     case "Razon Social":
                            $buscar_por = "razon_social";
                          break;
                }            
                
                $this->db->sql = "select * from " . $this->tabla . " where " . $buscar_por . " LIKE '%" . $this->texto_buscar . "%'";
                $this->db->sql.= " and id_empresa=" . $this->id_empresa;
                if($this->db->query_db()){
                    $this->view_listado();
                } else {
                    print "No se encotraron datos para esa busqueda.<br>";
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
            $formulario->combo_opciones("Por", "campo_indice", array("id_clienteproveedor", "razon_social","direccion"), $this->campo_indice);
            $formulario->cerrar ("Listado ordenado de clientes y Proveedores");
            $this->barra_menu();
   }

          
   public function show_listado() {
        $this->tomar_post();
        $formulario = new formulario();
        $formulario->abrir("Clientes y Proveedores");

        $formulario->encabezado("");
        $formulario->abrir_renglon();
       
            $this->tomar_post();
            
            if ($this->pagina > 0) {
                $hasta = $this->pagina * $this->registros_por_pagina;
            } else {
                $hasta = 0;
            }
            
            $this->db->sql ="select * from " . $this->tabla; // . " order by apellidoynombre ";
            $this->db->sql.= " where id_empresa=" . $this->id_empresa;
            $this->db->sql.= " limit " . $hasta . "," . $this->registros_por_pagina;
            
            // print "SQL: " . $this->db->sql . "<br>";
            
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
        
        $formulario->abrir("Listado de Clientes y Proveedores");
        
        $formulario->abrir_renglon();

        $formulario->tabla_open(920,array("Accion", "Tipo", "Razon Social","Direccion"));

        
       $icon = new icon();
       
       do {
              $formulario->tabla_line(array(
                    
                     "<a href='/editar_clienteproveedor/" . $this->db->campo("id_clienteproveedor") . "'>" . 
                     $icon->icono("editar",16) . " Editar" . "</a> " .
                     "<a href='/borrar_clienteproveedor/" . $this->db->campo("id_clienteproveedor") . "'>" . 
                     $icon->icono("borrar",16) . " Borrar" . "</a> ", 

                     $this->db->campo("tipo"),
                     $this->db->campo("razon_social"),                  
                     $this->db->campo("direccion")));
                            
        } while ($this->db->reg_siguiente());

        $formulario->tabla_close();        

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
                print "<a href='/clienteproveedor/" . ($pagina_activa - 1) . "' class='Prev'>&lt; Anterior</a>";    
            } else {
                print "<span class='AtStart'>&lt; Anterior</span>";
            }
            
            for ($i = $inicio; $i <= $final; $i++) {
                if ($pagina_activa<>$i) {
                    print "<a href='/clienteproveedor/" . $i . "'>" . $i . "</a>";
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
                print "<a href='/Clientes/" . ($pagina_activa + 1) . "' class='Next'>Siguiente &gt;</a>";
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
        $this->icono->agregar("agregar",16,"/clienteproveedor_agregar","Agregar nuevo cliente o proveedor");
        $this->icono->agregar("buscar",16,"/clienteproveedor_buscar","Buscar cliente o proveedor");
        $this->icono->agregar("subir",16,"/clienteproveedor","Clientes o proveedores");
        
        print "<br><br>";

   }

   public function que($id_clienteproveedor,$campo) {
          $this->db->sql="select * from " . $this->tabla . " where id_clienteproveedor=" . $id_clienteproveedor;
          $this->db->sql.= " and id_empresa=" . $this->id_empresa;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }

    
    
    public function buscar($sql_where) {    
          $this->db->sql ="select * from " . $this->tabla . $sql_where;
          $this->db->sql.= " and id_empresa=" . $this->id_empresa;
          // print "SQL: " . $this->db->sql . "<br>";
          if ($this->db->query_db()) {
            $this->cargar_registro();
            return true;
          } else {
              return false;
          }    
    }
    
        
/*    public function form_filtro_listado(){
            $formulario = new formulario();
            $formulario->abrir("Listado Maestro de Clientes",400,"nueva");
            $formulario->combo_box("Desde cliente","id_busqueda1","clientes","razon_social","id_cliente", $this->id_busqueda1);
            $formulario->combo_box(" Hasta cliente","id_busqueda2","clientes","razon_social","id_cliente", $this->id_busqueda2);
            $formulario->text_oculto("mostrar_menu",false);
            $formulario->cerrar("Listado Maestro de Clientes");
            $this->barra_menu();
 }


 public function mostrar_listado() {
            $this->tomar_post();
            $chofer = new chofer();

            $this->db->sql .= "select * from " . $this->tabla . " \n";
            $this->db->sql .= "order by razon_social";

            $this->db->query_db();
            $this->num=$this->db->reg_total;
            $reporte = new reporte("vertical","LISTADO MAESTRO DE CLIENTES","Desde: " . $chofer->que($this->id_busqueda1, "apellidoynombre") . "  Hasta: " . $chofer->que($this->id_busqueda2, "apellidoynombre"));
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
         
    
    
         
*/
} 

?>
