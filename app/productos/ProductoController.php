<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ProductoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "lista") {
        $search = $_GET['datos'];
        $body = $_GET['page'];

        $productos = ProductoAdo::getAllProducto($search, ($body - 1) * 5, 5);
        if (is_array($productos)) {
            $datos["estado"] = 1;
            $datos["total"] = $productos[1];
            $datos["productos"] = $productos[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $productos
            ));
        }
    } else if ($_GET["type"] == "getbyid") {
        $producto = ProductoAdo::getProductoById($_GET["idProducto"]);
        if (is_object($producto)) {
            print json_encode(array(
                "estado" => 1,
                "producto" => $producto
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $producto
            ));
        }
    } else if ($_GET["type"] == "getregistro") {
        $result = ProductoAdo::getDataRegistroProducto();
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);

    if ($body["type"] == "crud") {
        $retorno = ProductoAdo::crudProducto($body);
        if ($retorno == "inserted") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el producto"));
        } else if ($retorno == "updated") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el producto"));
        } else if ($retorno == "duplicate") {
            echo json_encode(array("estado" => 3, "mensaje" => "Ya existe un producto con la misma clave"));
        } else if ($retorno == "duplicatename") {
            echo json_encode(array("estado" => 4, "mensaje" => "Ya existe un producto con el mismo nombre"));
        } else {
            echo json_encode(array("estado" => 0, "mensaje" => $retorno));
        }
    } else if ($body["type"] == "delete") {
        $retorno = ProductoAdo::deleteProducto($body);
        if ($retorno == "deleted") {
            print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente"));
        } elseif ($retorno == "registrado") {
            print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el producto porque está ligada a una venta"));
        } else {
            print json_encode(array("estado" => 3, "mensaje" => $retorno));
        }
    }
}
