<?php
require 'db.php';
require 'vendor/autoload.php'; // Incluir el autoload de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excel_file"])) {
    $file = $_FILES["excel_file"]["tmp_name"];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        foreach ($rows as $row) {
            $id = $row[0];
            $modelo = $row[1];
            $imei = $row[2];
            $condicion = $row[3];
            $estado_gps = $row[4];

            $query = "UPDATE dispositivos_gps SET modelo = :modelo, imei = :imei, condicion = :condicion, estado_gps = :estado_gps WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':imei', $imei);
            $stmt->bindParam(':condicion', $condicion);
            $stmt->bindParam(':estado_gps', $estado_gps);

            $stmt->execute();
        }

        $_SESSION['message'] = "Datos actualizados correctamente.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Error al procesar el archivo: " . $e->getMessage();
    }

    header('Location: consulta_gps.php');
    exit();
}
?>
