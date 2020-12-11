<?php

/*
    Obtiene todos las tablas especificas de la base de datos
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ConfiguracionAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    //$body = $_GET['page'];
    
    $tablas = ConfiguracionAdo::getTablesNames();
    if ($tablas) {
        $datos["estado"] = 1;
        $datos["tablas"] = $tablas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}

