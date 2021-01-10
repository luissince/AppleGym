<?php

require '../database/DataBaseConexion.php';

class AsistenciaAdo
{

    function __construct()
    {
    }

    public static function insertAsistencia($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $codigoAsistencia = Database::getInstance()->getDb()->prepare("SELECT Fc_Asistencia_Codigo_Almanumerico();");
            $codigoAsistencia->execute();
            $idAsistencia = $codigoAsistencia->fetchColumn();

            $executeAsistencia = Database::getInstance()->getDb()->prepare("INSERT INTO asistenciatb ( " .
            "idAsistencia," .
            "fechaApertura," .
            "fechaCierre," .
            "horaApertura," .
            "horaCierre," .
            "estado," .
            "idPersona," .
            "tipoPersona)" .
            " VALUES(?,?,?,?,?,?,?,?)");
            $executeAsistencia->execute(
                array(
                    $idAsistencia,
                    $body['fechaApertura'],
                    $body['fechaCierre'],
                    $body['horaApertura'],
                    $body['horaCierre'],
                    $body['estado'],
                    $body['idPersona'],
                    $body['tipoPersona']
                )
            );

            Database::getInstance()->getDb()->commit();
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function editAsistencia($body)
    {

        $comando = "UPDATE asistenciatb " .
            "SET fechaCierre = ?," .
            " horaCierre = ?," .
            " estado = ?" .
            "WHERE idAsistencia = ?";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            $sentencia->execute(
                array(
                    $body['fechaCierre'],
                    $body['horaCierre'],
                    $body['estado'],
                    $body['idAsistencia']
                )
            );


            Database::getInstance()->getDb()->commit();
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function getAllAsistencia($idPersona)
    {
        $consulta = "SELECT * FROM asistenciatb WHERE idPersona = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, $idPersona, PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public static function getAllCountAsistencia()
    {
        $consulta = "SELECT COUNT(*) FROM asistenciatb";
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

    public static function getAsistenciaByIdPersona($idPersona)
    {
        try {
            // Preparar sentencia
            $comandoUno = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? and estado = 1");
            $comandoUno->bindValue(1, $idPersona, PDO::PARAM_STR);
            // Ejecutar sentencia preparada        
            $comandoUno->execute();
            if ($comandoUno->fetch()) {
                return "1";
            } else {
                return "0";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAsistenciaByIdPersonaDos($idPersona)
    {
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? and estado = 1 and fechaApertura  = CURDATE()");
            $comando->bindValue(1, $idPersona, PDO::PARAM_STR);
            $comando->execute();
            $validate = $comando->fetchObject();
            if ($validate) {
                return array("estado" => "2", "mensaje" => $validate);
            } else {
                return array("estado" => "3", "mensaje" => "Tiene un turno aperturado");
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function ReporteListaAsistenciaClienteFechas($fechaInicio, $fechaFinal)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            c.dni,
            c.apellidos,
            c.nombres,
            a.fechaApertura,
            a.horaApertura,
            a.fechaCierre,
            a.horaCierre
            FROM clientetb AS c INNER JOIN asistenciatb as a 
            ON a.idPersona = c.idCliente 
            WHERE fechaApertura BETWEEN ? AND ? AND tipoPersona = 1
            ORDER BY c.apellidos ASC, c.nombres ASC");
            $comando->bindValue(1, $fechaInicio, PDO::PARAM_STR);
            $comando->bindValue(2, $fechaFinal, PDO::PARAM_STR);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["dni"],
                    "cliente" => $row["apellidos"] . ' ' . $row["nombres"],
                    "fechaEntrada" => $row["fechaApertura"],
                    "horaEntrada" => $row["horaApertura"],
                    "fechaSalida" => $row["fechaCierre"],
                    "horaSalida" => $row["horaCierre"]
                ));
            }
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public static function ReporteListaAsistenciaEmpleadosFechas($fechaInicio, $fechaFinal)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            c.numeroDocumento,
            c.apellidos,
            c.nombres,
            a.fechaApertura,
            a.horaApertura,
            a.fechaCierre,
            a.horaCierre
            FROM empleadotb AS c INNER JOIN asistenciatb as a 
            ON a.idPersona = c.idEmpleado  
            WHERE fechaApertura BETWEEN ? AND ? AND tipoPersona = 2
            ORDER BY c.apellidos ASC, c.nombres ASC");
            $comando->bindValue(1, $fechaInicio, PDO::PARAM_STR);
            $comando->bindValue(2, $fechaFinal, PDO::PARAM_STR);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["numeroDocumento"],
                    "personal" => $row["apellidos"] . ' ' . $row["nombres"],
                    "fechaEntrada" => $row["fechaApertura"],
                    "horaEntrada" => $row["horaApertura"],
                    "fechaSalida" => $row["fechaCierre"],
                    "horaSalida" => $row["horaCierre"]
                ));
            }
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public static function ListaAsistencia($fechaInicio, $fechaFinal)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            c.numeroDocumento,
            c.apellidos,
            c.nombres,
            a.fechaApertura,
            a.horaApertura,
            a.fechaCierre,
            a.horaCierre
            FROM empleadotb AS c INNER JOIN asistenciatb as a 
            ON a.idPersona = c.idEmpleado  
            WHERE fechaApertura BETWEEN ? AND ? AND tipoPersona = 2
            ORDER BY c.apellidos ASC, c.nombres ASC");
            $comando->bindValue(1, $fechaInicio, PDO::PARAM_STR);
            $comando->bindValue(2, $fechaFinal, PDO::PARAM_STR);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["numeroDocumento"],
                    "personal" => $row["apellidos"] . ' ' . $row["nombres"],
                    "fechaEntrada" => $row["fechaApertura"],
                    "horaEntrada" => $row["horaApertura"],
                    "fechaSalida" => $row["fechaCierre"],
                    "horaSalida" => $row["horaCierre"]
                ));
            }
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function ListarAsistenciaClientesPorMes($month, $year)
    {
        try {
            $array = array();
            $cmdLista = Database::getInstance()->getDb()->prepare("SELECT  
            c.dni,
            c.apellidos,
            c.nombres,
            a.fechaApertura
            FROM clientetb AS c INNER JOIN asistenciatb as a 
            ON a.idPersona = c.idCliente  
            WHERE MONTH(a.fechaApertura) = $month AND YEAR(a.fechaApertura) = $year");
            $cmdLista->execute();

            $count = 0;
            while ($row = $cmdLista->fetch()) {
                $count++;
                $date = new DateTime($row["fechaApertura"]);
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["dni"],
                    "cliente" => $row["apellidos"] . ' ' . $row["nombres"],
                    "dia" => $date->format("d")
                ));
            }

            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function ListarAsistenciaEmpleadosPorMes($month, $year)
    {
        try {
            $array = array();
            $cmdLista = Database::getInstance()->getDb()->prepare("SELECT  
            c.numeroDocumento,
            c.apellidos,
            c.nombres,
            a.fechaApertura
            FROM empleadotb AS c INNER JOIN asistenciatb as a 
            ON a.idPersona = c.idEmpleado   
            WHERE MONTH(a.fechaApertura) = $month AND YEAR(a.fechaApertura) = $year");
            $cmdLista->execute();

            $count = 0;
            while ($row = $cmdLista->fetch()) {
                $count++;
                $date = new DateTime($row["fechaApertura"]);
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["numeroDocumento"],
                    "cliente" => $row["apellidos"] . ' ' . $row["nombres"],
                    "dia" => $date->format("d")
                ));
            }

            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
