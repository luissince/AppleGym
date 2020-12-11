<?php

set_time_limit(300);
session_start();
require_once '../librerias/dompdf/autoload.inc.php';

require '../ingresos/IngresoAdo.php';

use Dompdf\Dompdf;

$opcion = $_GET['opcion'];
$search = $_GET['search'];

$listar_ingresos = '';

if ($opcion == 1) {

    $ingresos = IngresoAdo::getIngresoReporteAll();
    $count = 0;
    $totalEfectivo = 0;
    $totalTarjeta = 0;
    while ($row = $ingresos->fetch()) {
        $count++;
        $transaccion = $row["procedencia"] == "1" ? "INGRESO POR MEMBRESIA" : "INGRESO POR PRODUCTOS";
        $serie = $row["serie"];
        $numeracion = $row["numeracion"];
        $serieVenta = $row["ventaSerie"];
        $numeracionVenta = $row["ventaNumeracion"];
        $fecha = $row["fecha"];
        $hora = $row["hora"];
        $forma = $row["forma"] == "1" ? "EFECTIVO" : ($row["forma"] == "2" ? "TARJETA" : "EFECTIVO");
        $total = number_format($row["monto"], 2, '.', '');

        if ($row["forma"] == "1") {
            $totalEfectivo += $row["monto"];
        } else if ($row["forma"] == "2") {
            $totalTarjeta += $row["monto"];
        }else if($row["forma"] == "3"){
            $totalEfectivo += $row["monto"];
        }
        $listar_ingresos .= '
            <tr>
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $count . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $transaccion . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $serie . '<br/>' . $numeracion . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $serieVenta . '<br/>' . $numeracionVenta . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . date_format(date_create($fecha), 'd/m/Y') . '<br/>' . IngresoAdo::getTimeFormat($hora) . '
                </td>
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $forma . '
                </td>
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $total . '
                </td>
            </tr>
            ';
    }
} else if ($opcion == 2) {
    $ingresos = IngresoAdo::getIngresoReporteSearch($search);
    $count = 0;
    $totalEfectivo = 0;
    $totalTarjeta = 0;
    while ($row = $ingresos->fetch()) {
        $count++;
        $transaccion = $row["procedencia"] == "1" ? "INGRESO POR MEMBRESIA" : "INGRESO POR PRODUCTOS";
        $serie = $row["serie"];
        $numeracion = $row["numeracion"];
        $serieVenta = $row["ventaSerie"];
        $numeracionVenta = $row["ventaNumeracion"];
        $fecha = $row["fecha"];
        $hora = $row["hora"];
        $forma = $row["forma"] == "1" ? "EFECTIVO" : ($row["forma"] == "2" ? "TARJETA" : "EFECTIVO");
        $total = number_format($row["monto"], 2, '.', '');

        if ($row["forma"] == "1") {
            $totalEfectivo += $row["monto"];
        } else if ($row["forma"] == "2") {
            $totalTarjeta += $row["monto"];
        }else if($row["forma"] == "3"){
            $totalEfectivo += $row["monto"];
        }
        $listar_ingresos .= '
            <tr>
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $count . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $transaccion . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $serie . '<br/>' . $numeracion . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $serieVenta . '<br/>' . $numeracionVenta . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . date_format(date_create($fecha), 'd/m/Y') . '<br/>' . IngresoAdo::getTimeFormat($hora) . '
                </td>
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $forma . '
                </td>
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $total . '
                </td>
            </tr>
            ';
    }
} else if ($opcion == 3) {
    $ingresos = IngresoAdo::getIngresoReporteOptions($_GET['transaccion'],$_GET['fechaInicio'],$_GET['fechaFin']);
    $count = 0;
    $totalEfectivo = 0;
    $totalTarjeta = 0;
    while ($row = $ingresos->fetch()) {
        $count++;
        $transaccion = $row["procedencia"] == "1" ? "INGRESO POR MEMBRESIA" : "INGRESO POR PRODUCTOS";
        $serie = $row["serie"];
        $numeracion = $row["numeracion"];
        $serieVenta = $row["ventaSerie"];
        $numeracionVenta = $row["ventaNumeracion"];
        $fecha = $row["fecha"];
        $hora = $row["hora"];
        $forma = $row["forma"] == "1" ? "EFECTIVO" : ($row["forma"] == "2" ? "TARJETA" : "EFECTIVO");
        $total = number_format($row["monto"], 2, '.', '');

        if ($row["forma"] == "1") {
            $totalEfectivo += $row["monto"];
        } else if ($row["forma"] == "2") {
            $totalTarjeta += $row["monto"];
        }else if($row["forma"] == "3"){
            $totalEfectivo += $row["monto"];
        }
        $listar_ingresos .= '
            <tr>
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $count . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $transaccion . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $serie . '<br/>' . $numeracion . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $serieVenta . '<br/>' . $numeracionVenta . '
                </td>
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . date_format(date_create($fecha), 'd/m/Y') . '<br/>' . IngresoAdo::getTimeFormat($hora) . '
                </td>
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $forma . '
                </td>
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                ' . $total . '
                </td>
            </tr>
            ';
    }
}

$content = '<html>'
        . '<head>'
        . '<style>
          body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: white;
          }
          table{
            border:none;
          }
          table thead{
          
          }
          table thead tr{
          
          }
          table thead tr th{
            font-size: 11pt;
            font-weight: normal;
            color: black;
          }
          '
        . '</style>'
        . '</head>'
        . '<body>'
        . '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                         <td width="30%" style="text-align:center;">
                            <img src="../images/logo.jpeg" alt="Logo" width="160" />
                        </td>
                        <td width="40%" style="text-align:center;">
                            <h4>Reportes General de Ingresos</h4>
                        </td>
                        <td width="30%" style="">
                            <h5>Fecha Inicio: '. date_format(date_create($_GET['fechaInicio']), 'd/m/Y') .' </h5>
                            <h5>Fecha Final: '.date_format(date_create($_GET['fechaFin']), 'd/m/Y').'</h5>
                        </td>
                    </tr>
                </tbody>
            </table>
                        
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border: 1px solid rgb(148, 147, 147);">
                <thead style="background-color: rgb(209, 206, 206);">
                    <tr> 
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">#</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Transacción</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Recibo de Pago</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Procedencia</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Fecha y Hora</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Forma de Ingreso</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $listar_ingresos . '
                </tbody>
            </table>
            
            <br/>
            
            <div style="display:block;width:100%;height:auto;">
             
                <div style="display:block;width:auto;float:right;">
                    <table width="auto" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>
                                    <div style="padding: 10px;text-align:right;background-color: rgb(209, 206, 206);border: 1px solid rgb(160, 159, 159)">Ingresos en efectivo:</div>
                                    <div style="padding: 10px;text-align:right;background-color: rgb(209, 206, 206);border: 1px solid rgb(160, 159, 159)">Ingresos en tarjeta:<div>
                                </th> 
                                 <th>
                                    <div style="padding: 10px;text-align:right;border: 1px solid rgb(160, 159, 159)">' . number_format($totalEfectivo, 2, '.', '') . '</div>
                                    <div style="padding: 10px;text-align:right;border: 1px solid rgb(160, 159, 159)">' . number_format($totalTarjeta, 2, '.', '') . '<div>
                                </th>
                            </tr> 
                        </thead>
                    </table>
                </div>
                <div style="clear:both;"></div>
            </div>
            
          '
        . '</body>'
        . '</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
//$dompdf->stream('ListaMatriculados.pdf');
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename=documento.pdf');
echo $dompdf->output();

