<?php

require '../database/DataBaseConexion.php';

class VentaAdo {

    function __construct() {
        
    }

    public static function insertVenta($body) {

        // Sentencia INSERT
        $quey_codigo_venta = "SELECT Fc_Venta_Codigo_Almanumerico();";
        $quey_codigo_membresia = "SELECT Fc_Membresia_Codigo_Almanumerico();";

        $detalle_venta = "INSERT INTO detalleventatb ( 
                idVenta,
                idOrigen,
                cantidad,
                precio,
                descuento,
                procedencia)
                VALUES(?,?,?,?,?,?)";

        $venta_credito = "INSERT INTO ventacreditotb(" .
                "idVenta," .
                "monto," .
                "fechaRegistro," .
                "horaRegistro," .
                "estado)" .
                " VALUES(?,?,?,?,?)";

        $membresia = "INSERT INTO membresiatb("
                . "idMembresia,"
                . "idPlan,"
                . "idCliente,"
                . "idVenta,"
                . "fechaInicio,"
                . "horaInicio,"
                . "fechaFin,"
                . "horaFin,"
                . "tipoMembresia,"
                . "estado,"
                . "cantidad,"
                . "precio,"
                . "descuento)"
                . "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {

            
            // Preparar la sentencia
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidando = Database::getInstance()->getDb()->prepare('SELECT serie FROM tipocomprobantetb WHERE idTipoComprobante  = ?');
            $cmdValidando->bindValue(1,$body["tipoDocumento"],PDO::PARAM_STR);
            $cmdValidando->execute();
            $serie = $cmdValidando->fetchColumn();

            $cmdValidando = Database::getInstance()->getDb()->prepare('SELECT * FROM ventatb WHERE serie = ?');
            $cmdValidando->bindValue(1,$serie,PDO::PARAM_STR);
            $cmdValidando->execute();
            if($cmdValidando->fetch()){
                $AuxNumeracion = Database::getInstance()->getDb()->prepare('SELECT max(numeracion)  FROM ventatb WHERE serie = ?');
                $AuxNumeracion->bindValue(1,$serie,PDO::PARAM_STR);
                $AuxNumeracion->execute();
                $Aumentado = $AuxNumeracion->fetchColumn() + 1;
				$ResultNumeracion =  $Aumentado;
            }else{
                $Numeracion = Database::getInstance()->getDb()->prepare('SELECT numeracion FROM tipocomprobantetb WHERE idTipoComprobante = ?');
                $Numeracion->bindValue(1,$body["tipoDocumento"],PDO::PARAM_STR);
                $Numeracion->execute();
				$ResultNumeracion = $Numeracion->fetchColumn();
            }

            $codigoVenta = Database::getInstance()->getDb()->prepare($quey_codigo_venta);
            $codigoVenta->execute();
            $idVenta = $codigoVenta->fetchColumn();

            $executeVenta = Database::getInstance()->getDb()->prepare("INSERT INTO ventatb ( 
                idVenta, 
                cliente,
                vendedor,
                documento,
                serie,
                numeracion,
                fecha,
                hora,
                tipo,
                forma,
                numero,
                pago,
                vuelto,
                estado)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $executeVenta->execute(
                    array(
                        $idVenta,
                        $body['cliente'],
                        $body['vendedor'],
                        $body["tipoDocumento"],
                        $serie,
                        $ResultNumeracion,
                        $body['fecha'],
                        $body['hora'],
                        $body['tipo'],
                        $body['forma'],
                        $body['numero'],
                        $body['pago'],
                        $body['vuelto'],                        
                        $body['estado']
                    )
            );

            // if ($body['tipo'] == 1) {
            //     $codigoIngresoNumerico = Database::getInstance()->getDb()->prepare($quey_codigo_ingreso_numerico);
            //     $codigoIngresoNumerico->execute();
            //     $numeracion = $codigoIngresoNumerico->fetchColumn();

            //     $executeIngreso = Database::getInstance()->getDb()->prepare($ingreso);
            //     $executeIngreso->execute(array(
            //         $idVenta,
            //         $body['fecha'],
            //         $body['hora'],
            //         $body['forma'],
            //         $body['total'],
            //         "P0001",
            //         $numeracion,
            //         $body['procedencia']
            //     ));
            // } else if ($body['tipo'] == 2) {
            //     $executeVentaCredito = Database::getInstance()->getDb()->prepare($venta_credito);
            //     $total_credito_inicial = 0;
            //     foreach ($body['credito'] as $credito) {
            //         if ($credito['inicial'] == true) {
            //             $total_credito_inicial += $credito['monto'];
            //         }
            //         $executeVentaCredito->execute(
            //                 array(
            //                     $idVenta,
            //                     $credito['monto'],
            //                     $credito['fecha'],
            //                     $credito['hora'],
            //                     $credito['inicial']
            //                 )
            //         );
            //     }

            //     if ($total_credito_inicial > 0) {
            //         $codigoIngresoNumerico = Database::getInstance()->getDb()->prepare($quey_codigo_ingreso_numerico);
            //         $codigoIngresoNumerico->execute();
            //         $numeracion = $codigoIngresoNumerico->fetchColumn();

            //         $executeIngreso = Database::getInstance()->getDb()->prepare($ingreso);
            //         $executeIngreso->execute(array(
            //             $idVenta,
            //             $body['fecha'],
            //             $body['hora'],
            //             $body['forma'],
            //             $total_credito_inicial,
            //             "P0001",
            //             $numeracion,
            //             $body['procedencia']
            //         ));
            //     }
            // }

            $executeDetalleVenta = Database::getInstance()->getDb()->prepare($detalle_venta);
            foreach ($body['lista'] as $result) {
                $executeDetalleVenta->execute(
                        array(
                            $idVenta,
                            $result['idPlan'],
                            $result['cantidad'],
                            $result['precio'],
                            $result['descuento'],
                            $result['procedencia']
                        )
                );

                if ($result["procedencia"] == 1) {
                    $codigoMembresia = Database::getInstance()->getDb()->prepare($quey_codigo_membresia);
                    $codigoMembresia->execute();
                    $idMembresia = $codigoMembresia->fetchColumn();

                    $executeMembresia = Database::getInstance()->getDb()->prepare($membresia);
                    $executeMembresia->execute(
                            array(
                                $idMembresia,
                                $result['idPlan'],
                                $body['cliente'],
                                $idVenta,
                                $result['fechaInico'],
                                $result['horaInicio'],
                                $result['fechaFin'],
                                $result['horaFin'],
                                $result['membresia'],
                                1,
                                $result['cantidad'],
                                $result['precio'],
                                $result['descuento'],
                            )
                    );
                }
            }

            Database::getInstance()->getDb()->commit();
           return "true";
        } catch (Exception $e) {
            //Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function getAll($x, $y) {
        $consulta = "SELECT v.idVenta,v.fecha,v.hora,t.nombre,v.serie,v.numeracion,v.tipo,v.forma,v.numero,v.estado,
        c.apellidos,c.nombres,sum(d.cantidad*d.precio) as 'total'
        from ventatb as v 
        INNER JOIN clientetb as c on c.idCliente = c.idCliente
        INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
        INNER JOIN detalleventatb as d ON d.idVenta = v.idVenta
        GROUP BY v.idVenta ORDER BY v.fecha DESC,v.hora DESC LIMIT $x,$y";
        try {

            $array = array();

            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();            
            $count = 0;
            $arrayVentas = array();
            while($row = $comando->fetch()){
                array_push($arrayVentas,array(
                    "id"=>$count,
                    "idVenta"=>$row["idVenta"],
                    "fecha"=>$row["fecha"],
                    "hora"=>$row["hora"],
                    "nombre"=>$row["nombre"],
                    "serie"=>$row["serie"],
                    "numeracion"=>$row["numeracion"],
                    "tipo"=>$row["tipo"],
                    "forma"=>$row["forma"],
                    "numero"=>$row["numero"],
                    "estado"=>$row["estado"],
                    "apellidos"=>$row["apellidos"],
                    "nombres"=>$row["nombres"],
                    "total"=>$row["total"]
                ));
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT count(*) as 'total'
            from ventatb as v 
            INNER JOIN clientetb as c on c.idCliente = c.idCliente
            INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
            INNER JOIN detalleventatb as d ON d.idVenta = v.idVenta
            GROUP BY v.idVenta");
            $comando->execute();
            $totalVentas =  $comando->fetchColumn();

            array_push($array,$arrayVentas,$totalVentas);

            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public static function getVentaSearchPrincipal($search, $x, $y) {
        $consulta = "SELECT v.idVenta,e.apellidos AS apellidosEmpleado,e.nombres AS nombresEmpleado,c.apellidos AS apellidosCliente,c.nombres AS nombresCliente,v.serie,v.numeracion,v.fecha,v.hora,v.total,v.tipo,v.forma,v.numero,v.estado,v.procedencia FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado
        INNER JOIN clientetb AS c ON v.cliente = c.idCliente 
        WHERE 
        (c.apellidos LIKE ? OR c.nombres LIKE ?) 
        OR 
        (e.apellidos LIKE ? OR e.nombres LIKE ?)
        OR
        v.serie LIKE ?
        OR
        v.numeracion LIKE ?
        OR
        (CONCAT(v.serie,' ',v.numeracion) LIKE ? )
        ORDER BY v.fecha DESC,v.hora DESC LIMIT $x,$y";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->bindValue(2, "$search%", PDO::PARAM_STR);
            $comando->bindValue(3, "$search%", PDO::PARAM_STR);
            $comando->bindValue(4, "$search%", PDO::PARAM_STR);
            $comando->bindValue(5, "$search%", PDO::PARAM_STR);
            $comando->bindValue(6, "$search%", PDO::PARAM_STR);
            $comando->bindValue(7, "$search%", PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getVentaSearchPrincipalCount($search) {
        $consulta = "SELECT COUNT(v.idVenta) FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado
        INNER JOIN clientetb AS c ON v.cliente = c.idCliente 
        WHERE
        (c.apellidos LIKE ? OR c.nombres LIKE ?) 
        OR 
        (e.apellidos LIKE ? OR e.nombres LIKE ?)
        OR
        v.numeracion LIKE ?
        OR
        (CONCAT(v.serie,' ',v.numeracion) LIKE ? )
        ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->bindValue(2, "$search%", PDO::PARAM_STR);
            $comando->bindValue(3, "$search%", PDO::PARAM_STR);
            $comando->bindValue(4, "$search%", PDO::PARAM_STR);
            $comando->bindValue(5, "$search%", PDO::PARAM_STR);
            $comando->bindValue(6, "$search%", PDO::PARAM_STR);
            $comando->bindValue(7, "$search%", PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public static function getVentaSearchOptions($transaccion, $fechaInicial, $fechaFinal, $tipo, $forma, $estado, $x, $y) {
        $consulta = "CALL Sp_Listar_Ventas_Search_Options(?,?,?,?,?,?,?,?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindParam(1, $transaccion);
            $comando->bindParam(2, $fechaInicial);
            $comando->bindParam(3, $fechaFinal);
            $comando->bindParam(4, $tipo);
            $comando->bindParam(5, $forma);
            $comando->bindParam(6, $estado);
            $comando->bindParam(7, $x);
            $comando->bindParam(8, $y);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    public static function getVentaSearchOptionsCount($transaccion, $fechaInicial, $fechaFinal, $tipo, $forma, $estado) {
        $consulta = "CALL Sp_Listar_Ventas_Search_Options_Count(?,?,?,?,?,?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindParam(1, $transaccion);
            $comando->bindParam(2, $fechaInicial);
            $comando->bindParam(3, $fechaFinal);
            $comando->bindParam(4, $tipo);
            $comando->bindParam(5, $forma);
            $comando->bindParam(6, $estado);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public static function getVentaReporteAll() {
        $consulta = "SELECT v.idVenta,e.apellidos AS apellidosEmpleado,e.nombres AS nombresEmpleado,c.apellidos AS apellidosCliente,c.nombres AS nombresCliente,v.serie,v.numeracion,v.fecha,v.hora,v.total,v.tipo,v.forma,v.numero,v.estado,v.procedencia FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado
        INNER JOIN clientetb AS c ON v.cliente = c.idCliente ORDER BY v.fecha DESC,v.hora DESC";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando;
        } catch (PDOException $e) {
            return array();
        }
    }

    public static function getVentaReporteSearchPrincipal($search) {
        $consulta = "SELECT v.idVenta,e.apellidos AS apellidosEmpleado,e.nombres AS nombresEmpleado,c.apellidos AS apellidosCliente,c.nombres AS nombresCliente,v.serie,v.numeracion,v.fecha,v.hora,v.total,v.tipo,v.forma,v.numero,v.estado,v.procedencia FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado
        INNER JOIN clientetb AS c ON v.cliente = c.idCliente 
        WHERE 
        (c.apellidos LIKE ? OR c.nombres LIKE ?) 
        OR 
        (e.apellidos LIKE ? OR e.nombres LIKE ?)
        OR
        v.serie LIKE ?
        OR
        v.numeracion LIKE ?
        OR
        (CONCAT(v.serie,' ',v.numeracion) LIKE ? )
        ORDER BY v.fecha DESC,v.hora DESC";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->bindValue(2, "$search%", PDO::PARAM_STR);
            $comando->bindValue(3, "$search%", PDO::PARAM_STR);
            $comando->bindValue(4, "$search%", PDO::PARAM_STR);
            $comando->bindValue(5, "$search%", PDO::PARAM_STR);
            $comando->bindValue(6, "$search%", PDO::PARAM_STR);
            $comando->bindValue(7, "$search%", PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando;
        } catch (PDOException $e) {
            return array();
        }
    }

    public static function getVentaReporteSearchOptions($transaccion, $fechaInicial, $fechaFinal, $tipo, $forma, $estado) {
        $consulta = "CALL Sp_Listar_Ventas_Reporte_Options(?,?,?,?,?,?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindParam(1, $transaccion);
            $comando->bindParam(2, $fechaInicial);
            $comando->bindParam(3, $fechaFinal);
            $comando->bindParam(4, $tipo);
            $comando->bindParam(5, $forma);
            $comando->bindParam(6, $estado);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $comando;
        } catch (PDOException $e) {
            return array();
        }
    }

    public static function getVenta($idVenta) {
        $object_venta = null;
        try {
            $venta = Database::getInstance()->getDb()->prepare("SELECT v.idVenta,e.apellidos AS apellidosEmpleado,e.nombres AS nombresEmpleado,c.apellidos AS apellidosCliente,c.nombres AS nombresCliente,c.dni,c.celular,c.email,c.direccion,v.documento,v.serie,v.numeracion,v.fecha,v.hora,v.total,v.tipo,v.forma,v.numero,v.estado FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado
            INNER JOIN clientetb AS c ON v.cliente = c.idCliente WHERE v.idVenta = ?");
            $venta->execute(array($idVenta));
            while ($rowv = $venta->fetch()) {
                $object_venta = array(
                    "idVenta" => $rowv["idVenta"],
                    "apellidosEmpleado" => $rowv["apellidosEmpleado"],
                    "nombresEmpleado" => $rowv["nombresEmpleado"],
                    "apellidosCliente" => $rowv["apellidosCliente"],
                    "nombresCliente" => $rowv["nombresCliente"],
                    "dni" => $rowv["dni"],
                    "celular" => $rowv["celular"],
                    "email" => $rowv["email"],
                    "direccion" => $rowv["direccion"],
                    "documento" => $rowv["documento"],
                    "serie" => $rowv["serie"],
                    "numeracion" => $rowv["numeracion"],
                    "fecha" => $rowv["fecha"],
                    "hora" => $rowv["hora"],
                    "total" => $rowv["total"],
                    "tipo" => $rowv["tipo"],
                    "forma" => $rowv["forma"],
                    "numero" => $rowv["numero"]);
            }
        } catch (Exception $ex) {
            
        }
        return $object_venta;
    }

    public static function getVentaDetalle($idVenta, $procedencia) {
        $array_venta_detalle = array();
        try {

            $venta_productos = "SELECT p.nombre,d.cantidad,d.precio,d.subTotal,d.descuento,d.total
            FROM detalleventatb AS d INNER JOIN productotb AS p ON d.idOrigen = p.idProducto WHERE d.idVenta = ?";
            $venta_membresia = "SELECT p.nombre,d.cantidad,d.precio,d.subTotal,d.descuento,d.total
            FROM detalleventatb AS d INNER JOIN plantb AS p ON d.idOrigen = p.idPlan WHERE d.idVenta = ?";

            $venta_detalle = Database::getInstance()->getDb()->prepare($procedencia == 1 ? $venta_membresia : $venta_productos);
            $venta_detalle->execute(array($idVenta));

            $count = 0;
            while ($rowvd = $venta_detalle->fetch()) {
                $count++;
                array_push($array_venta_detalle, array(
                    "id" => $count,
                    "nombre" => $rowvd["nombre"],
                    "cantidad" => $rowvd["cantidad"],
                    "precio" => $rowvd["precio"],
                    "subTotal" => $rowvd["subTotal"],
                    "descuento" => $rowvd["descuento"],
                    "total" => $rowvd["total"]
                ));
            }
        } catch (Exception $ex) {
            
        }
        return $array_venta_detalle;
    }

    public static function getVentaCredito($idVenta) {
        $array = array();
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT idVentaCredito,
                     monto,
                     fechaRegistro,
                     horaRegistro,
                     fechaPago,
                     horaPago,
                     estado
                     FROM ventacreditotb WHERE idVenta = ?");
            $comando->execute(array($idVenta));

            while ($row = $comando->fetch()) {
                array_push($array, array(
                    "idVentaCredito" => $row["idVentaCredito"],
                    "monto" => $row["monto"],
                    "fechaRegistro" => $row["fechaRegistro"],
                    "horaRegistro" => $row["horaRegistro"],
                    "fechaPago" => $row["fechaPago"],
                    "horaPago" => $row["horaPago"],
                    "estado" => $row["estado"]
                ));
            }
        } catch (Exception $ex) {
            
        }
        return $array;
    }

    public static function getAllComprobante()
    {
        try {
            $array = array();
            // Preparar sentencia
            $executecomprobante = Database::getInstance()->getDb()->prepare("SELECT idTipoComprobante,nombre FROM tipocomprobantetb");
            $executecomprobante->execute();
        
            while ($rowp = $executecomprobante->fetch()) {
                array_push($array, array(
                    "idTipoComprobante" => $rowp['idTipoComprobante'],
                    "nombre" => $rowp['nombre']
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
