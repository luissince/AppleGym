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

        $update_producto = "UPDATE productotb SET cantidad = cantidad - ? WHERE idProducto  = ?";

        $venta_credito = "INSERT INTO ventacreditotb(" .
            "idVenta," .
            "monto," .
            "fechaRegistro," .
            "horaRegistro," .
            "fechaPago," .
            "horaPago," .
            "estado)" .
            " VALUES(?,?,?,?,?,?,?)";

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
            . "fechaInicio,"
            . "horaInicio,"
            . "fechaFin,"
            . "horaFin,"
            . "tipoMembresia,"
            . "estado,"
            . "cantidad,"
            . "precio,"
            . "descuento)"
            . "VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

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
            $executeProducto = Database::getInstance()->getDb()->prepare($update_producto);

            $countMem1 = 0;
            $countMem3 = 0;
            $countMem4 = 0;
            $countMem5 = 0;

            foreach ($body['lista'] as $result) {
                if ($result["procedencia"] == 1) {

                    $codigoMembresia = Database::getInstance()->getDb()->prepare($quey_codigo_membresia);
                    $codigoMembresia->execute();
                    $idMembresia = $codigoMembresia->fetchColumn();

                    $cmdMembresia = Database::getInstance()->getDb()->prepare($membresia);
                    $cmdMembresia->execute(
                        array(
                            $idMembresia,
                            $result['idPlan'],
                            $body['cliente'],
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

                    $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                    $cmdHistorialMembresia->execute(array($idMembresia, "PRIMER REGISTRO DE MEMBRESÍA", $body['fecha'], $body['hora'], $result['fechaInico'], $result['fechaFin']));

                    $executeDetalleVenta->execute(
                        array(
                            $idVenta,
                            $idMembresia,
                            $result['cantidad'],
                            $result['precio'],
                            $result['descuento'],
                            $result['procedencia']
                        )
                    );

                    $countMem1++;
                } else if ($result["procedencia"] == 2) {
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

                    $validateProducto = Database::getInstance()->getDb()->prepare("SELECT * FROM productotb WHERE idProducto  = ?");
                    $validateProducto->bindValue(1, $result['idPlan'], PDO::PARAM_STR);
                    $validateProducto->execute();
                    if ($row = $validateProducto->fetch()) {
                        if ($row["inventario"] == 1) {
                            $executeProducto->execute(array($result['cantidad'], $result['idPlan']));
                        }
                    }
                } else if ($result["procedencia"] == 3) {

                    $trasValidate = Database::getInstance()->getDb()->prepare("SELECT fechaFin FROM membresiatb WHERE idMembresia  = ? AND fechaFin >= NOW() AND estado = 1");
                    $trasValidate->bindValue(1, $result['membresia'], PDO::PARAM_STR);
                    $trasValidate->execute();
                    if ($rowm = $trasValidate->fetch()) {
                        $fechaFin = $rowm["fechaFin"];

                        $trasValidate = Database::getInstance()->getDb()->prepare("SELECT DATEDIFF(fechaFin,CURDATE()) AS Dias
                        FROM membresiatb 
                        WHERE idMembresia = ?");
                        $trasValidate->bindValue(1, $result['idPlan'], PDO::PARAM_STR);
                        $trasValidate->execute();

                        $rowt =  $trasValidate->fetch();
                        $dias = $rowt["Dias"];

                        $date = new DateTime($fechaFin);
                        $date->modify("+" .  $dias . " day");

                        $cmdMembresia = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET fechaFin = ?,tipoMembresia =3,estado = 1 WHERE idMembresia = ?");
                        $cmdMembresia->bindValue(1, $date->format('Y-m-d'), PDO::PARAM_STR);
                        $cmdMembresia->bindValue(2, $result['membresia'], PDO::PARAM_STR);
                        $cmdMembresia->execute();

                        $cmdTraspaso = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET congelar = ?,estado = 0 WHERE idMembresia = ?");
                        $cmdTraspaso->bindValue(1, $dias, PDO::PARAM_INT);
                        $cmdTraspaso->bindValue(2, $result['idPlan'], PDO::PARAM_STR);
                        $cmdTraspaso->execute();

                        $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                        $cmdHistorialMembresia->execute(array($result['membresia'], "TRANSFERENCIA DE MEMBRESÍA", $body['fecha'], $body['hora'], $fechaFin, $date->format('Y-m-d')));

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

                        $countMem3++;
                    } else {

                        $trasValidate = Database::getInstance()->getDb()->prepare("SELECT DATEDIFF(fechaFin,CURDATE()) AS Dias
                        FROM membresiatb 
                        WHERE idMembresia = ?");
                        $trasValidate->bindValue(1, $result['idPlan'], PDO::PARAM_STR);
                        $trasValidate->execute();
                        $rowt =  $trasValidate->fetch();
                        $dias = $rowt["Dias"];

                        $date = new DateTime($body['fecha']);
                        $date->modify("+" .  $dias . " day");

                        $cmdMembresia = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET fechaInicio = ?,fechaFin = ?,estado = 1 WHERE idMembresia = ?");
                        $cmdMembresia->bindValue(1, $body['fecha'], PDO::PARAM_STR);
                        $cmdMembresia->bindValue(2, $date->format('Y-m-d'), PDO::PARAM_STR);
                        $cmdMembresia->bindValue(3, $result['membresia'], PDO::PARAM_STR);
                        $cmdMembresia->execute();

                        $cmdTraspaso = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET congelar = ?,estado = 0 WHERE idMembresia = ?");
                        $cmdTraspaso->bindValue(1, $dias, PDO::PARAM_INT);
                        $cmdTraspaso->bindValue(2, $result['idPlan'], PDO::PARAM_STR);
                        $cmdTraspaso->execute();

                        $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                        $cmdHistorialMembresia->execute(array($result['membresia'], "TRANSFERENCIA DE MEMBRESÍA", $body['fecha'], $body['hora'], $body['fecha'], $date->format('Y-m-d')));

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

                        $countMem3++;
                    }
                } else if ($result["procedencia"] == 4) {

                    $codigoMembresia = Database::getInstance()->getDb()->prepare($quey_codigo_membresia);
                    $codigoMembresia->execute();
                    $idMembresia = $codigoMembresia->fetchColumn();

                    $cmdMembresia = Database::getInstance()->getDb()->prepare($membresia);
                    $cmdMembresia->execute(
                        array(
                            $idMembresia,
                            $result['idPlan'],
                            $body['cliente'],
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

                    $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                    $cmdHistorialMembresia->execute(array($idMembresia, $result['nombre'], $body['fecha'], $body['hora'], $result['fechaInico'], $result['fechaFin']));

                    $executeDetalleVenta->execute(
                        array(
                            $idVenta,
                            $idMembresia,
                            $result['cantidad'],
                            $result['precio'],
                            $result['descuento'],
                            $result['procedencia']
                        )
                    );

                    $countMem4++;
                } else if ($result["procedencia"] == 5) {
                    $membresiaValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM membresiatb WHERE idMembresia = ?");
                    $membresiaValidate->bindParam(1, $result['idPlan'], PDO::PARAM_STR);
                    $membresiaValidate->execute();
                    $resultMembresia = $membresiaValidate->fetchObject();

                    $cmdMembresia = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET fechaInicio = ?,fechaFin = ?,tipoMembresia = ?,cantidad = ?,precio = ?,descuento = ?,estado = 1 WHERE idMembresia  = ?");
                    $cmdMembresia->execute(array(
                        $result['fechaInico'],
                        $result['fechaFin'],
                        $result['membresia'],
                        $result['cantidad'],
                        $result['precio'],
                        $result['descuento'],
                        $resultMembresia->idMembresia
                    ));

                    $executeDetalleVenta->execute(
                        array(
                            $idVenta,
                            $resultMembresia->idMembresia,
                            $result['cantidad'],
                            $result['precio'],
                            $result['descuento'],
                            $result['procedencia']
                        )
                    );

                    $cmdHistorialMembresia = Database::getInstance()->getDb()->prepare("INSERT INTO historialmembresia(idMembresia,descripcion,fecha,hora,fechaInicio,fechaFinal) VALUES(?,?,?,?,?,?)");
                    $cmdHistorialMembresia->execute(array($resultMembresia->idMembresia, "RENOVACIÓN", $body['fecha'], $body['hora'], $result['fechaInico'], $result['fechaFin']));
                    $countMem5++;
                }
            }

            if ($countMem1 > 1) {
                throw new Exception("No se puede registrar más de 2 planes a la vez.");
            }
            if ($countMem3 > 1) {
                throw new Exception("No se puede registrar más de 2 traspasos a la vez.");
            }
            if ($countMem4 > 1) {
                throw new Exception("No se puede registrar más de 2 activaciones a la vez.");
            }
            if ($countMem1 > 0 && $countMem3 > 0) {
                throw new Exception("No se puede registrar una plan normal y un traspaso al mismo tiempo.");
            }
            if ($countMem4 > 0 && $countMem3 > 0) {
                throw new Exception("No se puede registrar una activación y un traspaso al mismo tiempo.");
            }
            if ($countMem1 > 0 && $countMem4 > 0) {
                throw new Exception("No se puede registrar un plan normal y una activación al mismo tiempo.");
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
                            $credito['fecha'],
                            $credito['hora'],
                            $credito['inicial']
                        )
                    );
                }
            } else {
                foreach ($body['lista'] as $result) {
                    $total_venta += ($result['cantidad'] * ($result['precio'] - $result['descuento']));
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
                    "PAGO DEL COMPROBANTE " . $venta->serie . "-" . $venta->numeracion,
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
        $consulta = "SELECT 
        v.idVenta,
        v.fecha,
        v.hora,
        t.nombre,
        v.serie,
        v.numeracion,
        v.tipo,
        v.forma,
        v.numero,
        v.estado,
        c.dni,
        c.apellidos,
        c.nombres,
        sum(d.cantidad*(d.precio-d.descuento)) as total,
        CASE WHEN e.apellidos IS NULL OR e.apellidos = '' THEN 'SIN DATOS' ELSE e.apellidos END AS 	empleadoApellidos,
        CASE WHEN e.nombres IS NULL OR e.nombres = '' THEN 'SIN DATOS' ELSE e.nombres END AS empleadoNombres
        from ventatb as v 
        INNER JOIN clientetb as c on c.idCliente = v.cliente
        INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
        INNER JOIN detalleventatb as d on d.idVenta = v.idVenta
        LEFT JOIN empleadotb as e on e.idEmpleado = v.vendedor
        WHERE 
        ? = 0 AND v.fecha BETWEEN ? AND ?
        OR
        ? = 1 AND v.serie = ?
        OR
        ? = 1 AND v.numeracion = ?
        OR
        ? = 1 AND CONCAT(v.serie,'-',v.numeracion) = ?
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

            $comando->bindParam(12, $tipo, PDO::PARAM_INT);
            $comando->bindParam(13, $search, PDO::PARAM_STR);

            $comando->bindParam(14, $x, PDO::PARAM_INT);
            $comando->bindParam(15, $y, PDO::PARAM_INT);
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
                    "dni" => $row["dni"],
                    "apellidos" => $row["apellidos"],
                    "nombres" => $row["nombres"],
                    "total" => $row["total"],
                    "empleadoApellidos" => $row["empleadoApellidos"],
                    "empleadoNombres" => $row["empleadoNombres"]
                ));
            }

            $comando = Database::getInstance()->getDb()->prepare("SELECT COUNT(*)
            FROM ventatb AS v 
            INNER JOIN clientetb as c on c.idCliente = v.cliente
            INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento
            LEFT JOIN empleadotb as e on e.idEmpleado = v.vendedor
            WHERE 
            ? = 0 AND v.fecha BETWEEN ? AND ?
            OR
            ? = 1 AND v.serie = ?
            OR
            ? = 1 AND v.numeracion = ?
            OR
            ? = 1 AND CONCAT(v.serie,'-',v.numeracion) = ? 
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

            $comando->bindParam(12, $tipo, PDO::PARAM_INT);
            $comando->bindParam(13, $search, PDO::PARAM_STR);

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
            v.idVenta,
            v.fecha,
            v.hora,
            t.nombre,
            v.serie,
            v.numeracion,
            v.tipo,
            v.forma,
            v.numero,
            v.estado, 
            c.apellidos,
            c.nombres,
            sum(d.cantidad*(d.precio-d.descuento)) as total 
            from ventatb as v 
            INNER JOIN clientetb as c on c.idCliente = v.cliente 
            INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento 
            INNER JOIN detalleventatb as d on d.idVenta = v.idVenta 
            WHERE c.idCliente = ?
            GROUP BY v.idVenta 
            ORDER BY v.fecha DESC,v.hora DESC");
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

            $cmdDetalleVenta = Database::getInstance()->getDb()->prepare("SELECT 
            d.idVenta,
            (CASE 
            WHEN NOT muno.idMembresia IS NULL THEN (SELECT p.nombre FROM plantb AS p WHERE p.idPlan = muno.idPlan)
            WHEN NOT pr.idProducto IS NULL THEN UPPER(pr.nombre)
            WHEN NOT mtre.idMembresia IS NULL THEN (SELECT CONCAT('TRASPADO',': ',p.nombre) FROM plantb AS p WHERE p.idPlan = mtre.idPlan)
            WHEN NOT mcua.idMembresia IS NULL THEN (SELECT CONCAT('ACTIVACIÓN',': ',p.nombre) FROM plantb AS p WHERE p.idPlan = mcua.idPlan)
            ELSE (SELECT CONCAT('RENOVACIÓN',': ',p.nombre) FROM plantb AS p WHERE p.idPlan = mqui.idPlan) END) AS detalle,
            d.cantidad,
            d.precio,
            d.descuento
            FROM detalleventatb AS d 
            LEFT JOIN membresiatb  AS muno ON muno.idMembresia = d.idOrigen AND d.procedencia = 1  
            LEFT JOIN productotb AS pr ON pr.idProducto = d.idOrigen AND d.procedencia = 2        
            LEFT JOIN membresiatb AS mtre ON mtre.idMembresia = d.idOrigen AND d.procedencia = 3
            LEFT JOIN membresiatb AS mcua ON mcua.idMembresia = d.idOrigen AND d.procedencia = 4
            LEFT JOIN membresiatb AS mqui ON mqui.idMembresia = d.idOrigen AND d.procedencia = 5
            WHERE d.idVenta = ?");
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

    public static function getAsistencias($idCliente)
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

            $cmdIngresos = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            i.detalle,
            i.procedencia,
            i.fecha,
            i.hora,
            i.forma,
            i.monto,
            e.apellidos,
            e.nombres,
            c.dni as dni,
            c.apellidos as apcliente,
            c.nombres as nmcliente
            FROM ingresotb AS i 
            INNER JOIN empleadotb AS e ON i.vendedor = e.idEmpleado
            INNER JOIN ventatb AS v ON i.idPrecedencia = v.idVenta
            INNER JOIN clientetb AS c ON v.cliente = c.idCliente
            WHERE 
            ? = 0 AND i.fecha BETWEEN ? AND ? 
            OR 
            ? = 1 AND c.dni LIKE CONCAT(?,'%')
            OR 
            ? = 1 AND c.apellidos LIKE CONCAT(?,'%')
            OR 
            ? = 1 AND c.nombres LIKE CONCAT(?,'%')
            ORDER BY i.fecha DESC,i.hora DESC LIMIT ?,?");
            $cmdIngresos->bindParam(1, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(2, $fechaInicio, PDO::PARAM_STR);
            $cmdIngresos->bindParam(3, $fechaFin, PDO::PARAM_STR);

            $cmdIngresos->bindParam(4, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(5, $search, PDO::PARAM_STR);

            $cmdIngresos->bindParam(6, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(7, $search, PDO::PARAM_STR);

            $cmdIngresos->bindParam(8, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(9, $search, PDO::PARAM_STR);

            $cmdIngresos->bindParam(10, $x, PDO::PARAM_INT);
            $cmdIngresos->bindParam(11, $y, PDO::PARAM_INT);
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
                    "dni" => $row["dni"],
                    "apcliente" => $row["apcliente"],
                    "nmcliente" => $row["nmcliente"],
                ));
            }

            $cmdIngresos = Database::getInstance()->getDb()->prepare("SELECT count(*) 
            FROM ingresotb AS i 
            INNER JOIN empleadotb AS e ON i.vendedor = e.idEmpleado
            INNER JOIN ventatb AS v ON i.idPrecedencia = v.idVenta
            INNER JOIN clientetb AS c ON v.cliente = c.idCliente
            WHERE 
            ? = 0 AND i.fecha BETWEEN ? AND ? 
            OR 
            ? = 1 AND c.dni LIKE CONCAT(?,'%')
            OR 
            ? = 1 AND c.apellidos LIKE CONCAT(?,'%')
            OR 
            ? = 1 AND c.nombres LIKE CONCAT(?,'%')");
            $cmdIngresos->bindParam(1, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(2, $fechaInicio, PDO::PARAM_STR);
            $cmdIngresos->bindParam(3, $fechaFin, PDO::PARAM_STR);

            $cmdIngresos->bindParam(4, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(5, $search, PDO::PARAM_STR);

            $cmdIngresos->bindParam(6, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(7, $search, PDO::PARAM_STR);

            $cmdIngresos->bindParam(8, $tipo, PDO::PARAM_INT);
            $cmdIngresos->bindParam(9, $search, PDO::PARAM_STR);
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
            $executecomprobante = Database::getInstance()->getDb()->prepare("SELECT idTipoComprobante,nombre,predeterminado FROM tipocomprobantetb WHERE estado = 1");
            $executecomprobante->execute();
            while ($row = $executecomprobante->fetch()) {
                array_push($array, array(
                    "idTipoComprobante" => $row['idTipoComprobante'],
                    "nombre" => $row['nombre'],
                    "predeterminado" => $row["predeterminado"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function reporteIngreso($idIngreso)
    {
        try {
            $array = array();

            $cmdCabecera = Database::getInstance()->getDb()->prepare("SELECT 
            v.serie,
            v.numeracion,
            i.procedencia,
            i.idIngreso,
            i.forma,
            i.monto,
            i.fecha,
            i.hora,
            c.apellidos,
            c.nombres,
            c.direccion,
            c.celular
            FROM ingresotb AS i
            INNER JOIN ventatb AS v ON i.idPrecedencia = v.idVenta
            INNER JOIN clientetb AS c ON v.cliente = c.idCliente
            WHERE i.idIngreso = ?");
            $cmdCabecera->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdCabecera->execute();
            $resultCabecera = $cmdCabecera->fetchObject();

            $cmdDetalle = Database::getInstance()->getDb()->prepare("SELECT 
            i.detalle,i.monto 
            FROM ingresotb AS i
            INNER JOIN ventatb AS v ON i.idPrecedencia = v.idVenta
            WHERE i.idIngreso = ?");
            $cmdDetalle->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdDetalle->execute();
            $resultDetalle = $cmdDetalle->fetchObject();

            array_push($array, $resultCabecera, $resultDetalle);
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

                    $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM ventacreditotb WHERE idVenta  = ? AND fechaRegistro <> CURDATE() AND estado = 1");
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

                        $cmdMembresia = Database::getInstance()->getDb()->prepare("UPDATE membresiatb SET estado = -1 WHERE idMembresia  = ?");

                        $cmdDetalleVenta = Database::getInstance()->getDb()->prepare("UPDATE productotb SET cantidad = cantidad + ? WHERE idProducto = ?");

                        $validateDetalleVenta = Database::getInstance()->getDb()->prepare("SELECT
                        dv.idOrigen,
                        dv.cantidad,
                        dv.procedencia,
                        p.inventario
                        FROM detalleventatb AS dv 
                        LEFT JOIN productotb AS p ON p.idProducto = dv.idOrigen 
                        WHERE dv.idVenta = ?");
                        $validateDetalleVenta->bindParam(1, $idVenta, PDO::PARAM_STR);
                        $validateDetalleVenta->execute();
                        while ($row = $validateDetalleVenta->fetchObject()) {
                            if ($row->procedencia == 1) {
                                $cmdMembresia->bindParam(1, $row->idOrigen, PDO::PARAM_STR);
                                $cmdMembresia->execute();
                            } else if ($row->procedencia == 2) {
                                if ($row->inventario == 1) {
                                    $cmdDetalleVenta->bindParam(1, $row->cantidad, PDO::PARAM_STR);
                                    $cmdDetalleVenta->bindParam(2, $row->idOrigen, PDO::PARAM_STR);
                                    $cmdDetalleVenta->execute();
                                }
                            } else if ($row->procedencia == 3) {
                            } else if ($row->procedencia == 4) {
                            } else if ($row->procedencia == 5) {
                            }
                        }

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

    public static function getVentaByEmpleado($idEmpleado)
    {

        try {
            $array = array();
            $venta = Database::getInstance()->getDb()->prepare("SELECT 
            v.idVenta,
            v.fecha,
            v.hora,
            t.nombre,
            v.serie,
            v.numeracion,
            v.tipo,
            v.forma,
            v.numero,
            v.estado, 
            e.apellidos,
            e.nombres,
            sum(d.cantidad*(d.precio-d.descuento)) as total 
            from ventatb as v 
            INNER JOIN empleadotb as e on e.idEmpleado = v.vendedor 
            INNER JOIN tipocomprobantetb as t ON t.idTipoComprobante = v.documento 
            INNER JOIN detalleventatb as d on d.idVenta = v.idVenta 
            WHERE v.vendedor = ?
            GROUP BY v.idVenta ORDER BY v.fecha DESC,v.hora DESC");
            $venta->bindValue(1, $idEmpleado, PDO::PARAM_STR);
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

    public static function getAsistenciaByEmpleado($idEmpleado)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT fechaApertura,
                     fechaCierre,
                     horaApertura,
                     horaCierre,
                     estado
                     FROM asistenciatb WHERE idPersona = ?");
            $comando->bindParam(1, $idEmpleado, PDO::PARAM_STR);
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
}
