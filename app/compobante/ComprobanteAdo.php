<?php

require '../database/DataBaseConexion.php';

class ComprobanteAdo
{

    function __construct()
    {
    }


    public static function getAllComprobantes($search, $x, $y)
    {
        try {
            $array = array();

            $comprobantes = Database::getInstance()->getDb()->prepare("SELECT * 
            FROM tipocomprobantetb 
            WHERE 
            nombre LIKE CONCAT('%',?,'%')            
            LIMIT ?,?");
            $comprobantes->bindValue(1, $search, PDO::PARAM_STR);
            $comprobantes->bindValue(2, $x, PDO::PARAM_INT);
            $comprobantes->bindValue(3, $y, PDO::PARAM_INT);
            $comprobantes->execute();

            $arrayComprobantes = array();
            $count = 0;
            while ($row = $comprobantes->fetch()) {
                $count++;
                array_push($arrayComprobantes, array(
                    "id" => $count + $x,
                    "idTipoComprobante" => $row["idTipoComprobante"],
                    "nombre" => $row["nombre"],
                    "serie" => $row["serie"],
                    "numeracion" => $row["numeracion"],
                    "predeterminado" => $row["predeterminado"],
                    "estado" => $row["estado"]
                ));
            }

            $comprobantes = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM tipocomprobantetb 
            WHERE  
            nombre LIKE CONCAT('%',?,'%')");
            $comprobantes->bindValue(1, $search, PDO::PARAM_STR);
            $comprobantes->execute();
            $totalComprobantes =  $comprobantes->fetchColumn();

            array_push($array, $arrayComprobantes, $totalComprobantes);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getByIdComprobante($idComprobante)
    {
        try {
            $comprobante =  Database::getInstance()->getDb()->prepare("SELECT * FROM tipocomprobantetb WHERE idTipoComprobante  = ?");
            $comprobante->bindValue(1, $idComprobante, PDO::PARAM_INT);
            $comprobante->execute();
            return $comprobante->fetchObject();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function crudComprobante($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM tipocomprobantetb WHERE idTipoComprobante  = ?");
            $cmdValidate->bindValue(1, $body["idTipoComprobante"], PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM tipocomprobantetb WHERE idTipoComprobante  <> ? AND nombre = ?");
                $cmdValidate->bindValue(1, $body["idTipoComprobante"], PDO::PARAM_INT);
                $cmdValidate->bindValue(2, $body["nombre"], PDO::PARAM_STR);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollBack();
                    return "name";
                } else {
                    $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM tipocomprobantetb WHERE idTipoComprobante  <> ? AND serie = ?");
                    $cmdValidate->bindValue(1, $body["idTipoComprobante"], PDO::PARAM_INT);
                    $cmdValidate->bindValue(2, $body["serie"], PDO::PARAM_STR);
                    $cmdValidate->execute();
                    if ($cmdValidate->fetch()) {
                        Database::getInstance()->getDb()->rollBack();
                        return "serie";
                    } else {
                        $cmdComprobante = Database::getInstance()->getDb()->prepare("UPDATE tipocomprobantetb SET nombre = ?,serie=?,numeracion=?,predeterminado=?,estado=? WHERE idTipoComprobante = ?");
                        $cmdComprobante->bindValue(1, $body["nombre"], PDO::PARAM_STR);
                        $cmdComprobante->bindValue(2, $body["serie"], PDO::PARAM_STR);
                        $cmdComprobante->bindValue(3, $body["numeracion"], PDO::PARAM_STR);
                        $cmdComprobante->bindValue(4, $body["predeterminado"], PDO::PARAM_BOOL);
                        $cmdComprobante->bindValue(5, $body["estado"], PDO::PARAM_BOOL);
                        $cmdComprobante->bindValue(6, $body["idTipoComprobante"], PDO::PARAM_INT);
                        $cmdComprobante->execute();
                        Database::getInstance()->getDb()->commit();
                        return "updated";
                    }
                }
            } else {
                $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM tipocomprobantetb WHERE nombre = ?");
                $cmdValidate->bindValue(1, $body["nombre"], PDO::PARAM_STR);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollBack();
                    return "name";
                } else {
                    $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM tipocomprobantetb WHERE serie = ?");
                    $cmdValidate->bindValue(1, $body["serie"], PDO::PARAM_STR);
                    $cmdValidate->execute();
                    if ($cmdValidate->fetch()) {
                        Database::getInstance()->getDb()->rollBack();
                        return "serie";
                    } else {
                        $cmdComprobante = Database::getInstance()->getDb()->prepare("INSERT INTO tipocomprobantetb(nombre,serie,numeracion,predeterminado,estado)VALUES(?,?,?,?,?)");
                        $cmdComprobante->bindValue(1, $body["nombre"], PDO::PARAM_STR);
                        $cmdComprobante->bindValue(2, $body["serie"], PDO::PARAM_STR);
                        $cmdComprobante->bindValue(3, $body["numeracion"], PDO::PARAM_STR);
                        $cmdComprobante->bindValue(4, $body["predeterminado"], PDO::PARAM_BOOL);
                        $cmdComprobante->bindValue(5, $body["estado"], PDO::PARAM_BOOL);
                        $cmdComprobante->execute();
                        Database::getInstance()->getDb()->commit();
                        return "inserted";
                    }
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }

    public static function deleteComprobante($idComprobante)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM ventatb WHERE documento = ?");
            $cmdValidate->bindValue(1, $idComprobante, PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollBack();
                return "venta";
            } else {
                $comprobante = Database::getInstance()->getDb()->prepare("DELETE FROM tipocomprobantetb WHERE idTipoComprobante  = ?");
                $comprobante->bindValue(1, $idComprobante, PDO::PARAM_INT);
                $comprobante->execute();
                Database::getInstance()->getDb()->commit();
                return "deleted";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }
}
