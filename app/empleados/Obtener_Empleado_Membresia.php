<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './EmpleadoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $empleado = EmpleadoAdo::getMembresiaMarcarAsistencia($_GET["buscar"]);
    if (is_array($empleado)) {
        print json_encode(array(
            "estado" => 1,
            "empleado" => $empleado[0],
            "asistencia" => $empleado[1]
        ));
    } else {
        print json_encode(array(
            "estado" => 0,
            "mensaje" => $empleado
        ));
    }
    exit();
}
