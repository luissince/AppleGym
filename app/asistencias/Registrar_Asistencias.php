<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './AsistenciaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
    $validate = AsistenciaAdo::getAsistenciaByIdPersona($body['idPersona']);
    if ($validate == "1") {
        $json_string = json_encode(array("estado" => 1, "mensaje" => "Tiene aperturado una asistencia, cierre y vuelta a marcar."));
        echo $json_string;
    } 
    else {
        $retorno = AsistenciaAdo::insertAsistencia($body);
        if ($retorno == "true") {
            $json_string = json_encode(array("estado" => 2, "mensaje" => "Se marco correctamente el ingreso."));
            echo $json_string;
        } else {
            $json_string = json_encode(array("estado" => 3, "mensaje" => $retorno));
            echo $json_string;
        }
    }
}

