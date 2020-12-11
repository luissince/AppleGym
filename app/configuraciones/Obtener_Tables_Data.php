<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ConfiguracionAdo.php';

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    $body = json_decode(file_get_contents("php://input"), true);
//    // Manejar petición GET
//    $tablas = ConfiguracionAdo::getAll($body['tableName'], ($body['page']-1)*10, 10);
//    $total = ConfiguracionAdo::getAllCount($body);
//    if ($tablas) {
//        $datos["estado"] = 1;
//        $datos["page"] = $body;
//        $datos["page_rows"] = 10;
//        $datos["total"] = $total;
//        $datos["total_page"] = ceil($total / 10);
//        $datos["tableData"] = $tablas;
//        print json_encode($datos);
//    } else {
//        print json_encode(array(
//            "estado" => 2,
//            "mensaje" => "Ha ocurrido un error"
//        ));
//    }
//    exit();
//}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $body = $_GET['page'];
    $tableName = $_GET['tableName'];
    
    $tablas = ConfiguracionAdo::getAll($tableName, ($body-1)*10, 10);
    $total = ConfiguracionAdo::getAllCount($tableName);
    if (is_array($tablas) ) {
        $datos["estado"] = 1;
        $datos["page"] = $body;
        $datos["page_rows"] = 10;
        $datos["total"] = $total;
        $datos["total_page"] = ceil($total / 10);
        $datos["tableData"] = $tablas;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
    exit();
}





