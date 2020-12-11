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
        } catch (PDOException $e) {
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
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
