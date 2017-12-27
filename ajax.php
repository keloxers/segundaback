<?php
    require_once "inout.php";
    
    $type = $_GET['type'];
    $tipo = $_GET['tipo'];
    $id_cuenta_padre = $_GET['id_cuenta_padre'];
    
    
    
    switch ($type) {
        
        case 1:
            $clienteproveedor = new clienteproveedor();
            echo json_encode($clienteproveedor->buscar_clienteproveedor($_GET['term'],$tipo));
            break;
        case 2:
            $cuenta = new cuenta();
            echo json_encode($cuenta->buscar_cuenta($_GET['term'],$id_cuenta_padre));
            break;

        default:
        break;
    }
    
    
    
?>
