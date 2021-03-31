<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './ClienteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "lista") {
        $page = $_GET['page'];
        $search = $_GET['datos'];
        $clientes = ClienteAdo::getAllDatos($search, ($page - 1) * 10, 10);
        if (is_array($clientes)) {
            $datos["estado"] = 1;
            $datos["total"] = $clientes[1];
            $datos["clientes"] = $clientes[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $clientes
            ));
        }
    } else if ($_GET["type"] == "listatraspaso") {
        $clientes = ClienteAdo::getClientesTraspaso($_GET["idCliente"]);
        if (is_array($clientes)) {
            $datos["estado"] = 1;
            // $datos["total"] = $clientes[1];
            $datos["clientes"] = $clientes[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $clientes
            ));
        }
    } else if ($_GET["type"] == "listatraspasomem") {
        $dni = $_GET['dni'];
        $idCliente = $_GET["idCliente"];
        $data = ClienteAdo::getDataCLientesTraspaso($dni,$idCliente);
        if (is_array($data)) {
            $result["estado"] = 1;
            $result["traspasos"] = $data[0];
            $result["membresias"] = $data[1];
            print json_encode($result);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $data
            ));
        }
    }else if($_GET["type"] == "climem"){
        $cliente = ClienteAdo::getMembresiaMarcarAsistencia($_GET["buscar"]);
        if (is_array($cliente)) {
            print json_encode(array(
                "estado" => 1,
                "cliente" => $cliente[0],
                "membresias" => $cliente[1],
                "asistencia" => $cliente[2]
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $cliente
            ));
        }
    }
    exit();
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if ($body["type"] == "crud") {

        if (ClienteAdo::validateClienteId($body['idCliente'])) {
            if (ClienteAdo::validateClienteDniById($body['idCliente'], $body['dni'])) {
                $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un cliente con el mismo dni 1"));
                echo $json_string;
            } else {
                if (ClienteAdo::edit($body) == "updated") {
                    $json_string = json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el cliente"));
                    echo $json_string;
                } else {
                    $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                    echo $json_string;
                }
            }
        } else {
            if (ClienteAdo::validateClienteDni($body['dni'])) {
                $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un cliente con el mismo dni"));
                echo $json_string;
            } else {
                $retorno = ClienteAdo::insert($body);
                if ($retorno == "inserted") {
                    $json_string = json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el cliente!!"));
                    echo $json_string;
                } else {
                    $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                    echo $json_string;
                }
            }
        }
    } else if ($body["type"] == "deleted") {
        $retorno = ClienteAdo::deleteCliente($body);
        if ($retorno == "deleted") {
            print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente el cliente."));
        } elseif ($retorno == "asistencia") {
            print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el cliente porque tiene un historial de asistencias."));
        } else if ($retorno == "membresia") {
            print json_encode(array("estado" => 3, "mensaje" => "No se puede eliminar el cliente porque tiene un historial de ventas."));
        } else {
            print json_encode(array("estado" => 4, "mensaje" => $retorno));
        }
    } else if ($body["type"] == "byid") {
        $alumnos = ClienteAdo::getClientById($body);
        if (is_object($alumnos)) {
            print json_encode(array(
                "estado" => 1,
                "cliente" => $alumnos
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "Ha ocurrido un error"
            ));
        }
    }
}
