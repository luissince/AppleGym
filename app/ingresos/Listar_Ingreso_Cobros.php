<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//
require './IngresoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $idVenta = $_GET['idVenta'];
    
    $ingresos = IngresoAdo::getListaIngresosCobros($idVenta);
    if($ingresos){
        print json_encode(array(
            "estado" => 1,
            "ingresos" => $ingresos
        ));
    }else{
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $ingresos
        ));
    }
   
}
