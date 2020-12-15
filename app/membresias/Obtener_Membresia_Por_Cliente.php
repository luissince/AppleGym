<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './MembresiaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET    
    $membresias = MembresiaAdo::getAllMembresiasPorCliente($_GET['idCliente'],($_GET['page']-1)*10,10);
    if (is_array($membresias)){
        $datos["estado"] = 1;
        $datos["total"] = $membresias[1];
        $datos["membresias"] = $membresias[0];
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $membresias
        ));
    }
    exit();
}
