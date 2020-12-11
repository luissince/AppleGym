<?php

/**
 * Representa el la estructura de las Clientes
 * almacenadas en la base de datos
 */
require '../database/DataBaseConexion.php';

class ClienteAdo {

    function __construct() {
        
    }

    /**
     * Retorna en la todas las filas especificada de la tabla 'Clientes'
     *
     * @param $idCliente Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll($x, $y) {
        $array = array();
        try {
            // Preparar sentencia
            $clientes = Database::getInstance()->getDb()->prepare("SELECT * FROM clientetb LIMIT $x,$y");
            $membresias = Database::getInstance()->getDb()->prepare("SELECT idVenta,estado FROM  membresiatb WHERE idCliente = ? AND estado = 1");
            $venta = Database::getInstance()->getDb()->prepare("SELECT * FROM ventacreditotb WHERE idVenta = ? AND estado = 0");
            // Ejecutar sentencia preparada
            $clientes->execute();
            while ($row = $clientes->fetch()) {

                $membresias->execute(array($row["idCliente"]));
                $total_membresias = 0;
                $total_deudas = 0;
                while ($rows = $membresias->fetch()) {
                    $total_membresias++;
                    $venta->execute(array($rows['idVenta']));
                    while ($rowv = $venta->fetch()) {
                        $total_deudas++;
                    }
                }

                array_push($array, array(
                    "idCliente" => $row["idCliente"],
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "email" => $row["email"],
                    "celular" => $row["celular"],
                    "direccion" => $row["direccion"],
                    "predeterminado" => $row["predeterminado"],
                    "membresia" => $total_membresias,
                    "venta" => $total_deudas
                ));
            }
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }

    public static function getAllCount() {
        $consulta = "SELECT COUNT(*) FROM clientetb";
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

    public static function getAllDatos($datos, $x, $y) {
        $array = array();
        try {
            // Preparar sentencia
            $clientes = Database::getInstance()->getDb()->prepare("SELECT * FROM clientetb WHERE (apellidos LIKE ?) OR (nombres LIKE ?) OR (dni LIKE ?) LIMIT ?,?");
            $clientes->bindValue(1, "$datos%", PDO::PARAM_STR);
            $clientes->bindValue(2, "$datos%", PDO::PARAM_STR);
            $clientes->bindValue(3, "$datos%", PDO::PARAM_STR);
            $clientes->bindValue(4, $x, PDO::PARAM_INT);
            $clientes->bindValue(5, $y, PDO::PARAM_INT);

            $membresias = Database::getInstance()->getDb()->prepare("SELECT idVenta FROM  membresiatb WHERE idCliente = ? AND estado = 1");
            $venta = Database::getInstance()->getDb()->prepare("SELECT * FROM ventacreditotb WHERE idVenta = ? AND estado = 0");
            // Ejecutar sentencia preparada
            $clientes->execute();
            while ($row = $clientes->fetch()) {

                $membresias->execute(array($row["idCliente"]));
                $total_membresias = 0;
                $total_deudas = 0;

                while ($rows = $membresias->fetch()) {
                    $total_membresias++;
                    $venta->execute(array($rows['idVenta']));
                    while ($rowv = $venta->fetch()) {
                        $total_deudas++;
                    }
                }

                array_push($array, array(
                    "idCliente" => $row["idCliente"],
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "email" => $row["email"],
                    "celular" => $row["celular"],
                    "direccion" => $row["direccion"],
                    "predeterminado" => $row["predeterminado"],
                    "membresia" => $total_membresias,
                    "venta" => $total_deudas
                ));
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $array;
    }

    public static function getAllDatosCount($datos) {
        $consulta = "SELECT COUNT(*) FROM clientetb WHERE (apellidos LIKE ?) OR (nombres LIKE ?) OR (dni LIKE ?)";
        try {
            // Preparar sentencia
            $clientes = Database::getInstance()->getDb()->prepare($consulta);
            $clientes->bindValue(1, "$datos%", PDO::PARAM_STR);
            $clientes->bindValue(2, "$datos%", PDO::PARAM_STR);
            $clientes->bindValue(3, "$datos%", PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $clientes->execute();
            return $clientes->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Retorna en la fila especificada de la tabla 'Clientes'
     *
     * @param $idCliente Identificador del registro
     * @return array Datos del registro
     */
    public static function getClientById($idCliente) {
        $consulta = "SELECT * FROM clientetb WHERE idCliente = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idCliente['idCliente']));
            return $comando->fetchObject();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getMembresiaClienteById($idCliente) {
        $array = array();
        try {
            // Preparar sentencia
            $membresia = Database::getInstance()->getDb()->prepare("select 
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
                from
                membresiatb as m INNER JOIN plantb as c on m.idPlan = c.idPlan 
                WHERE m.idCliente = ? ORDER BY m.fechaInicio DESC,m.horaInicio DESC");
            // Ejecutar sentencia preparada
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
        } catch (PDOException $e) {
            
        }
        return $array;
    }

    /**
     * Insertar un nuevo cliente
     *   
     * @param $body Array que contiene la información del cliente
     * @return string
     */
    public static function insert($body) {

        // Sentencia INSERT
        $quey = "SELECT Fc_Cliente_Codigo_Almanumerico();";

//        $queyMovimiento = "SELECT Fc_Movimiento_Codigo_Numerico();";

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
                "predeterminado)" .
                " VALUES(?,?,?,?,?,?,?,?,?,?,?)";

//        $movimiento = "INSERT INTO movimientostb(idMovimiento,idTabla,descripcion,fechaRegistro,horaRegistro,usuario)VALUES(?,?,?,?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoCliente = Database::getInstance()->getDb()->prepare($quey);
            $codigoCliente->execute();
            $idCliente = $codigoCliente->fetchColumn();

//            $codigoMovimiento = Database::getInstance()->getDb()->prepare($queyMovimiento);
//            $codigoMovimiento->execute();
//            $idMovimiento = $codigoMovimiento->fetchColumn();

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
                        false
                    )
            );

//            $executeMovimiento = Database::getInstance()->getDb()->prepare($movimiento);
//            $executeMovimiento->execute(
//                    array(
//                        $idMovimiento,
//                        $idCliente,
//                        "creación del cliente",
//                        $body['fechaRegistro'],
//                        $body['horaRegistro'],
//                        $body['usuario']
//                    )
//            );

            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    /**
     * Editar un nuevo cliente
     *   
     */
    public static function edit($body) {

        // Sentencia UPDATE

        $comando = "UPDATE clientetb " .
                "SET dni = ?," .
                " apellidos = ?," .
                " nombres = ?," .
                " sexo = ?," .
                " fechaNacimiento = ?," .
                " codigo = ?," .
                " email = ?," .
                " celular = ?," .
                " direccion = ?" .
                "WHERE idCliente = ?";

//        $queyMovimiento = "SELECT Fc_Movimiento_Codigo_Numerico();";
//        $movimiento = "INSERT INTO movimientostb(idMovimiento,idTabla,descripcion,fechaRegistro,horaRegistro,usuario)VALUES(?,?,?,?,?,?)";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

//            $codigoMovimiento = Database::getInstance()->getDb()->prepare($queyMovimiento);
//            $codigoMovimiento->execute();
//            $idMovimiento = $codigoMovimiento->fetchColumn();

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
                        $body['idCliente']
                    )
            );

//            $executeMovimiento = Database::getInstance()->getDb()->prepare($movimiento);
//            $executeMovimiento->execute(
//                    array(
//                        $idMovimiento,
//                        $body['idCliente'],
//                        "se editó dicha información:" . " " . $body['dni'] . ", " . $body['apellidos'] . ", " . $body['nombres'] . ", " . $body['sexo'] . ", " . $body['fechaNacimiento'] . ", " . $body['codigo'] . ", " . $body['email'] . ", " . $body['celular'] . ", " . $body['direccion'],
//                        $body['fechaRegistro'],
//                        $body['horaRegistro'],
//                        $body['usuario']
//                    )
//            );

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deleteCliente($body) {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validateasistencia = Database::getInstance()->getDb()->prepare("SELECT * FROM asistenciatb WHERE idPersona = ? ");
            $validateasistencia->execute(array($body['idCliente']));

            if ($validateasistencia->rowCount() >= 1) {
                Database::getInstance()->getDb()->rollback();
                return "asistencia";
            } else {

                $validateventa = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE idCliente = ? ");
                $validateventa->execute(array($body['idCliente']));

                if ($validateventa->rowCount() >= 1) {
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

    public static function getClientByNumeroDocumento($value) {
        $query_cliente = "SELECT * FROM clientetb WHERE dni = ? or codigo = ?";
        
        $query_membresia = "SELECT m.fechaInicio,m.fechaFin,m.estado,p.nombre,p.tipoDisciplina,p.meses,p.dias,p.freeze,p.precio FROM 
                membresiatb as m INNER JOIN plantb as p on m.idPlan = p.idPlan  
                WHERE m.idCliente = ?";
        
        $query_venta = "SELECT * FROM ";
        
        $array = array();
        try {
            $execute_cliente = Database::getInstance()->getDb()->prepare($query_cliente);
            $execute_cliente->execute(array($value, $value));
            
            $cliente = $execute_cliente->fetchObject();
            
            array_push($array, $cliente);            

            $execute_membresia = Database::getInstance()->getDb()->prepare($query_membresia);
            $execute_membresia->bindParam(1, $cliente->idCliente);
            $execute_membresia->execute();
            array_push($array, $execute_membresia->fetchObject());
            return $array;
        } catch (PDOException $e) {
            return array();
        }
    }

    public static function validateClienteDni($dni) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM clientetb WHERE dni = ?");
        $validate->bindParam(1, $dni);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateClienteId($idCliente) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idCliente FROM clientetb WHERE idCliente = ?");
        $validate->bindParam(1, $idCliente);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateClienteDniById($idCliente, $dni) {
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

    public static function actualizarClientePredeterminado($idCliente) {
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

}
