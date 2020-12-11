<?php

/**
 * Obtiene un cliente de la base de datos por su id
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    // Manejar petición GET
    $alumnos = ClienteAdo::getClientById($body);
    if (is_object($alumnos)) {        
        print json_encode(array(
            "estado" => 1,
            "cliente" => $alumnos
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}
