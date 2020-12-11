<?php

/**
 * Obtiene un cliente de la base de datos por su id
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    // Manejar petición GET
    $cliente = ClienteAdo::getClientById($body);
    $membresia = ClienteAdo::getMembresiaClienteById($body);
    if ($cliente) {
        print json_encode(array(
            "estado" => 1,
            "clientes" => $cliente,
            "membresias" => $membresia
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}
