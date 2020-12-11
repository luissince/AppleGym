<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './AsistenciaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET

    $search = $_GET['dato'];

    $asistencias = AsistenciaAdo::getAsistenciaByIdPersona($search);

    if ($asistencias == "1") {
       $sc = AsistenciaAdo::getAsistenciaByIdPersonaDos($search);
        if ($sc["estado"] == "2") {           
            print json_encode($sc);
        } else {      
            print json_encode($sc);
        }
    } else if ($asistencias == "0") {
        $datos["estado"] = 1;
        $datos["asistencias"] = "Marcar entreda";
         print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}