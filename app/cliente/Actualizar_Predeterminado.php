<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require './ClienteAdo.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $result = ClienteAdo::actualizarClientePredeterminado($body['idCliente']);
    if($result == "updated"){
        echo json_encode(array(
            "estado" => 1,
            "mensaje" => "Se realizó el cambio correctamente."
        ));
    }else{
        echo json_encode(array(
            "estado" => 2,
            "mensaje" => $result
        ));
    }
}


