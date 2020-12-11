<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ProductoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if (ProductoAdo::validateProductoId($body['idProducto'])) {
        $retorno = ProductoAdo::editProducto($body);
        if ($retorno == "updated") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el producto"));
        } else if ($retorno == "duplicate") {
            echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un producto con la misma clave"));
        } else if ($retorno == "duplicatename") {
            echo json_encode(array("estado" => 3, "mensaje" => "Ya existe un producto con el mismo nombre"));
        } else {
            echo json_encode(array("estado" => 4, "mensaje" => $retorno));
        }
    } else {
        $retorno = ProductoAdo::insertProducto($body);
        if ($retorno == "inserted") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el producto"));
        } else if ($retorno == "duplicate") {
            echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un producto con la misma clave"));
        } else if ($retorno == "duplicatename") {
            echo json_encode(array("estado" => 3, "mensaje" => "Ya existe un producto con el mismo nombre"));
        } else {
            echo json_encode(array("estado" => 4, "mensaje" => $retorno));
        }
    }
}

