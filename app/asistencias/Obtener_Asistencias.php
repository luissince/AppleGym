<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './AsistenciaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $idPersona = $_GET['idPersona'];
    
    $asistencias = AsistenciaAdo::getAllAsistencia($idPersona);
    if ($asistencias) {
        $datos["estado"] = 1;
        $datos["asistencias"] = $asistencias;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $asistencias
        ));
    }
    exit();
}

