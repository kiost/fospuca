<?php
require 'db.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$query = "SELECT * FROM dispositivos_gps";
try {
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Añadir encabezados
    $columns = array_keys($result[0]);
    foreach ($columns as $index => $column) {
        $sheet->setCellValueByColumnAndRow($index + 1, 1, $column);
    }

    // Añadir datos
    $rowNumber = 2;
    foreach ($result as $row) {
        foreach ($row as $index => $value) {
            $sheet->setCellValueByColumnAndRow(array_search($index, $columns) + 1, $rowNumber, $value);
        }
        $rowNumber++;
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'dispositivos_gps.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;

} catch (PDOException $e) {
    echo 'Error: No se pudo ejecutar la consulta. ' . $e->getMessage();
    exit;
}
?>
