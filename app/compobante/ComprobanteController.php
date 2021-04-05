<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ComprobanteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "lista") {
        $page = $_GET['page'];
        $search = $_GET['datos'];
        $result = ComprobanteAdo::getAllComprobantes($search, ($page - 1) * 10, 10);
        if (is_array($result)) {
            $datos["estado"] = 1;
            $datos["total"] = $result[1];
            $datos["comprobantes"] = $result[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] == "getbyid") {
        $result = ComprobanteAdo::getByIdComprobante($_GET["idComprobante"]);
        if (is_object($result)) {
            print json_encode(array(
                "estado" => 1,
                "comprobante" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if ($body["type"] == "crud") {
        $result = ComprobanteAdo::crudComprobante($body);
        if ($result == "inserted") {
            print json_encode(array(
                "estado" => 1,
                "mensaje" => "Se registró correctamente el comprobante."
            ));
        } else if ($result == "updated") {
            print json_encode(array(
                "estado" => 1,
                "mensaje" => "Se actualizó correctamente el comprobante."
            ));
        } else if ($result == "name") {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ya existe un comprobante con el mismo nombre."
            ));
        } else if ($result == "serie") {
            print json_encode(array(
                "estado" => 3,
                "mensaje" => "Ya existe un comprobante con la misma serie."
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    } else if ($body["type"] == "delete") {
        $result = ComprobanteAdo::deleteComprobante($body["idTipoComprobante"]);
        if ($result == "deleted") {
            print json_encode(array(
                "estado" => 1,
                "mensaje" => "Se eliminó correctamente el comprobante."
            ));
        } else if ($result == "venta") {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "No se puede eliminar el comprobante porque esta ligado a una venta."
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    }
}
