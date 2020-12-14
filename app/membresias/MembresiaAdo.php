<?php

require '../database/DataBaseConexion.php';

class MembresiaAdo {
    
     function __construct() {
        
    }
    
    public static function getAllMembresias($x, $y) {
        $consulta = "SELECT * FROM membresiatb LIMIT $x,$y";
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
    
    public static function getAllCountMembresias() {
        $consulta = "SELECT COUNT(*) FROM membresiatb";
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

    public static function getAllMembresiasPorCliente($idCliente, $x, $y){

        try{
            $array = array();
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare("SELECT v.idVenta, v.cliente, m.idMembresia, p.nombre, v.documento, v.serie, v.numeracion, m.fechaInicio, m.fechaFin, v.estado, m.cantidad, m.precio, SUM(m.cantidad*m.precio) as 'total' 
            FROM membresiatb as m
            INNER JOIN ventatb as v ON v.idVenta = m.idVenta
            INNER JOIN plantb as p ON p.idPlan = m.idPlan
            where v.cliente=?
            GROUP BY m.idMembresia");
            $comando->bindValue(1,$idCliente,PDO::PARAM_STR);
            $comando->execute();
            $arrayDetalle = array();
            while($row = $comando->fetch()){
                array_push($arrayDetalle,$row);
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT count(*) FROM membresiatb as m
            INNER JOIN ventatb as v ON v.idVenta = m.idVenta
            INNER JOIN plantb as p ON p.idPlan = m.idPlan
            where v.cliente=?");
            $comando->bindValue(1,$idCliente,PDO::PARAM_STR);
            $comando->execute();
            $resulTotal = $comando->fetchColumn();
        
            array_push($array,$arrayDetalle,$resulTotal);
            return $array;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    
    
}