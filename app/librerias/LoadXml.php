<?php
include 'phpExcel/Classes/PHPExcel.php';
include '../cliente/ClienteAdo.php';
$texto1 = "ANGEL AGUSTIN VARGAS";
$datos1 = explode(" ", $texto1);
echo count($datos1) . '<br/>';

$texto2 = "EDGAR ABRAHAM SAMANIEGO TOMAS";
$datos2 = explode(" ", $texto2);
echo count($datos2) . '<br/>';

$texto3 = "IVAN  MANUEL VASQUEZ SANCHEZ (R2)";
$datos3 = explode(" ", $texto3);
echo count($datos3) . '<br/>';

$texto4 = "EVELIN NINA,ANGA CONLLACLLA";
$datos4 = explode(" ", $texto4);
echo count($datos4) . '<br/>';

$texto5 = "GLORIA MARIA DE JESUS SANTIVAÑEZ SANCHEZ";
$datos5 = explode(" ", $texto5);
echo count($datos5) . '<br/>';

if (isset($_FILES['excel']) && $_FILES['excel']['error'] == 0) {

    $array = array();

    echo '<br/>';

    $tmpfname = $_FILES['excel']['tmp_name'];
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();

    //echo "<table class=\"table table-sm\">";
    for ($row = 1; $row <= $lastRow; $row++) {
        $datos = explode(" ", $worksheet->getCell('B' . $row)->getValue());
        $apellidos = "";
        $nombres = "";
        if (count($datos) == 3) {
            $apellidos = $datos[1] . " " . $datos[2];
            $nombres = $datos[0];
        } else
        if (count($datos) == 4) {
            $apellidos = $datos[3] . " " . $datos[4];
            $nombres = $datos[1] . " " . $datos[2];
        } else if (count($datos) == 5) {
            $apellidos = $datos[4] . " " . $datos[5];
            $nombres = $datos[1] . " " . $datos[2] . " " . $datos[3];
        } else if (count($datos) == 6) {
            $apellidos = $datos[4] . " " . $datos[5] . " " . $datos[6];
            $nombres = $datos[1] . " " . $datos[2] . " " . $datos[3];
        } else {
            $apellidos = $worksheet->getCell('B' . $row)->getValue();
            $nombres = $worksheet->getCell('B' . $row)->getValue();
        }

        array_push($array, array(
            "dni" => (is_null($worksheet->getCell('A' . $row)->getValue()) || $worksheet->getCell('A' . $row)->getValue() == "" ? "" : $worksheet->getCell('A' . $row)->getValue()),
            "apellidos" => $apellidos,
            "nombres" => $nombres,
            "sexo" => 0,
            "fechaNacimiento" => "0000/00/00",
            "codigo" => "",
            "email" => "",
            "celular" => (is_null($worksheet->getCell('I' . $row)->getValue()) || $worksheet->getCell('I' . $row)->getValue() == "" ? "" : $worksheet->getCell('I' . $row)->getValue()),
            "direccion" => ""
        ));
        /*
          echo "<tr><td scope=\"row\">";
          echo $worksheet->getCell('A' . $row)->getValue();
          echo "</td><td>";
          echo $worksheet->getCell('B' . $row)->getValue();
          echo "</td><td>";
          echo $worksheet->getCell('C' . $row)->getValue();
          echo "</td><td>";
          echo $worksheet->getCell('I' . $row)->getValue();
          echo "</td><tr>"; */
    }
    //echo "</table>";



    for ($i = 0; $i < count($array); $i++) {
        $body = $array[$i];
        $insert = ClienteAdo::insert($body);

        if ($insert == "inserted") {
            echo $insert;
        } else {
            echo $insert;
        }
        echo '<br/>';
    }
}
?>

<form action = "" method = "POST" enctype = "multipart/form-data">
    <input type = "file" name = "excel"  />
    <input type = "submit"/>
</form>

