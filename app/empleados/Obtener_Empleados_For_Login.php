<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './EmpleadoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    $usuario = $_GET['usuario'];
    $clave = $_GET['clave'];

    $result = EmpleadoAdo::getEmpleadoForLogin($usuario, $clave);
    if (is_array($result)) {
        $empleados = $result[0];
        $roles =  $result[1];
        $datos["estado"] = 1;
        $datos["empleado"] = $empleados;
        $datos["roles"] = $roles;
        session_start();
        $_SESSION["IdEmpleado"] = $empleados->idEmpleado;
        $_SESSION["Apellidos"] = $empleados->apellidos;
        $_SESSION["Nombres"] = $empleados->nombres;
        $_SESSION["Roles"] = $roles;
        print json_encode($datos);
    } else if ($result == "nouser") {
        print json_encode(array(
            "estado" => 2,
            "message" => "Usuario incorrecto."
        ));
    } else if ($result == "nopassword") {
        print json_encode(array(
            "estado" => 3,
            "message" => "Contraseña incorrecta."
        ));
    }else if ($result == "nostate") {
        print json_encode(array(
            "estado" => 4,
            "message" => "Su usuario se encuentra en un estado inactivo."
        ));
    }
     else {
        print json_encode(array(
            "estado" => 0,
            "message" => $result
        ));
    }
    exit();
}
