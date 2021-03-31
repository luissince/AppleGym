<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = VentaAdo::insertarCredito($body);
    if ($retorno == "true") {
        echo json_encode(array(
            "estado" => 1,
            "mensaje" => "Se registro correctamente el cobro."
        ));
    } else if ($retorno == "noid") {
        echo json_encode(array(
            "estado" => 2,
            "mensaje" => "No se puedo registrar el cobro ya que la venta se encuentra anulada."
        ));
    } else {
        echo json_encode(array(
            "estado" => 0,
            "mensaje" => $retorno
        ));
    }
}
