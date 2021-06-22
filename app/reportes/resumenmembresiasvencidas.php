<?php
date_default_timezone_set('America/Lima');
define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../miempresa/MiEmpresaAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logo.jpeg";
$result = MiEmpresaAdo::ListarDashboard();
if (!is_array($result)) {
    echo $result;
} else {

    $arrayFinalizadas = $result[6];

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
        <td width="100%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
            <span style="font-size: 14pt; color: black; font-family: sans;">
                <b>RESUMEN DE MEMBRESÍAS VENCIDAS</b>
            </span>
            <br>
            <span style="font-size: 10pt; color: black; font-family: sans;">
                Clientes por Recuperar (Membresías que vencieron en los ultimos 30 días)
            </span>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>
            <th width="5%">N°</th>
            <th width="30%">Cliente</th>
            <th width="12%">Fecha de Finalización</th>
            <th width="12%">N° Celular</th>           
        </tr>
    </thead>
    <tbody>';
?>
    <?php
    $count = 0;
    foreach ($arrayFinalizadas as $value) {
        $count++;
        $html .= '<tr>
            <td>' .   $count . '</td>
            <td>' . $value["dni"] . '<br>' . $value["apellidos"] . ' ' . $value["nombres"] . '</td>
            <td>' .  date('d/m/Y', strtotime($value["fechaFin"])) . '</td>
            <td>' . $value["celular"] . '</td>
        </tr>';
    }
    ?>
    <?php
    $html .= '</tbody>
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
    $mpdf->SetTitle("Resumen de Asistencia - Clientes");
    $mpdf->SetAuthor("SysSoft Integra");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);

    $mpdf->Output();
}
