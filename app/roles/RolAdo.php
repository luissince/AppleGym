<?php

require '../database/DataBaseConexion.php';

class RolAdo
{

    function __construct()
    {
    }

    /**
     * Retorna en la todas las filas especificada de la tabla 'tabla_rol'
     *
     * @param $id Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll($x, $y)
    {
       
        try {
            $array = array();
            // Preparar sentencia
            $roles = Database::getInstance()->getDb()->prepare("SELECT * FROM tabla_rol LIMIT $x,$y");
            $roles->execute();
            $arrayRoles = $roles->fetchAll(PDO::FETCH_ASSOC);

            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM tabla_rol");
            $comando->execute();
            $totalRoles = $comando->fetchColumn();
            
            array_push($array, $arrayRoles, $totalRoles);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAllDatos($datos, $x, $y)
    {

        try {
            $array = array();
            // Preparar sentencia
            $roles = Database::getInstance()->getDb()->prepare("SELECT * FROM tabla_rol WHERE (nombre LIKE ?) LIMIT ?,?");
            $roles->bindValue(1, "$datos%", PDO::PARAM_STR);
            $roles->bindValue(2, $x, PDO::PARAM_INT);
            $roles->bindValue(3, $y, PDO::PARAM_INT);
            
            $roles->execute();

            $arrayRoles = array();
            $count = 0;
            while ($row = $roles->fetch()) {
                // $membresias->execute(array($row["idCliente"]));
                // $total_membresias = 0;
                // $total_deudas = 0;

                // while ($rows = $membresias->fetch()) {
                //     $total_membresias++;
                //     $venta->execute(array($rows['idVenta']));
                //     while ($rowv = $venta->fetch()) {
                //         $total_deudas++;
                //     }
                // }
                $count++;
                array_push($arrayRoles, array(
                    "count" => $count + $x,
                    "id" => $row["id"],
                    "nombre" => $row["nombre"],
                    "descripcion" => $row["descripcion"],
                    "claveAlterna" => $row["claveAlterna"],
                    "estado" => $row["estado"],
                    "predeterminado" => $row["predeterminado"],

                ));
            }

            $roles = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM tabla_rol WHERE (nombre LIKE ?)");
            $roles->bindValue(1, "$datos%", PDO::PARAM_STR);
            $roles->execute();
            $totalRoles =  $roles->fetchColumn();

            array_push($array, $arrayRoles, $totalRoles);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retorna en la fila especificada de la tabla 'tabla_rol'
     *
     * @param $id Identificador del registro
     * @return array Datos del registro
     */
    public static function getRolById($idRol)
    {
        $consulta = "SELECT * FROM tabla_rol WHERE id = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idRol['idRol']));
            return $comando->fetchObject();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function validateRolId($idRol)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT id FROM tabla_rol WHERE id = ?");
        $validate->bindParam(1, $idRol);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateRolNombreById($idRol, $nombre)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT id FROM tabla_rol WHERE id <> ? AND nombre = ?");
        $validate->bindParam(1, $idRol);
        $validate->bindParam(2, $nombre);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }


     /**
     * Editar un nuevo rol
     *   
     */
    public static function edit($body)
    {
        // Sentencia UPDATE
        $comando = "UPDATE tabla_rol " .
            "SET nombre = ?," .
            " descripcion = ?," .
            " claveAlterna = ?," .
            " estado = ?," .
            " predeterminado = ?" .
            " WHERE id = ?";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            $sentencia->execute(
                array(
                    $body['nombre'],
                    $body['descripcion'],
                    $body['claveAlterna'],
                    $body['estado'],
                    $body['predeterminado'],
                    $body['id']
                )
            );

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function validateRolNombre($nombre)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM tabla_rol WHERE nombre = ?");
        $validate->bindParam(1, $nombre);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Insertar un nuevo rol
     *   
     * @param $body Array que contiene la información del rol
     * @return string
     */
    public static function insert($body)
    {

        $rol = "INSERT INTO tabla_rol ( " .
            "nombre," .
            "descripcion," .
            "claveAlterna," .
            "estado," .
            "predeterminado)" .
            " VALUES(?,?,?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $executeRol = Database::getInstance()->getDb()->prepare($rol);
            $executeRol->execute(
                array(
                    $body['nombre'],
                    $body['descripcion'],
                    $body['claveAlterna'],
                    $body['estado'],
                    $body['predeterminado']
                )
            );

            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    // public static function getPrivilegioEmpleadoById($idRol){

    //     try {
    //         // Preparar sentencia
    //         $comando = Database::getInstance()->getDb()->prepare("SELECT 
    //         p.idprivilegio, p.idEmpledo, p.idModulo, m.nombre, e.rol, p.lectura, p.escritura, p.estado
    //         FROM privilegiotb as p
    //         INNER JOIN empleadotb as e ON p.idEmpledo=e.idEmpleado
    //         INNER JOIN modulotb as m ON m.idModulo=p.idModulo
    //         WHERE e.idEmpleado = ? ");

    //         $comando->bindValue(1, $idEmpleado, PDO::PARAM_STR);

    //         $comando->execute();
    //         return $comando->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         $e->getMessage();
    //     }
        
    // }

    public static function getAllModulos(){

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM modulotb");
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        
    }

    /*
    public static function getMembresiaClienteById($idCliente)
    {
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

    public static function deleteCliente($body)
    {
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

    public static function getClientByNumeroDocumento($value)
    {
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
    */
}
