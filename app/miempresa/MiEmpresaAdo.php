<?php

require '../database/DataBaseConexion.php';

class MiEmpresaAdo {

    function __construct() {
        
    }

    public static function registrar($body) {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("INSERT INTO mi_empresatb(representante,nombreEmpresa,ruc,telefono,celular,email,paginaWeb,direccion,terminos)VALUES(?,?,?,?,?,?,?,?,?)");
            $comando->execute(array(
                $body['representante'],
                $body['nombreEmpresa'],
                $body['ruc'],
                $body['telefono'],
                $body['celular'],
                $body['email'],
                $body['paginaWeb'],
                $body['direccion'],
                $body['terminos']
            ));
            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function actualizar($body) {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE mi_empresatb SET representante = ?,nombreEmpresa = ?,ruc = ?,telefono = ?,celular = ?,email = ?,paginaWeb = ?,direccion = ?,terminos = ? WHERE idMiEmpresa = ?");
            $comando->execute(array(
                $body['representante'],
                $body['nombreEmpresa'],
                $body['ruc'],
                $body['telefono'],
                $body['celular'],
                $body['email'],
                $body['paginaWeb'],
                $body['direccion'],
                $body['terminos'],
                $body['idMiEmpresa']
            ));
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function validate() {
        $consulta = "SELECT COUNT(*) FROM mi_empresatb";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getMiEmpresa() {
        $consulta = "SELECT * FROM  mi_empresatb";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            $array = array();
            while ($row = $comando->fetch()) {
                array_push($array, array(
                    "idMiEmpresa" => $row["idMiEmpresa"],
                    "representante" => $row["representante"],
                    "nombreEmpresa" => $row["nombreEmpresa"],
                    "ruc" => $row["ruc"],
                    "telefono" => $row["telefono"],
                    "celular" => $row["celular"],
                    "email" => $row["email"],
                    "paginaWeb" => $row["paginaWeb"],
                    "direccion" => $row["direccion"],
                    "terminos" => $row["terminos"]
                ));
            }
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function ListarDashboard(){
        try{
            $array = array();

            $cmdClientes = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM  clientetb");
            $cmdClientes->execute();
            $resultCliente =  $cmdClientes->fetchColumn();

            $cmdIngresos = Database::getInstance()->getDb()->prepare("SELECT SUM(monto) FROM  ingresotb WHERE fecha = CURDATE()");
            $cmdIngresos->execute();
            $resultIngresos = $cmdIngresos->fetchColumn();

            $cmdMembresias = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM  membresiatb WHERE CAST(DATEDIFF(fechaFin,CURDATE()) AS int) >=0 AND CAST(DATEDIFF(fechaFin,CURDATE()) AS int) <=10");
            $cmdMembresias->execute();
            $resultMembresias = $cmdMembresias->fetchColumn();

            $cmdCuentasPorCobrar = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM  ventacreditotb WHERE estado = 0");
            $cmdCuentasPorCobrar->execute();
            $resultCuentasPorCobrar = $cmdCuentasPorCobrar->fetchColumn();

            array_push($array,$resultCliente,$resultIngresos,$resultMembresias,$resultCuentasPorCobrar);

            return $array;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }

}
