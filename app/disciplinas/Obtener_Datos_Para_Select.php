<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './DisciplinaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $disciplinas = DisciplinaAdo::getAllDatosForSelect();
    if ($disciplinas) {
        $datos["estado"] = 1;
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
