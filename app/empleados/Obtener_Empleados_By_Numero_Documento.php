<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './EmpleadoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET

    $search = $_GET['dato'];
    
    $empleados = EmpleadoAdo::getEmpleadoByNumeroDocumento($search);

    if ($empleados) {
        $datos["estado"] = 1;
        $datos["empleados"] = $empleados;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $empleados
        ));
    }
    exit();
}

