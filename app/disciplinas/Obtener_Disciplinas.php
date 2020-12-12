<?php

/**
 * Obtiene todos los clientes de la base de datos
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:  Authorization, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require './DisciplinaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $body = $_GET['page'];
    $search = $_GET['datos'];

    $disciplinas = DisciplinaAdo::getAllDisciplina($search,($body - 1) * 10, 10);
    if (is_array($disciplinas)) {
        $datos["estado"] = 1;
        $datos["total"] = $disciplinas[1];
        $datos["disciplinas"] = $disciplinas[0];
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $disciplinas
        ));
    }
    exit();
}
