<?php

require '../database/DataBaseConexion.php';

class ProductoAdo
{

    function __construct()
    {
    }

    public static function insertProducto($body)
    {

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $validateProducto = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE idProducto = ?");
            $validateProducto->bindParam(1, $body['idProducto'], PDO::PARAM_STR);
            $validateProducto->execute();

            if ($validateProducto->fetch()) {

                $validateProducto = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE idProducto <> ? AND clave = ?");
                $validateProducto->bindParam(1, $body['idProducto'], PDO::PARAM_STR);
                $validateProducto->bindParam(2, $body['clave'], PDO::PARAM_STR);
                $validateProducto->execute();

                if ($validateProducto->fetch()) {
                    Database::getInstance()->getDb()->rollBack();
                    return "duplicate";
                } else {

                    $validateProducto = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE idProducto <> ? AND nombre = ?");
                    $validateProducto->bindParam(1, $body['idProducto'], PDO::PARAM_STR);
                    $validateProducto->bindParam(2, $body['nombre'], PDO::PARAM_STR);
                    $validateProducto->execute();

                    if ($validateProducto->fetch()) {
                        Database::getInstance()->getDb()->rollBack();
                        return "duplicatename";
                    } else {

                        $sentencia = Database::getInstance()->getDb()->prepare("UPDATE productotb 
                        SET clave = ?,
                        claveAlterna = ?,
                        nombre = ?,
                        categoria = ?,
                        impuesto = ?,
                        cantidad = ?,
                        costo = ?,
                        precio = ?,
                        estado = ?
                        WHERE idProducto = ?");
                        $sentencia->bindParam(1, $body['clave'], PDO::PARAM_STR);
                        $sentencia->bindParam(2, $body['claveAlterna'], PDO::PARAM_STR);
                        $sentencia->bindParam(3, $body['nombre'], PDO::PARAM_STR);
                        $sentencia->bindParam(4, $body['categoria'], PDO::PARAM_STR);
                        $sentencia->bindParam(5, $body['impuesto'], PDO::PARAM_STR);
                        $sentencia->bindParam(6, $body['cantidad'], PDO::PARAM_STR);
                        $sentencia->bindParam(7, $body['costo'], PDO::PARAM_STR);
                        $sentencia->bindParam(8, $body['precio'], PDO::PARAM_STR);
                        $sentencia->bindParam(9, $body['estado'], PDO::PARAM_STR);
                        $sentencia->bindParam(10, $body['idProducto'], PDO::PARAM_STR);
                        $sentencia->execute();

                        Database::getInstance()->getDb()->commit();
                        return "updated";
                    }
                }
            } else {

                $validateProducto = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE clave = ?");
                $validateProducto->bindParam(1, $body['idProducto'], PDO::PARAM_STR);
                $validateProducto->execute();

                if ($validateProducto->fetch()) {
                    Database::getInstance()->getDb()->rollBack();
                    return "duplicate";
                } else {

                    $validateProducto = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE nombre = ?");
                    $validateProducto->bindParam(1, $body['nombre'], PDO::PARAM_STR);
                    $validateProducto->execute();

                    if ($validateProducto->fetch()) {
                        Database::getInstance()->getDb()->rollBack();
                        return "duplicatename";
                    } else {

                        $codigoProducto = Database::getInstance()->getDb()->prepare("SELECT Fc_Producto_Codigo_Almanumerico();");
                        $codigoProducto->execute();
                        $idProducto = $codigoProducto->fetchColumn();

                        $sentencia = Database::getInstance()->getDb()->prepare("INSERT INTO productotb ( 
                        idProducto,
                        clave,
                        claveAlterna,
                        nombre,
                        categoria,
                        impuesto,
                        cantidad,
                        costo,
                        precio,
                        estado)
                        VALUES(?,?,?,?,?,?,?,?,?,?)");
                        $sentencia->bindParam(1, $idProducto, PDO::PARAM_STR);
                        $sentencia->bindParam(2, $body['clave'], PDO::PARAM_STR);
                        $sentencia->bindParam(3, $body['claveAlterna'], PDO::PARAM_STR);
                        $sentencia->bindParam(4, $body['nombre'], PDO::PARAM_STR);
                        $sentencia->bindParam(5, $body['categoria'], PDO::PARAM_STR);
                        $sentencia->bindParam(6, $body['impuesto'], PDO::PARAM_STR);
                        $sentencia->bindParam(7, $body['cantidad'], PDO::PARAM_STR);
                        $sentencia->bindParam(8, $body['costo'], PDO::PARAM_STR);
                        $sentencia->bindParam(9, $body['precio'], PDO::PARAM_STR);
                        $sentencia->bindParam(10, $body['estado'], PDO::PARAM_STR);
                        $sentencia->execute();

                        Database::getInstance()->getDb()->commit();
                        return "inserted";
                    }
                }
            }
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deleteProducto($body)
    {
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

    public static function validateProductoId($idProducto)
    {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idProducto FROM productotb WHERE idProducto = ?");
        $validate->bindParam(1, $idProducto);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllProducto($search, $x, $y)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE clave LIKE concat(?,'%')  OR nombre LIKE concat(?,'%') LIMIT ?,?");
            $comando->bindValue(1, $search, PDO::PARAM_STR);
            $comando->bindValue(2, $search, PDO::PARAM_STR);
            $comando->bindValue(3, $x, PDO::PARAM_INT);
            $comando->bindValue(4, $y, PDO::PARAM_INT);
            $comando->execute();
            $arrayProductos = array();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayProductos, array(
                    "id" => $count + $x,
                    "idProducto" => $row["idProducto"],
                    "clave" => $row["clave"],
                    "claveAlterna" => $row["claveAlterna"],
                    "nombre" => $row["nombre"],
                    "categoria" => $row["categoria"],
                    "impuesto" => $row["impuesto"],
                    "cantidad" => $row["cantidad"],
                    "costo" => $row["costo"],
                    "precio" => $row["precio"],
                    "estado" => $row["estado"]
                ));
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM productotb WHERE clave LIKE concat(?,'%')  OR nombre LIKE concat(?,'%')");
            $comando->bindValue(1, $search);
            $comando->bindValue(2, $search);
            $comando->execute();
            $totalProducto = $comando->fetchColumn();

            array_push($array, $arrayProductos, $totalProducto);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getProductoById($idProducto)
    {
        $consulta = "SELECT * FROM productotb WHERE idProducto = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idProducto['idProducto']));
            return $comando->fetchObject();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllDatosSearchProducto($datos, $x, $y)
    {
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
