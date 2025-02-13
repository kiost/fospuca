<?php
require 'db.php';
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    private $tableTitle;

    public function setTableTitle($tableTitle) {
        $this->tableTitle = $tableTitle;
    }

    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 15, 'Consulta de ' . $this->tableTitle, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Agregar la función Footer para incluir la marca de agua
    public function Footer() {
        $this->SetAlpha(0.1); // Ajustar la transparencia de la marca de agua
        $this->Image('images/fospuca-logo.png', 40, 40, 120, 120, '', '', '', false, 300, '', false, false, 0); // Posición y tamaño del icono
        $this->SetAlpha(1); // Restablecer la transparencia
    }
}

if (isset($_GET['tabla'])) {
    $tabla = $_GET['tabla'];
    $query = "SELECT * FROM $tabla";
    try {
        $stmt = $pdo->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: No se pudo ejecutar la consulta. ' . $e->getMessage();
        exit;
    }

    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Consulta de ' . ucfirst($tabla));
    $pdf->setTableTitle(ucfirst($tabla)); // Establecer el título de la tabla
    $pdf->SetHeaderData('', 0, 'Consulta de ' . ucfirst($tabla), '');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    $html = '<h2>Consulta de ' . ucfirst($tabla) . '</h2>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4">
                <thead>
                    <tr>';
    
    // Agregar encabezados dinámicamente
    foreach ($result[0] as $columna => $valor) {
        $html .= '<th>' . htmlspecialchars($columna) . '</th>';
    }

    $html .= '</tr></thead><tbody>';

    // Agregar datos dinámicamente
    foreach ($result as $row) {
        $html .= '<tr>';
        foreach ($row as $valor) {
            $html .= '<td>' . htmlspecialchars($valor) . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('consulta_' . $tabla . '.pdf', 'D');
}
?>
