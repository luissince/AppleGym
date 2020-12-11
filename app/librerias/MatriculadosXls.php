<?php

set_time_limit(300); //evita el error 20 segundos de peticion
session_start();



    include 'phpExcel/Classes/PHPExcel.php';
    include 'phpExcel/Classes/PHPExcel/Writer/Excel2007.php';

//crear un objeto excel
    $objPHPExcel = new PHPExcel();

    function cellColor($cells, $color) {
        global $objPHPExcel;
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }

//propiedades del archivo
    $objPHPExcel->getProperties()->setCreator("Cepre UNCP")
            ->setLastModifiedBy("Cepre UNCP")
            ->setTitle("Reporte de Matriculados")
            ->setSubject("Archivo Digital Excel")
            ->setDescription("Documento Generado del Sistema de Cepre UNCP")
            ->setKeywords("Somos del Centro, Somos del Peru")
            ->setCategory("Archivo con Lista de Matriculados");

//=================================================================================================================
//                      HOJA DE EXCEL QUE CONTIENE LISTA DE MATRICULADOS
//=================================================================================================================

    $nhoja = 0;

    if ($nhoja > 0) {
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, "Lista General de Pagos");
        // Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet, $nhoja);
    }

    //ENCABEZADO
    $objPHPExcel->setActiveSheetIndex($nhoja)->mergeCells('A1:E1');

    $objPHPExcel->setActiveSheetIndex($nhoja)
            ->setCellValue('A1', 'CENTRO DE ESTUDIOS PREUNIVERSITARIOS - UNCP')
            ->setCellValue('A2', 'N°')
            ->setCellValue('B2', 'DNI')
            ->setCellValue('C2', 'CODIGO')
            ->setCellValue('D2', 'VOUCHER')
            ->setCellValue('E2', 'MONTO')
            ->setCellValue('F2', 'FECHA');

    // Fuente de la primera fila en negrita
    $boldArray = array('font' => array('bold' => true,), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
    $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($boldArray);

    //Ancho de las columnas
    //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);


    $xy = 0;
    $cel = 3;
    /*
    $sql_lista1 = "SELECT DISTINCT b.IdMatricula,b.DniPersona FROM matricula b
                        INNER JOIN programacionmatricula c on b.IdPeriodo = c.IdPeriodo AND b.sede = c.IdSede
                        INNER JOIN periodo d ON d.IdPeriodo = c.IdPeriodo
                        WHERE  DATE(NOW()) BETWEEN c.FechaApertura AND d.FechaCierre";
    $stmn_lista1 = $con->prepare($sql_lista1);
    $stmn_lista1->execute();


    while ($result_lista1 = $stmn_lista1->fetch(PDO::FETCH_ASSOC)) {

        $sql_pagos = "SELECT a.ID,a.Dni,b.CodigoMatricula,a.Voucher,a.Monto,a.Fecha
                        FROM historialpagos a 
                        INNER JOIN matricula b ON a.Dni = b.DniPersona
                        INNER JOIN programacionmatricula c on b.IdPeriodo = c.IdPeriodo AND b.sede = c.IdSede
                        INNER JOIN periodo d ON d.IdPeriodo = c.IdPeriodo
                        WHERE a.Dni = '" . $result_lista1['DniPersona'] . "' AND b.IdMatricula = '" . $result_lista1['IdMatricula'] . "'
                        AND DATE(a.Fecha) BETWEEN c.FechaApertura AND DATE(NOW()) ORDER BY Fecha ASC";
        $stmn_pagos = $con->prepare($sql_pagos);
        $stmn_pagos->execute();
*/
//        while ($result_pagos = $stmn_pagos->fetch(PDO::FETCH_ASSOC)) {

        	//----------- CONVERSION DE FECHA -------------
//        	$fpago = date_create($result_pagos['Fecha']);
//    		$fpago_x=date_format($fpago, 'd/m/Y');

            $xy = $xy + 1;
            $boldArray = array('font' => array('bold' => false,), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
            $objPHPExcel->getActiveSheet()->getStyle('A' . $cel . ':F' . $cel . '')->applyFromArray($boldArray);
            $objPHPExcel->getActiveSheet()->getStyle("E" . $cel)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->setActiveSheetIndex($nhoja)
                    ->setCellValue("A" . $cel, '01')
                    ->setCellValue("B" . $cel, 'dni')
                    ->setCellValue("C" . $cel, '4454545')
                    ->setCellValue("D" . $cel, '11221212')
                    ->setCellValue("E" . $cel, '220000')
                    ->setCellValue("F" . $cel, '20/20/2012');
            $cel += 1;
        //}
     
  /*   
    }
*/

    //A continuación se procede a darle formato a la celdas
    $rango = "A2:F2";
    $styleArray = array('font' => array('name' => 'Arial', 'size' => 10),
        'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF'))), ''
    );
    $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);


    if ($nhoja == 0) {
        // Cambiar el nombre de hoja de cálculo
        $objPHPExcel->getActiveSheet()->setTitle("Lista General de Pagos");
    }



// Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
    $objPHPExcel->setActiveSheetIndex(0);



// Redirigir la salida al navegador web de un cliente ( Excel5 )
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Lista de Pagos.xls"');
    header('Cache-Control: max-age=0');
// Si usted está sirviendo a IE 9 , a continuación, puede ser necesaria la siguiente
    header('Cache-Control: max-age=1');

// Si usted está sirviendo a IE a través de SSL , a continuación, puede ser necesaria la siguiente

    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

