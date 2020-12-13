<?php

require '../database/DataBaseConexion.php';

class ProductoAdo {

    function __construct() {
        
    }

    public static function insertProducto($body) {

        // Sentencia INSERT
        $quey = "SELECT Fc_Producto_Codigo_Almanumerico();";

        $producto = "INSERT INTO productotb ( " .
                "idProducto," .
                "clave," .
                "claveAlterna," .
                "nombre," .
                "categoria," .
                "impuesto," .
                "cantidad," .
                "costo," .
                "precio," .
                "estado)" .
                " VALUES(?,?,?,?,?,?,?,?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $validateclave = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE clave = ?");
            $validateclave->execute(array($body['clave']));

            if ($validateclave->rowCount() == 1) {
                Database::getInstance()->getDb()->rollBack();
                return "duplicate";
            } else {

                $validatename = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE nombre = ?");
                $validatename->execute(array($body['nombre']));

                if ($validatename->rowCount() == 1) {
                    Database::getInstance()->getDb()->rollBack();
                    return "duplicatename";
                } else {
                    $codigoProducto = Database::getInstance()->getDb()->prepare($quey);
                    $codigoProducto->execute();
                    $idProducto = $codigoProducto->fetchColumn();

                    $executeProducto = Database::getInstance()->getDb()->prepare($producto);
                    $executeProducto->execute(
                            array(
                                $idProducto,
                                $body['clave'],
                                $body['claveAlterna'],
                                $body['nombre'],
                                $body['categoria'],
                                $body['impuesto'],
                                $body['cantidad'],
                                $body['costo'],
                                $body['precio'],
                                $body['estado']
                            )
                    );

                    Database::getInstance()->getDb()->commit();
                    return "inserted";
                }
            }
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function editProducto($body) {

        // Sentencia UPDATE

        $comando = "UPDATE productotb " .
                "SET clave = ?," .
                " claveAlterna = ?," .
                " nombre = ?," .
                " categoria = ?," .
                " impuesto = ?," .
                " cantidad = ?," .
                " costo = ?," .
                " precio = ?," .
                " estado = ?" .
                "WHERE idProducto = ?";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $validateclave = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE idProducto <> ? AND clave = ?");
            $validateclave->execute(array($body['idProducto'], $body['clave']));

            if ($validateclave->rowCount() == 1) {
                Database::getInstance()->getDb()->rollBack();
                return "duplicate";
            } else {

                $validatename = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE idProducto <> ? AND nombre = ?");
                $validatename->execute(array($body['idProducto'], $body['nombre']));

                if ($validatename->rowCount() == 1) {
                    Database::getInstance()->getDb()->rollBack();
                    return "duplicatename";
                } else {

                    $sentencia = Database::getInstance()->getDb()->prepare($comando);
                    $sentencia->execute(
                            array(
                                $body['clave'],
                                $body['claveAlterna'],
                                $body['nombre'],
                                $body['categoria'],
                                $body['impuesto'],
                                $body['cantidad'],
                                $body['costo'],
                                $body['precio'],
                                $body['estado'],
                                $body['idProducto']
                            )
                    );


                    Database::getInstance()->getDb()->commit();
                    return "updated";
                }
            }
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deleteProducto($body) {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM detalleventatb WHERE idOrigen = ? ");
            $validate->execute(array($body['idProducto']));

            if ($validate->rowCount() >= 1) {
                Database::getInstance()->getDb()->rollback();
                return "registrado";
            } else {
                $sentencia = Database::getInstance()->getDb()->prepare("DELETE FROM productotb WHERE idProducto = ?");
                $sentencia->execute(array($body['idProducto']));
                Database::getInstance()->getDb()->commit();
                return "deleted";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function validateProductoId($idProducto) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idProducto FROM productotb WHERE idProducto = ?");
        $validate->bindParam(1, $idProducto);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllProducto($x, $y) {      
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb LIMIT $x,$y");
            $comando->execute();
            $arrayProductos = array();
            while($row = $comando->fetch()){
                array_push($arrayProductos,$row);
            }

            $comando = Database::getInstance()->getDb()->prepare( "SELECT COUNT(*) FROM productotb");
            $comando->execute();
            $totalProducto = $comando->fetchColumn();

            array_push($array,$arrayProductos,$totalProducto);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getProductoById($idProducto) {
        $consulta = "SELECT * FROM productotb WHERE idProducto = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idProducto['idProducto']));
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllDatosSearchProducto($datos, $x, $y) {
        $consulta = "SELECT * FROM productotb WHERE (nombre LIKE ? OR clave LIKE ?) LIMIT ?,?";
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

}
