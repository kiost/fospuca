<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'menu.php';

$query = "SELECT id, modelo, imei, estado, estado_operativo, fecha_compra FROM dispositivos_gps";
try {
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: No se pudo ejecutar la consulta. ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Consulta de Dispositivos GPS</title>
    <!-- Importar Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Importar DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Importar DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
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
        .message-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1001;
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='card-panel green lighten-4 green-text text-darken-4 message-popup' id='message-popup'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Consulta de Dispositivos GPS</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h2>Consulta de Dispositivos GPS</h2>
            <a href="exportar_excel.php" class="btn">Descargar Excel</a>
            <a href="descargar_pdf.php" class="btn">Descargar PDF</a>
            <table id="gpsTable" class="striped">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>IMEI</th>
                        <th>Estado Operativo</th>
                        <th>Estado</th>
                        <th>Fecha de Compra</th>
                        
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td data-id='" . $row['id'] . "' data-field='modelo'>" . htmlspecialchars($row['modelo']) . "</td>";
                        echo "<td data-id='" . $row['id'] . "' data-field='imei'>" . htmlspecialchars($row['imei']) . "</td>";
                        echo "<td data-id='" . $row['id'] . "' data-field='estado_operativo'>" . htmlspecialchars($row['estado_operativo']) . "</td>";
                        echo "<td data-id='" . $row['id'] . "' data-field='estado'>" . htmlspecialchars($row['estado']) . "</td>";
                        echo "<td data-id='" . $row['id'] . "' data-field='fecha_compra'>" . htmlspecialchars($row['fecha_compra']) . "</td>";
                        
                        echo "<td><a href='registro_gps.php?id=" . $row['id'] . "' class='btn'>Modificar</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="dashboard.php" class="btn">Ir al Dashboard</a>
        </div>
    </div>
    <!-- Importar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Importar Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Importar DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Importar DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <!-- Script para DataTables y Botones -->
    <script>
        $(document).ready(function() {
            var table = $('#gpsTable').DataTable({
                dom: 'Bfrtip',
                buttons: []
            });

            table.buttons().container().appendTo('#gpsTable_wrapper .col-md-6:eq(0)');

            var messagePopup = document.getElementById('message-popup');
            if (messagePopup) {
                messagePopup.style.display = 'block';
                setTimeout(function() {
                    messagePopup.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>
