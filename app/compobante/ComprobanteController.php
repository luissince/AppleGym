<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ComprobanteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if($_GET["type"] == "lista"){
        $page = $_GET['page'];
        $search = $_GET['datos'];
        $result = ComprobanteAdo::getAllComprobantes($search, ($page - 1) * 10, 10);
        if(is_array($result)){
            $datos["estado"] = 1;
            $datos["total"] = $result[1];
            $datos["comprobantes"] = $result[0];
            print json_encode($datos);
        }else{
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}
