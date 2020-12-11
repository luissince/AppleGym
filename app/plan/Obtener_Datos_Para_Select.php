<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './PlanAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $planes = PlanAdo::getAllDatosForSelect();
    if (is_array($planes)) {
        $datos["estado"] = 1;
        $datos["planes"] = $planes;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}
