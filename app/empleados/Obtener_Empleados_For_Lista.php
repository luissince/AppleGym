<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require './EmpleadoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $opcion = $_GET['opcion'];
    $empleados = $opcion == 1 ? EmpleadoAdo::getEmpleadosForLista():EmpleadoAdo::getContratoById($_GET['idContrato']);
    $puestos = EmpleadoAdo::getPuestoForLista();
    $peridoPagos = EmpleadoAdo::getPeridoPagoForLista();
    if (is_array($empleados) && $puestos && $peridoPagos) {
        echo json_encode(array(
            "estado" => 1,
            "empleados" => $empleados,
            "puesto" => $puestos,
            "periodoPago" => $peridoPagos
        ));
    } else {
        echo json_encode(array(
            "estado" => 2,
            "error empleados" => $empleados,
            "error puesto" => $puestos,
            "error periodo pago" => $peridoPagos
         ));
    }
}
