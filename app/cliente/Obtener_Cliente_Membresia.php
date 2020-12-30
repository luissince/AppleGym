<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $cliente = ClienteAdo::getMembresiaMarcarAsistencia($_GET["buscar"]);
    if (is_array($cliente)) {
        print json_encode(array(
            "estado" => 1,
            "cliente" => $cliente[0],
            "membresias" => $cliente[1],
            "asistencia" => $cliente[2]
        ));
    } else {
        print json_encode(array(
            "estado" => 0,
            "mensaje" => $cliente
        ));
    }
    exit();
}
