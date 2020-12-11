<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './DisciplinaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $body = $_GET['page'];
    $search = $_GET['datos'];
    
    $disciplinas = DisciplinaAdo::getAllDatosSearch($search,($body-1)*10,10);
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

