<?php

require '../database/DataBaseConexion.php';

class VentaAdo
{

    function __construct()
    {
    }

    public static function insertVenta($body)
    {

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

        $ingreso = "INSERT INTO  ingresotb(" .
            "idPrecedencia ," .
            "detalle," .
            "tipo," .
            "forma," .
            "numero," .
            "monto)" .
            " VALUES(?,?,?,?,?,?)";

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
            $cmdValidando->bindValue(1, $body["tipoDocumento"], PDO::PARAM_STR);
            $cmdValidando->execute();
            $serie = $cmdValidando->fetchColumn();

            $cmdValidando = Database::getInstance()->getDb()->prepare('SELECT * FROM ventatb WHERE serie = ?');
            $cmdValidando->bindValue(1, $serie, PDO::PARAM_STR);
            $cmdValidando->execute();
            if ($cmdValidando->fetch()) {
                $AuxNumeracion = Database::getInstance()->getDb()->prepare('SELECT max(numeracion)  FROM ventatb WHERE serie = ?');
                $AuxNumeracion->bindValue(1, $serie, PDO::PARAM_STR);
                $AuxNumeracion->execute();
                $Aumentado = $AuxNumeracion->fetchColumn() + 1;
                $ResultNumeracion =  $Aumentado;
            } else {
                $Numeracion = Database::getInstance()->getDb()->prepare('SELECT numeracion FROM tipocomprobantetb WHERE idTipoComprobante = ?');
                $Numeracion->bindValue(1, $body["tipoDocumento"], PDO::PARAM_STR);
                $Numeracion->execute();
                $ResultNumeracion = $Numeracion->fetchColumn();
            }

            $total_venta = 0;

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

            if ($body['tipo'] == 2) {
                $executeVentaCredito = Database::getInstance()->getDb()->prepare($venta_credito);
                foreach ($body['credito'] as $credito) {
                    if ($credito['inicial'] == true) {
                        $total_venta += $credito['monto'];
                    }
                    $executeVentaCredito->execute(
                        array(
                            $idVenta,
                            $credito['monto'],
                            $credito['fecha'],
                            $credito['hora'],
                            $credito['inicial']
                        )
                    );
                }
            } else {
                foreach ($body['lista'] as $result) {
                    $total_venta += ($result['cantidad'] * $result['precio']);
                }
            }

            // $codigoIngresoNumerico = Database::getInstance()->getDb()->prepare($quey_codigo_ingreso_numerico);
            // $codigoIngresoNumerico->execute();
            // $numeracion = $codigoIngresoNumerico->fetchColumn();

            $executeIngreso = Database::getInstance()->getDb()->prepare($ingreso);
            $executeIngreso->execute(array(
                $idVenta,
                "INGRESO EN EFECTIVO DEL COMPROBANTE " . $serie . "-" . $ResultNumeracion,
                $body['tipo'],
                $body['forma'],
                $body['numero'],
                $total_venta
            ));

            Database::getInstance()->getDb()->commit();
            return "true";
        } catch (Exception $e) {
            //Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function getAll($search, $x, $y)
    {
        $consulta = "SELECT v.idVenta,v.fecha,v.hora,t.nombre,v.serie,v.numeracion,v.tipo,v.forma,v.numero,v.estado,
        c.apellidos,c.nombres,sum(d.cantidad*d.precio) as total,
        CASE WHEN e.apellidos IS NULL or e.apellidos = '' THEN 'SIN DATOS' ELSE e.apellidos END AS 	empleadoApellidos,
        CASE WHEN e.nombres IS NULL OR e.nombres = '' THEN 'SIN DATOS' ELSE e.nombres END AS empleadoNombres
        from ventatb as v 
        INNER JOIN clientetb as c on c.idCliente = v.cliente
        INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
        INNER JOIN detalleventatb as d on d.idVenta = v.idVenta
        LEFT JOIN empleadotb as e on e.idEmpleado = v.vendedor
        WHERE c.apellidos LIKE ? OR c.nombres LIKE ?
        GROUP BY v.idVenta
        ORDER BY v.fecha DESC,v.hora DESC LIMIT ?,?";
        try {

            $array = array();

            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->bindValue(2, "$search%", PDO::PARAM_STR);
            $comando->bindValue(3, $x, PDO::PARAM_INT);
            $comando->bindValue(4, $y, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            $arrayVentas = array();
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayVentas, array(
                    "id" => $count,
                    "idVenta" => $row["idVenta"],
                    "fecha" => $row["fecha"],
                    "hora" => $row["hora"],
                    "nombre" => $row["nombre"],
                    "serie" => $row["serie"],
                    "numeracion" => $row["numeracion"],
                    "tipo" => $row["tipo"],
                    "forma" => $row["forma"],
                    "numero" => $row["numero"],
                    "estado" => $row["estado"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "total" => $row["total"],
                    "empleadoApellidos" => $row["empleadoApellidos"],
                    "empleadoNombres" => $row["empleadoNombres"]
                ));
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*)
            from ventatb as v 
            INNER JOIN clientetb as c on c.idCliente = v.cliente
            INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
            LEFT JOIN empleadotb as e on e.idEmpleado = v.vendedor
            WHERE c.apellidos LIKE ? OR c.nombres LIKE ?");
            $comando->bindValue(1, "$search%", PDO::PARAM_STR);
            $comando->bindValue(2, "$search%", PDO::PARAM_STR);
            $comando->execute();
            $totalVentas =  $comando->fetchColumn();

            array_push($array, $arrayVentas, $totalVentas);

            return $array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public static function getVentaByCliente($idCliente)
    {

        try {
            $array = array();
            $venta = Database::getInstance()->getDb()->prepare("SELECT 
            v.idVenta,v.fecha,v.hora,t.nombre,v.serie,v.numeracion,
            v.tipo,v.forma,v.numero,v.estado, c.apellidos,c.nombres,sum(d.cantidad*d.precio) as total 
            from ventatb as v 
            INNER JOIN clientetb as c on c.idCliente = v.cliente 
            INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento 
            INNER JOIN detalleventatb as d on d.idVenta = v.idVenta 
            WHERE c.idCliente = ?
            GROUP BY v.idVenta ORDER BY v.fecha DESC,v.hora");
            $venta->bindValue(1, $idCliente, PDO::PARAM_STR);
            $venta->execute();
            $count = 0;
            while ($rowv = $venta->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "idVenta" => $rowv["idVenta"],
                    "fecha" => $rowv["fecha"],
                    "hora" => $rowv["hora"],
                    "nombre" => $rowv["nombre"],
                    "serie" => $rowv["serie"],
                    "numeracion" => $rowv["numeracion"],
                    "tipo" => $rowv["tipo"],
                    "forma" => $rowv["forma"],
                    "numero" => $rowv["numero"],
                    "estado" => $rowv["estado"],
                    "total" => $rowv["total"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getVentaDetalleBydVenta($idVenta)
    {
        $array_venta_detalle = array();
        try {

            $venta_productos = "SELECT p.nombre,d.cantidad,d.precio,d.subTotal,d.descuento,d.total
            FROM detalleventatb AS d INNER JOIN productotb AS p ON d.idOrigen = p.idProducto WHERE d.idVenta = ?";

            $venta_detalle = Database::getInstance()->getDb()->prepare($venta_productos);
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

    public static function getVentaCredito($idVenta)
    {
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

    public static function ResumenIngresosPorFecha()
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("");
            $comando->execute();

            while ($rowp = $comando->fetch()) {
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
