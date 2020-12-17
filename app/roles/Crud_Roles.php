<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './RolAdo.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $body = json_decode(file_get_contents("php://input"), true);
    if (RolAdo::validateRolId($body['id'])) {

        if (RolAdo::validateRolNombreById($body['id'], $body['nombre'])) {
            $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un rol con el mismo nombre, no se pudo actualizar"));
            echo $json_string;
        } else {
            $retorno = RolAdo::edit($body); 
            if ($retorno == "updated") {
                $json_string = json_encode(array("estado" => 1, "mensaje" => "Se actualizó correctamente el rol"));
                echo $json_string;
            } else {
                $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                echo $json_string;
            }
        }

    } 
    else {

        if (RolAdo::validateRolNombre($body['nombre'])) {
            $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un rol con el mismo nombre, no se pudo agregar"));
            echo $json_string;
        } else {
            $retorno = RolAdo::insert($body);
            if ($retorno == "inserted") {
                $json_string = json_encode(array("estado" => 1, "mensaje" => "Se registró correctamente el rol"));
                echo $json_string;
            } else {
                $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                echo $json_string;
            }
        }

    }
}
