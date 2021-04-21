<?php

require '../database/DataBaseConexion.php';

class DisciplinaAdo
{

    function __construct()
    {
    }

   
    public static function crudDisciplina($body)
    {

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoDisciplina = Database::getInstance()->getDb()->prepare("SELECT * FROM disciplinatb WHERE idDisciplina = ?");
            $codigoDisciplina->bindValue(1, $body["idDisciplina"], PDO::PARAM_STR);
            $codigoDisciplina->execute();
            if ($codigoDisciplina->fetch()) {

                $sentencia = Database::getInstance()->getDb()->prepare("UPDATE disciplinatb " .
                    "SET nombre = ?," .
                    " color = ?," .
                    " descripcion = ?," .
                    " estado = ?" .
                    "WHERE idDisciplina = ?");
                $sentencia->execute(
                    array(
                        $body['nombre'],
                        $body['color'],
                        $body['descripcion'],
                        $body['estado'],
                        $body['idDisciplina']
                    )
                );
                Database::getInstance()->getDb()->commit();
                return "updated";
            } else {
                $codigoDisciplina = Database::getInstance()->getDb()->prepare("SELECT Fc_Disciplina_Codigo_Almanumerico();");
                $codigoDisciplina->execute();
                $idDisciplina = $codigoDisciplina->fetchColumn();

                $executeDisciplina = Database::getInstance()->getDb()->prepare("INSERT INTO disciplinatb ( " .
                "idDisciplina," .
                "nombre," .
                "color," .
                "descripcion," .
                "estado)" .
                " VALUES(?,?,?,?,?)");
                $executeDisciplina->execute(
                    array(
                        $idDisciplina,
                        $body['nombre'],
                        $body['color'],
                        $body['descripcion'],
                        $body['estado']
                    )
                );
                Database::getInstance()->getDb()->commit();
                return "inserted";
            }
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }


    public static function delete($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM plantb_disciplinatb WHERE idDisciplina = ? ");
            $validate->execute(array($body['idDisciplina']));

            if ($validate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "registrado";
            } else {
                $sentencia = Database::getInstance()->getDb()->prepare("DELETE FROM disciplinatb WHERE idDisciplina = ?");
                $sentencia->execute(array($body['idDisciplina']));
                Database::getInstance()->getDb()->commit();
                return "deleted";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getAllDisciplina($search, $x, $y)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            idDisciplina ,nombre,color,descripcion,estado 
            FROM disciplinatb 
            WHERE nombre LIKE ?
            LIMIT ?,?");
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->bindValue(2, $x, PDO::PARAM_INT);
            $comando->bindValue(3, $y, PDO::PARAM_INT);
            $comando->execute();
            $arrayDisciplina = array();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayDisciplina, array(
                    "id" => $count + $x,
                    "idDisciplina" => $row["idDisciplina"],
                    "nombre" => $row["nombre"],
                    "color" => $row["color"],
                    "descripcion" => $row["descripcion"],
                    "estado" => $row["estado"]
                ));
            }
            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM disciplinatb WHERE nombre LIKE ?");
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->execute();
            $totalDisciplinas = $comando->fetchColumn();
            array_push($array, $arrayDisciplina, $totalDisciplinas);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getDisciplinaById($idDisciplina)
    {
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT idDisciplina ,nombre,color,descripcion,estado FROM disciplinatb WHERE idDisciplina = ?");
            $comando->execute(array($idDisciplina));
            return $comando->fetchObject();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
