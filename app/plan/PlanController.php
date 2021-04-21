<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
require './PlanAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] == "lista") {
        $page = $_GET['page'];
        $search = $_GET["datos"];
        $planes = PlanAdo::getAllPlanes($search, ($page - 1) * 10, 10);
        if (is_array($planes)) {
            $datos["estado"] = 1;
            $datos["total"] = $planes[1];
            $datos["planes"] = $planes[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $planes
            ));
        }
    } else if ($_GET["type"] == "listaplanlibre") {
        $resultLibre = PlanAdo::getAllDatosForSelectLibre();
        $result = PlanAdo::getAllDatosForSelect();
        if (is_array($resultLibre) && is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "planesLibre" => $resultLibre,
                "planesNormales" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] == "getbyid") {
        $result = PlanAdo::getPlanById($_GET["idPlan"]);
        if (is_array($result)) {
            $datos["estado"] = 1;
            $datos["planes"] = $result[0];
            $datos["disciplinas"] = $result[1];
            print json_encode($datos);
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
        $retorno = PlanAdo::insertPlan($body);
        if ($retorno == "inserted") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el plan."));
        } else if ($retorno == "updated") {
            echo json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el plan."));
        } else  if ($retorno == "name") {
            echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un plan con el mismo nombre."));
        } else if ($retorno == "membresia") {
            echo json_encode(array("estado" => 3, "mensaje" => "No se puede actualizar el plan por esta ligado a una membresía."));
        } else {
            echo json_encode(array("estado" => 0, "mensaje" => $retorno));
        }
    } else  if ($body["type"] == "deleted") {
        $retorno = PlanAdo::deletePlan($body);
        if ($retorno == "deleted") {
            print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente."));
        } elseif ($retorno == "registrado") {
            print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar el plan porque está ligada a una membresia."));
        } else {
            print json_encode(array("estado" => 3, "mensaje" => $retorno));
        }
    }
}
