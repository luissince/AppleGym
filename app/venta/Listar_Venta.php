<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
require './VentaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];
    $body = $_GET['page'];  
    if ($opcion == 1) {
        $ventas = VentaAdo::getAll(($body - 1) * 10, 10);
        if (is_array($ventas)) {
            $datos["estado"] = 1;
            $datos["total"] = $ventas[0];
            $datos["ventas"] = $ventas[1];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ventas
            ));
        }
    }else if($opcion == 2){
        $ventas = VentaAdo::getVentaSearchPrincipal($search,($body - 1) * 5, 5);
        $total = VentaAdo::getVentaSearchPrincipalCount($search);
        if ($ventas) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 5;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 5);
            $datos["ventas"] = $ventas;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ventas 
            ));
        }
    }else if($opcion == 3){
        $ventas = VentaAdo::getVentaSearchOptions($transaccion,$fechaInicio,$fechaFin,$tipo,$forma,$estado,($body - 1) * 5, 5);
        $total = VentaAdo::getVentaSearchOptionsCount($transaccion,$fechaInicio,$fechaFin,$tipo,$forma,$estado);
        if (is_array($ventas)) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 5;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 5);
            $datos["ventas"] = $ventas;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ventas
            ));
        }
    }
    exit();
}

