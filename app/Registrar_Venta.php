<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = VentaAdo::insertVenta($body);
    if ($retorno == "true") {
        $json_string = json_encode(array("estado" => 1, "mensaje" => "Se registro correctamente la venta."));
        echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
        echo $json_string;
    }
}