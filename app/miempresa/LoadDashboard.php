<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './MiEmpresaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['type'] == "informacion") {
        $result = MiEmpresaAdo::ListarDashboard();
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "clientes" => $result[0],
                "ingresos" => $result[1],
                "cuentas" => $result[2],
                "empleados" => $result[3]
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    } else if ($_GET['type'] == "porvencer") {
        $body = $_GET['page'];
        $result = MiEmpresaAdo::ListarPorVencer(($body - 1) * 10, 10);
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "memPorVencer" => $result[0],
                "memPorVencerTotal" => $result[1],
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    } else if ($_GET['type'] == "vencido") {
        $body = $_GET['page'];
        $result = MiEmpresaAdo::ListarVencidos(($body - 1) * 10, 10);
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "memFinazalidas" => $result[0],
                "memFinazalidasTotal" => $result[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    }
}
