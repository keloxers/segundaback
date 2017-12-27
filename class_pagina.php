<?php

class pagina {
        public $usuario;
        public $vaccion;
        public $mostrar_menu;
        
    function __construct() {
        $areas=explode("/",$_SERVER["REQUEST_URI"]);
        $this->vaccion=$areas[1];

        if ($this->vaccion=="index.php") {
            if (isset($_REQUEST["accion"])) {
                  $this->vaccion=$_REQUEST["accion"];
            } else {
                $this->vaccion="home";          
            }
        }                                               
        if (isset($_REQUEST["mostrar_menu"])) {
            $this->mostrar_menu = $_REQUEST["mostrar_menu"];
        } else {
            $this->mostrar_menu = true;
        }

        if ($this->vaccion=="reimprimir_salida") {
            $this->mostrar_menu = false;
        }                                               
        
        
        
    }

        public function pre_encabezado(){
            $icon = new icon();
            $this->usuario = new usuario();            
            $valor = true;
            switch ($this->vaccion) {
                case "Ingresar":
                    if (!$this->usuario->validar_usuario()){
                        $valor = false;
                    }
                    break;  
                case "sing_out":
                    $this->usuario->session_out();
                    break;
            }

            if ($this->mostrar_menu==true) {
                  print "<table width='920' border='0' align='center'>";
                  print "<tr>";
                  print "<td width='360'>";
                  print "<div align='left'>";
                  print " ";
                  print "</div>";
                  print "</td>";
                  print "<td width='560'>";
                  print "<div align='right'>";
                  if ($this->usuario->usuario_activo()) {
                      print "<a href='/'>";
                      print " " . "Home";
                      print "</a> \n | ";                  
                      print "Hola " . $this->usuario->usuario_activo("usuario");
                      print " | ";
                      print "<a href='/sing_out'>";
                      print " " . "Cerrar session";
                      print "</a> \n";                  
                  } else {
                      print "<a href='/form_register'>";
                      print "Registrarse";
                      print "</a>\n";
                      print " | ";
                      print "<a href='/login'>";
                      print "Ingresar";
                      print "</a>\n";                                        
                  }
                  print "</div></td></tr></table>";
            }
              return $valor ;
        }

        
        public function encabezado()   {
            if ($this->mostrar_menu==true) {
                    print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
                    print "<html xmlns='http://www.w3.org/1999/xhtml'>\n";
                    print "<head>\n";
                    print "<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1' />\n";
                    print "<title>Codex Cuentas 12.3.21 </title>\n";
                    print "<link type='text/css' href='/css/flick/jquery-ui-1.8.11.custom.css' rel='stylesheet' />";
                    print "<script type='text/javascript' src='/js/jquery-1.5.1.min.js'></script>";
                    print "<script type='text/javascript' src='/js/jquery-ui-1.8.11.custom.min.js'></script>";

                    print "<script type='text/javascript' src='/codex.js'></script>";
                    
                    // print "<script type='text/javascript' src='/fg.menu.js'></script>";
                    print "<link type='text/css' href='/fg.menu.css' media='screen' rel='stylesheet' />";
                    print "<link type='text/css' href='/theme/ui.all.css' media='screen' rel='stylesheet' />";

                    print "<link type='text/css' href='/fg.menu2.css' media='screen' rel='stylesheet' />";
                    // print "<script type='text/javascript' src='/fg.menu2.js'></script>";


    
                    
                    // print "<script type='text/javascript'> $(function(){ $('<div style='position: absolute; top: 20px; right: 300px;' />').appendTo('body').themeswitcher(); }); </script>";
                    
                    // un script debe ir si o si en head ?
                    
                                      
                    print "<link href='/codex.css' rel='stylesheet' type='text/css' />\n";
                    print "<link href='/paginador.css' rel='stylesheet' type='text/css' />\n";

                    print "</head>\n";
                    
                    
            }
            
            $login = $this->pre_encabezado();

            if ($this->mostrar_menu==true) {
                    print "<table width='920' border='0' align='center'><tr><td>\n";
                    if ($this->usuario->usuario_activo('tipo')=="administrador") {
                        print "<a tabindex='0' href='/menuContent.php' class='fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all' id='flyout'><span class='ui-icon ui-icon-triangle-1-s'></span>Menu</a> \n";
                        print "<br><br><br>";
                    }
            }
            
            return $login;
        }
        
        
        public function front(){
            print "<table width='920' border='0' align='center'><tr><td align='center'>\n";
            print "<a href='/form_register'>";
            print "<img src='/imagenes/imagen_front_2.jpg' border='0'>";            
            print "</a>\n";
            print "<td><tr><table>\n";            
            
        }        
		
		
        public function home()   {
			$formulario= new formulario();
			$formulario->abrir("",920);
			$formulario->abrir_renglon();
                        if ($this->usuario->usuario_activo("tipo")=="administrador"){
                            print "<div align='center'>";
                            print "<a href='/movimientos_ventas'>";
                            print "<img src='/imagenes/ventas.png' align='center' />";
                            print "</a>";
                            print "<a href='/movimientos_cobranzas'>";
                            print "<img src='/imagenes/cobros.png' align='center' />";
                            print "</a>";
                            print "<a href='/movimientos_egresos'>";
                            print "<img src='/imagenes/egresos.png' align='center' />";
                            print "</a>";
                            print "<a href='/movimientos_pagar_egresos'>";
                            print "<img src='/imagenes/pago_egresos.png' align='center' />";
                            print "</a>";
                            print "<a href='/informe_mayor'>";
                            print "<img src='/imagenes/mayor.png' align='center' />";
                            print "</a>";                            
                            print "</div>";
                            
                        }
                        
			print "<div align='center'>";
			print "<img src='/imagenes/symyl_logo.jpg' align='center' />";
			print "</div>";                        
                        if ($this->usuario->usuario_activo("tipo_empresa")=="agencias"){
                            print "<div align='center'>";
                            print "<a href='/movimientos_agregar_resumen_tj'>";
                            print "<img src='/imagenes/agencia_tj.png' align='center' />";
                            print "</a>";
                            print "<a href='/movimientos_cobro_agente_form'>";
                            print "<img src='/imagenes/agencia_cobro.png' align='center' />";
                            print "</a>";
                            print "<a href='/movimientos_caja_agencia_form'>";
                            print "<img src='/imagenes/agencia_movimiento_caja.png' align='center' />";
                            print "</a>";

                            print "</div>";
                            
                        }
                        $formulario->cerrar_renglon();
			$formulario->cerrar_formulario();


        }
		
		
		
        public function pie()   {
            if ($this->mostrar_menu) {
                print "</td></tr></table>";
				print "<div align='center'>";
                print "<table width='920' border='0' align='center'><tr><td>";
                print "<div class='end_div' align='center'>";
                print "Desarrollado por CodexControl.com 2011 - info@codexcontrol.com - Version 12.3.21";
                print "</div>";
                print "</td></tr></table>";
				print "</div>";
                print "</body>\n";
                print "</html>\n";
                session_destroy();
            }
        }
        
        
        
        
}  

?>
