<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ProductoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $search = $_GET['datos'];
    $body = $_GET['page'];
    
    $productos = ProductoAdo::getAllProducto($search,($body-1)*5,5);
    if (is_array($productos)){
        $datos["estado"] = 1;
        $datos["total"] = $productos[1];
        $datos["productos"] = $productos[0];
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $productos
        ));
    }
    exit();
}
