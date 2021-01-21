<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './MiEmpresaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $result = MiEmpresaAdo::ListarDashboard();
    if (is_array($result)) {        
        print json_encode(array(
            "estado" => 1,
            "clientes" => $result[0],
            "ingresos" => $result[1],
            "membresias" => $result[2],
            "cuentas" => $result[3]
        ));   
    } else {
        print json_encode(array(
            "estado" => 0,
            "mensaje" => $result
        ));
    }
    exit();
}
