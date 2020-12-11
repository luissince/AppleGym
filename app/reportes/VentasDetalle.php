<?php

set_time_limit(300);
session_start();
require_once '../librerias/dompdf/autoload.inc.php';
require '../venta/VentaAdo.php';

use Dompdf\Dompdf;

$idVenta = $_GET['idVenta'];
$procedencia = $_GET['procedencia'];
$empresa = $_GET['empresa'];
$empresa_documento = $_GET['empresaDocumento'];
$empresa_direccion = $_GET['empresaDireccion'];
$empresa_telefono_celular = 'Tel: '.$_GET['empresaTelefono'].' Cel: '.$_GET['empresaCelular'];
$empresa_email = $_GET['empresaEmail'];
$empresa_pagina_web = $_GET['empresaPaginaWeb'];
$empresa_terminos = $_GET['empresaTerminos'];

$ventas = VentaAdo::getVenta($idVenta);
$ventas_detalle = VentaAdo::getVentaDetalle($idVenta, $procedencia);
$venta_credito = VentaAdo::getVentaCredito($idVenta);
$lista_venta_detalle = '';
$lista_condicion_pago = '';

$subTotal = 0;
$descuento = 0;
$total = 0;

for ($index = 0; $index < count($ventas_detalle); $index++) {
    $lista_venta_detalle .= '<tr>';
    $new_lista_venta_detalle = $ventas_detalle[$index];

    foreach ($new_lista_venta_detalle as $key => $value) {

        $subTotal += $key == "subTotal" ? $value : 0;
        $descuento += $key == "descuento" ? $value : 0;
        $total += $key == "total" ? $value : 0;

        if ($key !== "subTotal") {
            if ($key == "id") {
                $lista_venta_detalle .= '
                <td style="text-align:center;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">' . $value . '</td>';
            } else if ($key == "nombre") {
                $lista_venta_detalle .= '
                <td style="text-align:left;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">' . strtoupper($value) . '</td>';
            } else if ($key == "cantidad") {
                $lista_venta_detalle .= '
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">' . number_format($value, 2, '.', '') . '</td>';
            } else if ($key == "precio") {
                $lista_venta_detalle .= '
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">' . number_format($value, 2, '.', '') . '</td>';
            } else if ($key == "descuento") {
                $lista_venta_detalle .= '
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">-' . number_format($value, 2, '.', '') . '</td> ';
            } else if ($key == "total") {
                $lista_venta_detalle .= '
                <td style="text-align:right;padding: 6px 7px;border: 1px solid rgb(148, 147, 147);font-size:11pt;">' . number_format($value, 2, '.', '') . '</td>';
            }
        }
    }
    $lista_venta_detalle .= '</tr>';
}
if (is_array($venta_credito)) {
    if (empty($venta_credito)) {
        $lista_condicion_pago .= ' <span>Pago al contado por el valor de S/. ' . number_format($total, 2, '.', '') . '</span>';
    } else {
        for ($i = 0; $i < count($venta_credito); $i++) {
            $new_venta_credito = $venta_credito[$index];
            $lista_condicion_pago .= '<span>Venta al crédito - Cuota Nro. '.(($i + 1) < 10 ? "00" + ($i + 1) : ($i + 1) >= 10 && ($i + 1) < 100 ? "0" + ($i + 1) : ($i + 1)).' ';
            foreach ($new_venta_credito as $key => $value) {
                $lista_condicion_pago .= ($key == "fechaRegistro" ? " Vence el <b><u>".date_format(date_create($value), "d/m/Y")."</u></b>" : "");
                $lista_condicion_pago .= ($key == "monto" ? " por S/. ".number_format($value,2,'.',''):"");
                $lista_condicion_pago .= ($key == "estado" ? $value == 1 ? " Estado Pagado ":" Estado en Proceso " : "");
            }
            $lista_condicion_pago .= '.</span><br/><br/>';
        }
    }
}


$documento = $ventas['documento'] == "1" ? "BOLETA" : ($ventas['documento'] == "2" ? "FACTURA" : "TICKET");
$serie = strtoupper($ventas["serie"]);
$numeracion = strtoupper($ventas["numeracion"]);
$fechaVenta = $ventas["fecha"];
$fechaVencimiento = $ventas["fecha"];
$tipoVenta = $procedencia == "1" ? "VENTA DE MEMBRESIA" : "VENTA DE PRODUCTOS";

$cliente = $ventas["apellidosCliente"] . " " . $ventas["nombresCliente"];
$documentoCliente = $ventas["dni"];
$celularCliente = $ventas["celular"];
$emailCliente = $ventas["email"];
$direccionCliente = $ventas["direccion"];
$observacion = "";

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
                <thead>
                    <tr>
                        <th width="30%" style="">
                            <img src="../images/logo.jpeg" alt="Logo" width="180" />
                        </th>
                        <th width="40%" style="text-align: center;font-size:11.5pt;">
                            <div style="padding:2px">
                                '.$empresa.'
                            </div>
                            <div style="padding:2px">
                                '.$empresa_direccion.'
                            </div
                            <div style="padding:2px">
                                '.$empresa_telefono_celular.'
                            </div>
                            <div style="padding:2px">
                                '.$empresa_email.'
                            </div>
                            <div style="padding:2px">
                                '.$empresa_pagina_web.'
                            </div>
                        </th>
                        <th width="30%" text-aling: center;">
                            <div style="border: 1px solid gray;text-align: center;">
                                <div style="padding: 8px 10px">
                                    R.U.C '.$empresa_documento.'
                                </div>
                                <div style="padding: 8px 10px;">
                                    ' . $documento . '
                                </div>
                                <div style="padding: 8px 10px;">
                                    ' . $serie . ' - ' . $numeracion . '
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody style="font-size:15px;">
                    <tr>
                        <td width="70%">
                            <table style="border:1px solid rgb(148, 147, 147);" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="border-right:1px solid rgb(148, 147, 147);width:120px;background-color:rgb(209, 206, 206);text-align:right;font-weight:bold;padding:6px 4px;">    
                                            Cliente:
                                        </td>
                                        <td style="text-align:left;padding:6px 4px;">    
                                            ' . $cliente . '
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td style="border-right:1px solid rgb(148, 147, 147);width:120px;background-color:rgb(209, 206, 206);text-align:right;font-weight:bold;padding:6px 4px;">     
                                            Documento:
                                        </td>
                                        <td style="text-align:left;padding:6px 4px;">    
                                            ' . $documentoCliente . '
                                        </td>
                                    </tr> 
                                     <tr>
                                        <td style="border-right:1px solid rgb(148, 147, 147);width:120px;background-color:rgb(209, 206, 206);text-align:right;font-weight:bold;padding:6px 4px;">     
                                            Celular:
                                        </td>
                                        <td style="text-align:left;padding:6px 4px;">    
                                            ' . $celularCliente . '
                                        </td>
                                    </tr> 
                                     <tr>
                                        <td style="border-right:1px solid rgb(148, 147, 147);width:120px;background-color:rgb(209, 206, 206);text-align:right;font-weight:bold;padding:6px 4px;">     
                                            Email:
                                        </td>
                                        <td style="text-align:left;padding:6px 4px;">    
                                            ' . $emailCliente . '
                                        </td>
                                    </tr> 
                                     <tr>
                                        <td style="border-right:1px solid rgb(148, 147, 147);width:120px;background-color:rgb(209, 206, 206);text-align:right;font-weight:bold;padding:6px 4px;">     
                                            Dirección:
                                        </td>
                                        <td style="text-align:left;padding:6px 4px;">    
                                            ' . $direccionCliente . '
                                        </td>
                                    </tr> 
                                     <tr>
                                        <td style="border-right:1px solid rgb(148, 147, 147);width:120px;background-color:rgb(209, 206, 206);text-align:right;font-weight:bold;padding:6px 4px;">     
                                            Observación:
                                        </td>
                                        <td style="text-align:left;padding:6px 4px;">    

                                        </td>
                                    </tr> 
                                </tbody>    
                            </table>
                        </td>
                        <td width="30%">
                            <table style="border-top:1px solid rgb(148, 147, 147);border-right:1px solid rgb(148, 147, 147);border-bottom:1px solid rgb(148, 147, 147);" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="background-color:rgb(209, 206, 206);padding:6px 2px;text-align:center;">
                                       Fecha de Venta
                                        </td>                                      
                                    </tr>
                                    <tr>
                                        <td style="padding:6px 2px;text-align:center;">
                                        ' . $fechaVenta . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:rgb(209, 206, 206);padding:6px 2px;text-align:center;">
                                        Fecha de Vencimiento
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:6px 2px;text-align:center;">
                                        ' . $fechaVencimiento . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:rgb(209, 206, 206);padding:6px 2px;text-align:center;">
                                            Transacción
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:6px 2px;text-align:center;">
                                        ' . $tipoVenta . '
                                        </td>
                                    </tr>
                                <tbody>
                            </table>
                        </td>
                    </tr>                   
                </tbody>
            </table>
            
            <br/>
            
            <table width="100%" style="border-collapse: collapse;border: 1px solid rgb(148, 147, 147);">
                <thead style="background-color: rgb(209, 206, 206);">
                    <tr> 
                        <th width="7%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">#</th>
                        <th width="41%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Detalle</th>
                        <th width="12%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Cantidad</th>
                        <th width="12%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Precio</th>
                        <th width="12%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Descuento</th>
                        <th width="12%" style="padding: 6px 7px;text-align:center;border: 1px solid rgb(148, 147, 147);">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $lista_venta_detalle . '
                </tbody>
            </table>
            
            <br/>
            
            <div style="display:block;width:100%;height:auto;">
            
                <div style="display:block;width:auto;float:left;">
                    <table width="200" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th style="padding:10px;">
                                    <div style="margin-bottom:5px;font-size:11pt;font-weight:bold;border-bottom:1px solid rgb(148, 147, 147);">Condición de pago:</div>
                                    <div style="text-align:left;">
                                        ' . $lista_condicion_pago . '
                                    </div>
                                </th> 
                            </tr> 
                        </thead>
                    </table>
                     <table width="200" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th style="padding:10px;">
                                    <div style="margin-bottom:5px;font-size:11pt;font-weight:bold;border-bottom:1px solid rgb(148, 147, 147);">Términos y Condiciones:</div>
                                    <div style="text-align:justify;">'.$empresa_terminos.'</div>
                                </th> 
                            </tr> 
                        </thead>
                    </table>
                </div>
                
                <div style="display:block;width:auto;float:right;">
                    <table width="auto" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>
                                    <div style="padding: 10px 5px 10px 65px;text-align:right;border-top: 1px solid rgb(148, 147, 147);border-left: 1px solid rgb(148, 147, 147);">Sub Total:</div>
                                    <div style="padding: 10px 5px 10px 65px;text-align:right;border-top: 1px solid rgb(148, 147, 147);border-left: 1px solid rgb(148, 147, 147);">Descuento:</div>
                                    <div style="padding: 10px 5px 10px 65px;text-align:right;border-top: 1px solid rgb(148, 147, 147);border-left: 1px solid rgb(148, 147, 147);border-bottom: 1px solid rgb(148, 147, 147);background-color: rgb(209, 206, 206);font-weight:bold;">Total:</div>
                                </th> 
                                <th>
                                    <div style="padding: 10px 5px 10px 65px;text-align:right;border-top: 1px solid rgb(148, 147, 147);border-left: 1px solid rgb(148, 147, 147);border-right: 1px solid rgb(148, 147, 147);">' . number_format($subTotal, 2, '.', '') . '</div>
                                    <div style="padding: 10px 5px 10px 65px;text-align:right;border-top: 1px solid rgb(148, 147, 147);border-left: 1px solid rgb(148, 147, 147);border-right: 1px solid rgb(148, 147, 147);">-' . number_format($descuento, 2, '.', '') . '</div>
                                    <div style="padding: 10px 5px 10px 65px;text-align:right;border-top: 1px solid rgb(148, 147, 147);border-left: 1px solid rgb(148, 147, 147);border-right: 1px solid rgb(148, 147, 147);border-bottom: 1px solid rgb(148, 147, 147);background-color: rgb(209, 206, 206);font-weight:bold;">' . number_format($total, 2, '.', '') . '</div>
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
//$dompdf->stream('ListaMatriculados.pdf');
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename=documento.pdf');
echo $dompdf->output();
