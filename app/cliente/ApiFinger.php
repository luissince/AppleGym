<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$body = json_decode(file_get_contents("php://input"), true);
    $json_string = json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el cliente"));
    echo $json_string;
}
