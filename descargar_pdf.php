<?php
require 'db.php';
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

$query = "SELECT modelo, imei, estado, estado_operativo, fecha_compra FROM dispositivos_gps";
try {
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: No se pudo ejecutar la consulta. ' . $e->getMessage();
    exit;
}

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 15, 'Consulta de Dispositivos GPS', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Agregar la función Footer para incluir la marca de agua
    public function Footer() {
        $this->SetAlpha(0.2); // Ajustar la transparencia de la marca de agua
        $this->Image('images/fospuca-logo.png', 40, 40, 120, 120, '', '', '', false, 300, '', false, false, 0); // Posición y tamaño del icono
        $this->SetAlpha(1); // Restablecer la transparencia
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Consulta de Dispositivos GPS');
$pdf->SetHeaderData('', 0, 'Consulta de Dispositivos GPS', '');
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

$html = '<table border="1" cellspacing="3" cellpadding="4">
            <thead>
                <tr>
                    <th>Modelo</th>
                    <th>IMEI</th>
                    <th>Estado GPS</th>
                    <th>Estado Operativo</th>
                    <th>Fecha de Compra</th>
                </tr>
            </thead>
            <tbody>';

foreach ($result as $row) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['modelo']) . '</td>
                <td>' . htmlspecialchars($row['imei']) . '</td>
                <td>' . htmlspecialchars($row['estado']) . '</td>
                <td>' . htmlspecialchars($row['estado_operativo']) . '</td>
                <td>' . htmlspecialchars($row['fecha_compra']) . '</td>
                </tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('dispositivos_gps.pdf', 'D');
?>
