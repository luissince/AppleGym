<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ContratoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);

    if (ContratoAdo::validateContratoId($body['idContrato'])) {
        if (ContratoAdo::editContrato($body) == "true") {
            $json_string = json_encode(array("estado" => 1, "mensaje" => "Edición correcta"));
            echo $json_string;
        } else {
            $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
            echo $json_string;
        }
    } else {
        if (ContratoAdo::insertContrato($body) == "true") {
            $json_string = json_encode(array("estado" => 1, "mensaje" => "Creacion correcta"));
            echo $json_string;
        } else {
            $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
            echo $json_string;
        }
    }
    
}
