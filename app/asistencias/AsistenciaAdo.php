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

        $comando = "UPDATE asistenciatb 
            SET fechaCierre = ?,
            horaCierre = ?,
            estado = ?
            WHERE idAsistencia = ?";

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
            ORDER BY a.fechaApertura DESC, a.horaApertura ASC");
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
            a.horaCierre,
            a.estado
            FROM empleadotb AS c INNER JOIN asistenciatb as a 
            ON a.idPersona = c.idEmpleado  
            WHERE fechaApertura BETWEEN ? AND ? AND tipoPersona = 2
            ORDER BY a.fechaApertura ASC, a.horaApertura ASC");
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
                    "horaSalida" => $row["horaCierre"],
                    "estado" => $row["estado"]
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
            a.idPersona,
            c.dni,
            c.apellidos,
            c.nombres,
            MAX(CASE WHEN day(fechaApertura) = 1 THEN 1 ELSE 0 END) AS '1',
            MAX(CASE WHEN day(fechaApertura) = 2 THEN 2 ELSE 0 END) AS '2',
            MAX(CASE WHEN day(fechaApertura) = 3 THEN 3 ELSE 0 END) AS '3',
            MAX(CASE WHEN day(fechaApertura) = 4 THEN 4 ELSE 0 END) AS '4',
            MAX(CASE WHEN day(fechaApertura) = 5 THEN 5 ELSE 0 END) AS '5',
            MAX(CASE WHEN day(fechaApertura) = 6 THEN 6 ELSE 0 END) AS '6',
            MAX(CASE WHEN day(fechaApertura) = 7 THEN 7 ELSE 0 END) AS '7',
            MAX(CASE WHEN day(fechaApertura) = 8 THEN 8 ELSE 0 END) AS '8',
            MAX(CASE WHEN day(fechaApertura) = 9 THEN 9 ELSE 0 END) AS '9',
            MAX(CASE WHEN day(fechaApertura) = 10 THEN 10 ELSE 0 END) AS '10',
            MAX(CASE WHEN day(fechaApertura) = 11 THEN 11 ELSE 0 END) AS '11',
            MAX(CASE WHEN day(fechaApertura) = 12 THEN 12 ELSE 0 END) AS '12',
            MAX(CASE WHEN day(fechaApertura) = 13 THEN 13 ELSE 0 END) AS '13',
            MAX(CASE WHEN day(fechaApertura) = 14 THEN 14 ELSE 0 END) AS '14',
            MAX(CASE WHEN day(fechaApertura) = 15 THEN 15 ELSE 0 END) AS '15',
            MAX(CASE WHEN day(fechaApertura) = 16 THEN 16 ELSE 0 END) AS '16',
            MAX(CASE WHEN day(fechaApertura) = 17 THEN 17 ELSE 0 END) AS '17',
            MAX(CASE WHEN day(fechaApertura) = 18 THEN 18 ELSE 0 END) AS '18',
            MAX(CASE WHEN day(fechaApertura) = 19 THEN 19 ELSE 0 END) AS '19',
            MAX(CASE WHEN day(fechaApertura) = 20 THEN 20 ELSE 0 END) AS '20',
            MAX(CASE WHEN day(fechaApertura) = 21 THEN 21 ELSE 0 END) AS '21',
            MAX(CASE WHEN day(fechaApertura) = 22 THEN 22 ELSE 0 END) AS '22',
            MAX(CASE WHEN day(fechaApertura) = 23 THEN 23 ELSE 0 END) AS '23',
            MAX(CASE WHEN day(fechaApertura) = 24 THEN 24 ELSE 0 END) AS '24',
            MAX(CASE WHEN day(fechaApertura) = 26 THEN 25 ELSE 0 END) AS '25',
            MAX(CASE WHEN day(fechaApertura) = 26 THEN 26 ELSE 0 END) AS '26',
            MAX(CASE WHEN day(fechaApertura) = 27 THEN 27 ELSE 0 END) AS '27',
            MAX(CASE WHEN day(fechaApertura) = 28 THEN 28 ELSE 0 END) AS '28',
            MAX(CASE WHEN day(fechaApertura) = 29 THEN 29 ELSE 0 END) AS '29',
            MAX(CASE WHEN day(fechaApertura) = 30 THEN 30 ELSE 0 END) AS '30',
            MAX(CASE WHEN day(fechaApertura) = 31 THEN 31 ELSE 0 END) AS '31'
            FROM asistenciatb AS a INNER JOIN clientetb AS c ON  c.idCliente = a.idPersona
            WHERE MONTH(a.fechaApertura) = $month AND YEAR(a.fechaApertura) = $year
           GROUP BY idPersona");
            $cmdLista->execute();

            $count = 0;
            while ($row = $cmdLista->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["dni"],
                    "cliente" => $row["apellidos"] . ' ' . $row["nombres"],
                    "dia1" => $row["1"],
                    "dia2" => $row["2"],
                    "dia3" => $row["3"],
                    "dia4" => $row["4"],
                    "dia5" => $row["5"],
                    "dia6" => $row["6"],
                    "dia7" => $row["7"],
                    "dia8" => $row["8"],
                    "dia9" => $row["9"],
                    "dia10" => $row["10"],
                    "dia11" => $row["11"],
                    "dia12" => $row["12"],
                    "dia13" => $row["13"],
                    "dia14" => $row["14"],
                    "dia15" => $row["15"],
                    "dia16" => $row["16"],
                    "dia17" => $row["17"],
                    "dia18" => $row["18"],
                    "dia19" => $row["19"],
                    "dia20" => $row["20"],
                    "dia21" => $row["21"],
                    "dia22" => $row["22"],
                    "dia23" => $row["23"],
                    "dia24" => $row["24"],
                    "dia25" => $row["25"],
                    "dia26" => $row["26"],
                    "dia27" => $row["27"],
                    "dia28" => $row["28"],
                    "dia29" => $row["29"],
                    "dia30" => $row["30"],
                    "dia31" => $row["31"],
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
            a.idPersona,
            c.numeroDocumento,
            c.apellidos,
            c.nombres,
            MAX(CASE WHEN day(fechaApertura) = 1 THEN 1 ELSE 0 END) AS '1',
            MAX(CASE WHEN day(fechaApertura) = 2 THEN 2 ELSE 0 END) AS '2',
            MAX(CASE WHEN day(fechaApertura) = 3 THEN 3 ELSE 0 END) AS '3',
            MAX(CASE WHEN day(fechaApertura) = 4 THEN 4 ELSE 0 END) AS '4',
            MAX(CASE WHEN day(fechaApertura) = 5 THEN 5 ELSE 0 END) AS '5',
            MAX(CASE WHEN day(fechaApertura) = 6 THEN 6 ELSE 0 END) AS '6',
            MAX(CASE WHEN day(fechaApertura) = 7 THEN 7 ELSE 0 END) AS '7',
            MAX(CASE WHEN day(fechaApertura) = 8 THEN 8 ELSE 0 END) AS '8',
            MAX(CASE WHEN day(fechaApertura) = 9 THEN 9 ELSE 0 END) AS '9',
            MAX(CASE WHEN day(fechaApertura) = 10 THEN 10 ELSE 0 END) AS '10',
            MAX(CASE WHEN day(fechaApertura) = 11 THEN 11 ELSE 0 END) AS '11',
            MAX(CASE WHEN day(fechaApertura) = 12 THEN 12 ELSE 0 END) AS '12',
            MAX(CASE WHEN day(fechaApertura) = 13 THEN 13 ELSE 0 END) AS '13',
            MAX(CASE WHEN day(fechaApertura) = 14 THEN 14 ELSE 0 END) AS '14',
            MAX(CASE WHEN day(fechaApertura) = 15 THEN 15 ELSE 0 END) AS '15',
            MAX(CASE WHEN day(fechaApertura) = 16 THEN 16 ELSE 0 END) AS '16',
            MAX(CASE WHEN day(fechaApertura) = 17 THEN 17 ELSE 0 END) AS '17',
            MAX(CASE WHEN day(fechaApertura) = 18 THEN 18 ELSE 0 END) AS '18',
            MAX(CASE WHEN day(fechaApertura) = 19 THEN 19 ELSE 0 END) AS '19',
            MAX(CASE WHEN day(fechaApertura) = 20 THEN 20 ELSE 0 END) AS '20',
            MAX(CASE WHEN day(fechaApertura) = 21 THEN 21 ELSE 0 END) AS '21',
            MAX(CASE WHEN day(fechaApertura) = 22 THEN 22 ELSE 0 END) AS '22',
            MAX(CASE WHEN day(fechaApertura) = 23 THEN 23 ELSE 0 END) AS '23',
            MAX(CASE WHEN day(fechaApertura) = 24 THEN 24 ELSE 0 END) AS '24',
            MAX(CASE WHEN day(fechaApertura) = 26 THEN 25 ELSE 0 END) AS '25',
            MAX(CASE WHEN day(fechaApertura) = 26 THEN 26 ELSE 0 END) AS '26',
            MAX(CASE WHEN day(fechaApertura) = 27 THEN 27 ELSE 0 END) AS '27',
            MAX(CASE WHEN day(fechaApertura) = 28 THEN 28 ELSE 0 END) AS '28',
            MAX(CASE WHEN day(fechaApertura) = 29 THEN 29 ELSE 0 END) AS '29',
            MAX(CASE WHEN day(fechaApertura) = 30 THEN 30 ELSE 0 END) AS '30',
            MAX(CASE WHEN day(fechaApertura) = 31 THEN 31 ELSE 0 END) AS '31'
            FROM asistenciatb AS a INNER JOIN empleadotb AS c ON  c.idEmpleado = a.idPersona
            WHERE MONTH(a.fechaApertura) = $month AND YEAR(a.fechaApertura) = $year
            GROUP BY idPersona");
            $cmdLista->execute();

            $count = 0;
            while ($row = $cmdLista->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "dni" => $row["numeroDocumento"],
                    "cliente" => $row["apellidos"] . ' ' . $row["nombres"],
                    "dia1" => $row["1"],
                    "dia2" => $row["2"],
                    "dia3" => $row["3"],
                    "dia4" => $row["4"],
                    "dia5" => $row["5"],
                    "dia6" => $row["6"],
                    "dia7" => $row["7"],
                    "dia8" => $row["8"],
                    "dia9" => $row["9"],
                    "dia10" => $row["10"],
                    "dia11" => $row["11"],
                    "dia12" => $row["12"],
                    "dia13" => $row["13"],
                    "dia14" => $row["14"],
                    "dia15" => $row["15"],
                    "dia16" => $row["16"],
                    "dia17" => $row["17"],
                    "dia18" => $row["18"],
                    "dia19" => $row["19"],
                    "dia20" => $row["20"],
                    "dia21" => $row["21"],
                    "dia22" => $row["22"],
                    "dia23" => $row["23"],
                    "dia24" => $row["24"],
                    "dia25" => $row["25"],
                    "dia26" => $row["26"],
                    "dia27" => $row["27"],
                    "dia28" => $row["28"],
                    "dia29" => $row["29"],
                    "dia30" => $row["30"],
                    "dia31" => $row["31"],
                ));
            }

            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
