<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = ClienteAdo::deleteCliente($body);
    if ($retorno == "deleted") {
        print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente el cliente."));
    } elseif ($retorno == "asistencia") {
        print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el cliente porque tiene un historial de asistencias."));
    } else if ($retorno == "membresia") {
        print json_encode(array("estado" => 3, "mensaje" => "No se puede eliminar el cliente porque tiene un historial de ventas."));
    } else {
        print json_encode(array("estado" => 4, "mensaje" => $retorno));
    }
}
