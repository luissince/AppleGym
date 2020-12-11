<?php

require '../database/DataBaseConexion.php';

class ContratoAdo {

    function __construct() {
        
    }

    public static function insertContrato($body) {
        $quey = "SELECT Fc_Contrato_Codigo_Almanumerico();";
        $contrato = "INSERT INTO contratotb ( " .
                "idContrato," .
                "idEmpleado," .
                "puesto," .
                "fechaInicio," .
                "fechaCulminacion," .
                "horario," .
                "periodo," .
                "sueldo," .
                "estado)" .
                "VALUES(?,?,?,?,?,?,?,?,?)";
        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoContrato = Database::getInstance()->getDb()->prepare($quey);
            $codigoContrato->execute();
            $idContrato = $codigoContrato->fetchColumn();

            $executeContrato = Database::getInstance()->getDb()->prepare($contrato);
            $executeContrato->execute(
                    array(
                        $idContrato,
                        $body['idEmpleado'],
                        $body['idPuesto'],
                        $body['fechaInicio'],
                        $body['fechaFin'],
                        $body['horario'],
                        $body['idPeriodoPago'],
                        $body['sueldo'],
                        true)
            );

            Database::getInstance()->getDb()->commit();
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function editContrato($body) {
        $comando = "UPDATE contratotb " .
                "SET puesto = ?," .
                " fechaInicio = ?," .
                " fechaCulminacion = ?," .
                " horario = ?," .
                " periodo = ?," .
                " sueldo = ?" .
                "WHERE idContrato = ? and idEmpleado = ?";
        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            $sentencia->execute(
                    array(
                        $body['idPuesto'],
                        $body['fechaInicio'],
                        $body['fechaFin'],
                        $body['horario'],
                        $body['idPeriodoPago'],
                        $body['sueldo'],
                        $body['idContrato'],
                        $body['idEmpleado']
                    )
            );

            Database::getInstance()->getDb()->commit();
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function getAllContratos($x, $y) {
        $consulta = "SELECT c.idContrato,c.idEmpleado,e.numeroDocumento,e.apellidos,e.nombres,c.fechaInicio,c.fechaCulminacion,systemagym.Fc_Obtener_Nombre_Periodo_Pago(c.periodo) as periodo,systemagym.Fc_Obtener_Nombre_Puesto(c.puesto) as puesto,c.sueldo
        FROM systemagym.contratotb as c INNER JOIN systemagym.empleadotb as e on c.idEmpleado = e.idEmpleado LIMIT $x,$y";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAllCountContratos() {
        $consulta = "SELECT COUNT(*) FROM contratotb ";
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

    public static function getSearchContratos($datos, $x, $y) {
        $consulta = "SELECT c.idContrato,c.idEmpleado,e.numeroDocumento,e.apellidos,e.nombres,c.fechaInicio,c.fechaCulminacion,systemagym.Fc_Obtener_Nombre_Periodo_Pago(c.periodo) as periodo,systemagym.Fc_Obtener_Nombre_Puesto(c.puesto) as puesto,c.sueldo
        FROM systemagym.contratotb as c INNER JOIN systemagym.empleadotb as e on c.idEmpleado = e.idEmpleado
        WHERE e.numeroDocumento LIKE ? OR e.apellidos LIKE ? OR e.nombres LIKE ? LIMIT ?,?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, $datos, PDO::PARAM_STR);
            $comando->bindValue(2, "$datos%", PDO::PARAM_STR);
            $comando->bindValue(3, "$datos%", PDO::PARAM_STR);
            $comando->bindValue(4, $x, PDO::PARAM_INT);
            $comando->bindValue(5, $y, PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function validateContratoId($idContrato) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idContrato FROM contratotb WHERE idContrato = ?");
        $validate->bindParam(1, $idContrato);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

}
