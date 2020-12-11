<?php

require '../database/DataBaseConexion.php';

class HorarioAdo {

    function __construct() {
        
    }

    public static function getAllHorarios() {
        try {
            // Preparar sentencia
            $queryhorarios = Database::getInstance()->getDb()->prepare("SELECT * FROM horariotb");
            $queryturnos = Database::getInstance()->getDb()->prepare("SELECT * FROM turnotb WHERE idHorario = ?");
            // Ejecutar sentencia preparada
            $queryhorarios->execute();
            $array = array();
            while ($rowh = $queryhorarios->fetch()) {
                $queryturnos->bindValue(1, $rowh['idHorario'], PDO::PARAM_STR);
                $queryturnos->execute();
                $arr_tarnos = array();
                while ($rowt = $queryturnos->fetch()) {
                    array_push($arr_tarnos, array(
                        "idTurno" => $rowt['idTurno'],
                        "idHorario" => $rowt['idHorario'],
                        "horaInicio" => $rowt['horaInicio'],
                        "horaSalida" => $rowt['horaSalida']
                    ));
                }                
                array_push($array, array(
                    "idHorario" => $rowh['idHorario'],
                    "descripcion" =>$rowh['descripcion'],
                    "dias" => $rowh['dias'],
                    "estado" => $rowh['estado'],
                    "turnos"=>$arr_tarnos)
                );
            }

            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getAllCountHorarios() {
        $consulta = "SELECT COUNT(*) FROM horariotb";
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

}
