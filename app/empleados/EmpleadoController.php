<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './EmpleadoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "lista") {
        $body = $_GET['page'];
        $text = $_GET['datos'];

        $empleados = EmpleadoAdo::getAllEmpleado($text, ($body - 1) * 10, 10);
        if (is_array($empleados)) {
            $datos["estado"] = 1;
            $datos["total"] = $empleados[1];
            $datos["empleados"] = $empleados[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error"
            ));
        }
    } else if ($_GET["type"] == "getbyid") {
        $empleados = EmpleadoAdo::getEmpleadoById($_GET["idEmpleado"]);
        if (is_object($empleados)) {
            $datos["estado"] = 1;
            $datos["empleados"] = $empleados;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error"
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);

    if ($body["type"] == "crud") {
        if (EmpleadoAdo::validateEmpleadoId($body['idEmpleado'])) {
            if (EmpleadoAdo::validateEmpledoNumeroDocumentoById($body['idEmpleado'], $body['numeroDocumento'])) {
                echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un empleado con el mismo número de documento"));
            } else {
                $retorno = EmpleadoAdo::editEmpleado($body);
                if ($retorno == "updated") {
                    echo json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el empleado"));
                } else {
                    echo json_encode(array("estado" => 3, "mensaje" => $retorno));
                }
            }
        } else {
            if (EmpleadoAdo::validateEmpleadoNumeroDocumento($body['numeroDocumento'])) {
                echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un empleado con el mismo número de documento"));
            } else {
                $retorno = EmpleadoAdo::insertEmpleado($body);
                if ($retorno == "inserted") {
                    echo json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el empleado"));
                } else {
                    echo json_encode(array("estado" => 3, "mensaje" => $retorno));
                }
            }
        }
    }
}
