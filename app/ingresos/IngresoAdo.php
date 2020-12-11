<?php

/**
 * Representa el la estructura de los Ingresos
 * almacenadas en la base de datos
 */
require '../database/DataBaseConexion.php';

class IngresoAdo {

    function __construct() {
        
    }

    public static function getIngresoAll($x, $y) {
        $array = array();
        try {
            $ingresos = Database::getInstance()->getDb()->prepare("SELECT 
                    i.idIngreso,i.fecha,i.hora,i.forma,i.monto,i.serie,i.numeracion,i.procedencia,
                    v.serie as ventaSerie,v.numeracion as ventaNumeracion
                    FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
                    ORDER BY i.fecha DESC,i.hora DESC LIMIT $x,$y");
            $ingresos->execute();
            while ($row = $ingresos->fetchObject()) {
                array_push($array, $row);
            }
        } catch (Exception $ex) {
            
        }
        return $array;
    }

    public static function getIngresoAllCount() {
        try {
            $ingresos = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM ingresotb");
            $ingresos->execute();
            return $ingresos->fetchColumn();
        } catch (Exception $ex) {
            return 0;
        }
    }

    public static function getIngresoSearch($search, $x, $y) {
        $query = "SELECT 
                    i.idIngreso,i.fecha,i.hora,i.forma,i.monto,i.serie,i.numeracion,i.procedencia,
                    v.serie as ventaSerie,v.numeracion as ventaNumeracion
                    FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
                    WHERE 
                    i.serie LIKE ?
                    OR
                    i.numeracion LIKE ?
                    OR
                    (CONCAT(i.serie,' ',i.numeracion) LIKE ?)
                    ORDER BY i.fecha DESC,i.hora DESC LIMIT $x,$y";
        try {
            $ingresos = Database::getInstance()->getDb()->prepare($query);
            $ingresos->bindValue(1, "$search%", PDO::PARAM_STR);
            $ingresos->bindValue(2, "$search%", PDO::PARAM_STR);
            $ingresos->bindValue(3, "$search%", PDO::PARAM_STR);
            $ingresos->execute();
            return $ingresos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIngresoSearchCount($search) {
        $query = "SELECT 
                    COUNT(i.idIngreso)
                    FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
                    WHERE 
                    i.serie LIKE ?
                    OR
                    i.numeracion LIKE ?
                    OR
                    (CONCAT(i.serie,'',i.numeracion)LIKE ?)
                    ";
        try {
            $ingresos = Database::getInstance()->getDb()->prepare($query);
            $ingresos->bindValue(1, "$search%", PDO::PARAM_STR);
            $ingresos->bindValue(2, "$search%", PDO::PARAM_STR);
            $ingresos->bindValue(3, "$search%", PDO::PARAM_STR);
            $ingresos->execute();
            return $ingresos->fetchColumn();
        } catch (Exception $ex) {
            return 0;
        }
    }

    public static function getIngresoOptions($transaccion, $fechaInicio, $fechaFin, $x, $y) {
        $query = "CALL Sp_Listar_Ingresos_Options(?,?,?,?,?)";
        try {
            $ingresos = Database::getInstance()->getDb()->prepare($query);
            $ingresos->bindParam(1, $transaccion);
            $ingresos->bindParam(2, $fechaInicio);
            $ingresos->bindParam(3, $fechaFin);
            $ingresos->bindParam(4, $x);
            $ingresos->bindParam(5, $y);
            $ingresos->execute();
            return $ingresos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIngresoOptionsCount($transaccion, $fechaInicio, $fechaFin) {
        $query = "CALL Sp_Listar_Ingresos_Options_Count(?,?,?)";
        try {
            $ingresos = Database::getInstance()->getDb()->prepare($query);
            $ingresos->bindParam(1, $transaccion);
            $ingresos->bindParam(2, $fechaInicio);
            $ingresos->bindParam(3, $fechaFin);
            $ingresos->execute();
            return $ingresos->fetchColumn();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIngresoPorId($idIngreso) {
        $array = array();
        try {
            $ingreso = Database::getInstance()->getDb()->prepare("SELECT * FROM ingresotb WHERE idIngreso = ?");
            $ingreso->execute(array($idIngreso));

            $cliente = Database::getInstance()->getDb()->prepare("SELECT 
                    c.dni,c.apellidos,c.nombres,c.email,c.celular,c.direccion
                    FROM ventatb AS v INNER JOIN clientetb AS c ON v.cliente = c.idCliente
                    WHERE v.idVenta = ?");

            while ($row = $ingreso->fetch()) {
                $cliente->execute(array($row['idVenta']));
                $cliente_object = $cliente->fetchObject();

                array_push($array, array(
                    "idVenta" => $row["idVenta"],
                    "fecha" => $row["fecha"],
                    "hora" => $row["hora"],
                    "forma" => $row["forma"],
                    "monto" => $row["monto"],
                    "serie" => $row["serie"],
                    "numeracion" => $row["numeracion"],
                    "procedencia" => $row["procedencia"],
                    "cliente" => $cliente_object
                ));
            }
        } catch (Exception $ex) {
            
        }
        return $array;
    }

    public static function getIngresoReporteAll() {

        try {
            $ingresos = Database::getInstance()->getDb()->prepare("SELECT 
                    i.idIngreso,i.fecha,i.hora,i.forma,i.monto,i.serie,i.numeracion,i.procedencia,
                    v.serie as ventaSerie,v.numeracion as ventaNumeracion
                    FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
                    ORDER BY i.fecha DESC,i.hora DESC");
            $ingresos->execute();
            return $ingresos;
        } catch (Exception $ex) {
            return array();
        }
    }

    public static function getIngresoReporteSearch($search) {
        $query = "SELECT 
                    i.idIngreso,i.fecha,i.hora,i.forma,i.monto,i.serie,i.numeracion,i.procedencia,
                    v.serie as ventaSerie,v.numeracion as ventaNumeracion
                    FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
                    WHERE 
                    i.serie LIKE ?
                    OR
                    i.numeracion LIKE ?
                    OR
                    (CONCAT(i.serie,' ',i.numeracion) LIKE ?)
                    ORDER BY i.fecha DESC,i.hora DESC ";
        try {
            $ingresos = Database::getInstance()->getDb()->prepare($query);
            $ingresos->bindValue(1, "$search%", PDO::PARAM_STR);
            $ingresos->bindValue(2, "$search%", PDO::PARAM_STR);
            $ingresos->bindValue(3, "$search%", PDO::PARAM_STR);
            $ingresos->execute();
            return $ingresos;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIngresoReporteOptions($transaccion, $fechaInicio, $fechaFin) {
        $query = "CALL Sp_Listar_Ingresos_Options_Reporte(?,?,?)";
        try {
            $ingresos = Database::getInstance()->getDb()->prepare($query);
            $ingresos->bindParam(1, $transaccion);
            $ingresos->bindParam(2, $fechaInicio);
            $ingresos->bindParam(3, $fechaFin);
            $ingresos->execute();
            return $ingresos;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function getListaIngresosCobros($idVenta) {
        try{
            $ingresos = Database::getInstance()->getDb()->prepare("SELECT * FROM ventacreditotb WHERE idVenta = ?");
            $ingresos->execute(array($idVenta));
            return $ingresos->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getTimeFormat($value) {
        $ar = split(":", $value);
        $hr = $ar[0];
        $min = intval($ar[1]);

        if ($min < 10) {
            $min = "0" . $min;
        }
        $ampm = "am";
        if ($hr > 12) {
            $hr -= 12;
            $ampm = "pm";
        }
        return $hr . ":" . $min . " " . $ampm;
    }

}
