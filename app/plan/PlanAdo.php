<?php

require '../database/DataBaseConexion.php';

class PlanAdo {

    function __construct() {
        
    }

    public static function insertPlan($body) {
        // Sentencia INSERT
        $query = "SELECT Fc_Plan_Codigo_Almanumerico();";

        $plan = "INSERT INTO plantb ( " .
                "idPlan," .
                "nombre," .
                "tipoDisciplina," .
                "sesiones," .
                "meses," .
                "dias," .
                "freeze," .
                "precio," .
                "descripcion," .
                "estado," .
                "prueba)" .
                " VALUES(?,?,?,?,?,?,?,?,?,?,?)";

        $plan_disciplina = "INSERT INTO plantb_disciplinatb (idPlan,idDisciplina,numero) VALUES(?,?,?)";

        try {
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $codigoPlan = Database::getInstance()->getDb()->prepare($query);
            $codigoPlan->execute();
            $idPlan = $codigoPlan->fetchColumn();

            $executePlan = Database::getInstance()->getDb()->prepare($plan);
            $executePlan->execute(
                    array(
                        $idPlan,
                        $body['nombre'],
                        $body['tipoDisciplina'],
                        $body['sesiones'],
                        $body['meses'],
                        $body['dias'],
                        $body['freeze'],
                        $body['precio'],
                        $body['descripcion'],
                        $body['estado'],
                        $body['prueba']
                    )
            );

            if ($body['tipoDisciplina'] == 2) {
                foreach ($body['arrdisciplinas'] as $result) {
                    $executePlanDisciplina = Database::getInstance()->getDb()->prepare($plan_disciplina);
                    $executePlanDisciplina->execute(
                            array(
                                $idPlan,
                                $result['id'],
                                $result['sesiones']
                            )
                    );
                }
            }

            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function editPlan($body) {

        $comando = "UPDATE plantb " .
                "SET nombre = ?," .
                " tipoDisciplina = ?," .
                " sesiones = ?," .
                " meses = ?," .
                " dias = ?," .
                " freeze = ?," .
                " precio = ?," .
                " descripcion = ?," .
                " estado = ?," .
                " prueba = ?" .
                " WHERE idPlan = ?";

        $plan_disciplina = "INSERT INTO plantb_disciplinatb (idPlan,idDisciplina,numero) VALUES(?,?,?)";

        $plan_disciplina_remove = "DELETE FROM plantb_disciplinatb WHERE idPlan = ?";

        try {
            // Preparar la sentencia         
            Database::getInstance()->getDb()->beginTransaction();

            $executePlan = Database::getInstance()->getDb()->prepare($comando);
            $executePlan->execute(
                    array(
                        $body['nombre'],
                        $body['tipoDisciplina'],
                        $body['sesiones'],
                        $body['meses'],
                        $body['dias'],
                        $body['freeze'],
                        $body['precio'],
                        $body['descripcion'],
                        $body['estado'],
                        $body['prueba'],
                        $body['idPlan']
                    )
            );

            $execute_plan_disciplina_remove = Database::getInstance()->getDb()->prepare($plan_disciplina_remove);
            $execute_plan_disciplina_remove->execute(array($body['idPlan']));

            if ($body['tipoDisciplina'] == 2) {
                foreach ($body['arrdisciplinas'] as $result) {
                    $executePlanDisciplina = Database::getInstance()->getDb()->prepare($plan_disciplina);
                    $executePlanDisciplina->execute(
                            array(
                                $body['idPlan'],
                                $result['id'],
                                $result['sesiones']
                            )
                    );
                }
            }

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deletePlan($body) {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE idPlan = ? ");
            $validate->execute(array($body['idPlan']));

            if ($validate->rowCount() >= 1) {
                Database::getInstance()->getDb()->rollback();
                return "registrado";
            } else {
                $sentencia = Database::getInstance()->getDb()->prepare("DELETE FROM plantb WHERE idPlan = ?");
                $sentencia->execute(array($body['idPlan']));
                Database::getInstance()->getDb()->commit();
                return "deleted";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getAllPlanes($x, $y) {
        $consulta = "SELECT * FROM plantb LIMIT $x,$y";
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

    public static function getAllCountPlanes() {
        $consulta = "SELECT COUNT(*) FROM plantb";
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

    public static function getPlanById($idPlan) {
        try {
            // Preparar sentencia
            $queryplan = Database::getInstance()->getDb()->prepare("SELECT * FROM plantb WHERE idPlan = ?");
            $queryplandisciplina = Database::getInstance()->getDb()->prepare("SELECT p.idDisciplina,d.nombre,p.numero FROM plantb_disciplinatb AS p INNER JOIN disciplinatb AS d ON p.idDisciplina = d.idDisciplina WHERE p.idPlan = ?");
            // Ejecutar sentencia preparada
            $queryplan->bindValue(1, $idPlan['idPlan'], PDO::PARAM_STR);
            $queryplan->execute();
            $array = array();
            while ($rowp = $queryplan->fetch()) {
                $queryplandisciplina->bindValue(1, $idPlan['idPlan'], PDO::PARAM_STR);
                $queryplandisciplina->execute();
                $arr_tarnos = array();
                while ($rowpd = $queryplandisciplina->fetch()) {
                    array_push($arr_tarnos, array(
                        "id" => $rowpd['idDisciplina'],
                        "name" => $rowpd['nombre'],
                        "sesiones" => $rowpd['numero']
                    ));
                }
                array_push($array, array(
                    "idPlan" => $rowp['idPlan'],
                    "nombre" => $rowp['nombre'],
                    "tipoDisciplina" => $rowp['tipoDisciplina'],
                    "sesiones" => $rowp['sesiones'],
                    "meses" => $rowp['meses'],
                    "dias" => $rowp['dias'],
                    "freeze" => $rowp['freeze'],
                    "precio" => $rowp['precio'],
                    "descripcion" => $rowp['descripcion'],
                    "disciplinas" => $arr_tarnos,
                    "estado" => $rowp['estado'],
                    "prueba" => $rowp['prueba'])
                );
            }
            return $array;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllDatosSearchPlan($datos, $x, $y) {
        $consulta = "SELECT * FROM plantb WHERE nombre LIKE ?  LIMIT ?,?";
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
        $queryplan = "SELECT idPlan,nombre,tipoDisciplina,meses,dias,freeze,sesiones,precio,descripcion FROM plantb WHERE estado = 1 AND prueba = 0";
        $queryplandisciplina = "SELECT d.nombre,p.numero FROM plantb_disciplinatb AS p INNER JOIN disciplinatb AS d ON p.idDisciplina = d.idDisciplina WHERE p.idPlan = ?";
        try {
            // Preparar sentencia
            $executeplan = Database::getInstance()->getDb()->prepare($queryplan);
            $executeplan->execute();

            $executedisciplinas = Database::getInstance()->getDb()->prepare($queryplandisciplina);
            $array = array();
            while ($rowp = $executeplan->fetch()) {
                $executedisciplinas->bindParam(1, $rowp['idPlan'], PDO::PARAM_STR);
                $executedisciplinas->execute();
                $arr_disciplinas = array();
                while ($rowd = $executedisciplinas->fetch()) {
                    array_push($arr_disciplinas, array(
                        "nombre" => $rowd['nombre'],
                        "numero" => $rowd['numero']
                    ));
                }
                array_push($array, array(
                    "idPlan" => $rowp['idPlan'],
                    "nombre" => $rowp['nombre'],
                    "tipoDisciplina" => $rowp['tipoDisciplina'],
                    "meses" => $rowp['meses'],
                    "dias" => $rowp['dias'],
                    "freeze" => $rowp['freeze'],
                    "sesiones" => $rowp['sesiones'],
                    "precio" => $rowp['precio'],
                    "descripcion" => $rowp['descripcion'],
                    "disciplinas" => $arr_disciplinas)
                );
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function validatePlanId($idPlan) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idPlan FROM plantb WHERE idPlan = ?");
        $validate->bindParam(1, $idPlan);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validatePlanNameById($idPlan, $nombre) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idPlan FROM plantb WHERE idPlan <> ? AND nombre = ?");
        $validate->bindParam(1, $idPlan);
        $validate->bindParam(2, $nombre);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validatePlanName($nombre) {
        $validate = Database::getInstance()->getDb()->prepare("SELECT idPlan FROM plantb WHERE nombre = ?");
        $validate->bindParam(1, $nombre);
        $validate->execute();
        if ($validate->fetch()) {
            return true;
        } else {
            return false;
        }
    }

}
