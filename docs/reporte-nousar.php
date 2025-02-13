<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


include('db.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function descargarExcel($tabla, $columnas, $datos) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar encabezados
    $col = 0;
    foreach ($columnas as $columna) {
        $sheet->setCellValueByColumnAndRow($col + 1, 1, $columna);
        $col++;
    }

    // Agregar datos
    $fila = 2;
    foreach ($datos as $dato) {
        $col = 0;
        foreach ($dato as $valor) {
            $sheet->setCellValueByColumnAndRow($col + 1, $fila, $valor);
            $col++;
        }
        $fila++;
    }

    // Descargar archivo
    $nombreArchivo = $tabla . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tabla = $_POST['tabla'];
    
    $stmt = $pdo->query("SELECT * FROM $tabla");
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columnas = array_keys($datos[0]);

    descargarExcel($tabla, $columnas, $datos);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Tablas</title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <meta charset="utf-8" />
    <!-- Importar Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Estilos Personalizados -->
    <style>
        .parallax-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: url('path/to/your/parallax-image.jpg') no-repeat center center fixed;
            background-size: cover;
            z-index: 1000;
        }
        .parallax-menu-content {
            position: relative;
            height: 100%;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.5);
        }
        .nav-link {
            color: #fff;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media only screen and (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
            .parallax-menu {
                width: 100%;
                height: auto;
                position: relative;
            }
        }
    </style>
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Reportes</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
<div class="container">
    <h1>Consultar Tablas</h1>

    <form action="reporte.php" method="POST">
        <div class="input-field">
            <select name="tabla">
                <option value="" disabled selected>Elige una tabla</option>
                <option value="usuarios">Usuarios</option>
                <option value="requisiciones">Requisiciones</option>
                <option value="dispositivos">Dispositivos</option>
                <option value="mantenimientos">Mantenimientos</option>
                <option value="proveedores">Proveedores</option>
            </select>
            <label>Tablas</label>
        </div>
        <button type="submit" class="btn">Consultar y Descargar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>