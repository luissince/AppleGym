<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './RolAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];
    $body = $_GET['page'];
    $search = $_GET['datos'];

    if ($opcion == 1) {
        $roles = RolAdo::getAll(($body - 1) * 10, 10);
        if (is_array($roles)) {
            $datos["estado"] = 1;
            $datos["total"] = $roles[1];
            $datos["roles"] = $roles[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $roles
            ));
        }
    } 
    else if ($opcion == 2) {
        $roles = RolAdo::getAllDatos($search, ($body - 1) * 10, 10);
        if (is_array($roles)) {
            $datos["estado"] = 1;
            $datos["total"] = $roles[1];
            $datos["roles"] = $roles[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $roles
            ));
        }
    }

    exit();
}
