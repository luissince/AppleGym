<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];

    if ($opcion == 1) {

        $body = $_GET['page'];
        $search = $_GET['datos'];

        $clientes = ClienteAdo::getAllDatos($search, ($body - 1) * 10, 10);
        if (is_array($clientes)) {
            $datos["estado"] = 1;
            $datos["total"] = $clientes[1];
            $datos["clientes"] = $clientes[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $clientes
            ));
        }
    } else if ($opcion == 2){
        // $body = $_GET['paginacion'];
        // $search = $_GET['datos'];

        $clientes = ClienteAdo::getClientesTraspaso();
        if (is_array($clientes)) {
            $datos["estado"] = 1;
            // $datos["total"] = $clientes[1];
            $datos["clientes"] = $clientes[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $clientes
            ));
        }
    } else if ($opcion == 3){
        $dni = $_GET['dni'];
        $data = ClienteAdo::getDataCLientesTraspaso($dni);
        if (is_array($data)) {
            $result["estado"] = 1;
            $result["membresias"] = $data;
            print json_encode($result);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $data
            ));
        }
    }

    exit();
}
