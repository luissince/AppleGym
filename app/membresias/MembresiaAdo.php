<?php

require '../database/DataBaseConexion.php';

class MembresiaAdo
{

    function __construct()
    {
    }

    public static function listarMembresias($opcion, $buscar, $tipo, $x, $y)
    {
        try {
            $array = array();

            $membresia = Database::getInstance()->getDb()->prepare("SELECT 
            m.idMembresia,
            c.dni,
            c.apellidos,
            c.nombres,
            p.nombre AS 'nombrePlan',  
            m.tipoMembresia,
            m.fechaInicio, 
            m.fechaFin, 
            CASE 
            /*WHEN CAST(PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM NOW()), EXTRACT(YEAR_MONTH FROM m.fechaFin)) AS INT) < 0 THEN 1*/
            WHEN m.estado = 0 THEN 3
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 THEN 1
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) <=10 THEN 2
            ELSE 0 END AS 'membresia', 
            m.cantidad, 
            m.precio, 
            SUM(m.cantidad*m.precio) AS 'total' 
            FROM membresiatb AS m 
            INNER JOIN plantb AS p ON p.idPlan = m.idPlan
            INNER JOIN clientetb AS c ON c.idCliente  = m.idCliente
            WHERE 
            ? = 0 AND m.estado <> -1
            OR
            ? = 1 AND c.dni LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND c.apellidos LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND c.nombres LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND CONCAT(c.apellidos,' ', c.nombres) LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND CONCAT(c.nombres,' ',c.apellidos) LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND p.nombre LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 2 AND ? = 1 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 AND m.estado = 1 
            OR
            ? = 2 AND ? = 2 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) <=10 AND m.estado = 1
            OR
            ? = 2 AND ? = 3 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) < 0 AND m.estado = 1
            OR
            ? = 2 AND ? = 4 AND m.estado = 0
            GROUP BY m.idMembresia
            LIMIT ?,?");
            $membresia->bindParam(1, $opcion, PDO::PARAM_INT); //0

            $membresia->bindParam(2, $opcion, PDO::PARAM_INT); //dni
            $membresia->bindParam(3, $buscar, PDO::PARAM_STR);

            $membresia->bindParam(4, $opcion, PDO::PARAM_INT); //apellidos
            $membresia->bindParam(5, $buscar, PDO::PARAM_STR);

            $membresia->bindParam(6, $opcion, PDO::PARAM_INT); //nombres
            $membresia->bindParam(7, $buscar, PDO::PARAM_STR);

            $membresia->bindParam(8, $opcion, PDO::PARAM_INT); //apellidos y nombres
            $membresia->bindParam(9, $buscar, PDO::PARAM_STR);

            $membresia->bindParam(10, $opcion, PDO::PARAM_INT); //nombres Y apellidos
            $membresia->bindParam(11, $buscar, PDO::PARAM_STR);

            $membresia->bindParam(12, $opcion, PDO::PARAM_INT); //plan
            $membresia->bindParam(13, $buscar, PDO::PARAM_STR);

            $membresia->bindParam(14, $opcion, PDO::PARAM_INT);
            $membresia->bindParam(15, $tipo, PDO::PARAM_INT);

            $membresia->bindParam(16, $opcion, PDO::PARAM_INT);
            $membresia->bindParam(17, $tipo, PDO::PARAM_INT);

            $membresia->bindParam(18, $opcion, PDO::PARAM_INT);
            $membresia->bindParam(19, $tipo, PDO::PARAM_INT);

            $membresia->bindParam(20, $opcion, PDO::PARAM_INT);
            $membresia->bindParam(21, $tipo, PDO::PARAM_INT);

            $membresia->bindParam(22, $x, PDO::PARAM_INT);
            $membresia->bindParam(23, $y, PDO::PARAM_INT);
            $membresia->execute();

            $count = 0;
            $array_membresias = array();
            while ($row = $membresia->fetch()) {
                $count++;
                array_push($array_membresias, array(
                    "id" => $count,
                    "idMembresia" => $row["idMembresia"],
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "membresia" => $row["membresia"],
                    "nombrePlan" => $row["nombrePlan"],
                    "fechaInicio" => $row["fechaInicio"],
                    "fechaFin" => $row["fechaFin"],
                    "total" => floatval($row["total"]),
                ));
            }

            $total = Database::getInstance()->getDb()->prepare("SELECT count(m.idMembresia) 
            FROM membresiatb AS m 
            INNER JOIN plantb AS p ON p.idPlan = m.idPlan
            INNER JOIN clientetb AS c ON c.idCliente  = m.idCliente
            WHERE 
            ? = 0 AND m.estado <> -1
            OR
            ? = 1 AND c.dni LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND c.apellidos LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND c.nombres LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND CONCAT(c.apellidos,' ', c.nombres) LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND CONCAT(c.nombres,' ',c.apellidos) LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 1 AND p.nombre LIKE CONCAT(?,'%') AND m.estado <> -1
            OR
            ? = 2 AND ? = 1 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 AND m.estado = 1
            OR
            ? = 2 AND ? = 2 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) <=10 AND m.estado = 1
            OR
            ? = 2 AND ? = 3 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS int) < 0 AND m.estado = 1
            OR
            ? = 2 AND ? = 4 AND m.estado = 0");
            $total->bindParam(1, $opcion, PDO::PARAM_INT); //0

            $total->bindParam(2, $opcion, PDO::PARAM_INT); //dni
            $total->bindParam(3, $buscar, PDO::PARAM_STR);

            $total->bindParam(4, $opcion, PDO::PARAM_INT); //apelldos
            $total->bindParam(5, $buscar, PDO::PARAM_STR);

            $total->bindParam(6, $opcion, PDO::PARAM_INT); //nombres
            $total->bindParam(7, $buscar, PDO::PARAM_STR);

            $total->bindParam(8, $opcion, PDO::PARAM_INT); //apellidos y nombres
            $total->bindParam(9, $buscar, PDO::PARAM_STR);

            $total->bindParam(10, $opcion, PDO::PARAM_INT); //nombres Y apellidos
            $total->bindParam(11, $buscar, PDO::PARAM_STR);

            $total->bindParam(12, $opcion, PDO::PARAM_INT); //plan
            $total->bindParam(13, $buscar, PDO::PARAM_STR);

            $total->bindParam(14, $opcion, PDO::PARAM_INT);
            $total->bindParam(15, $tipo, PDO::PARAM_INT);

            $total->bindParam(16, $opcion, PDO::PARAM_INT);
            $total->bindParam(17, $tipo, PDO::PARAM_INT);

            $total->bindParam(18, $opcion, PDO::PARAM_INT);
            $total->bindParam(19, $tipo, PDO::PARAM_INT);

            $total->bindParam(20, $opcion, PDO::PARAM_INT);
            $total->bindParam(21, $tipo, PDO::PARAM_INT);

            $total->execute();
            $resultTotal = $total->fetchColumn();

            array_push($array, $array_membresias, $resultTotal);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function listarMembresiasReporte($month, $year)
    {
        try {
            $membresia = Database::getInstance()->getDb()->prepare("SELECT 
            m.idMembresia,
            c.dni,
            c.apellidos,
            c.nombres,
            p.nombre AS 'nombrePlan', 
            m.tipoMembresia,
            m.fechaInicio, 
            m.fechaFin, 
            CASE 
            WHEN m.estado = 0 THEN 'Traspaso'
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 THEN 'Activa'
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) <=10 THEN 'Por Vencer'
            ELSE 'Finalizada' END AS 'membresia',
            CASE
            WHEN m.tipoMembresia = '2' THEN 'RECUPERACIÓN'
            WHEN m.tipoMembresia = '3' THEN 'TRASPASO'
            WHEN m.tipoMembresia = '4' THEN 'ACTIVACIÓN'
            WHEN m.tipoMembresia = '5' THEN 'RENOVACIÓN'
            ELSE 'NUEVO' END AS 'tipo'
            FROM detalleventatb as dv
            INNER JOIN membresiatb AS m ON m.idMembresia = dv.idOrigen 
            INNER JOIN plantb AS p ON p.idPlan = m.idPlan
            INNER JOIN clientetb AS c ON c.idCliente  = m.idCliente
            WHERE 
            ? = (SELECT MONTH(v.fecha) 
            FROM ventatb AS v 
            WHERE dv.idVenta =  v.idVenta)
            AND 
            ? = (SELECT YEAR(v.fecha)
            FROM ventatb AS v 
            WHERE dv.idVenta =  v.idVenta)
            AND m.estado <> -1 
            GROUP BY m.idMembresia");
            $membresia->bindParam(1, $month, PDO::PARAM_INT);
            $membresia->bindParam(2, $year, PDO::PARAM_INT);
            $membresia->execute();

            $count = 0;
            $array_membresias = array();
            while ($row = $membresia->fetch()) {
                $count++;
                array_push($array_membresias, array(
                    "id" => $count,
                    "idMembresia" => $row["idMembresia"],
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "membresia" => $row["membresia"],
                    "nombrePlan" => $row["nombrePlan"],
                    "fechaInicio" => date("d/m/Y", strtotime($row["fechaInicio"])),
                    "fechaFin" => date("d/m/Y", strtotime($row["fechaFin"])),
                    "tipo" => $row["tipo"],
                ));
            }

            return $array_membresias;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getAllMembresiasPorCliente($idCliente, $x, $y)
    {

        try {
            $array = array();
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            m.idMembresia, 
            p.nombre,
            m.tipoMembresia,
            m.fechaInicio, 
            m.fechaFin, 
            CASE 
            WHEN m.estado = 0 THEN 3
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 THEN 1
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) <=10 THEN 2
            ELSE 0 END AS 'membresia', 
            m.cantidad, 
            m.precio, 
            SUM(m.cantidad*m.precio) as 'total' 
            FROM membresiatb as m
            INNER JOIN plantb as p ON p.idPlan = m.idPlan
            WHERE m.idCliente = ? AND m.estado <> -1 
            GROUP BY m.idMembresia");
            $comando->bindValue(1, $idCliente, PDO::PARAM_STR);
            $comando->execute();
            $arrayDetalle = array();
            while ($row = $comando->fetchObject()) {
                array_push($arrayDetalle, $row);
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT count(*) 
            FROM membresiatb as m
            INNER JOIN plantb as p ON p.idPlan = m.idPlan
            WHERE m.idCliente = ? AND m.estado <> -1");
            $comando->bindValue(1, $idCliente, PDO::PARAM_STR);
            $comando->execute();
            $resulTotal = $comando->fetchColumn();

            array_push($array, $arrayDetalle, $resulTotal);
            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function GetByIdHistorialMembresia($idMembresia)
    {
        try {
            $historialMembresia = Database::getInstance()->getDb()->prepare("SELECT 
            descripcion,
            fecha,
            hora,
            fechaInicio,
            fechaFinal
            FROM historialmembresia 
            WHERE idMembresia = ?");
            $historialMembresia->bindValue(1, $idMembresia, PDO::PARAM_STR);
            $historialMembresia->execute();

            $count = 0;
            $arrayHistorialMembresia = array();
            while ($row =   $historialMembresia->fetch()) {
                $count++;
                array_push($arrayHistorialMembresia, array(
                    "id" => $count,
                    "descripcion" => $row["descripcion"],
                    "fecha" => $row["fecha"],
                    "hora" => $row["hora"],
                    "fechaInicio" => $row["fechaInicio"],
                    "fechaFinal" => $row["fechaFinal"]
                ));
            }

            return $arrayHistorialMembresia;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public static function GetByIdMembresia($idMembresia)
    {
        try {
            $cmdMembresia = Database::getInstance()->getDb()->prepare("SELECT 
            m.idMembresia ,
            m.idPlan,
            m.idCliente,
            m.fechaInicio,
            m.horaInicio,
            m.fechaFin,
            m.horaFin,
            m.tipoMembresia,
            m.estado,
            m.cantidad,
            m.precio,
            m.descuento,
            m.congelar,
            p.freeze
            FROM membresiatb AS m
            INNER JOIN plantb AS p ON p.idPlan = m.idPlan
            WHERE idMembresia = ?");
            $cmdMembresia->bindValue(1, $idMembresia, PDO::PARAM_STR);
            $cmdMembresia->execute();
            $membresia = $cmdMembresia->fetchObject();
            if (!$membresia) {
                throw new Exception("Membresía no encontrada, intente nuevamente.");
            }
            return $membresia;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function AjustarMembresiaFecha($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate =  Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb  WHERE idMembresia = ? AND estado = 0");
            $validate->bindValue(1, $body["idMembresia"], PDO::PARAM_STR);
            $validate->execute();
            if ($validate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'inactivo';
            } else {
                $validate =  Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb  WHERE idMembresia = ?");
                $validate->bindValue(1, $body["idMembresia"], PDO::PARAM_STR);
                $validate->execute();
                $resultValidate = $validate->fetchObject();

                $cmdMembresia = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET fechaFin = ? WHERE idMembresia = ?");
                $cmdMembresia->bindValue(1, $body["fechaFin"], PDO::PARAM_STR);
                $cmdMembresia->bindValue(2, $body["idMembresia"], PDO::PARAM_STR);
                $cmdMembresia->execute();

                $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                $cmdHistorialMembresia->execute(array($body["idMembresia"], "AJUSTE POR FECHA", $body['fecha'], $body['hora'], $resultValidate->fechaInicio, $body["fechaFin"]));

                Database::getInstance()->getDb()->commit();
                return "updated";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function AjustarMembresiaFreeze($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $validate =  Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb  WHERE idMembresia = ? AND estado = 0");
            $validate->bindValue(1, $body["idMembresia"], PDO::PARAM_STR);
            $validate->execute();
            if ($validate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'inactivo';
            } else {
                $validate =  Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb  WHERE idMembresia = ?");
                $validate->bindValue(1, $body["idMembresia"], PDO::PARAM_STR);
                $validate->execute();
                $resultValidate = $validate->fetchObject();

                $date = new DateTime($body["fechaFin"]);
                $date->modify("+" . $body["dias"] . " day");

                $cmdMembresia = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET fechaFin = ?,congelar = congelar+ ? WHERE idMembresia = ?");
                $cmdMembresia->bindValue(1, $date->format('Y-m-d'), PDO::PARAM_STR);
                $cmdMembresia->bindValue(2, $body["dias"], PDO::PARAM_INT);
                $cmdMembresia->bindValue(3, $body["idMembresia"], PDO::PARAM_STR);
                $cmdMembresia->execute();

                $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                $cmdHistorialMembresia->execute(array($body["idMembresia"], "AJUSTE POR FREEZE", $body['fecha'], $body['hora'], $resultValidate->fechaInicio, $date->format('Y-m-d')));

                Database::getInstance()->getDb()->commit();
                return "updated";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getMembresiaClienteRenovacion($idCliente)
    {
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            m.idMembresia,
            m.fechaInicio,
            m.fechaFin,
            CASE 
            WHEN m.estado = 0 THEN 3
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) > 10 THEN 1
            WHEN CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) >=0 AND CAST(DATEDIFF(m.fechaFin,CURDATE()) AS INT) <=10 THEN 2
            ELSE 0 END AS 'estado', 
            p.idPlan,
            p.nombre,
            p.meses,
            p.dias,
            p.freeze,
            p.precio
            FROM membresiatb AS m 
            INNER JOIN plantb AS p ON p.idPlan = m.idPlan
            WHERE m.idCliente = ? AND m.estado <> -1");
            $comando->bindParam(1, $idCliente, PDO::PARAM_STR);
            $comando->execute();

            $arrayDetalle = array();
            while ($row = $comando->fetchObject()) {
                array_push($arrayDetalle, $row);
            }
            return $arrayDetalle;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
