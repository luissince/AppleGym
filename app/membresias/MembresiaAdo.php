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
    
    
}

