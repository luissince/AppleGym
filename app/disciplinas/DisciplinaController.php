<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './DisciplinaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "lista") {
        $body = $_GET['page'];
        $search = $_GET['datos'];

        $disciplinas = DisciplinaAdo::getAllDisciplina($search, ($body - 1) * 10, 10);
        if (is_array($disciplinas)) {
            $datos["estado"] = 1;
            $datos["total"] = $disciplinas[1];
            $datos["disciplinas"] = $disciplinas[0];
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $disciplinas
            ));
        }
    }else if($_GET["type"] == "getbyid"){
        $disciplina = DisciplinaAdo::getDisciplinaById($_GET["idDisciplina"]);
        if (is_object($disciplina)) {
            $datos["estado"] = 1;
            $datos["disciplina"] = $disciplina;
            print json_encode($datos);
        } else {
            print json_encode(array(
                "estado" => 0,
                "mensaje" => $disciplina
            ));
        }
    }

} else if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    if ($body["type"] == "crud") {
        $retorno = DisciplinaAdo::crudDisciplina($body);
        if ($retorno == "inserted") {
            $json_string = json_encode(array("estado" => 1, "mensaje" => "Datos guardados correctamente."));
            echo $json_string;
        } else if ($retorno == "updated") {
            $json_string = json_encode(array("estado" => 1, "mensaje" => "Datos actualizos correctamente."));
            echo $json_string;
        } else {
            $json_string = json_encode(array("estado" => 2, "mensaje" => $retorno));
            echo $json_string;
        }
    } else if ($body["type"] == "delete") {
        $retorno = DisciplinaAdo::delete($body);
        if ($retorno == "deleted") {
            print json_encode(array("estado" => 1, "mensaje" => "Se eliminó correctamente."));
        } elseif ($retorno == "registrado") {
            print json_encode(array("estado" => 2, "mensaje" => "No se puede eliminar la disciplina porque está ligada a un plan."));
        } else {
            print json_encode(array("estado" => 0, "mensaje" => $retorno));
        }
    }
}
