<?php
    require_once "inout.php";
    $pagina = new pagina();
    $usuario = new usuario();
    
    $admin = new admin();
    
    $areas=explode("/",$_SERVER["REQUEST_URI"]);
    $vaccion=$areas[1];
    
    
    if ($vaccion=="index.php") {
        if (isset($_REQUEST["accion"])) {
            $vaccion=$_REQUEST["accion"];
        } else {
            $vaccion="home";          
        }
    }
    
    if (!$pagina->encabezado()) {
        print "Login incorrecto<br>";
        $vaccion="login";
    }

    // print "vaccion: " . $vaccion ."<br>";
    
    switch ($vaccion) {          
         case "form_register":
                $usuario->show_formulario_agregar();
              break;
         case "login":
                $usuario->formulario_login();
              break;
              
         case "usuario no valido":
              print "<b>Usuario no valido</b><br><br>";
              $usuario->formulario_login();
              break;
                            
         case "Registrarse":
              if ($usuario->agregar()) {
                  $usuario->formulario_login();
              } else {
                  $usuario->show_formulario_agregar();
              }
              break;
              
         case "perfil":
              $usuario->show_formulario_agregar();
              break;
              
         case "modificar perfil":
              $usuario->modificar();
              break;
              
              
         case "admin":
              $usuario->is_admin();
              $admin->ver_menu();
              break;
              
         case "panel":

              break;

          

          
          

// Menu de Asientos
         case "form_asiento_agregar":
              $asiento = new asiento();
              $asiento->form_agregar_asiento();
              break;
         case "Guardar Asiento":
              $asiento = new asiento();
              $asiento->agregar();
              break;          
          
          
// Menu de Cuentas
         case "cuentas_agregar":
              $cuenta = new cuenta();
              $cuenta->show_formulario_agregar();
              break;
         case "Agregar Cuenta":
              $cuenta = new cuenta();
              $cuenta->agregar();
              break;
         case "cuenta_buscar":
              $cuenta = new cuenta();
              $cuenta->show_formulario_buscar();
              break;
         case "Buscar cuentas":
              $cuenta = new cuenta();
              $cuenta->buscar_show();
              break;
         case "editar_cuenta":
              $cuenta = new cuenta();
              $cuenta->show_formulario_agregar();
              break;
         case "Modificar Cuenta":
              $cuenta = new cuenta();
              $cuenta->modificar();
              break;
         case "borrar_cuenta":
              $cuenta = new cuenta();
              $cuenta->confirmar_borrar();
              break;
         case "Confirma borrar cuentas":
              $cuenta = new cuenta();
              $cuenta->borrar();
              break;          
         case "cuentas":
              $cuenta = new cuenta();
              $cuenta->show_listado();
              break;
          

// Menu de ClientesProveedores
         case "clienteproveedor_agregar":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->show_formulario_agregar();
              break;
         case "Agregar cliente o proveedor":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->agregar();
              break;
         case "clienteproveedor_buscar":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->show_formulario_buscar();
              break;
         case "Buscar Clientes o Proveedores":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->buscar_show();
              break;
         case "editar_clienteproveedor":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->show_formulario_agregar();
              break;
         case "Modificar cliente o proveedor":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->modificar();
              break;
         case "borrar_clienteproveedor":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->confirmar_borrar();
              break;
         case "Confirma Borrar cliente o proveedor":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->borrar();
              break;          
         case "clienteproveedor":
              $clienteproveedor = new clienteproveedor();
              $clienteproveedor->show_listado();
              break;
          
          
          
          
          
// Informes
         case "form_asientos_entre_fechas":
              $asiento = new asiento();
              $asiento->form_asientos_entre_fechas();
              break;
         case "Mostrar asientos entre fechas":
              $asiento = new asiento();
              $asiento->asientos_entre_fechas();
              break;          
          
          
// Empresas
         case "empresas_agregar":
              $empresa = new empresa();
              $empresa->form_agregar_empresa();
              break;
         case "Crear empresa":
              $empresa = new empresa();
              $empresa->agregar();
              break;

         case "empresas_asignar":
              $empresa = new empresa();
              $empresa->empresas_asignar_form();
              break;
         case "Asignar empresa":
              $empresa = new empresa();
              $empresa->empresas_asignar();
              break;          
          
          
// Menu de Usuarios              
         case "Usuarios":
              $usuario->is_admin();         
              $usuario->show_listado(0);
              break;


         case "movimientos_ventas":
              $movimiento = new movimiento();
              $movimiento->movimientos_ventas_agregar_form();
              break;
         case "Agregar venta movimiento":
              $movimiento = new movimiento();
              $movimiento->movimientos_ventas_agregar();
              break;
          
          
         case "movimientos_cobranzas":
              $movimiento = new movimiento();
              $movimiento->movimientos_cobranzas_form();
              break;
         case "Agregar cobranza movimiento":
              $movimiento = new movimiento();
              $movimiento->movimientos_cobranzas_agregar();
              break;

         case "movimientos_egresos":
              $movimiento = new movimiento();
              $movimiento->movimientos_egresos_form();
              break;
         case "Agregar egreso movimiento":
              $movimiento = new movimiento();
              $movimiento->movimientos_egresos_agregar();
              break;          

         case "movimientos_pagar_egresos":
              $movimiento = new movimiento();
              $movimiento->movimientos_pagar_egresos_form();
              break;
         case "Agregar pago egreso movimiento":
              $movimiento = new movimiento();
              $movimiento->movimientos_pagos_egresos_agregar();
              break;                    
          
         case "movimientos_agregar_resumen_tj":
              $movimiento = new movimiento();
              $movimiento->movimientos_agregar_resumen_tj_form();
              break;
         case "Agregar asiento Tj":
              $movimiento = new movimiento();
              $movimiento->agregar_asiento_tj();
              break;          

         case "movimientos_caja_agencia_form":
              $movimiento = new movimiento();
              $movimiento->movimientos_caja_agencia_form();
              break;                    
         case "Agregar movimiento caja agencia":
              $movimiento = new movimiento();
              $movimiento->movimientos_caja_agencia();
              break;                    
          
         case "movimientos_cobro_agente_form":
              $movimiento = new movimiento();
              $movimiento->movimientos_cobro_agente_form();
              break;                    
         case "Agregar cobro agente":
              $movimiento = new movimiento();
              $movimiento->movimientos_cobro_agente();
              break;                    
          
          
          

// Informes 
          
         case "informe_ventas":
              $informe = new informe();
              $informe->informe_ventas_form();
              break;
         case "Ver informe ventas":
              $informe = new informe();
              $informe->informe_ventas();
              break;

          
         case "informe_gastos":
              $informe = new informe();
              $informe->informe_gastos_form();
              break;
         case "Ver informe gastos":
              $informe = new informe();
              $informe->informe_gastos();
              break;          
          
          

         case "informe_mayor":
              $informe = new informe();
              $informe->informe_mayor_form();
              break;
         case "Ver informe mayor":
              $informe = new informe();
              $informe->informe_mayor();
              break;

         case "informe_rendicion_diaria":
              $informe = new informe();
              $informe->informe_rendicion_form();
              break;
         case "Ver rendicion diaria":
              $informe = new informe();
              $informe->informe_rendicion();
              break;          
          
         case "informe_saldoporcliente":
              $informe = new informe();
              $informe->informe_saldosporclientes_form();
              break;
         case "Ver saldos por clientes":
              $informe = new informe();
              $informe->informe_saldosporclientes();
              break;                    
          
         case "informe_saldoporproveedores":
              $informe = new informe();
              $informe->informe_saldoporproveedores_form();
              break;
         case "Ver saldos por proveedores":
              $informe = new informe();
              $informe->informe_saldoporproveedores();
              break;                    

          
          
          
         default:
            $pagina->home();
            break;
    }
    $pagina->pie();
?>
