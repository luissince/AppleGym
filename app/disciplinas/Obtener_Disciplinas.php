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

    $disciplinas = DisciplinaAdo::getAllDisciplina(($body - 1) * 10, 10);
    $total = DisciplinaAdo::getAllCountDisciplina();
    if ($disciplinas) {
        $datos["estado"] = 1;
        $datos["page"] = $body;
        $datos["page_rows"] = 10;
        $datos["total"] = $total;
        $datos["total_page"] = ceil($total / 10);
        $datos["disciplinas"] = $disciplinas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}
