<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $result = ClienteAdo::actualizarHuella($body);
    echo json_encode(array("estado" => 1, "response" => $result));
}else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $result = ClienteAdo::obtenerHuella();
    if(is_array($result)){
        echo json_encode(array("estado" => 1, "data" => $result));
    }else{
        echo json_encode(array("estado" => 2, "message" => $result));
    }
    
} 