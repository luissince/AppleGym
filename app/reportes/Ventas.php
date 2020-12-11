<?php

set_time_limit(300);
session_start();
require_once '../librerias/dompdf/autoload.inc.php';
require '../venta/VentaAdo.php';

use Dompdf\Dompdf;

$opcion = $_GET['opcion'];

$listar_ventas = '';

if ($opcion == 1) {
    $ventas = VentaAdo::getVentaReporteAll();
    $count = 0;
    $totalContado = 0;
    $totalCredito = 0;
    while ($row = $ventas->fetch()) {
        $count++;
        $procedencia = $row['procedencia'] == "2" ? "VENTA DE PRODUCTOS" : "VENTA DE MEMBRESIA";
        $fecha = date_create($row['fecha']);
        $vendedor = strtoupper($row['apellidosEmpleado'] . ' ' . $row['nombresEmpleado']);
        $comprobante = strtoupper($row['serie']) . ' ' . strtoupper($row['numeracion']);
        $cliente = strtoupper($row['apellidosCliente'] . ' ' . $row['nombresCliente']);
        $tipoPago = $row['tipo'] == 1 ? "CONTADO" : "CRÉDITO";
        $formaPago = ($row['forma'] == "1") ? "EFECTIVO" : ($row['forma'] == "2" ? "TARJETA" : "POR CONDICIÓN");
        $estado = ($row['estado'] == "1") ? "<span style='color:#04a804;'>CANCELADO</span>" : ($row['estado'] == "2" ? "<span style='color:#DCAF08;'>PENDIENTE</span>" : "<span style='color: #cf0f1f;'>ANULADO</span>");
        $total = number_format($row['total'], 2, '.', ' ');
        if ($row['tipo'] == "1") {
            $totalContado += $row['total'];
        }else
        if ($row['tipo'] == "2") {
            $totalCredito += $row['total'];
        }
        $listar_ventas .= '
                <tr>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $count . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $procedencia . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $fecha->format("d/m/yy") . " " . VentaAdo::getTimeFormat($row['hora']) . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $vendedor . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $comprobante . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $cliente . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $tipoPago . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $formaPago . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $estado . '
                           </td>
                           <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $total . '
                           </td>
                </tr>
                           ';
    }
} else if ($opcion == 2) {
    $ventas = VentaAdo::getVentaReporteSearchPrincipal($_GET['search']);
    $count = 0;
    $totalContado = 0;
    $totalCredito = 0;
    while ($row = $ventas->fetch()) {
        $count++;
        $procedencia = $row['procedencia'] == "2" ? "VENTA DE PRODUCTOS" : "VENTA DE MEMBRESIA";
        $fecha = date_create($row['fecha']);
        $vendedor = strtoupper($row['apellidosEmpleado'] . ' ' . $row['nombresEmpleado']);
        $comprobante = strtoupper($row['serie']) . ' ' . strtoupper($row['numeracion']);
        $cliente = strtoupper($row['apellidosCliente'] . ' ' . $row['nombresCliente']);
        $tipoPago = $row['tipo'] == 1 ? "CONTADO" : "CRÉDITO";
        $formaPago = ($row['forma'] == "1") ? "EFECTIVO" : ($row['forma'] == "2" ? "TARJETA" : "POR CONDICIÓN");
        $estado = ($row['estado'] == "1") ? "<span style='color:#04a804;'>CANCELADO</span>" : ($row['estado'] == "2" ? "<span style='color:#DCAF08;'>PENDIENTE</span>" : "<span style='color: #cf0f1f;'>ANULADO</span>");
        $total = number_format($row['total'], 2, '.', ' ');
        if ($row['tipo'] == "1") {
            $totalContado += $row['total'];
        }else
        if ($row['tipo'] == "2") {
            $totalCredito += $row['total'];
        }
        $listar_ventas .= '
                <tr>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $count . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $procedencia . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $fecha->format("d/m/yy") . " " . VentaAdo::getTimeFormat($row['hora']) . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $vendedor . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $comprobante . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $cliente . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $tipoPago . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $formaPago . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $estado . '
                           </td>
                           <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $total . '
                           </td>
                </tr>
                           ';
    }
} else if ($opcion == 3) {
    $ventas = VentaAdo::getVentaReporteSearchOptions($_GET['transacciones'], $_GET['fechaInicio'], $_GET['fechaFin'], $_GET['tipo'], $_GET['forma'], $_GET['estado']);
    $count = 0;
    $totalContado = 0;
    $totalCredito = 0;
    while ($row = $ventas->fetch()) {
        $count++;
        $procedencia = $row['procedencia'] == "2" ? "VENTA DE PRODUCTOS" : "VENTA DE MEMBRESIA";
        $fecha = date_create($row['fecha']);
        $vendedor = strtoupper($row['apellidosEmpleado'] . ' ' . $row['nombresEmpleado']);
        $comprobante = strtoupper($row['serie']) . ' ' . strtoupper($row['numeracion']);
        $cliente = strtoupper($row['apellidosCliente'] . ' ' . $row['nombresCliente']);
        $tipoPago = $row['tipo'] == 1 ? "CONTADO" : "CRÉDITO";
        $formaPago = ($row['forma'] == "1") ? "EFECTIVO" : ($row['forma'] == "2" ? "TARJETA" : "POR CONDICIÓN");
        $estado = ($row['estado'] == "1") ? "<span style='color:#04a804;'>CANCELADO</span>" : ($row['estado'] == "2" ? "<span style='color:#DCAF08;'>PENDIENTE</span>" : "<span style='color: #cf0f1f;'>ANULADO</span>");
        $total = number_format($row['total'], 2, '.', ' ');
        if ($row['tipo'] == "1") {
            $totalContado += $row['total'];
        }else
        if ($row['tipo'] == "2") {
            $totalCredito += $row['total'];
        }
        $listar_ventas .= '
                <tr>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $count . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $procedencia . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $fecha->format("d/m/yy") . " " . VentaAdo::getTimeFormat($row['hora']) . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $vendedor . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $comprobante . '
                           </td>
                           <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $cliente . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $tipoPago . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $formaPago . '
                           </td>
                           <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">
                           ' . $estado . '
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
                            <h4>Reportes General de Ventas</h4>
                        </td>
                        <td width="30%" style="">
                            <h5>Fecha Inicio: ' . date_create($_GET['fechaInicio'])->format("d/m/yy") . '</h5>
                            <h5>Fecha Final: ' . date_create($_GET['fechaFin'])->format("d/m/yy") . '</h5>
                        </td>
                    </tr>
                </tbody>
            </table>
                        
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border: 1px solid rgb(148, 147, 147);">
                <thead style="background-color: rgb(209, 206, 206);">
                    <tr> 
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">#</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Transacción</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Fecha</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Vendedor</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Comprobante</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Cliente</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Tipo Pago</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Forma Pago</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Estado</th>
                        <th width="0%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $listar_ventas . '
                </tbody>
            </table>
            
            <br/>
            
            <div style="display:block;width:100%;height:auto;">
             
                <div style="display:block;width:auto;float:right;">
                    <table width="auto" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>
                                    <div style="padding: 10px;text-align:right;background-color: rgb(209, 206, 206);border: 1px solid rgb(160, 159, 159)">Ventas al contado:</div>
                                    <div style="padding: 10px;text-align:right;background-color: rgb(209, 206, 206);border: 1px solid rgb(160, 159, 159)">Ventas al crédito:<div>
                                </th> 
                                 <th>
                                    <div style="padding: 10px;text-align:right;border: 1px solid rgb(160, 159, 159)">' . number_format($totalContado, 2, '.', ' ') . '</div>
                                    <div style="padding: 10px;text-align:right;border: 1px solid rgb(160, 159, 159)">' . number_format($totalCredito, 2, '.', ' ') . '<div>
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
