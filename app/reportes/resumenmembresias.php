<?php
date_default_timezone_set('America/Lima');
define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../membresias/MembresiaAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logo.jpeg";

$title = "RESUMEN DE MEMBRESIAS - MES";
$fechaIngreso = $_GET["month"] . " / " . $_GET["year"];

$result = MembresiaAdo::listarMembresiasReporte(intval($_GET["month"]), intval($_GET["year"]));
if (!is_array($result)) {
    echo $result;
} else {
    $html = '
    <html>
    <head>
    <style>
        body {
            font-family: Arial;
            font-size: 10pt;
        }
        p {	
            font-family: Arial;
        }
        table.items {
            border: 0.1mm solid #000000;
        }
        td { 
            vertical-align: middle; 
        }
        table thead th {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
            border-top: 0.1mm solid #000000;
            border-bottom: 0.1mm solid #000000;
        }
        table tbody td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
            border-top: 0.1mm solid #000000;
            border-bottom: 0.1mm solid #000000;
        }
        table tfoot td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
            border-top: 0.1mm solid #000000;
            border-bottom: 0.1mm solid #000000;
        }
        table thead td { 
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
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
                       ' . date("d-m-Y") . '
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
    
    <table width="100%" style="font-family: serif;" cellpadding="10">
        <tr>
            <td width="15%" style="border: 0mm solid #888888;text-align: center;">
                <img src="' . $rutaImage . '" style="width:80px;">
            </td>
            <td width="85%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
                <span style="font-size: 14pt; color: black; font-family: sans;">
                    <b>' . $title . ' </b>
                </span>
                <br>
                <span style="font-size: 10pt; color: black; font-family: sans;">
                    DEL ' . $fechaIngreso . ' 
            </span>
            </td>
        </tr>
    </table>

    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>
            <th width="5%" rowspan="1">N°</th>
            <th width="35%" rowspan="1">CLIENTE</th>
            <th width="20%" rowspan="1">MEMBRESÍA</th>
            <th width="20%" rowspan="1">PLAN</th>        
            <th width="20%" rowspan="1">DURACIÓN</th>
            <th width="20%" rowspan="1">TIPO</th>
        </tr>       
    </thead>
    <tbody>' ?>

    <?php
    foreach ($result as $value) {
        
        $html .= '<tr>
                <td align="left">' . $value["id"] . '</td>
                <td align="left">' . $value["dni"] . '<br>' . $value["apellidos"] . '<br>' . $value["nombres"] . '</td>
                <td align="left">' . $value["membresia"]  . '</td>
                <td align="left">' . $value["nombrePlan"] . '</td>
                <td align="left">DEL ' . $value["fechaInicio"] . '<br> AL ' . $value["fechaFin"] . '</td>
                <td align="left"> ' . $value["tipo"]  . '</td>
            </tr>';
    }
    ?>

    <?php $html .= '</tbody></table>
    
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
