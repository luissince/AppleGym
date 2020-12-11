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
    
    $empleados = EmpleadoAdo::getEmpleadoForLogin($usuario, $clave);
    $empresa = EmpleadoAdo::getDatosEmpresa();
    $cliente = EmpleadoAdo::getDatosCliente();
    if (is_object($empleados)) {
        $datos["estado"] = 1;
        $datos["empleado"] = $empleados;
        $datos["empresa"] = $empresa;
        $datos["cliente"] = $cliente;
        session_start();
        $_SESSION["IdEmpleado"] = $empleados->idEmpleado;
        $_SESSION["Apellidos"] = $empleados->apellidos;
        $_SESSION["Nombres"] = $empleados->nombres;
        print json_encode($datos);
    } else if($empleados==false){
        print json_encode(array(
            "estado" => 2,
            "message" => "Usuario o contraseña incorrecto(a)"
        ));
    }else{
        print json_encode(array(
            "estado" => 0,
            "message" => $empleados
        ));
    }
    exit();
}

