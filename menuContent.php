<?php
    require_once "inout.php";

    $usuario = new usuario();
print "
<ul>
    <li><a href='#'>Tablas</a>
        <ul>
            <li><a href='/empresas'>Empresas</a>
                <ul>
                    <li><a href='/empresas_agregar'>Agregar</a></li>
                    <li><a href='/empresas_asignar'>Asignar</a></li>
                </ul>            
            </li>            
            <li><a href='/cuentas'>Cuentas</a>
                <ul>
                    <li><a href='/cuentas_agregar'>Agregar</a></li>
                    <li><a href='/cuentas_buscar'>Buscar</a></li>
                    <li><a href='/cuentas'>Listar</a></li>
                </ul>            
            </li>            
            <li><a href='/clienteproveedor'>Clientes Proveedores</a>
                <ul>
                    <li><a href='/clienteproveedor_agregar'>Agregar</a></li>
                    <li><a href='/clienteproveedor_buscar'>Buscar</a></li>
                    <li><a href='/clienteproveedor'>Listar</a></li>
                </ul>            
            </li>            
            
            
        </ul>
    </li>

    <li><a href='#'>Contable</a>
        <ul>
            <li><a href='/form_asiento_agregar'>Agregar asiento contable</a></li>

        </ul>
    </li>
    
    <li><a href='#'>Informes</a>
        <ul>
            <li><a href='/informe_ventas'>Ventas</a></li>
            <li><a href='/informe_gastos'>Gastos</a></li>
            <li><a href='/informe_mayor'>Mayor</a></li>
            <li><a href='/informe_saldoporcliente'>Saldos de clientes</a></li>
            <li><a href='/informe_saldoporproveedores'>Saldos de Proveedores</a></li>
            <li><a href='/informe_rendicion_diaria'>Rendicion Diaria</a></li>
        </ul>
    </li>
    <li><a href='#'>Movimientos</a>
        <ul>
                    <li><a href='/movimientos_ventas'>Ventas</a></li>
                    <li><a href='/movimientos_cobranzas'>Cobranzas</a></li>
                    <li><a href='/movimientos_egresos'>Egresos</a></li>
                    <li><a href='/movimientos_pagar_egresos'>Pagar Egresos</a></li>";

        print "</ul>
    </li>";
        
    if ($usuario->usuario_activo("tipo_empresa")=="agencias") {        
    
        print "<li><a href='#'>Agencia</a>
                <ul>
                    <li><a href='/movimientos_agregar_resumen_tj'>Agregar Resumen Tj</a></li>
                    <li><a href='/movimientos_cobro_agente_form'>Agregar cobro agente</a></li>
                    <li><a href='/movimientos_caja_agencia_form'>Agregar Movimiento caja Agencia 000</a></li>                    
                </ul>
               </li>";
    }
        
    print "

    
    <li><a href='/perfil'>Perfil</a></li>
    </ul>
";

 // <li><a href='/form_asientos_entre_fechas'>Asientos entre fecha</a></li>

?>  
