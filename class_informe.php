<?php

class informe {

    public $fecha;
    public $fecha_hasta;

    public $id_cuenta1;
    
    public $icono;    
    public $config;

    public $usuario;    

    function __construct() {
        $this->box = new mensaje();
        $this->db = new db();             
        $this->icono = new icon();
        $this->config = new configuracion();
        $this->usuario = new usuario();
        $this->id_usuario_activo = $this->usuario->usuario_activo("id_usuario");
        $this->id_empresa = $this->usuario->usuario_activo("id_empresa");                
        
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
            
        if (isset($_REQUEST["id_clienteproveedor"])) {
            $this->id_clienteproveedor=$_REQUEST["id_clienteproveedor"]; }
                        
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
            

        if (isset($_REQUEST["id_cuenta1"])) {
            $this->id_cuenta1 .= $_REQUEST["id_cuenta1"]; }
            
            
}


        public function informe_ventas_form() {
            $this->tomar_post();
            $formulario = new formulario();            
            $formulario->abrir("Informe Ventas",400,"nueva");
            $formulario->date_box("Desde Fecha", "fecha", "");
            $formulario->date_box("Hasta Fecha", "fecha_hasta", "");
            $formulario->text_oculto("mostrar_menu",false);            
            $formulario->cerrar("Ver informe ventas");
            
  }
  

   public function informe_ventas() {

            $this->tomar_post();
            
            // entre esa fecha todos los movimientos debito de todos los proveedores
            
            $clienteproveedor = new clienteproveedor();
            $aritmetica = new aritmetica();

            $id_cuenta_perdidas = $this->config->que_configuracion($this->id_empresa . "_cuenta_deudoresporventa", "numero");
            
            $db2= new db();
            
            $db2->sql  = "select * from cuentas \n";
            $db2->sql .= "where id_cuenta_padre=" . $id_cuenta_perdidas . " \n";
            $db2->sql .= "order by cuenta";

            if (!$db2->query_db()) {
                print "No se encontraron cuentas Perdidas<br>";
                die;
            }
            
            $reporte = new reporte("vertical","INFORME VENTAS","Desde: " . $this->fecha . "  Hasta: " . $this->fecha_hasta);
            $reporte->col_xPos = array ( 1,5,7.5,9,11);
            $reporte->col_tamanos = array ( 7,7,10,5,5);

            $reporte->col_nombres_columnas = array ("Cliente Proveedor","Fecha", "Detalle", "", "Importe");
            $reporte->col_alineacion = array("left", "left", "left","right","right");
            $reporte->inicializar();

            $credito=0;
            $debito=0;

            $debitos_total=0;
            
            
            do {
                
                    $this->db->sql  = "select * from asientos \n";
                    $this->db->sql .= "where fecha>='" . $this->fecha . "' \n";
                    $this->db->sql .= "and fecha<='" . $this->fecha_hasta . "' \n";
                    $this->db->sql .= "and id_cuenta=" . $db2->campo("id_cuenta") . " \n";            
                    $this->db->sql .= "and tipo_asiento='debito' \n";
                    $this->db->sql .= "and estado='activo' \n";
                    $this->db->sql .= "order by fecha";

                    if ($this->db->query_db()) {

                        do {

                            $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                            $debitos_total += $debito;                    
                            $credito="";

                            $reporte->renglon = array (
                                                        $clienteproveedor->que($this->db->campo("id_clienteproveedor"),"razon_social"),
                                                        $this->db->campo("fecha"),
                                                        $this->db->campo("detalle"),
                                                        $credito,
                                                        $debito
                                                        );
                            $reporte->imprimir_renglon();

                        } while ($this->db->reg_siguiente());

                        }
            } while ($db2->reg_siguiente());                    
            
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","",
                "TOTAL $",
                $aritmetica->formato_numero($debitos_total, 2)
                );
            $reporte->imprimir_renglon();
            $reporte->mostrar();


       
            
            
  }


  
  
  
  
  
  
  
  
  
        public function informe_gastos_form() {
            $this->tomar_post();
            $formulario = new formulario();            
            $formulario->abrir("Informe Gastos",400,"nueva");
            $formulario->date_box("Desde Fecha", "fecha", "");
            $formulario->date_box("Hasta Fecha", "fecha_hasta", "");
            $formulario->text_oculto("mostrar_menu",false);            
            $formulario->cerrar("Ver informe gastos");
            
  }
  

   public function informe_gastos() {
            $this->tomar_post();
            
            // entre esa fecha todos los movimientos debito de todos los proveedores
            
            $clienteproveedor = new clienteproveedor();
            $aritmetica = new aritmetica();

            $id_cuenta_perdidas = $this->config->que_configuracion($this->id_empresa . "_cuenta_proveedores", "numero");
            
            $db2= new db();
            
            $db2->sql  = "select * from cuentas \n";
            $db2->sql .= "where id_cuenta_padre=" . $id_cuenta_perdidas . " \n";
            $db2->sql .= "order by cuenta";

            if (!$db2->query_db()) {
                print "No se encontraron cuentas Perdidas<br>";
                die;
            }
            
            $reporte = new reporte("vertical","INFORME GASTOS","Desde: " . $this->fecha . "  Hasta: " . $this->fecha_hasta);
            $reporte->col_xPos = array ( 1,5,7.5,9,11);
            $reporte->col_tamanos = array ( 7,7,10,5,5);

            $reporte->col_nombres_columnas = array ("Cliente Proveedor","Fecha", "Detalle", "", "Importe");
            $reporte->col_alineacion = array("left", "left", "left","right","right");
            $reporte->inicializar();

            $credito=0;
            $debito=0;

            $creditos_total=0;
            $debitos_total=0;
            
            
            do {
                
                    $this->db->sql  = "select * from asientos \n";
                    $this->db->sql .= "where fecha>='" . $this->fecha . "' \n";
                    $this->db->sql .= "and fecha<='" . $this->fecha_hasta . "' \n";
                    $this->db->sql .= "and id_cuenta=" . $db2->campo("id_cuenta") . " \n";            
                    $this->db->sql .= "and estado='activo' \n";
                    $this->db->sql .= "order by fecha";

                    if ($this->db->query_db()) {

                        do {

                            if($this->db->campo("tipo_asiento")=="credito"){
                                $credito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                                $creditos_total += $credito;
                                $debito="";
                            } else {
                                $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                                $debitos_total += $debito;                    
                                $credito="";
                            }

                            $reporte->renglon = array (
                                                        $clienteproveedor->que($this->db->campo("id_clienteproveedor"),"razon_social"),
                                                        $this->db->campo("fecha"),
                                                        $this->db->campo("detalle"),
                                                        $debito,
                                                        $credito
                                                        );
                            $reporte->imprimir_renglon();

                        } while ($this->db->reg_siguiente());

                        }
            } while ($db2->reg_siguiente());                    
            
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","",
                "TOTAL $",
                $aritmetica->formato_numero($creditos_total, 2)
                );
            $reporte->imprimir_renglon();
            $reporte->mostrar();


            
            
  }
  
  
  
  
  
  

        public function informe_mayor_form() {
            $this->tomar_post();
            $formulario = new formulario();            
            $formulario->abrir("Informe Mayor",400,"nueva");
            
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
            
            
            $formulario->date_box("Desde Fecha", "fecha", "");
            $formulario->date_box("Hasta Fecha", "fecha_hasta", "");
            $formulario->text_oculto("mostrar_menu",false);            
            $formulario->cerrar("Ver informe mayor");
            
  }
  

   public function informe_mayor() {
            $this->tomar_post();
            $clienteproveedor = new clienteproveedor();
            $aritmetica = new aritmetica();
            $cuenta = new cuenta();
            
            $reporte = new reporte("vertical","INFORME MAYOR",
                                   "Desde: " . $this->fecha . "  Hasta: " . $this->fecha_hasta,
                                   "Cuenta: " . $cuenta->que($this->id_cuenta1, "cuenta"));
            $reporte->col_xPos = array ( 1,5,7.5,9,11);
            $reporte->col_tamanos = array ( 7,7,10,5,5);
            
            $reporte->col_nombres_columnas = array ("Cliente Proveedor","Fecha", "Detalle", "Credito", "Debito");
            $reporte->col_alineacion = array("left", "left", "left","right","right");
            $reporte->inicializar();

            
            $credito="0.00";
            $debito="0.00";            
            
            $creditos_total =0;
            $debitos_total =0;
            

            $this->db->sql  = "select sum(importe) as importe from asientos \n";
            $this->db->sql .= "where fecha<'" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $this->id_cuenta1 . " \n";            
            $this->db->sql .= "and tipo_asiento='credito' \n";
            $this->db->sql .= "and estado='activo' \n";
            $this->db->sql .= "order by fecha";            
            
            // print "SQL: " . $this->db->sql . "<br>";
            
            
            if ($this->db->query_db()){
                $credito=$aritmetica->formato_numero($this->db->campo("importe"),2);
            }
            
            $this->db->sql  = "select sum(importe) as importe from asientos \n";
            $this->db->sql .= "where fecha<'" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $this->id_cuenta1 . " \n";            
            $this->db->sql .= "and tipo_asiento='debito' \n";
            $this->db->sql .= "and estado='activo' \n";
            $this->db->sql .= "order by fecha";            
            
            // print "SQL: " . $this->db->sql . "<br>";
            // Die;
            
            if ($this->db->query_db()){
                $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
            }
            

            $reporte->renglon = array (
                                        "",
                                        "",
                                        "Saldo Anterior",
                                        $credito,
                                        $debito
                                        );
            $reporte->imprimir_renglon();
            
            
            
            $this->db->sql  = "select * from asientos \n";
            $this->db->sql .= "where fecha>='" . $this->fecha . "' \n";
            $this->db->sql .= "and fecha<='" . $this->fecha_hasta . "' \n";
            $this->db->sql .= "and id_cuenta=" . $this->id_cuenta1 . " \n";            
            $this->db->sql .= "and estado='activo' \n";
            $this->db->sql .= "order by fecha";
            
            // print "SQL: " . $this->db->sql . "<br>";

            if (!$this->db->query_db()){
                Print "No se encontraron movimientos en esa cuenta.<br>";
                exit;
            }
            
            // $credito=0;
            // $debito=0;

            $creditos_total +=$credito;
            $debitos_total +=$debito;
            
            
            do {
            
                if($this->db->campo("tipo_asiento")=="credito"){
                    $credito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    $creditos_total += $credito;
                    $debito="";
                } else {
                    $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    $debitos_total += $debito;                    
                    $credito="";
                }
                
                $reporte->renglon = array (
                                            $clienteproveedor->que($this->db->campo("id_clienteproveedor"),"razon_social"),
                                            $this->db->campo("fecha"),
                                            $this->db->campo("detalle"),
                                            $credito,
                                            $debito
                                            );
                $reporte->imprimir_renglon();
                
            } while ($this->db->reg_siguiente());
            
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","",
                $aritmetica->formato_numero($creditos_total, 2),
                $aritmetica->formato_numero($debitos_total, 2)
                );
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();

            $saldo=$aritmetica->formato_numero($creditos_total, 2) - $aritmetica->formato_numero($debitos_total, 2);

            $reporte->renglon = array ("","","",
                "SALDO $",
                $aritmetica->formato_numero($saldo, 2)
                );
            $reporte->imprimir_renglon();
            
            $reporte->mostrar();


            
            
  }


  
        public function informe_saldosporclientes_form() {
            $this->tomar_post();
            $formulario = new formulario();            
            $formulario->abrir("Informe Clientes",400,"nueva");
            
            // resumen de cobranzas - una linea un cliente un saldo
            // si el cliente no tiene deuda no aparece
            // un total general
            
            $formulario->text_oculto("mostrar_menu",false);            
            $formulario->cerrar("Ver saldos por clientes");
            
  }
  

  
  
  
  
  

   public function informe_saldosporclientes() {


            $this->tomar_post();
            $aritmetica = new aritmetica();

            $db = new db();
            
            $reporte = new reporte("vertical","Saldos por clientes",
                                   "",
                                   "");
            $reporte->col_xPos = array ( 1,9);
            $reporte->col_tamanos = array (10,5);
            
            $reporte->col_nombres_columnas = array ("Cliente", "Saldo");
            $reporte->col_alineacion = array("left", "right");
            $reporte->inicializar();

            $db->sql  = "select * from clientesproveedores \n";
            $db->sql .= "where tipo='cliente' \n";
            $db->sql .= "and estado='activo' \n";
            $db->sql .= "and id_empresa=" . $this->id_empresa . " \n";                        
            $db->sql .= "order by razon_social";            
            
            
            if(!$db->query_db()) {
                print "No hay clientes activos.";
                Die;
            }
            
            
            $saldo_total=0;
                    
            do {

                    $credito=0;
                    $debito=0;
                
                    $this->db->sql  = "select sum(importe) as importe from asientos \n";
                    $this->db->sql .= "where tipo_asiento='credito' \n";
                    $this->db->sql .= "and id_cuenta=" . $db->campo("id_cuenta"). " \n";
                    $this->db->sql .= "and estado='activo' \n";
                    $this->db->sql .= "order by fecha";            

                    // print "SQL: " . $this->db->sql . "<br>";


                    if ($this->db->query_db()){
                        $credito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    }

                    $this->db->sql  = "select sum(importe) as importe from asientos \n";
                    $this->db->sql .= "where tipo_asiento='debito' \n";
                    $this->db->sql .= "and id_cuenta=" . $db->campo("id_cuenta"). " \n";                    
                    $this->db->sql .= "and estado='activo' \n";
                    $this->db->sql .= "order by fecha";            

                    // print "SQL: " . $this->db->sql . "<br>";
                    // Die;

                    if ($this->db->query_db()){
                        $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    }

                    $saldo=$debito-$credito;
                    
                    if($saldo>0) {
                        $reporte->renglon = array (
                                                    $db->campo("razon_social"),
                                                    $aritmetica->formato_numero($saldo,2) );
                        $reporte->imprimir_renglon();
                        $saldo_total+=$saldo;
                    }
                
                
            } while ($db->reg_siguiente());
            



            
            $reporte->renglon = array ("","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("",
                $aritmetica->formato_numero($saldo_total, 2)
                );
            $reporte->imprimir_renglon();
            $reporte->mostrar();
            
            
  }

  
  
  
  
  
  
  
    public function informe_saldoporproveedores_form() {
            $this->tomar_post();
            $formulario = new formulario();            
            $formulario->abrir("Informe Proveedores",400,"nueva");
            
            // resumen de cobranzas - una linea un cliente un saldo
            // si el cliente no tiene deuda no aparece
            // un total general
            
            $formulario->text_oculto("mostrar_menu",false);            
            $formulario->cerrar("Ver saldos por proveedores");
            
    }
  

  
  
  
  
  

   public function informe_saldoporproveedores() {


            $this->tomar_post();
            $aritmetica = new aritmetica();

            $db = new db();
            
            $reporte = new reporte("vertical","Saldos por proveedores",
                                   "",
                                   "");
            $reporte->col_xPos = array ( 1,9);
            $reporte->col_tamanos = array (10,5);
            
            $reporte->col_nombres_columnas = array ("Cliente", "Saldo");
            $reporte->col_alineacion = array("left", "right");
            $reporte->inicializar();

            $db->sql  = "select * from clientesproveedores \n";
            $db->sql .= "where tipo='proveedor' \n";
            $db->sql .= "and estado='activo' \n";
            $db->sql .= "and id_empresa=" . $this->id_empresa . " \n";                        
            $db->sql .= "order by razon_social";            
            
            
            if(!$db->query_db()) {
                print "No hay clientes activos.";
                Die;
            }
            
            
            $saldo_total=0;
                    
            do {

                    $credito=0;
                    $debito=0;
                
                    $this->db->sql  = "select sum(importe) as importe from asientos \n";
                    $this->db->sql .= "where tipo_asiento='credito' \n";
                    $this->db->sql .= "and id_cuenta=" . $db->campo("id_cuenta"). " \n";
                    $this->db->sql .= "and estado='activo' \n";
                    $this->db->sql .= "order by fecha";            

                    // print "SQL: " . $this->db->sql . "<br>";


                    if ($this->db->query_db()){
                        $credito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    }

                    $this->db->sql  = "select sum(importe) as importe from asientos \n";
                    $this->db->sql .= "where tipo_asiento='debito' \n";
                    $this->db->sql .= "and id_cuenta=" . $db->campo("id_cuenta"). " \n";                    
                    $this->db->sql .= "and estado='activo' \n";
                    $this->db->sql .= "order by fecha";            

                    // print "SQL: " . $this->db->sql . "<br>";
                    // Die;

                    if ($this->db->query_db()){
                        $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    }

                    $saldo=$debito-$credito;
                    
                    if($saldo>0) {
                        $reporte->renglon = array (
                                                    $db->campo("razon_social"),
                                                    $aritmetica->formato_numero($saldo,2) );
                        $reporte->imprimir_renglon();
                        $saldo_total+=$saldo;
                    }
                
                
            } while ($db->reg_siguiente());
            
            
            $reporte->renglon = array ("","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("",
                $aritmetica->formato_numero($saldo_total, 2)
                );
            $reporte->imprimir_renglon();
            $reporte->mostrar();
            
            
  }

  


  
  
  
  
  public function informe_rendicion_form() {
            $this->tomar_post();
            $formulario = new formulario();            
            $formulario->abrir("Rendicion Diaria",400,"nueva");            
            $formulario->date_box("Desde Fecha", "fecha", "");
            $formulario->text_oculto("mostrar_menu",false);            
            $formulario->cerrar("Ver rendicion diaria");
            
  }
  

  
  
  
  
  

   public function informe_rendicion() {

            $this->tomar_post();
            
            // entre esa fecha todos los movimientos debito de todos los proveedores
            
            $clienteproveedor = new clienteproveedor();
            $aritmetica = new aritmetica();
            
            $reporte = new reporte("vertical","REPORTE DIARIO","De: " . $this->fecha);
            $reporte->col_xPos = array ( 1,5,7.5,9,11);
            $reporte->col_tamanos = array ( 7,7,10,5,5);

            $reporte->col_nombres_columnas = array ("","", "", "", "");
            $reporte->col_alineacion = array("left", "left", "left","right","right");
            $reporte->inicializar();

            
            // CUENTA CAJA
            
            
            $reporte->renglon = array ("INGRESOS DE CAJA","", "", "", "");
            $reporte->imprimir_renglon();                            
            $reporte->renglon = array ("Cliente Proveedor","Fecha", "Detalle", "", "Importe");
            $reporte->imprimir_renglon();

            $id_cuenta_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            $credito=0;
            $caja_total=0;
            
            $this->db->sql  = "select * from asientos \n";
            $this->db->sql .= "where fecha='" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $id_cuenta_caja . " \n";            
            $this->db->sql .= "and tipo_asiento='credito' \n";
            $this->db->sql .= "and estado='activo' \n";
            $this->db->sql .= "order by fecha";

            if ($this->db->query_db()) {

                do {
                    $credito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    $caja_total += $credito;                    
                    $debito="";

                    $reporte->renglon = array (
                            $clienteproveedor->que($this->db->campo("id_clienteproveedor"),"razon_social"),
                            $this->db->campo("fecha"),
                            $this->db->campo("detalle"),
                            $debito,
                            $credito
                    );
                    $reporte->imprimir_renglon();
                } while ($this->db->reg_siguiente());
            }
            
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","",
                                        "TOTAL INGRESOS CAJA $",
                                        $aritmetica->formato_numero($caja_total, 2)
                                        );
            $reporte->imprimir_renglon();            
            
            // CUENTA CORRIENTES
            
            $reporte->renglon = array ("CUENTA CORRIENTES","", "", "", "");
            $reporte->imprimir_renglon();                            
            $reporte->renglon = array ("Cliente Proveedor","Fecha", "Detalle", "", "Importe");
            $reporte->imprimir_renglon();

            $id_cuenta_ctacte = $this->config->que_configuracion($this->id_empresa . "_cuenta_ctacte", "numero");
            $ctacte_total=0;
            
            $this->db->sql  = "select * from asientos \n";
            $this->db->sql .= "where fecha='" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $id_cuenta_ctacte . " \n";            
            $this->db->sql .= "and tipo_asiento='debito' \n";
            $this->db->sql .= "and estado='activo' \n";
            $this->db->sql .= "order by fecha";

            if ($this->db->query_db()) {

                do {
                    $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    $ctacte_total += $debito;                    
                    $credito="";

                    $reporte->renglon = array (
                            $clienteproveedor->que($this->db->campo("id_clienteproveedor"),"razon_social"),
                            $this->db->campo("fecha"),
                            $this->db->campo("detalle"),
                            $credito,
                            $debito
                    );
                    $reporte->imprimir_renglon();
                } while ($this->db->reg_siguiente());
            }
            
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","",
                                        "TOTAL CTA CTE $",
                                        $aritmetica->formato_numero($ctacte_total, 2)
                                        );
            $reporte->imprimir_renglon();            
            
            
            
            // GASTOS PROVEEDORES
            
            $reporte->renglon = array ("GASTOS","", "", "", "");
            $reporte->imprimir_renglon();                            
            $reporte->renglon = array ("Cliente Proveedor","Fecha", "Detalle", "", "Importe");
            $reporte->imprimir_renglon();

            $id_cuenta_proveedores = $this->config->que_configuracion($this->id_empresa . "_cuenta_proveedores", "numero");
            $gastos_total=0;
            
            $this->db->sql  = "select * from asientos \n";
            $this->db->sql .= "where fecha='" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $id_cuenta_proveedores . " \n";            
            $this->db->sql .= "and tipo_asiento='debito' \n";
            $this->db->sql .= "and estado='activo' \n";
            $this->db->sql .= "order by fecha";

            if ($this->db->query_db()) {

                do {
                    $debito=$aritmetica->formato_numero($this->db->campo("importe"),2);
                    $gastos_total += $debito;                    
                    $credito="";

                    $reporte->renglon = array (
                            $clienteproveedor->que($this->db->campo("id_clienteproveedor"),"razon_social"),
                            $this->db->campo("fecha"),
                            $this->db->campo("detalle"),
                            $credito,
                            $debito
                    );
                    $reporte->imprimir_renglon();
                } while ($this->db->reg_siguiente());
            }
            
            $reporte->renglon = array ("","","","","");
            $reporte->imprimir_renglon();
            $reporte->imprimir_renglon();
            $reporte->renglon = array ("","","",
                                        "TOTAL GASTOS $",
                                        $aritmetica->formato_numero($gastos_total, 2)
                                        );
            $reporte->imprimir_renglon();            

            $reporte->renglon = array ("","","",
                                        "",
                                        ""
                                        );
            $reporte->imprimir_renglon();            
            $reporte->imprimir_renglon();

            
            
            $caja_anterior=0;
            $gastos_anterior=0;
            
            $this->db->sql  = "select sum(importe) as importe from asientos \n";
            $this->db->sql .= "where fecha<'" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $id_cuenta_caja . " \n";            
            $this->db->sql .= "and tipo_asiento='credito' \n";
            $this->db->sql .= "and estado='activo' \n";

            if ($this->db->query_db()) {
                $caja_anterior = $this->db->campo("importe");
            }
            
            $this->db->sql  = "select sum(importe) as importe from asientos \n";
            $this->db->sql .= "where fecha<'" . $this->fecha . "' \n";
            $this->db->sql .= "and id_cuenta=" . $id_cuenta_proveedores . " \n";            
            $this->db->sql .= "and tipo_asiento='debito' \n";
            $this->db->sql .= "and estado='activo' \n";

            if ($this->db->query_db()) {
                $gastos_anterior = $this->db->campo("importe");
            }
            
            $saldo_anterior = $caja_anterior - $gastos_anterior;
            
            $reporte->renglon = array ("","","",
                                        "SALDO ANTERIOR $",
                                        $aritmetica->formato_numero($saldo_anterior, 2)
                                        );
            $reporte->imprimir_renglon();            
            
            $reporte->renglon = array ("","","",
                                        "ENTRADA $",
                                        $aritmetica->formato_numero($caja_total, 2)
                                        );
            $reporte->imprimir_renglon();            
            
            
            $reporte->renglon = array ("","","",
                                        "GASTOS $",
                                        $aritmetica->formato_numero($gastos_total, 2)
                                        );
            $reporte->imprimir_renglon();            
            
            $total_caja_general=$saldo_anterior + $caja_total - $gastos_total;
            
            $reporte->renglon = array ("","","",
                                        "TOTAL CAJA $",
                                        $aritmetica->formato_numero($total_caja_general, 2)
                                        );
            $reporte->imprimir_renglon();            
            
            
            
            
            
            
            
            
            $reporte->mostrar();
            
            
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
}
?>
