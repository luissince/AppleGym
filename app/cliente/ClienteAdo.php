<?php

/**
 * Representa el la estructura de las Clientes
 * almacenadas en la base de datos
 */
require '../database/DataBaseConexion.php';

class ClienteAdo
{

    function __construct()
    {
    }

    public static function getAllDatos($datos, $x, $y)
    {

        try {
            $array = array();

            $clientes = Database::getInstance()->getDb()->prepare("SELECT * 
            FROM clientetb 
            WHERE 
            apellidos LIKE CONCAT(?,'%') 
            OR 
            nombres LIKE CONCAT(?,'%') 
            OR
            CONCAT(apellidos,' ',nombres) LIKE CONCAT(?,'%') 
            OR
            CONCAT(nombres,' ',apellidos) LIKE CONCAT(?,'%') 
            OR
            dni LIKE CONCAT(?,'%') 
            LIMIT ?,?");
            $clientes->bindValue(1, $datos, PDO::PARAM_STR);
            $clientes->bindValue(2, $datos, PDO::PARAM_STR);
            $clientes->bindValue(3, $datos, PDO::PARAM_STR);
            $clientes->bindValue(4, $datos, PDO::PARAM_STR);
            $clientes->bindValue(5, $datos, PDO::PARAM_STR);
            $clientes->bindValue(6, $x, PDO::PARAM_INT);
            $clientes->bindValue(7, $y, PDO::PARAM_INT);
            $clientes->execute();

            $membresias = Database::getInstance()->getDb()->prepare("SELECT * FROM  membresiatb WHERE idCliente = ? AND estado = 1");

            $membresiaActivas = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE fechaFin > CURDATE()");
            $membresiaVencidas = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE fechaFin <= CURDATE()");

            $deudas = Database::getInstance()->getDb()->prepare("SELECT * FROM ventatb as v INNER JOIN ventacreditotb as vc on v.idVenta = vc.idVenta
            WHERE v.estado <> 3 AND vc.estado = 0 AND v.cliente = ?");

            $arrayClientes = array();
            $count = 0;
            while ($row = $clientes->fetch()) {

                $total_membresias = 0;
                $total_deudas = 0;

                $membresias->execute(array($row["idCliente"]));
                while ($rows = $membresias->fetch()) {
                    $total_membresias++;
                }
                $deudas->execute(array($row["idCliente"]));
                while ($rows = $deudas->fetch()) {
                    $total_deudas++;
                }

                $count++;
                array_push($arrayClientes, array(
                    "id" => $count + $x,
                    "idCliente" => $row["idCliente"],
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "email" => $row["email"],
                    "celular" => $row["celular"],
                    "direccion" => $row["direccion"],
                    "predeterminado" => $row["predeterminado"],
                    "descripcion" => $row["descripcion"],
                    "membresia" => $total_membresias,
                    "deudas" => $total_deudas
                ));
            }

            $clientes = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM clientetb 
            WHERE  
            apellidos LIKE CONCAT(?,'%') 
            OR 
            nombres LIKE CONCAT(?,'%') 
            OR
            CONCAT(apellidos,' ',nombres) LIKE CONCAT(?,'%') 
            OR
            CONCAT(nombres,' ',apellidos) LIKE CONCAT(?,'%') 
            OR
            dni LIKE CONCAT(?,'%')");
            $clientes->bindValue(1, $datos, PDO::PARAM_STR);
            $clientes->bindValue(2, $datos, PDO::PARAM_STR);
            $clientes->bindValue(3, $datos, PDO::PARAM_STR);
            $clientes->bindValue(4, $datos, PDO::PARAM_STR);
            $clientes->bindValue(5, $datos, PDO::PARAM_STR);
            $clientes->execute();
            $totalClientes =  $clientes->fetchColumn();

            array_push($array, $arrayClientes, $totalClientes);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getClientesTraspaso()
    {

        try {
            $array = array();

            $clientes = Database::getInstance()->getDb()->prepare("SELECT * 
            FROM clientetb AS c
            INNER JOIN membresiatb AS m ON m.idCliente = c.idCliente
            WHERE m.fechafin > NOW()");
            $clientes->execute();

            $membresias = Database::getInstance()->getDb()->prepare("SELECT * FROM  membresiatb WHERE idCliente = ? AND estado = 1");

            // $deudas = Database::getInstance()->getDb()->prepare("SELECT * FROM ventatb as v INNER JOIN ventacreditotb as vc on v.idVenta = vc.idVenta
            //  WHERE v.estado <> 3 AND vc.estado = 0 AND v.cliente = ?");

            $arrayClientes = array();
            $count = 0;
            while ($row = $clientes->fetch()) {

                $count++;
                array_push($arrayClientes, array(
                    "id" => $count,
                    "idCliente" => $row["idCliente"],
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "email" => $row["email"],
                    "celular" => $row["celular"],
                    "direccion" => $row["direccion"],
                    "predeterminado" => $row["predeterminado"],
                    "descripcion" => $row["descripcion"]
                    // "membresia" => $total_membresias,
                    // "deudas" => $total_deudas
                ));
            }

            array_push($array, $arrayClientes);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getDataCLientesTraspaso($dni)
    {
        try {
            $arrayMembresias = array();

            $membresias = Database::getInstance()->getDb()->prepare("SELECT m.idMembresia, p.nombre, m.idCliente, m.idVenta, m.fechaInicio, m.fechaFin, DATEDIFF(m.fechaFin,CURDATE()) AS Dias, m.tipoMembresia, m.cantidad, m.precio 
            FROM  membresiatb AS m INNER JOIN plantb AS p ON m.idPlan=p.idPlan
            WHERE idCliente = ? ");
            $membresias->bindValue(1, $dni, PDO::PARAM_STR);
            $membresias->execute();

            $count = 0;
            while ($row = $membresias->fetch()) {

                $count++;
                array_push($arrayMembresias, array(
                    "id" => $count,
                    "idMembresia" => $row["idMembresia"],
                    "plan" => $row["nombre"],
                    "idCliente" => $row["idCliente"],
                    "idVenta" => $row["idVenta"],
                    "fechaInicio" => $row["fechaInicio"],
                    "fechaFin" => $row["fechaFin"],
                    "dias" => $row["Dias"],
                    "tipoMembresia" => $row["tipoMembresia"],
                    "cantidad" => $row["cantidad"],
                    "precio" => $row["precio"]
                    // "membresia" => $total_membresias,
                    // "deudas" => $total_deudas
                ));
            }

            return $arrayMembresias;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getClientById($idCliente)
    {
        $consulta = "SELECT * FROM clientetb WHERE idCliente = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idCliente['idCliente']));
            return $comando->fetchObject();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getMembresiaMarcarAsistencia($buscar)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM clientetb WHERE dni = ? or codigo = ?");
            $comando->bindValue(1, $buscar, PDO::PARAM_STR);
            $comando->bindValue(2, $buscar, PDO::PARAM_STR);
            $comando->execute();
            $cliente = $comando->fetchObject();
            if (!$cliente) {
                throw new Exception("Datos no encontrados, intente nuevamente o consulte al encargado sobre su información");
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT p.nombre,m.fechaInicio,m.fechaFin,
            CASE 
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 THEN 1
            ELSE 0 END AS 'membresia'
            FROM membresiatb AS m INNER JOIN plantb AS p ON m.idPlan=p.idPlan 
            WHERE 
            m.idCliente = ? AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) > 10 
            OR
            m.idCliente = ? AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) <=10");
            $comando->bindValue(1, $cliente->idCliente, PDO::PARAM_STR);
            $comando->bindValue(2, $cliente->idCliente, PDO::PARAM_STR);
            $comando->execute();

            $arrayMembresias = array();
            while ($row = $comando->fetch()) {
                array_push($arrayMembresias, array(
                    "nombre" => $row["nombre"],
                    "fechaInicio" => $row["fechaInicio"],
                    "fechaFin" => $row["fechaFin"],
                    "membresia" => $row["membresia"],
                ));
            }

            $resultAsistencia = "";
            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? and estado = 1");
            $comando->bindValue(1, $cliente->idCliente, PDO::PARAM_STR);
            $comando->execute();
            if ($comando->fetch()) {
                $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? and estado = 1");
                $comando->bindValue(1, $cliente->idCliente, PDO::PARAM_STR);
                $comando->execute();
                $validate = $comando->fetchObject();
                if ($validate) {
                    $resultAsistencia = $validate;
                } else {
                    $resultAsistencia = "MARCAR ENTRADA";
                }
            } else {
                $resultAsistencia = "MARCAR ENTRADA";
            }

            array_push($array, $cliente, $arrayMembresias, $resultAsistencia);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getMembresiaClienteById($idCliente)
    {
        $array = array();
        try {
            $membresia = Database::getInstance()->getDb()->prepare("SELECT 
                c.idPlan,
                m.idVenta,
                c.nombre,
                c.tipoDisciplina,
                c.meses,
                c.dias,
                c.freeze,
                c.precio,
                c.descripcion,
                m.fechaInicio,
                m.horaInicio,
                m.fechaFin,
                m.horaFin,
                m.estado
                FROM
                membresiatb AS m INNER JOIN plantb AS c ON m.idPlan = c.idPlan 
                WHERE m.idCliente = ? ORDER BY m.fechaInicio DESC,m.horaInicio DESC");
            $membresia->execute(array($idCliente['idCliente']));

            $disciplina = Database::getInstance()->getDb()->prepare("SELECT 
                    d.nombre,
                    p.numero 
                    FROM 
                    plantb_disciplinatb AS p 
                    INNER JOIN disciplinatb AS d 
                    ON p.idDisciplina = d.idDisciplina WHERE p.idPlan = ?");

            $venta = Database::getInstance()->getDb()->prepare("SELECT 
                    idVentaCredito,
                    monto,
                    fechaRegistro,
                    fechaPago,
                    estado 
                    FROM ventacreditotb 
                    WHERE idVenta = ?");

            while ($row = $membresia->fetch()) {

                $array_disciplina = array();
                $disciplina->execute(array($row["idPlan"]));
                while ($rows = $disciplina->fetch()) {
                    array_push($array_disciplina, array(
                        "nombre" => $rows['nombre'],
                        "numero" => $rows['numero']
                    ));
                }

                $array_venta = array();
                $venta->execute(array($row["idVenta"]));
                while ($rowv = $venta->fetch()) {
                    array_push($array_venta, $rowv);
                }

                array_push($array, array(
                    "nombre" => $row["nombre"],
                    "tipoDisciplina" => $row["tipoDisciplina"],
                    "meses" => $row["meses"],
                    "dias" => $row["dias"],
                    "freeze" => $row["freeze"],
                    "precio" => $row["precio"],
                    "descripcion" => $row["descripcion"],
                    "fechaInicio" => $row["fechaInicio"],
                    "horaInicio" => $row["horaInicio"],
                    "fechaFin" => $row["fechaFin"],
                    "horaFin" => $row["horaFin"],
                    "estado" => $row["estado"],
                    "disciplinas" => $array_disciplina,
                    "venta" => $array_venta
                ));
            }
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function insert($body)
    {


        $quey = "SELECT Fc_Cliente_Codigo_Almanumerico();";

        $cliente = "INSERT INTO clientetb ( " .
            "idCliente," .
            "dni," .
            "apellidos," .
            "nombres," .
            "sexo," .
            "fechaNacimiento," .
            "codigo," .
            "email," .
            "celular," .
            "direccion," .
            "predeterminado," .
            "descripcion)" .
            " VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            Database::getInstance()->getDb()->beginTransaction();

            $codigoCliente = Database::getInstance()->getDb()->prepare($quey);
            $codigoCliente->execute();
            $idCliente = $codigoCliente->fetchColumn();

            $executeCliente = Database::getInstance()->getDb()->prepare($cliente);
            $executeCliente->execute(
                array(
                    $idCliente,
                    $body['dni'],
                    $body['apellidos'],
                    $body['nombres'],
                    $body['sexo'],
                    $body['fechaNacimiento'],
                    $body['codigo'],
                    $body['email'],
                    $body['celular'],
                    $body['direccion'],
                    false,
                    $body['descripcion']
                )
            );
            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function edit($body)
    {
        $comando = "UPDATE clientetb " .
            "SET dni = ?," .
            " apellidos = ?," .
            " nombres = ?," .
            " sexo = ?," .
            " fechaNacimiento = ?," .
            " codigo = ?," .
            " email = ?," .
            " celular = ?," .
            " direccion = ?," .
            " descripcion = ?" .
            "WHERE idCliente = ?";
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            $sentencia->execute(
                array(
                    $body['dni'],
                    $body['apellidos'],
                    $body['nombres'],
                    $body['sexo'],
                    $body['fechaNacimiento'],
                    $body['codigo'],
                    $body['email'],
                    $body['celular'],
                    $body['direccion'],
                    $body['descripcion'],
                    $body['idCliente']
                )
            );
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deleteCliente($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validateasistencia = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? ");
            $validateasistencia->execute(array($body['idCliente']));

            if ($validateasistencia->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "asistencia";
            } else {

                $validateventa = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE idCliente = ? ");
                $validateventa->execute(array($body['idCliente']));

                if ($validateventa->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "membresia";
                } else {
                    $sentencia = Database::getInstance()->getDb()->prepare("DELETE FROM clientetb WHERE idCliente = ?");
                    $sentencia->execute(array($body['idCliente']));
                    Database::getInstance()->getDb()->commit();
                    return "deleted";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function validateClienteDni($dni)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM clientetb WHERE dni = ?");
        $validate->bindParam(1, $dni);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateClienteId($idCliente)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idCliente FROM clientetb WHERE idCliente = ?");
        $validate->bindParam(1, $idCliente);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateClienteDniById($idCliente, $dni)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idCliente FROM clientetb WHERE idCliente <> ? AND dni = ?");
        $validate->bindParam(1, $idCliente);
        $validate->bindParam(2, $dni);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function actualizarClientePredeterminado($idCliente)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE clientetb SET predeterminado = 0");
            $comando->execute();

            $predeterminado = Database::getInstance()->getDb()->prepare("UPDATE clientetb SET predeterminado = 1 WHERE idCliente = ?");
            $predeterminado->execute(array($idCliente));

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }

    public static function actualizarHuella($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE clientetb SET huella = ?, imageHuella = ? WHERE idCliente  = 'CL0001'");
            $comando->execute(array($body["huella"], $body["imageHuella"]));
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }

    public static function obtenerHuella()
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT dni,apellidos,nombres,huella,imageHuella FROM clientetb");
            $comando->execute();
            while ($row = $comando->fetch()) {
                array_push($array, $row);
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
