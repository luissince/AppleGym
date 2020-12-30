<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './EmpleadoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $body = $_GET['page'];
    $text = $_GET['datos'];

    $empleados = EmpleadoAdo::getAllEmpleado($text, ($body - 1) * 10, 10);
    if (is_array($empleados)) {
        $datos["estado"] = 1;
        $datos["total"] = $empleados[1];
        $datos["empleados"] = $empleados[0];
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}
