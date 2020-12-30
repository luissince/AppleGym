<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];

    if ($opcion == 1) {
        $body = $_GET['page'];
        $search = $_GET['datos'];
        $ventas = VentaAdo::getAll($search, ($body - 1) * 10, 10);
        if (is_array($ventas)) {
            $datos["estado"] = 1;
            $datos["total"] = $ventas[1];
            $datos["ventas"] = $ventas[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ventas
            ));
        }
    } else if ($opcion == 2) {
        $ventas = VentaAdo::getVentaByCliente($_GET["idCliente"]);
        if (is_array($ventas)) {
            $datos["estado"] = 1;
            $datos["ventas"] = $ventas;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ventas
            ));
        }
    } else if ($opcion == 3) {
        $detalle = VentaAdo::getVentaDetalleByd($_GET["idVenta"]);
        if (is_array($detalle)) {
            print json_encode(array(
                "estado" => 1,
                "detalle" => $detalle
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $detalle
            ));
        }
    } else if ($opcion == 4) {
        $credito = VentaAdo::getVentaCredito($_GET["idVenta"]);
        if (is_array($credito)) {
            print json_encode(array(
                "estado" => 1,
                "detalle" => $credito
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $credito
            ));
        }
    }else if($opcion == 5){
        $ingresos = VentaAdo::getIngresos($_GET["fechaInicial"], $_GET["fechaFinal"]);
        if (is_array($ingresos)) {
            print json_encode(array(
                "estado" => 1,
                "ingresos" => $ingresos[0],
                "total" => $ingresos[1],
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ingresos
            ));
        }
    }else if($opcion == 6){
        $asistencias = VentaAdo::getAsistemcias($_GET["idCliente"]);
        if (is_array($asistencias)) {
            print json_encode(array(
                "estado" => 1,
                "asistencias" => $asistencias,
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $asistencias
            ));
        }
    }
    exit();
}
