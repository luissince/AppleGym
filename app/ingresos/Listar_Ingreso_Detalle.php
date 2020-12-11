<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//
require './IngresoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idIngreso = $_GET['idIngreso'];

    $ingreso = IngresoAdo::getIngresoPorId($idIngreso);
    if ($ingreso) {
        print json_encode(array(
            "estado" => 1,
            "ingreso" => $ingreso
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $ingreso
        ));
    }
}

