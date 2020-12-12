<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './ClienteAdo.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if (ClienteAdo::validateClienteId($body['idCliente'])) {
        if (ClienteAdo::validateClienteDniById($body['idCliente'], $body['dni'])) {
            $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un cliente con el mismo dni 1"));
            echo $json_string;
        } else {
            if (ClienteAdo::edit($body) == "updated") {
                $json_string = json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el cliente"));
                echo $json_string;
            } else {
                $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                echo $json_string;
            }
        }
    } 
    else {
        if (ClienteAdo::validateClienteDni($body['dni'])) {
            $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un cliente con el mismo dni"));
            echo $json_string;
        } else {
            $retorno = ClienteAdo::insert($body);
            if ($retorno == "inserted") {
                $json_string = json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el cliente!!"));
                echo $json_string;
            } else {
                $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                echo $json_string;
            }
        }
    }
}
