<?php

require '../database/DataBaseConexion.php';

class RolAdo
{

    function __construct()
    {
    }


    public static function getAllRoles($search, $x, $y)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT idRol,nombre,descripcion,estado FROM roltb
            WHERE nombre LIKE CONCAT(?,'%') OR descripcion LIKE CONCAT(?,'%')
            LIMIT ?,?");
            $comando->bindValue(1, $search, PDO::PARAM_STR);
            $comando->bindValue(2, $search, PDO::PARAM_STR);
            $comando->bindValue(3, $x, PDO::PARAM_INT);
            $comando->bindValue(4, $y, PDO::PARAM_INT);
            $comando->execute();

            $arrayRoles = array();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayRoles, array(
                    "id" => $count,
                    "idRol" => $row["idRol"],
                    "nombre" => $row["nombre"],
                    "descripcion" => $row["descripcion"],
                    "estado" => $row["estado"],
                ));
            }


            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM roltb
            WHERE nombre LIKE CONCAT(?,'%') OR descripcion LIKE CONCAT(?,'%')");
            $comando->bindValue(1, $search);
            $comando->bindValue(2, $search);
            $comando->execute();
            $totalRoles = $comando->fetchColumn();

            array_push($array, $arrayRoles, $totalRoles);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getRolById($idRol)
    {
        try {
            $cmdRol = Database::getInstance()->getDb()->prepare("SELECT * FROM roltb WHERE idRol = ?");
            $cmdRol->bindValue(1, $idRol, PDO::PARAM_INT);
            $cmdRol->execute();
            return $cmdRol->fetchObject();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getPermisosByIdRol($idRol)
    {
        try {
            $array = array();
            $cmdRol = Database::getInstance()->getDb()->prepare("SELECT 
            p.idPermiso ,
            p.idRol,
            p.idModulo,
            m.nombre,
            p.ver,
            p.crear,
            p.actualizar,
            p.eliminar
            FROM permisotb as p INNER JOIN modulotb AS m ON p.idModulo = m.idModulo 
            WHERE p.idRol = ?");
            $cmdRol->bindValue(1, $idRol, PDO::PARAM_INT);
            $cmdRol->execute();

            $count = 0;
            while ($row = $cmdRol->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "idPermiso" => $row["idPermiso"],
                    "idRol" => $row["idRol"],
                    "idModulo" => $row["idModulo"],
                    "nombre" => $row["nombre"],
                    "ver" => $row["ver"],
                    "crear" => $row["crear"],
                    "actualizar" => $row["actualizar"],
                    "eliminar" => $row["eliminar"],
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function crudRol($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM roltb WHERE idRol  = ?");
            $cmdValidate->bindValue(1, $body["idRol"], PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM roltb WHERE idRol  <> ? AND nombre = ?");
                $cmdValidate->bindValue(1, $body["idRol"], PDO::PARAM_INT);
                $cmdValidate->bindValue(2, $body["nombre"], PDO::PARAM_STR);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "nameduplicate";
                } else {
                    $cmdUpdate =  Database::getInstance()->getDb()->prepare("UPDATE roltb SET nombre = ?,descripcion=?,estado=?  WHERE idRol  = ?");
                    $cmdUpdate->bindValue(1, $body["nombre"], PDO::PARAM_STR);
                    $cmdUpdate->bindValue(2, $body["descripcion"], PDO::PARAM_STR);
                    $cmdUpdate->bindValue(3, $body["estado"], PDO::PARAM_BOOL);
                    $cmdUpdate->bindValue(4, $body["idRol"], PDO::PARAM_INT);
                    $cmdUpdate->execute();
                    Database::getInstance()->getDb()->commit();
                    return "updated";
                }
            } else {
                $cmdValidate =  Database::getInstance()->getDb()->prepare("SELECT * FROM roltb WHERE nombre = ?");
                $cmdValidate->bindValue(1, $body["nombre"], PDO::PARAM_STR);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "nameduplicate";
                } else {
                    $cmdInsert =  Database::getInstance()->getDb()->prepare("INSERT INTO roltb (nombre,descripcion,estado) VALUES(?,?,?)");
                    $cmdInsert->bindValue(1, $body["nombre"], PDO::PARAM_STR);
                    $cmdInsert->bindValue(2, $body["descripcion"], PDO::PARAM_STR);
                    $cmdInsert->bindValue(3, $body["estado"], PDO::PARAM_BOOL);
                    $cmdInsert->execute();

                    $idRol = Database::getInstance()->getDb()->lastInsertId();
                    $cmdPermiso =  Database::getInstance()->getDb()->prepare("INSERT INTO permisotb (idRol, idModulo, ver,crear,actualizar,eliminar) VALUES (?,?,?,?,?,?)");
                    for ($i = 0; $i < 23; $i++) {
                        $cmdPermiso->execute(array($idRol, ($i + 1), 0, 0, 0, 0));
                    }

                    Database::getInstance()->getDb()->commit();
                    return "inserted";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateModulos($modulos)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comando = Database::getInstance()->getDb()->prepare("UPDATE permisotb SET ver = ?,crear=?,actualizar=?,eliminar=? WHERE idPermiso = ?");
            foreach ($modulos as $value) {
                $comando->execute(array(
                    $value["ver"],
                    $value["crear"],
                    $value["actualizar"],
                    $value["eliminar"],
                    $value["idPermiso"]
                ));
            }
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteRol($idRol)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM empleadotb WHERE idRol = ?");
            $cmdValidate->bindParam(1, $idRol, PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "personal";
            } else {
                $cmdDelete =  Database::getInstance()->getDb()->prepare("DELETE FROM roltb WHERE idRol = ?");
                $cmdDelete->bindValue(1, $idRol, PDO::PARAM_INT);
                $cmdDelete->execute();

                $cmdPermiso = Database::getInstance()->getDb()->prepare("DELETE FROM permisotb WHERE idRol = ?");
                $cmdPermiso->bindValue(1, $idRol, PDO::PARAM_STR);
                $cmdPermiso->execute();

                Database::getInstance()->getDb()->commit();
                return "deleted";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
