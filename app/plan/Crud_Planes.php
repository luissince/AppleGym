<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require './PlanAdo.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if (PlanAdo::validatePlanId($body['idPlan'])) {
        if (PlanAdo::validatePlanNameById($body['idPlan'], $body['nombre'])) {
            echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un plan con el mismo nombre"));
        } else {
            if (PlanAdo::editPlan($body) == "updated") {
                echo json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el plan"));
            } else {
                echo json_encode(array("estado" => 3, "mensaje" => $retorno));
            }
        }
    } else {
        if (PlanAdo::validatePlanName($body['nombre'])) {
            echo json_encode(array("estado" => 2, "mensaje" => "Ya existe un plan con el mismo nombre"));
        } else {
            $retorno = PlanAdo::insertPlan($body);
            if ($retorno == "inserted") {
                echo json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el plan"));
            } else {
                echo json_encode(array("estado" => 3, "mensaje" => $retorno));
            }
        }
    }
}
