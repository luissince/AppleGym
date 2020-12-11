<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ConfiguracionAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    // Manejar petición GET
    $tables = ConfiguracionAdo::getTableDataById($body);
    if ($tables) {
        $datos["estado"] = 1;
        $datos["tables"] = $tables;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            'mensaje" => "Ha ocurrido un error '.$tables
        ));
    }
    exit();
}

