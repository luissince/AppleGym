<?php

require '../database/DataBaseConexion.php';

class PlanAdo
{

    function __construct()
    {
    }

    public static function insertPlan($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate = Database::getInstance()->getDb()->prepare("SELECT idPlan FROM plantb WHERE idPlan = ?");
            $validate->bindParam(1, $body['idPlan'], PDO::PARAM_STR);
            $validate->execute();
            if ($validate->fetch()) {

                $validate = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE idPlan = ?");
                $validate->bindParam(1, $body['idPlan'], PDO::PARAM_STR);
                $validate->execute();
                if ($validate->fetch()) {
                    Database::getInstance()->getDb()->rollBack();
                    return "membresia";
                } else {
                    $validate = Database::getInstance()->getDb()->prepare("SELECT idPlan FROM plantb WHERE idPlan <> ? AND  nombre = ?");
                    $validate->bindParam(1, $body['idPlan'], PDO::PARAM_STR);
                    $validate->bindParam(2, $body['nombre'], PDO::PARAM_STR);
                    $validate->execute();
                    if ($validate->fetch()) {
                        Database::getInstance()->getDb()->rollBack();
                        return "name";
                    } else {
                        $executePlan = Database::getInstance()->getDb()->prepare("UPDATE plantb " .
                            "SET nombre = ?," .
                            " tipoDisciplina = ?," .
                            " tipoPlan = ?," .
                            " sesiones = ?," .
                            " meses = ?," .
                            " dias = ?," .
                            " freeze = ?," .
                            " precio = ?," .
                            " descripcion = ?," .
                            " estado = ?," .
                            " prueba = ?" .
                            " WHERE idPlan = ?");
                        $executePlan->execute(
                            array(
                                $body['nombre'],
                                $body['tipoDisciplina'],
                                $body['tipoPlan'],
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

                        $execute_plan_disciplina_remove = Database::getInstance()->getDb()->prepare("DELETE FROM plantb_disciplinatb WHERE idPlan = ?");
                        $execute_plan_disciplina_remove->execute(array($body['idPlan']));

                        if ($body['tipoDisciplina'] == 2) {
                            foreach ($body['arrdisciplinas'] as $result) {
                                $executePlanDisciplina = Database::getInstance()->getDb()->prepare("INSERT INTO plantb_disciplinatb (idPlan,idDisciplina,numero) VALUES(?,?,?)");
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
                    }
                }
            } else {

                $validate = Database::getInstance()->getDb()->prepare("SELECT idPlan FROM plantb WHERE nombre = ?");
                $validate->bindParam(1, $body['nombre'], PDO::PARAM_STR);
                $validate->execute();
                if ($validate->fetch()) {
                    Database::getInstance()->getDb()->rollBack();
                    return "name";
                } else {
                    $codigoPlan = Database::getInstance()->getDb()->prepare("SELECT Fc_Plan_Codigo_Almanumerico();");
                    $codigoPlan->execute();
                    $idPlan = $codigoPlan->fetchColumn();

                    $executePlan = Database::getInstance()->getDb()->prepare("INSERT INTO plantb ( " .
                        "idPlan," .
                        "nombre," .
                        "tipoDisciplina," .
                        "tipoPlan," .
                        "sesiones," .
                        "meses," .
                        "dias," .
                        "freeze," .
                        "precio," .
                        "descripcion," .
                        "estado," .
                        "prueba)" .
                        " VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                    $executePlan->execute(
                        array(
                            $idPlan,
                            $body['nombre'],
                            $body['tipoDisciplina'],
                            $body['tipoPlan'],
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
                            $executePlanDisciplina = Database::getInstance()->getDb()->prepare("INSERT INTO plantb_disciplinatb (idPlan,idDisciplina,numero) VALUES(?,?,?)");
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
                }
            }
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function deletePlan($body)
    {
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

    public static function getAllPlanes($search, $x, $y)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            idPlan,
            nombre,
            tipoDisciplina,
            tipoPlan,
            sesiones,
            meses,
            dias,
            freeze,
            precio,
            descripcion,
            estado,
            prueba
            FROM plantb 
            WHERE nombre LIKE CONCAT(?,'%')
            LIMIT ?,?");
            $comando->bindValue(1, $search, PDO::PARAM_STR);
            $comando->bindValue(2, $x, PDO::PARAM_INT);
            $comando->bindValue(3, $y, PDO::PARAM_INT);
            $comando->execute();
            $arrayPlanes = array();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayPlanes, array(
                    "id" => $count + $x,
                    "idPlan" => $row["idPlan"],
                    "nombre" => $row["nombre"],
                    "tipoDisciplina" => $row["tipoDisciplina"],
                    "tipoPlan" => $row["tipoPlan"],
                    "sesiones" => $row["sesiones"],
                    "meses" => $row["meses"],
                    "dias" => $row["dias"],
                    "freeze" => $row["freeze"],
                    "precio" => $row["precio"],
                    "descripcion" => $row["descripcion"],
                    "estado" => $row["estado"],
                    "prueba" => $row["prueba"]
                ));
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM plantb WHERE  nombre LIKE CONCAT(?,'%')");
            $comando->bindValue(1, $search, PDO::PARAM_STR);
            $comando->execute();
            $totalPlanes = $comando->fetchColumn();

            array_push($array, $arrayPlanes, $totalPlanes);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getPlanById($idPlan)
    {
        try {
            $array = array();

            $queryplan = Database::getInstance()->getDb()->prepare("SELECT * FROM plantb WHERE idPlan = ?");
            $queryplandisciplina = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDisciplina,
            d.nombre,
            p.numero 
            FROM plantb_disciplinatb AS p 
            INNER JOIN disciplinatb AS d ON p.idDisciplina = d.idDisciplina 
            WHERE p.idPlan = ?");

            $queryplan->bindValue(1, $idPlan, PDO::PARAM_STR);
            $queryplan->execute();
            if ($rowp = $queryplan->fetch()) {
                $queryplandisciplina->bindValue(1, $idPlan, PDO::PARAM_STR);
                $queryplandisciplina->execute();
                $arr_tarnos = array();
                while ($rowpd = $queryplandisciplina->fetch()) {
                    array_push($arr_tarnos, array(
                        "id" => $rowpd['idDisciplina'],
                        "name" => $rowpd['nombre'],
                        "sesiones" => $rowpd['numero']
                    ));
                }

                $querydisciplina = Database::getInstance()->getDb()->prepare("SELECT idDisciplina, nombre FROM disciplinatb");
                $querydisciplina->execute();
                $arrayDisciplina = array();
                while ($rowd = $querydisciplina->fetchObject()) {
                    array_push($arrayDisciplina, $rowd);
                }

                $plan =  (object) array(
                    "idPlan" => $rowp['idPlan'],
                    "nombre" => $rowp['nombre'],
                    "tipoDisciplina" => $rowp['tipoDisciplina'],
                    "tipoPlan" => $rowp['tipoPlan'],
                    "sesiones" => $rowp['sesiones'],
                    "meses" => $rowp['meses'],
                    "dias" => $rowp['dias'],
                    "freeze" => $rowp['freeze'],
                    "precio" => $rowp['precio'],
                    "descripcion" => $rowp['descripcion'],
                    "disciplinas" => $arr_tarnos,
                    "estado" => $rowp['estado'],
                    "prueba" => $rowp['prueba']
                );

                array_push($array, $plan, $arrayDisciplina);

                return $array;
            } else {
                throw new Exception("No se encontro el plan, intente nuevamente.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getAllDatosForSelect()
    {
        $queryplan = "SELECT idPlan,nombre,tipoDisciplina,meses,dias,freeze,sesiones,precio,descripcion FROM plantb WHERE estado = 1 AND prueba = 0 AND tipoPlan = 0";
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
                    "disciplinas" => $arr_disciplinas
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllDatosForSelectLibre()
    {
        $queryplan = "SELECT idPlan,nombre,tipoDisciplina,meses,dias,freeze,sesiones,precio,descripcion FROM plantb WHERE estado = 1 AND prueba = 0 AND tipoPlan = 1";
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
                    "disciplinas" => $arr_disciplinas
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
