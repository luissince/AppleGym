<?php

require '../database/DataBaseConexion.php';

class ComprobanteAdo
{

    function __construct()
    {
    }


    public static function getAllComprobantes($search, $x, $y)
    {
        try {
            $array = array();

            $comprobantes = Database::getInstance()->getDb()->prepare("SELECT * 
            FROM tipocomprobantetb 
            WHERE 
            nombre LIKE CONCAT('%',?,'%')            
            LIMIT ?,?");
            $comprobantes->bindValue(1, $search, PDO::PARAM_STR);
            $comprobantes->bindValue(2, $x, PDO::PARAM_INT);
            $comprobantes->bindValue(3, $y, PDO::PARAM_INT);
            $comprobantes->execute();

            $arrayComprobantes = array();
            $count = 0;
            while ($row = $comprobantes->fetch()) {
                $count++;
                array_push($arrayComprobantes, array(
                    "id" => $count + $x,
                    "idTipoComprobante" => $row["idTipoComprobante"],
                    "nombre" => $row["nombre"],
                    "serie" => $row["serie"],
                    "numeracion" => $row["numeracion"],
                    "predeterminado" => $row["predeterminado"],
                    "estado" => $row["estado"]
                ));
            }

            $comprobantes = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM tipocomprobantetb 
            WHERE  
            nombre LIKE CONCAT('%',?,'%')");
            $comprobantes->bindValue(1, $search, PDO::PARAM_STR);
            $comprobantes->execute();
            $totalComprobantes =  $comprobantes->fetchColumn();

            array_push($array, $arrayComprobantes, $totalComprobantes);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getByIdComprobante($idComprobante)
    {
        try {
        } catch (Exception $ex) {
        }
    }

    public static function crudComprobante($body)
    {
        try {
        } catch (Exception $ex) {
        }
    }

    public static function deleteComprobante($idComprobante)
    {
        try {
        } catch (Exception $ex) {
        }
    }
}
