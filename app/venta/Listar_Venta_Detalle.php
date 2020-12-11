<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//asasdsaf
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $idVenta = $_GET['idVenta'];
    $procedencia = $_GET['procedencia'];   
    
    $ventas = VentaAdo::getVenta($idVenta);
    $ventas_detalle = VentaAdo::getVentaDetalle($idVenta,$procedencia);
    $venta_credito = VentaAdo::getVentaCredito($idVenta);
    if ($ventas != null && !empty($ventas_detalle)) {
        print json_encode(array(
            "estado" => 1,
            "venta" => $ventas,
            "venta_detalle" => $ventas_detalle,
            "venta_credito" => $venta_credito
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $ventas
        ));
    }
    exit();
    
}

