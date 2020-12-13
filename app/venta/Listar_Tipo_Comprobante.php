<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comprobantes = VentaAdo::getAllComprobante();
    if (is_array($comprobantes)) {
        $datos["estado"] = 1;
        $datos["comprobantes"] = $comprobantes;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un problema interno en cargar los comprobantes."
        ));
    }
    exit();
}
