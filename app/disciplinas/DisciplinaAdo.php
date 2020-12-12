<?php

require '../database/DataBaseConexion.php';

class DisciplinaAdo {

    function __construct() {
        
    }

    /**
     * Insertar un nueva disciplina
     *   
     * @param $body Array que contiene la información de la disciplina
     * @return string
     */
    public static function insert($body) {

        // Sentencia INSERT
        $quey = "SELECT Fc_Disciplina_Codigo_Almanumerico();";

        $disciplina = "INSERT INTO disciplinatb ( " .
                "idDisciplina," .
                "nombre," .
                "color," .
                "descripcion," .
                "estado)" .
                " VALUES(?,?,?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoDisciplina = Database::getInstance()->getDb()->prepare($quey);
            $codigoDisciplina->execute();
            $idDisciplina = $codigoDisciplina->fetchColumn();

            $executeDisciplina = Database::getInstance()->getDb()->prepare($disciplina);
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
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function editDisciplina($body) {

        // Sentencia UPDATE

        $comando = "UPDATE disciplinatb " .
                "SET nombre = ?," .
                " color = ?," .
                " descripcion = ?," .
                " estado = ?" .
                "WHERE idDisciplina = ?";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $sentencia = Database::getInstance()->getDb()->prepare($comando);
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
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function delete($body) {
        $consulta = "DELETE FROM disciplinatb WHERE idDisciplina = ?";
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM plantb_disciplinatb WHERE idDisciplina = ? ");
            $validate->execute(array($body['idDisciplina']));

            if ($validate->rowCount() >= 1) {
                Database::getInstance()->getDb()->rollback();
                return "registrado";
            } else {
                $sentencia = Database::getInstance()->getDb()->prepare($consulta);
                $sentencia->execute(array($body['idDisciplina']));
                Database::getInstance()->getDb()->commit();
                return "deleted";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getAllDisciplina($search,$x, $y) {       
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
            while($row = $comando->fetch()){
                $count++;
                array_push($arrayDisciplina,array(
                    "id"=>$count+$x,
                    "idDisciplina"=>$row["idDisciplina"],
                    "nombre"=>$row["nombre"],
                    "color"=>$row["color"],
                    "descripcion"=>$row["descripcion"],
                    "idDisestadociplina"=>$row["estado"]
                ));
            }
            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM disciplinatb WHERE nombre LIKE ?");
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->execute();
            $totalDisciplinas = $comando->fetchColumn();
            array_push($array,$arrayDisciplina,$totalDisciplinas);
            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getDisciplinaById($idDisciplina) {
        $consulta = "SELECT idDisciplina ,nombre,color,descripcion,estado FROM disciplinatb WHERE idDisciplina = ?";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($idDisciplina['idDisciplina']));
            return $comando->fetchObject();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAllDatosSearch($datos, $x, $y) {
        $consulta = "SELECT * FROM disciplinatb WHERE nombre LIKE ? LIMIT ?,?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, "$datos%", PDO::PARAM_STR);
            $comando->bindValue(2, $x, PDO::PARAM_INT);
            $comando->bindValue(3, $y, PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAllDatosForSelect() {
        $consulta = "SELECT idDisciplina,nombre FROM disciplinatb";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
