<?php
date_default_timezone_set('America/Lima');
define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../venta/VentaAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logo.jpeg";
$title = "COMPROBANTE DE INGRESO";
$resumen = VentaAdo::reporteIngreso(intval($_GET["idIngreso"]));
if (!is_array($resumen)) {
    echo $resumen;
} else {
    $cabecera = $resumen[0];
    $detalle = $resumen[1];
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
        <tr>
            <td width="15.33333333333333%" style="background-color:white;">
                <img src="' . $rutaImage . '" style="width:80px;">
            </td>
            <td width="50.33333333333333%" style="text-align:center;">
                <span style="font-size: 11pt; color: black;">
                    <b>' . $title . ' </b>
                </span>
            </td>   
            <td width="33.33333333333333%" style="border: 1px solid #888888;text-align: center;vertical-align: middle;padding:0;">
                <table style="background-color:#aba8a8;padding:5px;font-size:9pt;border-spacing: 0;border-collapse: collapse" width="100%">
                    <tr>
                        <td style="padding:7px;border-bottom:1px solid #888888;">NUMERACIÓN</td>
                    </tr>
                </table>
                <table style="background-color:#bebdbd;padding:5px;border-spacing: 0;border-collapse: collapse" width="100%">
                    <tr>
                        <td style="padding:14px;">N° '.$cabecera->idIngreso.'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width="100%" style="font-family: Arial;font-weight:bold;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;" >
        <tr>   
            <td width="66.66666666666667%" style="border: 1px solid #888888;text-align: center;vertical-align: middle;padding:0;">
                <table width="100%" style="font-size:8pt;text-align:left;border-spacing: 0;border-collapse: collapse;">
                    <tr>
                        <td style="background-color:#aba8a8;padding:5px;width:25%;">CLIENTE:</td>
                        <td style="background-color:white;padding:5px;width:75%;border-bottom:1px solid #888888;">'.$cabecera->apellidos.' '.$cabecera->nombres.'</td>
                    </tr>
                    <tr>
                        <td style="background-color:#aba8a8;padding:5px;width:25%;">DIRECCIÓN:</td>
                        <td style="background-color:white;padding:5px;width:75%;border-bottom:1px solid #888888;">'.$cabecera->direccion.'</td>
                    </tr>
                    <tr>
                        <td style="background-color:#aba8a8;padding:5px;width:25%;">CELULAR:</td>
                        <td style="background-color:white;padding:5px;width:75%;border-bottom:1px solid #888888;">'.$cabecera->celular.'</td>
                    </tr>
                    <tr>
                        <td style="background-color:#aba8a8;padding:5px;width:25%;">METODO DE PAGO:</td>
                        <td style="background-color:white;padding:5px;width:75%;">'.($cabecera->forma==1?"EFECTIVO":"TARJETA").'</td>
                    </tr>
                </table>
            </td>
            <td width="33.33333333333333%" style="border: 1px solid #888888;text-align: center;vertical-align: middle;padding:0;">
                <table style="background-color:#aba8a8;padding:5px;font-size:9pt;border-spacing: 0;border-collapse: collapse;" width="100%">
                    <tr>
                        <td style="padding: 8px;border-bottom:1px solid #888888;">FECHA (DD/MM/YYYY)</td>
                    </tr>
                </table>
                <table style="background-color:white;border-spacing: 0;border-collapse: collapse;" width="100%">
                    <tr>
                        <td style="padding:18px;font-size:11px;">'.date("d/m/Y", strtotime($cabecera->fecha)).'<br>'.$cabecera->hora.'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    
    <table width="100%" style="font-family: Arial;font-size:11px;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;border:1px solid  #888888;">
        <tr>
            <td width="66.66666666666667%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                CONCEPTO
            </td>
            <td width="33.33333333333333%" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                VALOR
            </td>
        </tr>
         <tr>
            <td width="66.66666666666667%" style="background-color:#ffffff;padding:10px;text-align:left;border-right:1px solid #888888;">
                '. $detalle->detalle.'
            </td>
            <td width="33.33333333333333%" style="background-color:#ffffff;padding:10px;text-align:right;">
                S/ '.number_format(round($detalle->monto,2,PHP_ROUND_HALF_UP),2,'.','').'
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2" style="background-color:#aba8a8;padding:5px;text-align:center;font-weight:bold;">
                
            </td>
        </tr>
    </table>

    <table width="100%" style="font-family: Arial;font-weight:bold;border-spacing: 0;border-collapse: collapse;margin-bottom:20px;" >
    <tr>   
        <td width="66.66666666666667%">
            
        </td>
        <td width="33.33333333333333%" style="text-align: center;vertical-align: middle;padding:0;">
            <table style="background-color:white;border-spacing: 0;border-collapse: collapse;background-color:#aba8a8;" width="100%">
                <tr>
                    <td style="padding: 8px;">Total: </td>
                    <td style="padding:8px;font-size:11px;">S/ '.number_format(round($detalle->monto,2,PHP_ROUND_HALF_UP),2,'.','').'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    </body>
</html>
';


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
