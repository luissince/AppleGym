<?php

require '../database/DataBaseConexion.php';

class MembresiasAdo {

    function __construct() {
        
    }

    public static function getAllMembresias($x, $y) {
        $consulta = "SELECT m.idMembresia,c.dni,c.apellidos,c.nombres,p.nombre as plan,p.meses,p.dias,p.freeze,m.fechaInicio,m.fechaFin,m.tipo,m.estado FROM membresiatb as m INNER JOIN clientetb as c on m.idCliente = c.idCliente INNER JOIN plantb as p on m.idPlan = p.idPlan LIMIT $x,$y";
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
        $consulta = "SELECT COUNT(m.idMembresia) FROM membresiatb as m INNER JOIN clientetb as c on m.idCliente = c.idCliente INNER JOIN plantb as p on m.idPlan = p.idPlan";
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
