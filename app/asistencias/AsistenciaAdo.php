<?php

require '../database/DataBaseConexion.php';

class AsistenciaAdo {

    function __construct() {
        
    }

    public static function insertAsistencia($body) {

        $quey = "SELECT Fc_Asistencia_Codigo_Almanumerico();";

        $asistencia = "INSERT INTO asistenciatb ( " .
                "idAsistencia," .
                "fechaApertura," .
                "fechaCierre," .
                "horaApertura," .
                "horaCierre," .
                "estado," .
                "idPersona," .
                "tipoPersona)".
                " VALUES(?,?,?,?,?,?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoAsistencia = Database::getInstance()->getDb()->prepare($quey);
            $codigoAsistencia->execute();
            $idAsistencia = $codigoAsistencia->fetchColumn();

            $executeAsistencia = Database::getInstance()->getDb()->prepare($asistencia);
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

    public static function editAsistencia($body) {

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

    public static function getAllAsistencia($idPersona) {
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
    

    public static function getAllCountAsistencia() {
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

    public static function getAsistenciaByIdPersona($idPersona) {
        try {
            // Preparar sentencia
            $comandoUno = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? and estado = 1");
            $comandoUno->bindValue(1, $idPersona, PDO::PARAM_STR);
            // Ejecutar sentencia preparada        
            $comandoUno->execute();
            $validateUno = $comandoUno->fetchAll(PDO::FETCH_ASSOC);
            if ($validateUno) {
                return "1";
            } else {
                return "0";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAsistenciaByIdPersonaDos($idPersona) {
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? and estado = 1 and fechaApertura  = CURDATE()");
            $comando->bindValue(1, $idPersona, PDO::PARAM_STR);
            // Ejecutar sentencia preparada        
            $comando->execute();
            $validate = $comando->fetchAll(PDO::FETCH_ASSOC);
            if ($validate) {
                return array("estado" => "2", "mensaje" => $validate);
            } else {
                return array("estado" => "3", "mensaje" => "No cerro su turno");
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*

      public static function getEmpleadoById($idEmpleado) {
      $consulta = "SELECT * FROM empleadotb WHERE idEmpleado = ?";
      try {
      // Preparar sentencia
      $comando = Database::getInstance()->getDb()->prepare($consulta);
      // Ejecutar sentencia preparada
      $comando->execute(array($idEmpleado['idEmpleado']));
      return $comando->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
      return false;
      }
      }

      public static function getAllDatosSearchEmpleado($datos, $x, $y) {
      $consulta = "SELECT * FROM empleadotb WHERE (apellidos LIKE ? OR numeroDocumento LIKE ?) LIMIT ?,?";
      try {
      // Preparar sentencia
      $comando = Database::getInstance()->getDb()->prepare($consulta);
      $comando->bindValue(1, "$datos%", PDO::PARAM_STR);
      $comando->bindValue(2, "$datos%", PDO::PARAM_STR);
      $comando->bindValue(3, $x, PDO::PARAM_INT);
      $comando->bindValue(4, $y, PDO::PARAM_INT);
      // Ejecutar sentencia preparada
      $comando->execute();
      return $comando->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
      return $e->getMessage();
      }
      }

     */
}
