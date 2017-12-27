<?php

class empresa {

    public $id_empresa;
    public $empresa;
    public $id_empresa_seleccionada;
    
/*
        id_empresa
	empresa
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
        
        $this->tabla = "empresas";
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

            
        if (isset($_REQUEST["id_empresa"])) {
            $this->id_empresa = $_REQUEST["id_empresa"]; }
            
        if (isset($_REQUEST["empresa"])) {
            $this->empresa = $_REQUEST["empresa"]; }
            
        if (isset($_REQUEST["id_empresa_seleccionada"])) {
            $this->id_empresa_seleccionada = $_REQUEST["id_empresa_seleccionada"]; }
                                    
        if (isset($_REQUEST["texto_buscar"])) {
            $this->texto_buscar = $_REQUEST["texto_buscar"]; }                        
        if (isset($_REQUEST["buscar_por"])) {
            $this->buscar_por = $_REQUEST["buscar_por"]; }            
            
}


        public function cargar_registro(){
                $this->id_empresa = $this->db->campo("id_empresa");
                $this->empresa = $this->db->campo("empresa");
        }

        public function limpiar_registro(){
                $this->id_empresa = 0;
                $this->empresa = "";
        }
        

        
        public function form_agregar_empresa() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Crear empresa y plan de cuenta basico",920);
            
            if ($this->id_empresa>0) {
                Print "Ya existe una empresa asociada a este usuario.";
            } else {
                $formulario->text_box("Empresa", "empresa", 75, 75, $this->empresa, "");
                $formulario->boton("Crear empresa");                
            }
            
            $formulario->cerrar_formulario();
        } 

        public function empresas_asignar_form() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Asignar una empresa",920);
            
            if ($this->id_empresa>0) {
                Print "Ya existe una empresa asociada a este usuario.<br>";
                Print "Si desea crear una nueva o asignar a otra consulte con el administrador.<br>";
            } else {
                $formulario->combo_box("Empresa", "id_empresa_seleccionada", "empresas", "empresa", "id_empresa", "");
                $formulario->boton("Asignar empresa");                
            }
            
            $formulario->cerrar_formulario();
        }   
  

        public function empresas_asignar() {
            $this->tomar_post();
            $formulario = new formulario();
            $formulario->abrir("Asignar una empresa",920);            
            if ($this->id_empresa>0) {
                Print "Ya existe una empresa asociada a este usuario.<br>";
                Print "Si desea crear una nueva o asignar a otra consulte con el administrador.<br>";
            } else {
                
                $this->db->sql = "UPDATE \n";
                $this->db->sql .= "usuarios SET \n";
                $this->db->sql .= "id_empresa=". $this->id_empresa_seleccionada . " \n";
                $this->db->sql .= " where id_usuario=" . $this->id_usuario_activo . "\n";

                // print "SQL: " . $this->db->sql . "<br>";
                $this->db->query_db();
                if ($this->db->reg_afectados>0) {
                    Print "Se asigno correctamente la empresa al usuario<br>";
                } else {
                    Print "Ocurrio un error de asignacion<br>";
                }
            }
            $formulario->cerrar_formulario();

        }   
        
        

   public function agregar() {
          $this->tomar_post();
                    
          if ($this->validacion()) {
             print "Datos ingresados incorrectamente<br>";
              exit;
          }

            $this->db->sql = " SELECT * from empresas where id_empresa=" . $this->id_empresa . " limit 1";
            // print "SQL: " . $this->db->sql . "<br>";
            if($this->db->query_db()){
                print "No puedes crear un plan. Ya tienes asignado una empresa con plan de cuentas";
                Die;
            }
          
          
          $this->armar_sql("nuevo");
          
          // print $this->db->sql . "<br>";
          
          $this->db->query_db();
          if ($this->db->insertado()) {
                $this->box->mensaje="Se agrego correctamente la empresa";
                $this->box->show_ok();
                $this->id_empresa = $this->db->insertado();
                $this->crear_plan();
          }

          
  }

  public function validacion() {
          $devolucion=false;
          if ($this->empresa==""){
                print "El importe no es valido.<br>";
                $devolucion=true;
          }
          return $devolucion;
  }
  
  
  
   private function armar_sql($accion) {
       
            if ($accion=="nuevo"){
                $this->db->sql = "INSERT INTO ";
            } else {
                $this->db->sql = "UPDATE ";
            }
            $this->db->sql .= $this->tabla . " SET ";
            $this->db->sql .= "empresa='". $this->empresa . "' ";
            
            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_empresa=" . $this->id_empresa . "";
            }
          }

          
        
        
        
        public function crear_plan(){
                $this->id_usuario = $this->id_usuario_activo;
                
                $this->db->sql = " INSERT INTO `cuentas` (`id_usuario`, `id_empresa`, `id_cuenta_padre`, `id_cuenta_contrapartida`, `codigo`, `cuenta`, `tipo_cuenta`) VALUES
                    ($this->id_empresa, $this->id_usuario, 0, 0, '01', 'Activo', 'debito')";
                
                if ($this->db->query_db()){
                    $id_cuenta = $this->db->insertado();
                }
                
                $this->db->sql = "INSERT INTO `cuentas` (`id_empresa`, `id_usuario`, `id_cuenta_padre`, `id_cuenta_contrapartida`, `codigo`, `cuenta`, `tipo_cuenta`) VALUES ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", 0, 0, '02', 'Pasivo', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", 0, 0, '03', 'Patrimonio Neto', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+1) . ", 0, '01.01', 'Activo Corriente', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+1) . ", 0, '01.02', 'Activo No Corriente', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.01', 'Bienes de uso', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.02', 'Inmuebles', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.03', 'Muebles y Utiles', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.04', 'Rodados', 'debito'), ";                        
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+4) . ", 0, '01.01.01', 'Disponibilidad', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+4) . ", 0, '01.01.02', 'Creditos', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+4) . ", 0, '01.01.03', 'Otros Debitos', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+4) . ", 0, '01.01.04', 'Bienes de cambio', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+4) . ", 0, '01.01.05', 'Inversiones', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+10) . ", 0, '01.01.01.01', 'Caja', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+10) . ", 0, '01.01.01.02', 'Banco Corrientes', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+10) . ", 0, '01.01.01.03', 'Banco Macro', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+10) . ", 0, '01.01.01.04', 'Banco Nacion', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+11) . ", 0, '01.01.02.01', 'Documentos a cobrar', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+11) . ", 0, '01.01.02.02', 'Deudores por ventas', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+11) . ", 0, '01.01.02.03', 'Deudores morosos', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+11) . ", 0, '01.01.02.04', 'Valores a depositar', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 11) . ", 0, '01.01.02.05', 'Anticipo a proveedores', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 12) . ", 0, '01.01.03.01', 'Impuestos a favor', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 13) . ", 0, '01.01.04.01', 'Mercaderias', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 14) . ", 0, '01.01.05.01', 'Plazos fijos', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 14) . ", 0, '01.01.05.02', 'Titulos publicos', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 2) . ", 0, '02.01', 'Pasivo Corriente', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 2) . ", 0, '02.02', 'Pasivo No Corriente', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 28) . ", 0, '02.01.01', 'Deudas comerciales', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 28) . ", 0, '02.01.02', 'Deudas bancarias', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 28) . ", 0, '02.01.03', 'Deudas fiscales', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 28) . ", 0, '02.01.04', 'Deudas Sociales', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 30) . ", 0, '02.01.01.01', 'Proveedores', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 30) . ", 0, '02.01.01.02', 'Deudores por ventas', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 30) . ", 0, '02.01.01.03', 'Anticipos de clientes', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 31) . ", 0, '02.01.02.01', 'Prestamos a pagar', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 32) . ", 0, '02.01.03.01', 'Impuestos y tasas a pagar', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 33) . ", 0, '02.01.04.01', 'Sueldos y Jornales a pagar', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 33) . ", 0, '02.01.04.02', 'Cargas sociales a depositar', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 29) . ", 0, '02.02.01', 'Deudas a Largo Plazo', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 3) . ", 0, '03.01', 'Capital', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 3) . ", 0, '03.02', 'Resultado No Asignado', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+ 3) . ", 0, '03.03', 'Reserva Legal', 'credito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", 0, 0, '04', 'Resultado', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+45) . ", 0, '04.01', 'Ganancia', 'debito'), ";
                        $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+45) . ", 0, '04.02', 'Perdidas', 'credito') ";
                // print "SQL: " . $this->db->sql . "<br>";

                        
                if ($this->usuario->usuario_activo("tipo_empresa")=="agencias") {
                            $this->db->sql .= ", (" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.05', 'Quiniela', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.06', 'Quini Express', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.07', 'Loto', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.08', 'Quini6', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.09', 'Brinco', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.10', 'Loto5', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.11', 'Loteria', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.12', 'Maradona', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.13', 'Telekinos', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.14', 'Premios', 'debito'), ";
                            $this->db->sql .= "(" . $this->id_empresa . ", " . $this->id_usuario . ", " . ($id_cuenta+5) . ", 0, '01.02.15', 'Agencia 000', 'debito') ";                            
                }
                $this->db->sql .= ";";

                // print "SQL: " . $this->db->sql . "<br>";
                $this->db->query_db();
                
                $cuenta = new cuenta();
                
                $this->db->sql = "
                    INSERT INTO configuracion (id_usuario, codigo, descripcion, numero, texto, fecha) VALUES 
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_caja', NULL, " . $cuenta->buscar_id("Caja",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_ctacte', NULL, " . $cuenta->buscar_id("Deudores por ventas",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_proveedores', NULL, " . $cuenta->buscar_id("Proveedores",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_deudoresporventa', NULL, " . $cuenta->buscar_id("Deudores por ventas",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_premios', NULL, " . $cuenta->buscar_id("Premios",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_quiniela', NULL, " . $cuenta->buscar_id("Quiniela",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_quini_express', NULL, " . $cuenta->buscar_id("Quini Express",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_loto', NULL, " . $cuenta->buscar_id("Loto",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_quini6', NULL, " . $cuenta->buscar_id("Quini6",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_brinco', NULL, " . $cuenta->buscar_id("Brinco",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_loto5', NULL, " . $cuenta->buscar_id("Loto5",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_loteria', NULL, " . $cuenta->buscar_id("Loteria",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_maradona', NULL, " . $cuenta->buscar_id("Maradona",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_cuenta_telekinos', NULL, " . $cuenta->buscar_id("Telekinos",$this->id_empresa) . ", NULL, NULL),
                    (" . $this->id_usuario . ", '" . $this->id_empresa . "_agencia_000', NULL, " . $cuenta->buscar_id("Agencia 000",$this->id_empresa) . ", NULL, NULL);
                ";

                
                
                
                // print "SQL: " . $this->db->sql . "<br>";                
                $this->db->query_db();
                
                
        }
        

}

?>
