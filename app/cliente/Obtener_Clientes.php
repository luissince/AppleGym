<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];
    $body = $_GET['page'];
    $search = $_GET['datos'];

    if ($opcion == 1) {
        $clientes = ClienteAdo::getAll(($body - 1) * 10, 10);
        $total = ClienteAdo::getAllCount();
        if (is_array($clientes)) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 10;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 10);
            $datos["clientes"] = $clientes;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $clientes
            ));
        }
    } else if ($opcion == 2) {
        $clientes = ClienteAdo::getAllDatos($search, ($body - 1) * 10, 10);
        $total = ClienteAdo::getAllDatosCount($search);
        if ($clientes) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 10;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 10);
            $datos["clientes"] = $clientes;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "No hay datos para mostrar."
            ));
        }
    }

    exit();
}
