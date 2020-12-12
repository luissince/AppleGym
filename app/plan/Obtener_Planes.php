<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
require './PlanAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $body = $_GET['page'];
    $search = $_GET["datos"];
    $planes = PlanAdo::getAllPlanes($search,($body-1)*10,10);
    if (is_array($planes) ){
        $datos["estado"] = 1;
        $datos["total"] = $planes[1];
        $datos["planes"] = $planes[0];
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}

