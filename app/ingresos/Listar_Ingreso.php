<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//
require './IngresoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $opcion = $_GET['opcion'];
    $body = $_GET['page'];
    $search = $_GET['search'];
    $transaccion = $_GET['transaccion'];
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];
    //$tipo = $_GET['tipo'];
   // $forma = $_GET['forma'];
   // $estado = $_GET['estado'];    
    if ($opcion == 1) {
        $ingresos = IngresoAdo::getIngresoAll(($body - 1) * 5, 5);
        $total = IngresoAdo::getIngresoAllCount();
        if ($ingresos) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 5;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 5);
            $datos["ingresos"] = $ingresos;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error primer: ".$ingresos
            ));
        }
    }else if($opcion == 2){
        $ingresos = IngresoAdo::getIngresoSearch($search,($body - 1) * 5, 5);
        $total = IngresoAdo::getIngresoSearchCount($search);
        if ($ingresos) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 5;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 5);
            $datos["ingresos"] = $ingresos;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error segundo: ".$ingresos
            ));
        }
    }else if($opcion == 3){
        $ingresos = IngresoAdo::getIngresoOptions($transaccion,$fechaInicio,$fechaFin,($body - 1) * 5, 5);
        $total = IngresoAdo::getIngresoOptionsCount($transaccion,$fechaInicio,$fechaFin);
        if (is_array($ingresos)) {
            $datos["estado"] = 1;
            $datos["page"] = $body;
            $datos["page_rows"] = 5;
            $datos["total"] = $total;
            $datos["total_page"] = ceil($total / 5);
            $datos["ingresos"] = $ingresos;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $ingresos
            ));
        }
    }
    exit();
}

