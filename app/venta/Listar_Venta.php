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
        $tipo = $_GET['tipo'];
        $search = $_GET['datos'];
        $fechaInicial = $_GET["fechaInicial"];
        $fechaFinal = $_GET["fechaFinal"];

        $ventas = VentaAdo::getAll($tipo, $search, $fechaInicial, $fechaFinal, ($body - 1) * 10, 10);
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
    } else if ($opcion == 5) {
        $body = $_GET['page'];
        $tipo = $_GET['tipo'];
        $search = $_GET['datos'];
        $fechaInicial = $_GET["fechaInicial"];
        $fechaFinal = $_GET["fechaFinal"];

        $ingresos = VentaAdo::getIngresos($tipo, $search, $fechaInicial, $fechaFinal, ($body - 1) * 10, 10);
        if (is_array($ingresos)) {
            print json_encode(array(
                "estado" => 1,
                "ingresos" => $ingresos[0],
                "total" => $ingresos[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ingresos
            ));
        }
    } else if ($opcion == 6) {
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
    } else if ($opcion == 7) {
        $venta = VentaAdo::AnularVenta($_GET["idVenta"]);
        if ($venta == "deleted") {
            print json_encode(array(
                "estado" => 1,
                "mensaje" => "Se anuló correctamente la venta.",
            ));
        } else if ($venta == "anulado") {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "La venta ya se encuentra anulada.",
            ));
        } else if ($venta == "fecha") {
            print json_encode(array(
                "estado" => 3,
                "mensaje" => "La fecha de anulación no es la mismo día de la venta.",
            ));
        } else if ($venta == "pagos") {
            print json_encode(array(
                "estado" => 3,
                "mensaje" => "La venta tiene cuotas cobradas.",
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $venta
            ));
        }
    }
    exit();
}
