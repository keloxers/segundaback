<?php

class movimiento {

    public $id_clienteproveedor;
    public $id_clienteproveedor1;
    public $id_cuenta1;
    public $id_cuenta;
    public $fecha;
    public $fecha_pago;
    public $nro_comprobante;
    public $detalle;
    public $forma_pago;
    public $importe;
            
            
    public $tipo;
            
    public $imp_quiniela;
    public $imp_qe;
    public $imp_loto;
    public $imp_q6;
    public $imp_brinco;
    public $imp_loto5;
    public $imp_loteria;
    public $imp_maradona;
    public $imp_telekino;
    
    public $cobrar_maquina;
    
    public $icono;    
    
    public $config;
    public $id_usuario_activo;
    public $id_empresa;



    /*

    id_clienteproveedor
    fecha
    nro_comprobante
    detalle
    forma_pago
    importe


*/


    
    public $texto_buscar;
    public $buscar_por;
    public $pagina;
    public $registros_por_pagina;
    public $paginas_botones;
    
    public $tabla;
    public $usuario;    
    public $clienteproveedor;    

    function __construct() {
        $this->box = new mensaje();
        $this->db = new db();             
        $this->icono = new icon();
        $this->config = new configuracion();
        $this->clienteproveedor = new clienteproveedor();
        $this->tabla = "choferes";
        $this->pagina = 0;
        $this->registros_por_pagina = 10;
        $this->paginas_botones=10;
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
            
        if (isset($_REQUEST["id_clienteproveedor1"])) {
            $this->id_clienteproveedor1=$_REQUEST["id_clienteproveedor1"]; }

        if (isset($_REQUEST["id_cuenta1"])) {
            $this->id_cuenta1=$_REQUEST["id_cuenta1"]; }
        if (isset($_REQUEST["id_cuenta"])) {
            $this->id_cuenta=$_REQUEST["id_cuenta"]; }
            
        if (isset($_REQUEST["fecha_anio"])) {
            $this->fecha=$_REQUEST["fecha_anio"]; }
        if (isset($_REQUEST["fecha_mes"])) {
            $this->fecha .= "/" . $_REQUEST["fecha_mes"]; }
        if (isset($_REQUEST["fecha_dia"])) {
            $this->fecha .= "/" . $_REQUEST["fecha_dia"]; }

        if (isset($_REQUEST["fecha_pago_anio"])) {
            $this->fecha_pago=$_REQUEST["fecha_pago_anio"]; }
        if (isset($_REQUEST["fecha_pago_mes"])) {
            $this->fecha_pago .= "/" . $_REQUEST["fecha_pago_mes"]; }
        if (isset($_REQUEST["fecha_pago_dia"])) {
            $this->fecha_pago .= "/" . $_REQUEST["fecha_pago_dia"]; }
            
            
        if (isset($_REQUEST["nro_comprobante"])) {
            $this->nro_comprobante=$_REQUEST["nro_comprobante"]; }
        if (isset($_REQUEST["detalle"])) {
            $this->detalle=$_REQUEST["detalle"]; }
        if (isset($_REQUEST["forma_pago"])) {
            $this->forma_pago=$_REQUEST["forma_pago"]; }
        if (isset($_REQUEST["importe"])) {
            $this->importe=$_REQUEST["importe"]; }


        if (isset($_REQUEST["tipo"])) {
            $this->tipo=$_REQUEST["tipo"]; }
        if (isset($_REQUEST["cobrar_maquina"])) {
            $this->cobrar_maquina=$_REQUEST["cobrar_maquina"]; }            
        if (isset($_REQUEST["imp_quiniela"])) {
            $this->imp_quiniela=$_REQUEST["imp_quiniela"]; }
        if (isset($_REQUEST["imp_qe"])) {
            $this->imp_qe =$_REQUEST["imp_qe"]; }
        if (isset($_REQUEST["imp_loto"])) {
            $this->imp_loto =$_REQUEST["imp_loto"]; }
        if (isset($_REQUEST["imp_q6"])) {
            $this->imp_q6 =$_REQUEST["imp_q6"]; }
        if (isset($_REQUEST["imp_brinco"])) {
            $this->imp_brinco =$_REQUEST["imp_brinco"]; }
        if (isset($_REQUEST["imp_loto5"])) {
            $this->imp_loto5 =$_REQUEST["imp_loto5"]; }
        if (isset($_REQUEST["imp_loteria"])) {
            $this->imp_loteria =$_REQUEST["imp_loteria"]; }
        if (isset($_REQUEST["imp_maradona"])) {
            $this->imp_maradona =$_REQUEST["imp_maradona"]; }
        if (isset($_REQUEST["imp_telekino"])) {
            $this->imp_telekino =$_REQUEST["imp_telekino"]; }
            
            
            
        if (isset($_REQUEST["total_pagar"])) {
            $this->total_pagar=$_REQUEST["total_pagar"]; }            
            
        if (isset($_REQUEST["importe_premios"])) {
            $this->importe_premios=$_REQUEST["importe_premios"]; }
        if (isset($_REQUEST["importe_efectivo"])) {
            $this->importe_efectivo=$_REQUEST["importe_efectivo"]; }
        if (isset($_REQUEST["importe_gastos"])) {
            $this->importe_gastos=$_REQUEST["importe_gastos"]; }
        if (isset($_REQUEST["importe_ctacte"])) {
            $this->importe_ctacte=$_REQUEST["importe_ctacte"]; }

        if (isset($_REQUEST["diferencia"])) {
            $this->diferencia=$_REQUEST["diferencia"]; }


            
}



        public function movimientos_ventas_agregar_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Agregar Ventas");
            
            // $this->limpiar_registro();

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
                    <div class='detalle_clienteproveedor'>Cliente:<br>
                            <input id='clienteproveedor_ajax' name='clienteproveedor_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_clienteproveedor1' id='id_clienteproveedor1' value=''>
                        </div>
                        <br>
                    <div id='clienteproveedor_detalle'></div>
                </td>
              </tr>
            </table>
            </div>
            ";

            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Nro Comprobante","nro_comprobante",20,20,$this->nro_comprobante,"");
            $formulario->text_box("Detalle","detalle",75,255,$this->detalle,"");
            $formulario->combo_opciones("Forma Pago","forma_pago",array("Contado","Cuenta Cte"),$this->forma_pago);
            $formulario->text_box("Importe","importe",20,20,$this->importe,"");
            $formulario->cerrar("Agregar venta movimiento");
            
  }
  

   public function movimientos_ventas_agregar() {
            $this->tomar_post();
            
            if ($this->id_clienteproveedor1<=0){
                print "No ha seleccionado un proveedor!<br>";
                die;
            }            
                        
            if ($this->importe<=0){
                print "El importe no es correcto!<br>";
                die;
            }

            $asiento = new asiento();
            $cuenta = new cuenta();
            
            $asiento->id_clienteproveedor = $this->id_clienteproveedor1;
            $asiento->id_usuario = $this->usuario->id_usuario;
            $asiento->id_empresa = $this->usuario->id_empresa;
            $asiento->fecha = $this->fecha;
            $asiento->detalle = $this->detalle;
            $asiento->importe=$this->importe;
            $asiento->estado="activo";
            $asiento->tipo_asiento ="credito";
            
            $id_cuenta_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            $id_cuenta_ctacte = $this->config->que_configuracion($this->id_empresa . "_cuenta_ctacte", "numero");
            
            $id_cuentaclienteproveedor=$this->clienteproveedor->que($this->id_clienteproveedor1, "id_cuenta");
            
            $asiento->id_cuenta=$id_cuentaclienteproveedor;
            $asiento->tipo_asiento ="debito";
            $asiento->add();
            

            if ($this->forma_pago == "Contado") {
                $asiento->id_cuenta=$id_cuentaclienteproveedor;
                $asiento->tipo_asiento ="credito";
                $asiento->add();

                
                $asiento->detalle = $cuenta->que($id_cuentaclienteproveedor, "cuenta") . ". " . $this->detalle;
                $asiento->tipo_asiento = "credito";
                $asiento->id_cuenta = $id_cuenta_caja;
                $asiento->add();
                
            } else {
                $asiento->detalle = $cuenta->que($id_cuentaclienteproveedor, "cuenta") . ". " . $this->detalle;
                $asiento->id_cuenta=$id_cuenta_ctacte;
                $asiento->tipo_asiento ="debito";
                $asiento->add();
            }            

            Print "Movimiento Venta agregado. <br>";
  }


        public function movimientos_cobranzas_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Agregar Cobranza");
            
            // $this->limpiar_registro();

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
                    <div class='detalle_clienteproveedor'>Cliente:<br>
                            <input id='clienteproveedor_ajax' name='clienteproveedor_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_clienteproveedor1' id='id_clienteproveedor1' value=''>
                            
                        </div>
                        <br>
                    <div id='clienteproveedor_detalle'></div>
                </td>
              </tr>
            </table>
            </div>
            ";

            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Nro Comprobante","nro_comprobante",20,20,$this->nro_comprobante,"");
            $formulario->text_box("Detalle","detalle",75,255,$this->detalle,"");            
            $formulario->text_box("Importe","importe",20,20,$this->importe,"");
            $formulario->cerrar("Agregar cobranza movimiento");
            
  }
  

   public function movimientos_cobranzas_agregar() {
            $this->tomar_post();
            
            if ($this->id_clienteproveedor1<=0){
                print "No ha seleccionado un proveedor!<br>";
                die;
            }            
                        
            if ($this->importe<=0){
                print "El importe no es correcto!<br>";
                die;
            }

            $asiento = new asiento();
            
            $asiento->id_clienteproveedor = $this->id_clienteproveedor1;
            $asiento->id_usuario = $this->usuario->id_usuario;
            $asiento->id_empresa = $this->usuario->id_empresa;
            $asiento->fecha = $this->fecha;
            $asiento->detalle = $this->detalle;
            $asiento->importe=$this->importe;
            $asiento->estado="activo";
            $asiento->tipo_asiento ="credito";
            
            $id_cuenta_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            $id_cuenta_ctacte = $this->config->que_configuracion($this->id_empresa . "_cuenta_ctacte", "numero");
            
            
            $id_cuentaclienteproveedor=$this->clienteproveedor->que($this->id_clienteproveedor1, "id_cuenta");
            
            $asiento->id_cuenta=$id_cuentaclienteproveedor;
            $asiento->add();

            $asiento->id_cuenta=$id_cuenta_ctacte;
            $asiento->tipo_asiento ="credito";
            $asiento->add();

            $asiento->id_cuenta=$id_cuenta_caja;
            $asiento->add();
            
            Print "Movimiento cobranza agregado. <br>";
  }

  
  
        public function movimientos_egresos_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Agregar Egreso");
            $cuenta = new cuenta();
            // $this->limpiar_registro();

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
                    <div class='detalle_clienteproveedor'>Proveedor:<br>
                            <input id='clienteproveedor_ajax' name='clienteproveedor_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_clienteproveedor1' id='id_clienteproveedor1' value=''>
                        </div>
                        <br>
                    <div id='clienteproveedor_detalle'></div>
                </td>
              </tr>              
            </table>
            </div>
            ";

            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Nro Comprobante","nro_comprobante",20,20,$this->nro_comprobante,"");
            $formulario->text_box("Detalle","detalle",75,255,$this->detalle,"");
            
            $formulario->combo_opciones("Forma Pago","forma_pago",array("Contado","A pagar"),"Contado");

            $id_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            $id_cuenta_padre = $cuenta->que($id_caja, "id_cuenta_padre");
            
            print "
            <table width='920' border='0'>
              <tr>
                <td height='24' colspan='5'>
                    <div class='detalle_asiento'>Debitar de Cuenta:<br>
                            <input id='cuenta_ajax' name='cuenta_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_cuenta1' id='id_cuenta1' value=''>
                            <input type='hidden' name='id_padre_ajax_cuenta' id='id_padre_ajax_cuenta' value='" . $id_cuenta_padre . "'>
                        </div>
                        <br>
                    <div id='cuenta_detalle'></div>
                </td>
              </tr>                
              </tr>              
            </table>
            
            ";
            $formulario->date_box("Fecha pago", "fecha_pago", "");
            

            $formulario->text_box("Importe","importe",20,20,$this->importe,"");
            $formulario->cerrar("Agregar egreso movimiento");
            
  }
  

   public function movimientos_egresos_agregar() {
            $this->tomar_post();
            
            if ($this->id_clienteproveedor1<=0){
                print "No ha seleccionado un proveedor!<br>";
                return;
            }            
            
            if ($this->id_cuenta1<=0 and $this->forma_pago=="Contado"){
                print "No ha seleccionado una cuenta a debitar!<br>";
                return;
            }
            
            if ($this->importe<=0){
                print "El importe no es correcto!<br>";
                return;
            }
            
            
            $asiento = new asiento();
            $clienteproveedor = new clienteproveedor();
            
            $asiento->id_clienteproveedor = $this->id_clienteproveedor1;
            $asiento->id_usuario = $this->usuario->id_usuario;
            $asiento->id_empresa = $this->usuario->id_empresa;
            
            $asiento->detalle = $this->detalle;
            $asiento->importe=$this->importe;
            $asiento->estado="activo";

            $id_cuentaclienteproveedor=$this->clienteproveedor->que($this->id_clienteproveedor1, "id_cuenta");
            $id_cuenta_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");

            // asiento en la cuenta del proveedor
            $asiento->fecha = $this->fecha_pago;
            $asiento->id_cuenta=$id_cuentaclienteproveedor;
            $asiento->tipo_asiento ="debito";            
            $asiento->add();
            
            
            if ($this->forma_pago=="Contado"){
                // asiento en caja
                $asiento->fecha = $this->fecha;
                $asiento->id_cuenta=$id_cuenta_caja;
                $asiento->tipo_asiento ="debito";
                $asiento->add();                
                
                // contra asiento en la cuenta del proveedor
                $asiento->fecha = $this->fecha;
                $asiento->id_cuenta=$id_cuentaclienteproveedor;
                $asiento->tipo_asiento ="credito";            
                $asiento->add();
                
            }
            
            $id_cuenta_proveedores = $this->config->que_configuracion($this->id_empresa . "_cuenta_proveedores", "numero");
            $razon_social =$clienteproveedor->que($this->id_clienteproveedor1, "razon_social");

            // asiento en la cuenta general de proveedor
            if ($this->forma_pago=="Contado"){
                $asiento->fecha = $this->fecha;
                $asiento->detalle = $asiento->detalle . ". " . $razon_social;
                $asiento->id_cuenta=$id_cuenta_proveedores;
                $asiento->tipo_asiento ="debito";            
                $asiento->add();
                $asiento->tipo_asiento ="credito";                            
                $asiento->add();
            }

            
            
            Print "Movimiento Egreso agregado. Forma de pago: " . $this->forma_pago . "<br>";
            
  }



  
  
        public function movimientos_pagar_egresos_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Agregar Pago a Egreso");
            $cuenta = new cuenta();
            // $this->limpiar_registro();

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
                    <div class='detalle_clienteproveedor'>Proveedor:<br>
                            <input id='clienteproveedor_ajax' name='clienteproveedor_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_clienteproveedor1' id='id_clienteproveedor1' value=''>
                        </div>
                        <br>
                    <div id='clienteproveedor_detalle'></div>
                </td>
              </tr>              
            </table>
            </div>
            ";

            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Nro Comprobante","nro_comprobante",20,20,$this->nro_comprobante,"");
            $formulario->text_box("Detalle","detalle",75,255,$this->detalle,"");

            $id_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            $id_cuenta_padre = $cuenta->que($id_caja, "id_cuenta_padre");
            
            print "
            <table width='920' border='0'>
              <tr>
                <td height='24' colspan='5'>
                    <div class='detalle_asiento'>Debitar de Cuenta:<br>
                            <input id='cuenta_ajax' name='cuenta_ajax' type='text' size='50' maxlength='100' />
                            <input type='hidden' name='id_cuenta1' id='id_cuenta1' value=''>
                            <input type='hidden' name='id_padre_ajax_cuenta' id='id_padre_ajax_cuenta' value='" . $id_cuenta_padre . "'>
                        </div>
                        <br>
                    <div id='cuenta_detalle'></div>
                </td>
              </tr>                
              </tr>              
            </table>
            
            ";
            $formulario->date_box("Fecha pago", "fecha_pago", "");
            

            $formulario->text_box("Importe","importe",20,20,$this->importe,"");
            $formulario->cerrar("Agregar pago egreso movimiento");
            
  }
  

   public function movimientos_pagos_egresos_agregar() {
            $this->tomar_post();
            $clienteproveedor = new clienteproveedor();
            
            if ($this->id_clienteproveedor1<=0){
                print "No ha seleccionado un proveedor!<br>";
                return;
            }            
            
            if ($this->id_cuenta1<=0){
                print "No ha seleccionado una cuenta a debitar!<br>";
                return;
            }
            
            if ($this->importe<=0){
                print "El importe no es correcto!<br>";
                return;
            }
            
            $razon_social =$clienteproveedor->que($this->id_clienteproveedor1, "razon_social");
            $asiento = new asiento();
            
            $asiento->id_clienteproveedor = $this->id_clienteproveedor1;
            $asiento->id_usuario = $this->usuario->id_usuario;
            $asiento->id_empresa = $this->usuario->id_empresa;
            
            $asiento->detalle = $this->detalle;
            $asiento->importe=$this->importe;
            $asiento->estado="activo";

            $id_cuentaclienteproveedor=$this->clienteproveedor->que($this->id_clienteproveedor1, "id_cuenta");

            // Asiento en la cuenta del proveedor
            $asiento->fecha = $this->fecha;
            $asiento->id_cuenta=$id_cuentaclienteproveedor;
            $asiento->tipo_asiento ="credito";
            $asiento->add();                
            
            // Asiento en la cuenta de disponibilidad
            $asiento->fecha = $this->fecha_pago;
            $asiento->id_cuenta=$this->id_cuenta1;
            $asiento->tipo_asiento ="debito";            
            $asiento->add();

            $id_cuenta_proveedores = $this->config->que_configuracion($this->id_empresa . "_cuenta_proveedores", "numero");


            // Asiento en la cuenta de proveedores General
            $asiento->fecha = $this->fecha;
            $asiento->id_cuenta=$id_cuenta_proveedores;
            $asiento->detalle = $this->detalle . ", " . $razon_social;
            $asiento->tipo_asiento ="debito";            
            $asiento->add();
            
            $asiento->fecha = $this->fecha_pago;
            $asiento->id_cuenta=$id_cuenta_proveedores;
            $asiento->tipo_asiento ="credito";            
            $asiento->add();

            Print "Movimiento Pago Egreso agregado. <br>";
            
            
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

  
        public function movimientos_agregar_resumen_tj_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Agregar Rendicion de TJ");
            // $this->limpiar_registro();

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

            $formulario->combo_opciones("Tipo","tipo",array("Agente","AGENCIA 74"),$this->tipo);
            $formulario->combo_opciones("Cobrar Maquina","cobrar_maquina",array("si","no"),$this->cobrar_maquina);
            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Quiniela \$","imp_quiniela",20,20,"","");
            $formulario->text_box("Quini-Express \$","imp_qe",20,20,"","");
            $formulario->text_box("Loto \$","imp_loto",20,20,"","");
            $formulario->text_box("Quini6 \$","imp_q6",20,20,"","");
            $formulario->text_box("Brinco \$","imp_brinco",20,20,"","");
            $formulario->text_box("Loto5 \$","imp_loto5",20,20,"","");
            $formulario->text_box("Loteria \$","imp_loteria",20,20,"","");
            $formulario->text_box("Maradona \$","imp_maradona",20,20,"","");
            $formulario->text_box("Telekino \$","imp_telekino",20,20,"","");
            $formulario->cerrar("Agregar asiento Tj");
            
  }
  
        public function agregar_asiento_tj() {
            $this->tomar_post();

            $cuenta = new cuenta();
            // $clienteproveedor = new clienteproveedor();

            if ($this->id_cuenta1<=0){
                print "No ha seleccionado un proveedor!<br>";
                die;
            }            
                        
            // print "id_clienteproveedor1: " . $this->id_clienteproveedor1 . "<br>";
                        
            $comision_q = 0.85;
            $comision_j = 0.90;
            
            if ($this->tipo=="AGENCIA 74") {
                $comision_q=1;
                $comision_j=1;            
            }

            if (!is_numeric($this->imp_quiniela)) {
                $this->imp_quiniela=0;            }
            if (!is_numeric($this->imp_qe)) {
                $this->imp_qe=0;            }
            if (!is_numeric($this->imp_loto)) {
                $this->imp_loto=0;            }
            if (!is_numeric($this->imp_q6)) {
                $this->imp_q6=0;            }
            if (!is_numeric($this->imp_brinco)) {
                $this->imp_brinco=0;            }
            if (!is_numeric($this->imp_loto5)) {
                $this->imp_loto5=0;             }
            if (!is_numeric($this->imp_loteria)) {
                $this->imp_loteria=0;             }
            if (!is_numeric($this->imp_maradona)) {
                $this->imp_maradona=0;             }
            if (!is_numeric($this->imp_telekino)) {
                $this->imp_telekino=0;             }
                            
            $asiento = new asiento();
            $cuenta = new cuenta();

            $asiento->id_clienteproveedor = $this->id_cuenta1;
            $asiento->id_usuario = $this->id_usuario_activo;
            $asiento->id_empresa = $this->id_empresa;
            $asiento->fecha = $this->fecha;
            $asiento->estado="activo";

            $cuenta_quiniela = $this->config->que_configuracion($this->id_empresa . "_cuenta_quiniela", "numero");
            $cuenta_quini_express = $this->config->que_configuracion($this->id_empresa . "_cuenta_quini_express", "numero");
            $cuenta_loto = $this->config->que_configuracion($this->id_empresa . "_cuenta_loto", "numero");
            $cuenta_quini6 = $this->config->que_configuracion($this->id_empresa . "_cuenta_quini6", "numero");
            $cuenta_brinco = $this->config->que_configuracion($this->id_empresa . "_cuenta_brinco", "numero");
            $cuenta_loto5 = $this->config->que_configuracion($this->id_empresa . "_cuenta_loto5", "numero");
            $cuenta_loteria = $this->config->que_configuracion($this->id_empresa . "_cuenta_loteria", "numero");
            $cuenta_maradona = $this->config->que_configuracion($this->id_empresa . "_cuenta_maradona", "numero");
            $cuenta_telekinos = $this->config->que_configuracion($this->id_empresa . "_cuenta_telekinos", "numero");

            // print "1";            
            $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . " Venta";
            $asiento->tipo_asiento ="debito";

            $asiento->id_cuenta=$cuenta_quiniela;
            $asiento->importe=$this->imp_quiniela;
            $asiento->add();

            $asiento->id_cuenta=$cuenta_quini_express;
            $asiento->importe=$this->imp_qe;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_loto;
            $asiento->importe=$this->imp_loto;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_quini6;
            $asiento->importe=$this->imp_q6;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_brinco;
            $asiento->importe=$this->imp_brinco;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_loto5;
            $asiento->importe=$this->imp_loto5;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_loteria;
            $asiento->importe=$this->imp_loteria;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_maradona;
            $asiento->importe=$this->imp_maradona;            
            $asiento->add();

            $asiento->id_cuenta=$cuenta_telekinos;
            $asiento->importe=$this->imp_telekino;            
            $asiento->add();

            $total_quiniela = $this->imp_quiniela * $comision_q;
            $total_juegos = $this->imp_qe + $this->imp_loto + $this->imp_q6 + $this->imp_brinco + $this->imp_loto5;
            $total_juegos *= $comision_j;            
            $total_loteria = $this->imp_loteria * $comision_j;            
            $total_maradona = $this->imp_maradona * $comision_j;            
            $total_telekino = $this->imp_telekino * $comision_j;
            
            $asiento->id_cuenta=$this->id_cuenta1;
            $asiento->tipo_asiento ="debito";
            print "1";            
            $asiento->detalle = "Quiniela";
            $asiento->importe=$total_quiniela;            
            $asiento->add();
            
            $asiento->detalle = "Juegos tj";
            $asiento->importe=$total_juegos;            
            $asiento->add();

            $asiento->detalle = "Loteria";
            $asiento->importe=$total_loteria;            
            $asiento->add();
            
            $asiento->detalle = "Maradona";
            $asiento->importe=$total_maradona;            
            $asiento->add();

            $asiento->detalle = "Telekino";
            $asiento->importe=$total_telekino;            
            $asiento->add();            
            
            if ($this->cobrar_maquina=="si" and $this->tipo<>"AGENCIA 74") {
                $asiento->detalle = "Maquina";
                $asiento->importe=2;            
                $asiento->add();                            
            }
            
            print "Se registro correctamente la venta de quiniela";
            
            
  }

  
  
        public function movimientos_caja_agencia_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Movimiento de Caja Agencia");
            // $this->limpiar_registro();
            $formulario->combo_opciones("Tipo","tipo",array("Gasto","Cta Cte","Cambio","Cobro"),"Egreso");

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


            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Detalle","detalle",75,255,$this->detalle,"");
            $formulario->text_box("Importe \$","importe",20,20,"","");
            $formulario->cerrar("Agregar movimiento caja agencia");
  }
  
  
        public function movimientos_caja_agencia() {
            $this->tomar_post();
            
            $asiento = new asiento();            
            $cuenta = new cuenta();


            if ($this->id_cuenta1<=0){
                print "No ha seleccionado una cuenta!<br>";
                die;
            }            
            if (!is_numeric($this->importe)) {
                print "El importe no es correcto!.";
                return false;
            }
                        
            // print "id_clienteproveedor1: " . $this->id_clienteproveedor1 . "<br>";
                        
            // $id_cuenta_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            
            // asiento el credito en la agencia
            

            $id_cuenta_agencia000 = $this->config->que_configuracion($this->id_empresa . "_agencia_000", "numero");

            $asiento->id_clienteproveedor = $this->id_cuenta1;
            $asiento->id_usuario = $this->id_usuario_activo;
            $asiento->id_empresa = $this->id_empresa;
            $asiento->fecha = $this->fecha;
            $asiento->estado="activo";

            
    switch ($this->tipo) {          
         case "Cta Cte":
                $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . ". " . $this->detalle;
                $asiento->tipo_asiento ="credito";
                $asiento->id_cuenta=$id_cuenta_agencia000;
                $asiento->importe=$this->importe;
                $asiento->add();

                // asiento el debito en la cuenta contrasiento

                $asiento->tipo_asiento ="debito";
                $asiento->detalle = $this->detalle;
                $asiento->id_cuenta=$this->id_cuenta1;
                $asiento->add();

              break;            

         case "Gasto":
                $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . ". " . $this->detalle;
                $asiento->tipo_asiento ="credito";
                $asiento->id_cuenta=$id_cuenta_agencia000;
                $asiento->importe=$this->importe;
                $asiento->add();

                // asiento el debito en la cuenta contrasiento

                $asiento->tipo_asiento ="debito";
                $asiento->detalle = $this->detalle;
                $asiento->id_cuenta=$this->id_cuenta1;
                $asiento->add();
                
                $asiento->tipo_asiento ="credito";
                $asiento->add();                
                

              break;            

         case "Cambio":
                $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . ". " . $this->detalle;
                $asiento->tipo_asiento ="debito";
                $asiento->id_cuenta=$id_cuenta_agencia000;
                $asiento->importe=$this->importe;
                $asiento->add();

                // asiento el debito en la cuenta contrasiento

                $asiento->tipo_asiento ="debito";
                $asiento->detalle = $this->detalle;
                $asiento->id_cuenta=$this->id_cuenta1;
                $asiento->add();
                

              break;            
          

         case "Cobro":
                $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . ". " . $this->detalle;
                $asiento->tipo_asiento ="debito";
                $asiento->id_cuenta=$id_cuenta_agencia000;
                $asiento->importe=$this->importe;
                $asiento->add();

                // asiento el debito en la cuenta contrasiento

                
                $asiento->tipo_asiento ="credito";
                $asiento->detalle = $this->detalle;
                $asiento->id_cuenta=$this->id_cuenta1;
                $asiento->add();

                /*                 
                $asiento->tipo_asiento ="credito";
                $asiento->add();                
                */
                

              break;            
          
          
          
    }
            
            
            
            print "Se registro correctamente el movimiento caja";
            
  }


        public function movimientos_cobro_agente_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Agregar Cobro Agente");
            // $this->limpiar_registro();

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

            $formulario->date_box("Fecha", "fecha", "");
            $formulario->text_box("Importe \$","importe",20,20,"","");
            $formulario->text_box("Premios \$","imp_quiniela",20,20,"","");
            $formulario->cerrar("Agregar cobro agente");
            
  }


        public function movimientos_cobro_agente() {
            $this->tomar_post();
            
            $asiento = new asiento();            
            $cuenta = new cuenta();     

            if ($this->id_cuenta1<=0){
                print "No ha seleccionado una cuenta!<br>";
                die;
            }            
            if (!is_numeric($this->importe)) {
                $this->importe=0;
            }
            if (!is_numeric($this->imp_quiniela)) {
                $this->imp_quiniela=0;
            }

            $importe_pago = $this->imp_quiniela + $this->importe;
            
            if ($importe_pago <=0) {
                print "El efectivo y el premio estan en 0.00 no se puede agregar!<br>";
                return;                
            }
            
            // print "id_clienteproveedor1: " . $this->id_clienteproveedor1 . "<br>";                        
            $id_cuenta_caja = $this->config->que_configuracion($this->id_empresa . "_cuenta_caja", "numero");
            $id_cuenta_premios = $this->config->que_configuracion($this->id_empresa . "_cuenta_premios", "numero");
            // asiento el credito en la agencia

            // $id_cuenta_agencia000 = $this->config->que_configuracion($this->id_empresa . "_agencia_000", "numero");

            $asiento->id_clienteproveedor = $this->id_cuenta1;
            $asiento->id_usuario = $this->id_usuario_activo;
            $asiento->id_empresa = $this->id_empresa;
            $asiento->fecha = $this->fecha;
            $asiento->estado="activo";
            $asiento->tipo_asiento ="credito";
            
            // asiento el debito en la cuenta contrasiento
            
            if ($this->importe>0){
                $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . " Entrega Efectivo" ;            
                $asiento->id_cuenta=$this->id_cuenta1;
                $asiento->importe=$this->importe;
                $asiento->add();
                
                $asiento->id_cuenta=$id_cuenta_caja;
                $asiento->importe=$this->importe;
                $asiento->add();                
            }
            
            if ($this->imp_quiniela>0){
                $asiento->detalle = $cuenta->que($this->id_cuenta1, "cuenta") . " Entrega Premios" ;            
                $asiento->id_cuenta=$this->id_cuenta1;
                $asiento->importe=$this->imp_quiniela;
                $asiento->add();
                
                $asiento->id_cuenta=$id_cuenta_premios;
                $asiento->importe=$this->imp_quiniela;
                $asiento->add();                
            }
            
            print "Se registro correctamente el cobro agente";
            
  }
  
  
  
  
  
  
}
?>
