<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ProductoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = ProductoAdo::deleteProducto($body);
    if ($retorno == "deleted") {
        print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente"));
    } elseif ($retorno == "registrado") {
        print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el producto porque está ligada a una venta"));
    } else {
        print json_encode(array("estado" => 3, "mensaje" => $retorno));
    }
}

