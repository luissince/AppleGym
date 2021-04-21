<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './MembresiaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    if ($_GET['type'] == "lista") {
        $pagina = $_GET['page'];
        $opcion = $_GET['opcion'];
        $search = $_GET['search'];
        $membresia = $_GET['membresia'];
        $membresias = MembresiaAdo::listarMembresias($opcion, $search, intval($membresia), ($pagina - 1) * 10, 10);
        if (is_array($membresias)) {
            $datos["estado"] = 1;
            $datos["membresias"] = $membresias[0];
            $datos["total"] = $membresias[1];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $membresias
            ));
        }
    } else if ($_GET["type"] == "getbyid") {
        $result = MembresiaAdo::GetByIdMembresia($_GET["idMembresia"]);
        if (is_object($result)) {
            print json_encode(array(
                "estado" => 1,
                "membresia" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] == "getlismem") {
        $membresias = MembresiaAdo::getAllMembresiasPorCliente($_GET['idCliente'], ($_GET['page'] - 1) * 10, 10);
        if (is_array($membresias)) {
            $datos["estado"] = 1;
            $datos["total"] = $membresias[1];
            $datos["membresias"] = $membresias[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $membresias
            ));
        }
    } else if ($_GET["type"] == "listahistorialdetalle") {
        $result = MembresiaAdo::GetByIdHistorialMembresia($_GET["idMembresia"]);
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "historial" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] == "getmembycliente") {
        $result = MembresiaAdo::getMembresiaClienteRenovacion($_GET["idCliente"]);
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "membresias" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    }

    exit();
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if ($body["type"] == "updateAjusteFecha") {
        $result = MembresiaAdo::AjustarMembresiaFecha($body);
        if ($result == "updated") {
            print json_encode(array(
                "estado" => 1,
                "mensaje" => "Se actualizó correctamente la membresia."
            ));
        } else if ($result == "inactivo") {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "La membresia esta inactiva no puedes hacer cambios."
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else  if ($body["type"] == "updateAjusteFreeze") {
        $result = MembresiaAdo::AjustarMembresiaFreeze($body);
        if ($result == "updated") {
            print json_encode(array(
                "estado" => 1,
                "mensaje" => "Se actualizó correctamente la membresia."
            ));
        } else if ($result == "inactivo") {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "La membresia esta inactiva no puedes hacer cambios."
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    }
}
