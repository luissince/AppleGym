<?php

require '../database/DataBaseConexion.php';

class VentaAdo
{

    function __construct()
    {
    }

    public static function insertVenta($body)
    {
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
            "vendedor," .
            "detalle," .
            "procedencia," .
            "fecha," .
            "hora," .
            "forma," .
            "monto)" .
            " VALUES(?,?,?,?,?,?,?,?)";

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
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidando = Database::getInstance()->getDb()->prepare('SELECT serie FROM tipocomprobantetb WHERE idTipoComprobante  = ?');
            $cmdValidando->bindValue(1, $body["tipoDocumento"], PDO::PARAM_STR);
            $cmdValidando->execute();
            $serie = $cmdValidando->fetchColumn();

            if ($body["estadoNumeracion"] == false) {
                $cmdValidando = Database::getInstance()->getDb()->prepare('SELECT * FROM ventatb WHERE serie = ?');
                $cmdValidando->bindValue(1, $serie, PDO::PARAM_STR);
                $cmdValidando->execute();
                if ($cmdValidando->fetch()) {
                    $AuxNumeracion = Database::getInstance()->getDb()->prepare('SELECT *  FROM ventatb WHERE serie = ? AND numeracion = ?');
                    $AuxNumeracion->bindValue(1, $serie, PDO::PARAM_STR);
                    $AuxNumeracion->bindValue(2, $body["numracion"], PDO::PARAM_INT);
                    $AuxNumeracion->execute();
                    if ($AuxNumeracion->fetch()) {
                        throw new Exception('La numeración del comprobante ' . $serie . ' ya existe.');
                    } else {
                        $ResultNumeracion = $body["numracion"];
                    }
                } else {
                    $ResultNumeracion = $body["numracion"];
                }
            } else {
                $cmdValidando = Database::getInstance()->getDb()->prepare('SELECT * FROM ventatb WHERE serie = ?');
                $cmdValidando->bindValue(1, $serie, PDO::PARAM_STR);
                $cmdValidando->execute();
                if ($cmdValidando->fetch()) {
                    $AuxNumeracion = Database::getInstance()->getDb()->prepare('SELECT max(numeracion) FROM ventatb WHERE serie = ?');
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
                    $total_venta += ($result['cantidad'] * ($result['precio']-$result['descuento']));
                }
            }

            if ($total_venta > 0) {
                $executeIngreso = Database::getInstance()->getDb()->prepare($ingreso);
                $executeIngreso->execute(array(
                    $idVenta,
                    $body['vendedor'],
                    "INGRESO DEL COMPROBANTE " . $serie . "-" . $ResultNumeracion,
                    1,
                    $body['fecha'],
                    $body['hora'],
                    $body['forma'],
                    $total_venta
                ));
            }

            Database::getInstance()->getDb()->commit();
            return "true";
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function insertarCredito($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdVenta = Database::getInstance()->getDb()->prepare("SELECT serie,numeracion FROM ventatb WHERE idVenta = ? AND estado <> 3");
            $cmdVenta->bindParam(1, $body["idVenta"], PDO::PARAM_STR);
            $cmdVenta->execute();
            $venta = $cmdVenta->fetchObject();

            if (is_object($venta)) {
                $montoCobrado = 0;
                $cmdCredito = Database::getInstance()->getDb()->prepare("UPDATE ventacreditotb SET fechaPago = ?,horaPago = ?,estado = ? WHERE idVentaCredito  = ?");
                foreach ($body['arrayCredito'] as $result) {
                    $montoCobrado += floatval($result["monto"]);
                    $cmdCredito->execute(array(
                        $result["fechaPago"],
                        $result["horaPago"],
                        $result["estado"],
                        $result["idCredito"]
                    ));
                }

                $cmdSumas = Database::getInstance()->getDb()->prepare("SELECT * FROM ventacreditotb WHERE idVenta = ? ");
                $cmdSumas->bindParam(1, $body["idVenta"], PDO::PARAM_STR);
                $cmdSumas->execute();

                $totalMonto = 0;
                $totalCobrado = 0;
                while ($row = $cmdSumas->fetch()) {
                    $totalCobrado += $row["estado"] == 0 ? 0 : $row["monto"];
                    $totalMonto += $row["monto"];
                }

                if ($totalMonto ==  $totalCobrado) {
                    $cmdValidate = Database::getInstance()->getDb()->prepare("UPDATE ventatb SET estado = 1 WHERE idVenta = ?");
                    $cmdValidate->bindParam(1, $body["idVenta"], PDO::PARAM_STR);
                    $cmdValidate->execute();
                }

                $executeIngreso = Database::getInstance()->getDb()->prepare("INSERT INTO  ingresotb(" .
                    "idPrecedencia," .
                    "vendedor," .
                    "detalle," .
                    "procedencia," .
                    "fecha," .
                    "hora," .
                    "forma," .
                    "monto)" .
                    " VALUES(?,?,?,?,?,?,?,?)");

                $executeIngreso->execute(array(
                    $body["idVenta"],
                    $body["vendedor"],
                    "COBRO DEL COMPROBANTE " . $venta->serie . "-" . $venta->numeracion,
                    2,
                    $body['fecha'],
                    $body['hora'],
                    $body['forma'],
                    $montoCobrado
                ));

                Database::getInstance()->getDb()->commit();
                return "true";
            } else {
                Database::getInstance()->getDb()->rollback();
                return "noid";
            }
        } catch (Exception $e) {
            Database::getInstance()->getDb()->rollback();
            return $e->getMessage();
        }
    }

    public static function getAll($tipo, $search, $fechaInicio, $fechaFin, $x, $y)
    {
        $consulta = "SELECT v.idVenta,v.fecha,v.hora,t.nombre,v.serie,v.numeracion,v.tipo,v.forma,v.numero,v.estado,
        c.apellidos,c.nombres,sum(d.cantidad*(d.precio-d.descuento)) as total,
        CASE WHEN e.apellidos IS NULL or e.apellidos = '' THEN 'SIN DATOS' ELSE e.apellidos END AS 	empleadoApellidos,
        CASE WHEN e.nombres IS NULL OR e.nombres = '' THEN 'SIN DATOS' ELSE e.nombres END AS empleadoNombres
        from ventatb as v 
        INNER JOIN clientetb as c on c.idCliente = v.cliente
        INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
        INNER JOIN detalleventatb as d on d.idVenta = v.idVenta
        LEFT JOIN empleadotb as e on e.idEmpleado = v.vendedor
        WHERE 
        ? = 0 AND v.fecha BETWEEN ? AND ?
        OR
        ? = 1 AND v.serie LIKE CONCAT(?,'%') 
        OR
        ? = 1 AND v.numeracion LIKE CONCAT(?,'%') 
        OR
        ? = 1 AND c.apellidos LIKE CONCAT(?,'%') 
        OR 
        ? = 1 AND c.nombres LIKE CONCAT(?,'%')
        GROUP BY v.idVenta
        ORDER BY v.fecha DESC,v.hora DESC LIMIT ?,?";
        try {

            $array = array();

            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindParam(1, $tipo, PDO::PARAM_INT);
            $comando->bindParam(2, $fechaInicio, PDO::PARAM_STR);
            $comando->bindParam(3, $fechaFin, PDO::PARAM_STR);

            $comando->bindParam(4, $tipo, PDO::PARAM_INT);
            $comando->bindParam(5, $search, PDO::PARAM_STR);

            $comando->bindParam(6, $tipo, PDO::PARAM_INT);
            $comando->bindParam(7, $search, PDO::PARAM_STR);

            $comando->bindParam(8, $tipo, PDO::PARAM_INT);
            $comando->bindParam(9, $search, PDO::PARAM_STR);

            $comando->bindParam(10, $tipo, PDO::PARAM_INT);
            $comando->bindParam(11, $search, PDO::PARAM_STR);

            $comando->bindParam(12, $x, PDO::PARAM_INT);
            $comando->bindParam(13, $y, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            $arrayVentas = array();
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayVentas, array(
                    "id" => $count + $x,
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
            WHERE 
            ? = 0 AND v.fecha BETWEEN ? AND ?
            OR
            ? = 1 AND v.serie LIKE CONCAT(?,'%') 
            OR
            ? = 1 AND v.numeracion LIKE CONCAT(?,'%') 
            OR
            ? = 1 AND c.apellidos LIKE CONCAT(?,'%') 
            OR 
            ? = 1 AND c.nombres LIKE CONCAT(?,'%')");
            $comando->bindParam(1, $tipo, PDO::PARAM_INT);
            $comando->bindParam(2, $fechaInicio, PDO::PARAM_STR);
            $comando->bindParam(3, $fechaFin, PDO::PARAM_STR);

            $comando->bindParam(4, $tipo, PDO::PARAM_INT);
            $comando->bindParam(5, $search, PDO::PARAM_STR);

            $comando->bindParam(6, $tipo, PDO::PARAM_INT);
            $comando->bindParam(7, $search, PDO::PARAM_STR);

            $comando->bindParam(8, $tipo, PDO::PARAM_INT);
            $comando->bindParam(9, $search, PDO::PARAM_STR);

            $comando->bindParam(10, $tipo, PDO::PARAM_INT);
            $comando->bindParam(11, $search, PDO::PARAM_STR);
            $comando->execute();
            $totalVentas =  $comando->fetchColumn();

            array_push($array, $arrayVentas, $totalVentas);

            return $array;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public static function getVentaByCliente($idCliente)
    {

        try {
            $array = array();
            $venta = Database::getInstance()->getDb()->prepare("SELECT 
            v.idVenta,v.fecha,v.hora,t.nombre,v.serie,v.numeracion,
            v.tipo,v.forma,v.numero,v.estado, c.apellidos,c.nombres,sum(d.cantidad*(d.precio-d.descuento)) as total 
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


    public static function getVentaDetalleByd($idVenta)
    {
        try {
            $array = array();

            $cmdDetalleVenta = Database::getInstance()->getDb()->prepare("SELECT d.idVenta,
            (case when pl.idPlan is null 
            then UPPER(pr.nombre)
            else UPPER(pl.nombre) END) as detalle,
            d.cantidad,
            d.precio,
            d.descuento
            FROM detalleventatb as d 
            left JOIN plantb  as pl on d.idOrigen = pl.idPlan
            left join productotb as pr on d.idOrigen = pr.idProducto
            where d.idVenta = ?");
            $cmdDetalleVenta->bindParam(1, $idVenta, PDO::PARAM_STR);
            $cmdDetalleVenta->execute();

            $count = 0;
            while ($row = $cmdDetalleVenta->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "idVenta" => $row["idVenta"],
                    "detalle" => $row["detalle"],
                    "cantidad" => $row["cantidad"],
                    "precio" => $row["precio"],
                    "descuento" => $row["descuento"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public static function getVentaCredito($idVenta)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT idVentaCredito,
                     monto,
                     fechaRegistro,
                     horaRegistro,
                     fechaPago,
                     horaPago,
                     estado
                     FROM ventacreditotb WHERE idVenta = ?");
            $comando->bindParam(1, $idVenta, PDO::PARAM_STR);
            $comando->execute();

            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "idVentaCredito" => $row["idVentaCredito"],
                    "monto" => floatval($row["monto"]),
                    "fechaRegistro" => $row["fechaRegistro"],
                    "horaRegistro" => $row["horaRegistro"],
                    "fechaPago" => $row["fechaPago"],
                    "horaPago" => $row["horaPago"],
                    "estado" => $row["estado"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAsistemcias($idCliente)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT fechaApertura,
                     fechaCierre,
                     horaApertura,
                     horaCierre,
                     estado
                     FROM asistenciatb WHERE idPersona = ?");
            $comando->bindParam(1, $idCliente, PDO::PARAM_STR);
            $comando->execute();

            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "fechaApertura" => $row["fechaApertura"],
                    "fechaCierre" => $row["fechaCierre"],
                    "horaApertura" => $row["horaApertura"],
                    "horaCierre" => $row["horaCierre"],
                    "estado" => $row["estado"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIngresos($tipo, $search, $fechaInicio, $fechaFin, $x, $y)
    {
        try {
            $array = array();

            $cmdIngresos = Database::getInstance()->getDb()->prepare("SELECT i.idIngreso,
            i.detalle,
            i.procedencia,
            i.fecha,
            i.hora,
            i.forma,
            i.monto,
            e.apellidos,
            e.nombres 
            FROM ingresotb AS i INNER JOIN empleadotb AS e ON i.vendedor = e.idEmpleado
            WHERE i.fecha BETWEEN ? and ?
            ORDER BY i.fecha DESC,i.hora DESC LIMIT ?,?");
            $cmdIngresos->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdIngresos->bindParam(2, $fechaFin, PDO::PARAM_STR);
            $cmdIngresos->bindParam(3, $x, PDO::PARAM_INT);
            $cmdIngresos->bindParam(4, $y, PDO::PARAM_INT);
            $cmdIngresos->execute();

            $arrayIngresos = array();
            $count = 0;
            while ($row = $cmdIngresos->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id" => $count + $x,
                    "idIngreso" => $row["idIngreso"],
                    "detalle" => $row["detalle"],
                    "procedencia" => $row["procedencia"],
                    "fecha" => $row["fecha"],
                    "hora" => $row["hora"],
                    "forma" => $row["forma"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "monto" => $row["monto"],
                ));
            }

            $cmdIngresos = Database::getInstance()->getDb()->prepare("SELECT count(*) FROM ingresotb AS i 
            INNER JOIN empleadotb AS e ON i.vendedor = e.idEmpleado
            WHERE i.fecha BETWEEN ? and ?");
            $cmdIngresos->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdIngresos->bindParam(2, $fechaFin, PDO::PARAM_STR);
            $cmdIngresos->execute();
            $resultTotal = $cmdIngresos->fetchColumn();

            array_push($array, $arrayIngresos, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function reportePorFechaIngresos($fechaInicio, $FechaFin)
    {
        try {
            $array = array();
            $cmdIngresos = Database::getInstance()->getDb()->prepare("SELECT 
            (case procedencia
            when 1 then 'VENTAS'
            else 'CUENTAS POR COBRAR' end) AS transaccion,
            count(forma) as cantidad,
            (case forma
            when 1 then sum(monto) 
            else 0 end)as efectivo,
            (case forma
            when 2 then sum(monto)
            else 0 end)as tarjeta
            from ingresotb
            where fecha between ? and ?
            group by forma,procedencia");
            $cmdIngresos->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdIngresos->bindParam(2, $FechaFin, PDO::PARAM_STR);
            $cmdIngresos->execute();
            $count = 0;
            while ($row = $cmdIngresos->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "transaccion" => $row["transaccion"],
                    "cantidad" => floatval($row["cantidad"]),
                    "efectivo" => floatval($row["efectivo"]),
                    "tarjeta" => floatval($row["tarjeta"])
                ));
            }
            return  $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllComprobante()
    {
        try {
            $array = array();
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

    public static function AnularVenta($idVenta)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM ventatb WHERE idVenta = ? AND estado = 3");
            $cmdValidate->bindParam(1, $idVenta, PDO::PARAM_STR);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "anulado";
            } else {
                $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM ventatb WHERE idVenta = ? AND fecha < CURDATE()");
                $cmdValidate->bindParam(1, $idVenta, PDO::PARAM_STR);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "fecha";
                } else {

                    $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM ventacreditotb WHERE idVenta  = ? AND estado = 1");
                    $cmdValidate->bindParam(1, $idVenta, PDO::PARAM_STR);
                    $cmdValidate->execute();
                    if ($cmdValidate->fetch()) {
                        Database::getInstance()->getDb()->rollback();
                        return "pagos";
                    } else {
                        $cmdVenta = Database::getInstance()->getDb()->prepare("UPDATE ventatb SET estado = 3 WHERE idVenta = ?");
                        $cmdVenta->bindParam(1, $idVenta, PDO::PARAM_STR);
                        $cmdVenta->execute();

                        $cmdIngreso = Database::getInstance()->getDb()->prepare("DELETE FROM ingresotb WHERE idPrecedencia = ?");
                        $cmdIngreso->bindParam(1, $idVenta, PDO::PARAM_STR);
                        $cmdIngreso->execute();

                        $cmdMembresia = Database::getInstance()->getDb()->prepare("DELETE FROM membresiatb WHERE idVenta = ?");
                        $cmdMembresia->bindParam(1, $idVenta, PDO::PARAM_STR);
                        $cmdMembresia->execute();

                        Database::getInstance()->getDb()->commit();
                        return "deleted";
                    }
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
