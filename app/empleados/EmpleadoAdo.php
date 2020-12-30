<?php

require '../database/DataBaseConexion.php';

class EmpleadoAdo
{

    function __construct()
    {
    }

    public static function insertEmpleado($body)
    {

        $quey = "SELECT Fc_Empleado_Codigo_Almanumerico();";

        $empleado = "INSERT INTO empleadotb ( " .
            "idEmpleado," .
            "tipoDocumento," .
            "numeroDocumento," .
            "apellidos," .
            "nombres," .
            "sexo," .
            "fechaNacimiento," .
            "codigo," .
            "ocupacion," .
            "formaPago," .
            "entidadBancaria," .
            "numeroCuenta," .
            "rol," .
            "estado," .
            "telefono," .
            "celular," .
            "email," .
            "direccion," .
            "usuario," .
            "clave)" .
            " VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoEmpleado = Database::getInstance()->getDb()->prepare($quey);
            $codigoEmpleado->execute();
            $idEmpleado = $codigoEmpleado->fetchColumn();

            $executeEmpleado = Database::getInstance()->getDb()->prepare($empleado);
            $executeEmpleado->execute(
                array(
                    $idEmpleado,
                    $body['tipoDocumento'],
                    $body['numeroDocumento'],
                    $body['apellidos'],
                    $body['nombres'],
                    $body['sexo'],
                    $body['fechaNacimiento'],
                    $body['codigo'],
                    $body['ocupacion'],
                    $body['formaPago'],
                    $body['entidadBancaria'],
                    $body['numeroCuenta'],
                    $body['rol'],
                    $body['estado'],
                    $body['telefono'],
                    $body['celular'],
                    $body['email'],
                    $body['direccion'],
                    $body['usuario'],
                    $body['clave']
                )
            );

            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function editEmpleado($body)
    {

        $comando = "UPDATE empleadotb " .
            "SET tipoDocumento = ?," .
            " numeroDocumento = ?," .
            " apellidos = ?," .
            " nombres = ?," .
            " sexo = ?," .
            " fechaNacimiento = ?," .
            " codigo = ?," .
            " ocupacion = ?," .
            " formaPago = ?," .
            " entidadBancaria = ?," .
            " numeroCuenta = ?," .
            " rol = ?," .
            " estado = ?," .
            " telefono = ?," .
            " celular = ?," .
            " email = ?," .
            " direccion = ?," .
            " usuario = ?," .
            " clave = ?" .
            "WHERE idEmpleado = ?";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            $sentencia->execute(
                array(
                    $body['tipoDocumento'],
                    $body['numeroDocumento'],
                    $body['apellidos'],
                    $body['nombres'],
                    $body['sexo'],
                    $body['fechaNacimiento'],
                    $body['codigo'],
                    $body['ocupacion'],
                    $body['formaPago'],
                    $body['entidadBancaria'],
                    $body['numeroCuenta'],
                    $body['rol'],
                    $body['estado'],
                    $body['telefono'],
                    $body['celular'],
                    $body['email'],
                    $body['direccion'],
                    $body['usuario'],
                    $body['clave'],
                    $body['idEmpleado']
                )
            );


            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deleteEmpleado($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validateasistencia = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? ");
            $validateasistencia->execute(array($body['idEmpleado']));

            if ($validateasistencia->rowCount() >= 1) {
                Database::getInstance()->getDb()->rollback();
                return "asistencia";
            } else {

                $validateventa = Database::getInstance()->getDb()->prepare("SELECT * FROM ventatb WHERE vendedor = ? ");
                $validateventa->execute(array($body['idEmpleado']));

                if ($validateventa->rowCount() >= 1) {
                    Database::getInstance()->getDb()->rollback();
                    return "venta";
                } else {
                    $sentencia = Database::getInstance()->getDb()->prepare("DELETE FROM empleadotb WHERE idEmpleado = ?");
                    $sentencia->execute(array($body['idEmpleado']));
                    Database::getInstance()->getDb()->commit();
                    return "deleted";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getAllEmpleado($search, $x, $y)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM empleadotb 
            WHERE numeroDocumento LIKE concat(?,'%') OR apellidos LIKE concat(?,'%') OR nombres LIKE concat(?,'%') 
            LIMIT ?,?");
            $comando->bindParam(1, $search, PDO::PARAM_STR);
            $comando->bindParam(2, $search, PDO::PARAM_STR);
            $comando->bindParam(3, $search, PDO::PARAM_STR);
            $comando->bindParam(4, $x, PDO::PARAM_INT);
            $comando->bindParam(5, $y, PDO::PARAM_INT);
            $comando->execute();
            $arrayEmpleados = array();
            while($row = $comando->fetch()){
                array_push($arrayEmpleados,array(
                    "idEmpleado" => $row["idEmpleado"],
                    "tipoDocumento" => $row["tipoDocumento"],
                    "numeroDocumento" => $row["numeroDocumento"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "sexo" => $row["sexo"],
                    "fechaNacimiento" => $row["fechaNacimiento"],
                    "telefono" => $row["telefono"],
                    "celular" => $row["celular"],
                    "email" => $row["email"],
                    "direccion" => $row["direccion"],
                    "codigo" => $row["codigo"],
                    "ocupacion" => $row["ocupacion"],
                    "formaPago" => $row["formaPago"],
                    "entidadBancaria" => $row["entidadBancaria"],
                    "numeroCuenta" => $row["numeroCuenta"],
                    "rol" => $row["rol"],
                    "usuario" => $row["usuario"],
                    "clave" => $row["clave"],
                    "estado" => $row["estado"]
                ));
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM empleadotb 
            WHERE numeroDocumento LIKE concat(?,'%') OR apellidos LIKE concat(?,'%') OR nombres LIKE concat(?,'%')");
            $comando->bindParam(1, $search, PDO::PARAM_STR);
            $comando->bindParam(2, $search, PDO::PARAM_STR);
            $comando->bindParam(3, $search, PDO::PARAM_STR);
            $comando->execute();
            $resultTotal =  $comando->fetchColumn();

            array_push($array,$arrayEmpleados,$resultTotal);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public static function getEmpleadoById($idEmpleado)
    {
        $consulta = "SELECT * FROM empleadotb WHERE idEmpleado = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idEmpleado['idEmpleado']));
            return $comando->fetchObject();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllDatosSearchEmpleado($datos, $x, $y)
    {
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

    public static function getEmpleadoForLogin($usuario, $clave)
    {
        $consulta = "SELECT * FROM empleadotb WHERE usuario = ? and clave = ? ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, $usuario, PDO::PARAM_STR);
            $comando->bindValue(2, $clave, PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchObject();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getEmpleadosForLista()
    {
        $consulta = "SELECT * FROM empleadotb ORDER BY apellidos ASC";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->setFetchMode(PDO::FETCH_ASSOC);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getPuestoForLista()
    {
        $consulta = "SELECT * FROM tabla_puesto ORDER BY nombre ASC";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->setFetchMode(PDO::FETCH_ASSOC);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getPeridoPagoForLista()
    {
        $consulta = "SELECT * FROM tabla_periodo_pago ORDER BY nombre ASC";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->setFetchMode(PDO::FETCH_ASSOC);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getEmpleadoByNumeroDocumento($numeroDocumento)
    {
        $consulta = "SELECT * FROM empleadotb WHERE numeroDocumento = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($numeroDocumento));
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function validateEmpleadoId($idEmpleados)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idEmpleado FROM empleadotb WHERE idEmpleado = ?");
        $validate->bindParam(1, $idEmpleados);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateEmpleadoNumeroDocumento($documento)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM empleadotb WHERE numeroDocumento = ?");
        $validate->bindParam(1, $documento);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateEmpledoNumeroDocumentoById($idEmpleado, $documento)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idEmpleado FROM empleadotb WHERE idEmpleado <> ? AND numeroDocumento = ?");
        $validate->bindParam(1, $idEmpleado);
        $validate->bindParam(2, $documento);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function getContratoById($idContrato)
    {
        $consulta = "SELECT c.idEmpleado,e.apellidos,e.nombres,c.puesto,c.fechaInicio,c.fechaCulminacion,c.horario,c.periodo,c.sueldo
                FROM systemagym.contratotb as c INNER JOIN systemagym.empleadotb as e on c.idEmpleado = e.idEmpleado
                WHERE c.idContrato = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idContrato));
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getDatosEmpresa()
    {
        $array = null;
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT idMiEmpresa,representante,nombreEmpresa,ruc,telefono,celular,email,paginaWeb,direccion,terminos FROM mi_empresatb");
            $comando->execute();
            while ($row = $comando->fetch()) {
                $array = array(
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
                );
            }
        } catch (Exception $ex) {
        }
        return $array;
    }

    public static function getDatosCliente()
    {
        $array = null;
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT idCliente,apellidos,nombres FROM clientetb WHERE predeterminado = 1");
            $comando->execute();
            while ($row = $comando->fetch()) {
                $array = array(
                    "idCliente" => $row["idCliente"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"]
                );
            }
        } catch (Exception $ex) {
        }
        return $array;
    }
}
