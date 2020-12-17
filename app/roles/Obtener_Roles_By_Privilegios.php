<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './RolAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idRol = $_GET['id'];

    $modulos = RolAdo::getAllModulos();
    // $privilegios = EmpleadoAdo::getPrivilegioEmpleadoById($idEmpleado);

    if (is_array($modulos)) {
        print json_encode(array(
            "estado" => 1,
            "modulos" => $modulos
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error "    
        ));
    }
    exit();
}
