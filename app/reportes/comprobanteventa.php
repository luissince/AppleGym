<?php
date_default_timezone_set('America/Lima');
define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../venta/VentaAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logo.jpeg";
$title = "COMPROBANTE DE INGRESO";

$result = VentaAdo::repoteVenta($_GET["idVenta"]);
if (!is_array($result)) {
    echo $result;
} else {

    $venta = $result[0];
    $detalleVenta = $result[1];
    $empresa = $result[2];
    $credito = $result[3];

    $html = '
<html>
    <head>
        <style>
            body {
                font-family: Arial;
                font-size: 10pt;
            }
        </style>
    </head>
    <body>

    <!--mpdf
    <htmlpageheader name="myheader">
        <table width="100%">
            <tr>
                <td width="50%" style="color:#969696; ">
                    <span style="font-weight: bold; font-size: 9pt;">
                        AppleGym Perú
                    </span>
                </td>
                <td width="50%" style="color:#969696;text-align: right;">
                    <span style="font-weight: bold; font-size: 9pt;">
                    ' . date("d/m/Y") . '
                    </span>
                </td>
            </tr>
        </table>
    </htmlpageheader>
    <htmlpagefooter name="myfooter">
        <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Pagin {PAGENO} de {nb}
        </div>
    </htmlpagefooter>
    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->

    <table width="100%" style="font-family: Arial;font-weight:bold;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;">
        <tbody>
            <tr>
                <td width="20%" style="background-color:white;">
                    <img src="' . $rutaImage . '" style="width:80px;">
                </td>
                <td width="50%" style="text-align:center;">
                    <span style="font-size: 10pt; color: black;">
                        <b>' . $empresa->nombreEmpresa . ' </b>
                    </span>
                    <br>
                    <span style="font-size: 8pt; color: black;">
                        <b>' . $empresa->direccion . ' </b>
                    </span>
                    <br>
                    <span style="font-size: 8pt; color: black;">
                        <b>' . $empresa->telefono . ' ' . $empresa->celular . ' </b>
                    </span>
                    <br>
                    <span style="font-size: 8pt; color: black;">
                        <b>' . $empresa->email . '</b>
                    </span>
                    <br>
                    <span style="font-size: 8pt; color: black;">
                        <b>' . $empresa->paginaWeb . '</b>
                    </span>
                </td>   
                <td width="30%" style="border: 1px solid #888888;text-align: center;vertical-align: middle;padding:0;">
                    <table style="background-color:#aba8a8;padding:5px;font-size:9pt;border-spacing: 0;border-collapse: collapse" width="100%">
                        <tr>
                            <td style="padding:7px;border-bottom:1px solid #888888;">RUC: ' . $empresa->ruc . '</td>
                        </tr>
                    </table>
                    <table style="background-color:#bebdbd;padding:5px;border-spacing: 0;border-collapse: collapse" width="100%">
                        <tr>
                            <td style="padding:5px;">' . $venta->nombre . '</td>
                        </tr>
                        <tr>
                            <td style="padding:5px;">' . $venta->serie . '-' . $venta->numeracion . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table width="100%" style="font-family: Arial;font-size:11px;font-weight:bold;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;" >
            <thead>
                <tr>
                    <th width="20%" style="background-color:#aba8a8;padding:5px;text-align:left;border-top:1px solid #888888;border-left:1px solid #888888;">CLIENTE:</th>
                    <th width="50%" style="background-color:white;padding:5px;text-align:left;border:1px solid #888888;">' . $venta->dni . ' ' . $venta->apellidos . ' ' . $venta->nombres . '</th>
                    <th width="30%" style="background-color:#aba8a8;padding:5px;text-align:center;border:1px solid #888888">FECHA EMISIÓN</th>
                </tr>
                <tr>
                    <th width="20%" style="background-color:#aba8a8;padding:5px;text-align:left;border-left:1px solid #888888;">DIRECCIÓN:</th>
                    <th width="50%" style="background-color:white;padding:5px;text-align:left;border-left:1px solid #888888;border-right:1px solid #888888;">' . $venta->direccion . '</th>
                    <th width="30%" style="background-color:white;padding:5px;text-align:center;border-right:1px solid #888888"></th>
                <tr>
                <tr>
                    <td width="20%" style="background-color:#aba8a8;padding:5px;text-align:left;border-left:1px solid #888888;">CELULAR:</td>
                    <td width="50%" style="background-color:white;padding:5px;text-align:left;border:1px solid #888888;">' . $venta->celular . '</td>
                    <th width="30%" style="background-color:white;padding:5px;text-align:center;border-right:1px solid #888888">' . date("d/m/Y", strtotime($venta->fecha)) . '</th>
                </tr>
                <tr>
                    <td width="20%" style="background-color:#aba8a8;padding:5px;text-align:left;border-left:1px solid #888888;border-bottom:1px solid #888888;">METODO DE PAGO:</td>
                    <td width="50%" style="background-color:white;padding:5px;text-align:left;border-left:1px solid #888888;border-right:1px solid #888888;border-bottom:1px solid #888888;">' . ($venta->tipo == 1 ? "CONTADO" : "CRÉDITO") . '</td>
                    <th width="30%" style="background-color:white;padding:5px;text-align:center;border-bottom:1px solid #888888;border-right:1px solid #888888"></th>
                </tr>
            </thead>
    </table>

     
    <table width="100%" style="font-family: Arial;font-size:11px;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;border:1px solid  #888888;">
        <thead>
            <tr>
                <th width="5%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                    #
                </th>
                <th width="35%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                    CONCEPTO
                </th>
                <th width="15%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                    CANTIDAD
                </th>
                <th width="15%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                    PRECIO UNT.
                </th>
                <th width="15%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                    DESCUENTO
                </th>
                <th width="15%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                    IMPORTE
                </th>
            </tr> 
        </thead>
        <tbody>';
?>
        <?php
        $count = 0;

        $importeBruto = 0;
        $descuento = 0;
        $subImporte = 0;
        $impuesto = 0;
        $importeNeto = 0;

        foreach ($detalleVenta as $value) {
            $count++;
            $html .= '
            <tr>
               <td width="" style="background-color:#ffffff;padding:10px;text-align:left;border-right:1px solid #888888;">
                   ' . $count . '
               </td>
               <td width="" style="background-color:#ffffff;padding:10px;text-align:left;border-right:1px solid #888888;">
                    ' . $value->detalle . '
               </td>
               <td width="" style="background-color:#ffffff;padding:10px;text-align:right;border-right:1px solid #888888;">
                    ' . number_format(round($value->cantidad, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '
               </td>
               <td width="" style="background-color:#ffffff;padding:10px;text-align:right;border-right:1px solid #888888;">
                    ' . number_format(round($value->precio, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '
               </td>
               <td width="" style="background-color:#ffffff;padding:10px;text-align:right;border-right:1px solid #888888;">
                    ' . number_format(round($value->descuento, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '
               </td>
               <td width="" style="background-color:#ffffff;padding:10px;text-align:right;">
                    ' . number_format(round((($value->precio - $value->descuento) * $value->cantidad), 2, PHP_ROUND_HALF_UP), 2, '.', '') . '
               </td>
            </tr>';
            $importeBruto += $value->precio * $value->cantidad;
            $descuento += $value->descuento * $value->cantidad;
            $importeNeto += (($value->precio - $value->descuento) * $value->cantidad);
        }
        ?>
        <?php
        $html .= '</tbody>            
       <tfoot>
        <tr>
               <td width="100%" colspan="6" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">   
               </td>
           </tr>
       </tfoot>    
    </table>

  <table width="100%" style="font-family: Arial;font-size:11px;font-weight:bold;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;" >
        <thead>
            <tr>
                <th width="20%"></th>
                <th width="50%"></th>
                <th width="15%" style="text-align:left;padding:5px;">IMPORTE BRUTO:</th>
                <th width="15%" style="text-align:right;padding:5px;">' . number_format(round($importeBruto, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
            </tr>
            <tr>
                <th width="20%"></th>
                <th width="50%"></th>
                <th width="15%" style="text-align:left;padding:5px;">DESCUENTO:</th>
                <th width="15%" style="text-align:right;padding:5px;">' . number_format(round($descuento, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
            </tr>
            <tr>
                <th width="20%"></th>
                <th width="50%"></th>
                <th width="15%" style="text-align:left;background-color:#aba8a8;padding:5px;">IMPORTE NETO:</th>
                <th width="15%" style="text-align:right;background-color:#aba8a8;padding:5px;">' . number_format(round($importeNeto, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
            </tr>
        </thead>
    </table>';
        ?>

    <?php

    if (!empty($credito)) {
        $html .= '
        <table width="100%" style="font-family: Arial;font-size:11px;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;">
            <thead>
                <tr>
                    <th style="text-align:left;padding:5px;">PLAZOS DE PAGO</th>                
                </tr>
            </thead>
            <tbody>';

            $plazo = 0;
            foreach ($credito as $value) {
                $plazo++;
                if($value->estado == 0){
                    $html .= '
                    <tr>
                        <td style="text-align:left;padding:5px;color:red;font-weight:normal;">CUOTA N° '.$plazo.' POR PAGAR POR EL MONDO DE S/ '.number_format(round($value->monto, 2, PHP_ROUND_HALF_UP), 2, '.', '') .'</td>
                    </tr>';
                }else{
                    $html .= '
                    <tr>
                        <td style="text-align:left;padding:5px;color:black;font-weight:normal;">CUOTA N° '.$plazo.' PAGADO POR EL MONDO DE S/ '.number_format(round($value->monto, 2, PHP_ROUND_HALF_UP), 2, '.', '') .'</td>
                    </tr>';
                }
                
            }

        $html .= '</tbody>
        </table>';
    }

    ?>

<?php
    $html .= '<table width="100%" style="font-family: Arial;font-size:11px;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;" >
        <thead>
            <tr>
                <th colspan="6" style="text-align:left;padding:5px;font-weight:bold;">TÉRMINOS Y CONDICIONES</th>
            </tr>
            <tr>
                <th colspan="6" style="text-align:left;padding:5px;font-weight:normal;">' . $empresa->terminos . '</th>
            </tr>
        </thead>
    </table>

    </body>
</html>';


    $mpdf = new \Mpdf\Mpdf([
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 18,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10
    ]);

    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle("AppleGym Perú");
    $mpdf->SetAuthor("AppleGym Perú");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);

    $mpdf->Output();
}
