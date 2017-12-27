<?php

class asiento {

    public $id_asiento;
    public $id_clienteproveedor;
    public $id_empresa;
    public $id_cuenta;
    public $id_cuenta1;
    public $id_cuenta2;
    public $id_usuario;
    public $fecha;
    public $detalle;
    public $tipo_asiento;
    public $importe;
    public $estado;

    public $aplicar_contrapartida;
    public $id_cuenta_contrapartida;
    public $tipo_contra_asiento;
    public $fecha_hasta;
    
/*




id_asiento
id_clienteproveedor
id_cuenta
id_usuario
id_empresa
fecha
detalle
tipo_asiento
importe
estado

fecha_hasta

  
  
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
        $this->tabla = "asientos";
        $this->pagina = 0;
        $this->registros_por_pagina = 10;
        $this->paginas_botones=10;
        $this->id_usuario_activo = $this->usuario->usuario_activo("id_usuario");
        $this->id_empresa = $this->usuario->usuario_activo("id_empresa");
    }
    
    private function tomar_post() {
            $areas=explode("/",$_SERVER["REQUEST_URI"]);
            $vaccion=$areas[1];
            if ($vaccion=="editar_proveedor" or $vaccion=="borrar_proveedor") {
                $this->id_proveedor=$areas[2];
            }

            if ($vaccion=="proveedores") {
                $this->pagina=$areas[2];
                if ($this->pagina < 1) {
                    $this->pagina=0;
                }
            }
            
        if (isset($_REQUEST["id_asiento"])) {
            $this->id_asiento = $_REQUEST["id_asiento"]; }
        if (isset($_REQUEST["id_clienteproveedor"])) {
            $this->id_clienteproveedor = $_REQUEST["id_clienteproveedor"]; }
        if (isset($_REQUEST["id_cuenta"])) {
            $this->id_cuenta = $_REQUEST["id_cuenta"]; }
        if (isset($_REQUEST["id_cuenta1"])) {
            $this->id_cuenta1 = $_REQUEST["id_cuenta1"]; }
        
        if (isset($_REQUEST["id_cuenta2"])) {
            $this->id_cuenta2 = $_REQUEST["id_cuenta2"]; }
            
        if (isset($_REQUEST["id_usuario"])) {
            $this->id_usuario = $_REQUEST["id_usuario"]; }
        if (isset($_REQUEST["id_empresa"])) {
            $this->id_empresa = $_REQUEST["id_empresa"]; }

        if (isset($_REQUEST["fecha_anio"])) {
            $this->fecha=$_REQUEST["fecha_anio"]; }
        if (isset($_REQUEST["fecha_mes"])) {
            $this->fecha .= "/" . $_REQUEST["fecha_mes"]; }
        if (isset($_REQUEST["fecha_dia"])) {
            $this->fecha .= "/" . $_REQUEST["fecha_dia"]; }
            
            
        if (isset($_REQUEST["fecha_hasta_anio"])) {
            $this->fecha_hasta=$_REQUEST["fecha_hasta_anio"]; }
        if (isset($_REQUEST["fecha_hasta_mes"])) {
            $this->fecha_hasta .= "/" . $_REQUEST["fecha_hasta_mes"]; }
        if (isset($_REQUEST["fecha_hasta_dia"])) {
            $this->fecha_hasta .= "/" . $_REQUEST["fecha_hasta_dia"]; }
            
            
        if (isset($_REQUEST["detalle"])) {
            $this->detalle = $_REQUEST["detalle"]; }
        if (isset($_REQUEST["tipo_asiento"])) {
            $this->tipo_asiento = $_REQUEST["tipo_asiento"]; }
        if (isset($_REQUEST["importe"])) {
            $this->importe = $_REQUEST["importe"]; }
        if (isset($_REQUEST["estado"])) {
            $this->estado = $_REQUEST["estado"]; }

        if (isset($_REQUEST["aplicar_contrapartida"])) {
            $this->aplicar_contrapartida = $_REQUEST["aplicar_contrapartida"]; }
        if (isset($_REQUEST["id_cuenta_contrapartida"])) {
            $this->id_cuenta_contrapartida = $_REQUEST["id_cuenta_contrapartida"]; }
            
        if (isset($_REQUEST["tipo_contra_asiento"])) {
            $this->tipo_contra_asiento = $_REQUEST["tipo_contra_asiento"]; }
            
            
            if (isset($_REQUEST["texto_buscar"])) {
            $this->texto_buscar = $_REQUEST["texto_buscar"]; }                        
        if (isset($_REQUEST["buscar_por"])) {
            $this->buscar_por = $_REQUEST["buscar_por"]; }            
            
}


        public function cargar_registro(){
                $this->id_asiento = $this->db->campo("id_asiento");
                $this->id_clienteproveedor = $this->db->campo("id_clienteproveedor");
                $this->id_cuenta = $this->db->campo("id_cuenta");
                $this->id_usuario = $this->db->campo("id_usuario");
                $this->id_empresa = $this->db->campo("id_empresa");
                $this->fecha = $this->db->campo("fecha");
                $this->detalle = $this->db->campo("detalle");
                $this->tipo_asiento = $this->db->campo("tipo_asiento");
                $this->importe = $this->db->campo("importe");
                $this->estado = $this->db->campo("estado");
                                
        }

        public function limpiar_registro(){

                $this->id_asiento = 0;
                $this->id_clienteproveedor = 0;
                $this->id_cuenta = 0;
                $this->id_usuario = 0;
                $this->id_empresa = 0;
                $this->fecha = "";
                $this->detalle = "";
                $this->tipo_asiento = 0;
                $this->importe = 0;
                $this->estado = "";

            
        }

        public function form_agregar_asiento() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Asientos",920);
            
            
            print "<div id='principal'>
            <table width='920' border='0'>
              <tr align='left' valign='top'>
                <td colspan='2' rowspan='2'><div class='encabezado' id='encabezado'></div></td>
                <td width='32'>&nbsp;</td>
                <td colspan='2' rowspan='2'>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height='24' colspan='5'>
                    <div class='detalle_asiento'>Cuenta:<br>
                            <input id='cuenta_ajax' name='cuenta_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_cuenta1' id='id_cuenta1' value=''>
                        </div>
                        <br>
                    <div id='cuenta_detalle'></div>
                </td>
              </tr>
            </table>
            </div>
            ";
            $formulario->date_box("Fecha", "fecha", $this->fecha);
            $formulario->text_box("Detalle", "detalle", 75, 75, $this->detalle, "");
            $formulario->combo_opciones("Tipo de asiento","tipo_asiento",array("debito","credito"),$this->tipo_asiento);

            print "<div id='principal2'>
            <table width='920' border='0'>
              <tr>
                <td height='24' colspan='5'>
                    <div class='detalle_asiento2'>Cuenta:<br>
                            <input id='cuenta_ajax2' name='cuenta_ajax2' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_cuenta2' id='id_cuenta2' value=''>
                        </div>
                        <br>
                    <div id='cuenta_detalle2'></div>
                </td>
              </tr>
            </table>
            </div>
            ";
            $formulario->combo_opciones("Tipo de contra asiento","tipo_contra_asiento",array("debito","credito"),$this->tipo_contra_asiento);            
            $formulario->text_box("Importe", "importe", 15, 15, $this->importe, "");
            

            
            $formulario->boton("Guardar Asiento");
            
            $formulario->cerrar_formulario();
            print "
                <script type='text/javascript' language='JavaScript'>
                document.forms['form'].elements['cuenta'].focus();
                </script>                
            ";
  }



   public function agregar($id_cuenta1=0) {
          $this->tomar_post();
                   
          if ($this->id_cuenta1<=0){
                print "No se selecciono una cuenta.<br>";
                return;
          }
          if ($this->id_cuenta2<=0){
                print "No se selecciono una cuenta para el contra asiento.<br>";
                return;
          }

          if ($this->validacion()) {
             print "Datos ingresados incorrectamente<br>";
              return;
          }
                    
          $this->id_cuenta = $this->id_cuenta1;
          
          if ($id_cuenta1>0){
            $this->id_cuenta=$id_cuenta1;
          }
          if ($this->id_clienteproveedor==""){
            $this->id_clienteproveedor=0;
          }          
          // print "<br>id_cuenta1: " . $this->id_cuenta1 . "<br>";
          // print "id_cuenta: " . $this->id_cuenta . "<br>";
          
          $this->estado="activo";
          $this->id_usuario= $this->id_usuario_activo;
          
          if ($this->add()) {
                $this->box->mensaje="Se agrego correctamente el asiento";
                $this->box->show_ok();
          }

          $this->id_cuenta = $this->id_cuenta2;
          $this->tipo_asiento = $this->tipo_contra_asiento;
              
          if ($this->add()) {
                $this->box->mensaje="Se agrego correctamente el contra asiento";
                $this->box->show_ok();
          }

                  
          

          
  }

  
  
  
public function add() {
                    
          
          $this->estado="activo";
          $this->id_usuario= $this->id_usuario_activo;
          
          $this->armar_sql("nuevo");
          
          // print $this->db->sql . "<br>";
          
          if ($this->importe==0){
              // no se graban los asientos con importe 0
              return false;
          }
          
          
          $this->db->query_db();
          if ($this->db->insertado()) {
                return true;
          } else {
              return false;
          }

          
  }  
  
  
  
  
  public function validacion() {
          $devolucion=false;

          // para campos que no deben estar vacios al momento de grabar en la tabla
          
          if (!is_numeric($this->importe)){
                print "El importe no es valido.<br>";
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

            $this->db->sql .= "id_clienteproveedor=". $this->id_clienteproveedor . ", \n";
            $this->db->sql .= "id_cuenta=". $this->id_cuenta . ", \n";
            $this->db->sql .= "id_usuario=". $this->id_usuario . ", \n";
            $this->db->sql .= "id_empresa=". $this->id_empresa . ", \n";
            $this->db->sql .= "fecha='". $this->fecha . "', \n";
            $this->db->sql .= "detalle='". $this->detalle . "', \n";
            $this->db->sql .= "tipo_asiento='". $this->tipo_asiento . "', \n";
            $this->db->sql .= "importe=". $this->importe . ", \n";
            $this->db->sql .= "estado='". $this->estado . "' \n";
            
            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_asiento=" . $this->id_asiento . "\n";
            }
            
          }

          
          
          
   
          
  public function show_form_filtro_listado() {
            $formulario = new formulario();
            $formulario->abrir("Filtro para Listado",400);
            $formulario->combo_opciones("Por", "campo_indice", array("id_proveedor", "direccion"), $this->campo_indice);            
            $formulario->cerrar ("Listado ordenado de categoria socio");
            $this->barra_menu();
   }

          
   public function show_listado() {
        $this->tomar_post();
        $formulario = new formulario();
        $formulario->abrir("Proveedores");

        $formulario->encabezado("");
        $formulario->abrir_renglon();
       
            $this->tomar_post();
            
            if ($this->pagina > 0) {
                $hasta = $this->pagina * $this->registros_por_pagina;
            } else {
                $hasta = 0;
            }
            
            $this->db->sql="select * from " . $this->tabla; // . " order by apellidoynombre ";
            $this->db->sql.= " where id_usuario=" . $this->id_usuario_activo;
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
        
        $formulario->abrir("Listado de Categoria Socios");
        
        $formulario->abrir_renglon();

        $formulario->tabla_open(920,array("Accion", "Id","Proveedor","Direccion"));
       
       $icon = new icon();
       

       do {
              $formulario->tabla_line(array(
                    
                     "<a href='/editar_proveedor/" . $this->db->campo("id_proveedor") . "'>" . 
                     $icon->icono("editar",16) . " Editar" . "</a> " .
                     "<a href='/borrar_proveedor/" . $this->db->campo("id_proveedor") . "'>" . 
                     $icon->icono("borrar",16) . " Borrar" . "</a> ", 

                     $this->db->campo("id_proveedor"),
                     $this->db->campo("proveedor"),                              
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
        $this->icono->agregar("agregar",16,"/proveedor_agregar","Agregar nuevo proveedor");
        $this->icono->agregar("buscar",16,"/proveedor_buscar","Buscar proveedores");
        $this->icono->agregar("subir",16,"/proveedores","Proveedores");
        // $this->icono->agregar("volver",16,"/admin","Adminitraci�n");
        
        print "<br><br>";

   }

   public function que($id_asiento ,$campo) {
          $this->db->sql="select * from " . $this->tabla . " where id_asiento=" . $id_asiento;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }

    public function buscar($id_asiento) {    
          $this->db->sql="select * from " . $this->tabla . " where id_proveedor=" . $id_proveedor;
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
         

         
public function form_asientos_entre_fechas() {         
            $formulario = new formulario();
            $formulario->abrir("Listado de asientos entre fechas",400,"misma");
            $formulario->date_box("Fecha desde", "fecha", "");
            $formulario->date_box("Fecha hasta", "fecha_hasta", "");            
            // $formulario->text_oculto("mostrar_menu",false);
            $formulario->cerrar("Mostrar asientos entre fechas");
            $this->barra_menu();    
}
         
    


public function asientos_entre_fechas() {         

        $this->tomar_post();
        $aritmetica = new aritmetica();
        
        $this->db->sql = "select sum(importe) as importe from asientos \n";
        $this->db->sql.= "where id_empresa=" . $this->id_usuario_activo . " \n";
        $this->db->sql.= "and fecha<'" . $this->fecha . "' \n";
        $this->db->sql.= "and tipo_asiento='credito' \n";
        
        if (!$this->db->query_db()) {
            $total_credito=0;
        } else {
            $total_credito+=$this->db->campo("importe");
        }
        
        $this->db->sql = "select sum(importe) as importe from asientos \n";
        $this->db->sql.= "where id_empresa=" . $this->id_empresa . " \n";
        $this->db->sql.= "and fecha<'" . $this->fecha . "' \n";
        $this->db->sql.= "and tipo_asiento='debito' \n";
        
        if (!$this->db->query_db()) {
            $total_debito=0;
        } else {
            $total_debito+=$this->db->campo("importe");
        }
        
        $total_saldo = $total_debito - $total_credito;
        
        $this->db->sql = "select * from asientos \n";
        $this->db->sql.= "where id_empresa=" . $this->id_empresa . " \n";
        $this->db->sql.= "and fecha>='" . $this->fecha . "' \n";
        $this->db->sql.= "and fecha<='" . $this->fecha_hasta . "' \n";
        
        // print "SQL: " . $this->db->sql . "<br>";
        
        if (!$this->db->query_db()) {
            print "No se encontraron asientos en esta fecha.";
            die;
        }
               
        $cuenta = new cuenta();
        $formulario = new formulario();
        
        $sub_total_credito=0;
        $sub_total_debito=0;
        
        $formulario->abrir("Listado de asientos entre fechas");
        $formulario->abrir_renglon();
        $formulario->tabla_open(920,array("Fecha", "Cuenta", "Detalle","Debito", "Credito","Saldo"));

        $formulario->tabla_line(array(
            "",
            "",
            "",
            "<div align='right'>" . $aritmetica->formato_numero($total_credito,2) . "</div>",
            "<div align='right'>" . $aritmetica->formato_numero($total_debito,2) . "</div>",
            "<div align='right'>" . $aritmetica->formato_numero($total_saldo,2) . "</div>"));        
        
        
        $saldo=0;
        
        $sub_total_credito = 0;
        $sub_total_debito = 0;
        
        do {
                $debito=0;
                $credito=0;                
                if ($this->db->campo("tipo_asiento")=="debito"){
                    $debito=$this->db->campo("importe");
                    $saldo+=$debito;
                } else {
                    $credito=$this->db->campo("importe");
                    $saldo-=$credito;
                }

                $sub_total_credito += $credito;
                $sub_total_debito += $debito;

                $formulario->tabla_line(array(
                    $this->db->campo("fecha"),
                    $cuenta->que($this->db->campo("id_cuenta"),"cuenta"),
                    $this->db->campo("detalle"),
                    "<div align='right'>" . $aritmetica->formato_numero($debito,2) . "</div>",
                    "<div align='right'>" . $aritmetica->formato_numero($credito,2) . "</div>",
                    "<div align='right'></div>"));
                
        } while ($this->db->reg_siguiente());
        
        $sub_total_saldo=$total_saldo + $sub_total_debito - $sub_total_credito;
        
        $formulario->tabla_line(array(
                    "",
                    "",
                    "<div align='right'>SubTotales</div>",
                    "<div align='right'>" . $aritmetica->formato_numero($sub_total_debito,2) . "</div>",
                    "<div align='right'>" . $aritmetica->formato_numero($sub_total_credito,2) . "</div>",
                    "<div align='right'>" . $aritmetica->formato_numero($sub_total_saldo,2) . "</div>"));
                
        $formulario->tabla_close();        
        $formulario->cerrar_renglon();
        $formulario->cerrar_formulario();
}





















}

?>
