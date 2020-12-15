<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];
    $body = $_GET['page'];  
    $search = $_GET['datos'];  
    if ($opcion == 1) {
        $ventas = VentaAdo::getAll($search,($body - 1) * 10, 10);
        if (is_array($ventas)) {
            $datos["estado"] = 1;
            $datos["total"] = $ventas[1];
            $datos["ventas"] = $ventas[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ventas
            ));
        }
    }
    exit();
}

