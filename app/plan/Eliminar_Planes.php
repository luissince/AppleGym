<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './PlanAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = PlanAdo::deletePlan($body);
    if ($retorno == "deleted") {
        print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente"));
    } elseif ($retorno == "registrado") {
        print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el plan porque está ligada a una membresia"));
    } else {
        print json_encode(array("estado" => 3, "mensaje" => $retorno));
    }
}

