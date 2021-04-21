<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    $result = ClienteAdo::actualizarHuella($body);
    if ($result == "updated") {
        echo json_encode(array("estado" => 1, "response" => "Se actualizó correctamente el huella."));
    } else   if ($result == "nocliente") {
        echo json_encode(array("estado" => 2, "response" => "El dni del cliente o personal no se encuentra registrado."));
    } else {
        echo json_encode(array("estado" => 0, "response" => $result));
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] == "listaclientes") {
        $result = ClienteAdo::obtenerHuellaClientes();
        if (is_array($result)) {
            echo json_encode(array("estado" => 1, "data" => $result));
        } else {
            echo json_encode(array("estado" => 2, "message" => $result));
        }
    } else if ($_GET["type"] == "listapersonal") {
        $result = ClienteAdo::obtenerHuellaEmpleados();
        if (is_array($result)) {
            echo json_encode(array("estado" => 1, "data" => $result));
        } else {
            echo json_encode(array("estado" => 2, "message" => $result));
        }
    } else  if ($_GET["type"] == "searchCliente") {
        $result = ClienteAdo::marcarEntredaSalida($_GET["idCliente"], $_GET["estado"], $_GET["persona"]);
        if ($result == "salida") {
            echo json_encode(array("estado" => 1, "message" => "Se marco su salida correctamente."));
        } else if ($result == "entrada") {
            echo json_encode(array("estado" => 2, "message" => "Se marco su ingreso correctamente."));
        } else {
            echo json_encode(array("estado" => 0, "message" => $result));
        }
    }
}
