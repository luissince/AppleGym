<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET

    $search = $_GET['dato'];
    
    $array = ClienteAdo::getClientByNumeroDocumento($search);
    
    if (!empty($array)) {
        $datos["estado"] = 1;
        $datos["array"] = $array;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Error al realizar la petición"
        ));
    }
    exit();
}


