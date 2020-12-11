<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './ConfiguracionAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $body = json_decode(file_get_contents("php://input"), true);
    
    if (ConfiguracionAdo::validateIdEquals($body)) {
        if (ConfiguracionAdo::validateNameEquals($body)) {
            $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un item con el mismo nombre"));
            echo $json_string;
        } else {
            if (ConfiguracionAdo::editDataTable($body) == "updated") {
                $json_string = json_encode(array("estado" => 1, "mensaje" => "Creacion correcta"));
                echo $json_string;
            } else {
                $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                echo $json_string;
            }
        } 
    } else {
        if (ConfiguracionAdo::validateNameEquals($body)) {
            $json_string = json_encode(array("estado" => 3, "mensaje" => "Ya existe un item con el mismo nombre"));
            echo $json_string;
        } else {
            $retorno = ConfiguracionAdo::insertDataTable($body);
            if ($retorno == "inserted") {
                $json_string = json_encode(array("estado" => 1, "mensaje" => "Creacion correcta"));
                echo $json_string;
            } else {
                $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
                echo $json_string;
            }
        }
    }
}

