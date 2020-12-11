<?php

require '../database/DataBaseConexion.php';

class ConfiguracionAdo {

    function __construct() {
        
    }

    public static function getTablesNames() {
        $consulta = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'systemagym' and table_name like 'tabla_%'";
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

    public static function getAll($tableName, $x, $y) {

        $consulta = 'SELECT * FROM ' . $tableName . ' LIMIT ' . $x . ',' . $y;
        //$consulta = 'SELECT * FROM ' . $body['tableName'] . ' LIMIT ' . ($body['page' - 1] * 10) . ',' . (10);
        //$consulta = "SELECT * FROM ? LIMIT ?,?";
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

    public static function getAllCount($tableName) {
        $consulta = 'SELECT COUNT(*) FROM ' . $tableName;
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
    
    public static function getAllDatos($tableName, $datos, $x, $y) {
        $consulta = 'SELECT * FROM ' . $tableName .' WHERE nombre LIKE ? LIMIT ?,?';
        //$consulta = "SELECT * FROM clientetb WHERE apellidos LIKE ? LIMIT ?,?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
//            $comando->bindParam(1, "$datos%");
//            $comando->bindParam(2, $x);
//            $comando->bindParam(3, $y);
            $comando->bindValue(1, "$datos%", PDO::PARAM_STR);
            $comando->bindValue(2, $x, PDO::PARAM_INT);
            $comando->bindValue(3, $y, PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            //$comando->execute(array("$datos%",$x, $y));
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    public static function getTableDataById($body) {
        
        $consulta = 'SELECT * FROM '.$body['tableName'].' WHERE id = ?';
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($body['id']));
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function validateIdEquals($body) {
        $validate = Database::getInstance()->getDb()->prepare('SELECT id FROM ' . $body['tableName'] . ' WHERE id = ?');
        $validate->bindParam(1, $body['id']);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateNameEquals($body) {
        $validate = Database::getInstance()->getDb()->prepare('SELECT nombre FROM ' . $body['tableName'] . ' WHERE id <> ? AND nombre = ?');
        $validate->bindParam(1, $body['id']);
        $validate->bindParam(2, $body['nombre']);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function editDataTable($body) {

        // Sentencia UPDATE
        $query = 'UPDATE '.$body['tableName'].
                ' SET nombre = ?,' .
                ' descripcion = ?,' .
                ' claveAlterna = ?,' .
                ' estado = ?,' .
                ' predeterminado = ?' .
                ' WHERE id = ?';

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();
            $sentencia = Database::getInstance()->getDb()->prepare($query);
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

    public static function insertDataTable($body) {

        // Sentencia INSERT
        $query = 'INSERT INTO '.$body['tableName'].' (nombre, descripcion, claveAlterna, estado, predeterminado)'.
                ' VALUES(?,?,?,?,?)';
        
        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();
            $sentencia = Database::getInstance()->getDb()->prepare($query);
            $sentencia->execute(
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
    
//    public static function validateClienteDniById($idCliente,$dni) {
//        $validate = Database::getInstance()->getDb()->prepare("SELECT idCliente FROM clientetb WHERE idCliente <> ? AND dni = ?");
//        $validate->bindParam(1, $idCliente);
//        $validate->bindParam(2, $dni);
//        $validate->execute();
//        if ($validate->fetch()) {
//            return true;
//        } else {
//            return false;
//        }
//    }

}
