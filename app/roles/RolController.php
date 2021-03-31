<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './RolAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "allData") {
        $search = $_GET['datos'];
        $page = $_GET['page'];

        $result = RolAdo::getAllRoles($search, ($page - 1) * 10, 10);
        if (is_array($result)) {
            $datos["estado"] = 1;
            $datos["total"] = $result[1];
            $datos["roles"] = $result[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $productos
            ));
        }
    } else if ($_GET["type"] == "data") {
        $idRol = $_GET['idRol'];
        $result = RolAdo::getRolById($idRol);
        if (is_object($result)) {
            print json_encode(array(
                "estado" => 1,
                "rol" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] == "permisobyidrol") {
        $idRol = $_GET['idRol'];
        $result = RolAdo::getPermisosByIdRol($idRol);
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "permisos" => $result
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
        $result = RolAdo::crudRol($body);
        if ($result == "inserted") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el rol"));
        } else if ($result == "updated") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el rol"));
        } else if ($result == "nameduplicate") {
            echo json_encode(array("estado" => 2, "mensaje" => "Hay un rol con el mismo nombre."));
        } else {
            echo json_encode(array("estado" => 0, "mensaje" => $result));
        }
    } else if ($body["type"] == "updateModulo") {
        $result = RolAdo::updateModulos($body["modulos"]);
        if ($result == "updated") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se actualizo correctamente los provilegios."));
        } else {
            echo json_encode(array("estado" => 0, "mensaje" => $result));
        }
    } else if ($body["type"] == "deleterol") {
        $result = RolAdo::deleteRol($body["idRol"]);
        if ($result == "deleted") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente el rol."));
        } else if ($result == "personal") {
            echo json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el rol, porque esta ligado a un personal."));
        } else {
            echo json_encode(array("estado" => 0, "mensaje" => $result));
        }
    }
}
