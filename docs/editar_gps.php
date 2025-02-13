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
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
                        echo "<td><button class='btn modificar-btn' data-id='" . $row['id'] . "'>Modificar</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="dashboard.php" class="btn">Ir al Dashboard</a>
        </div>
    </div>

    <!-- Modal para editar dispositivo -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>Editar Dispositivo GPS</h4>
            <form id="editForm" action="editar_gps.php" method="POST">
                <input type="hidden" id="editId" name="id">
                <div class="form-group">
                    <label for="editImei">IMEI:</label>
                    <input type="text" id="editImei" name="imei" class="validate" required>
                </div>
                <div class="form-group">
                    <label for="editModelo">Modelo:</label>
                    <input type="text" id="editModelo" name="modelo" class="validate" required>
                </div>
                <div class="form-group">
                    <label for="editEstado">Estado del Dispositivo:</label>
                    <select id="editEstado" name="estado" class="browser-default" required>
                        <option value="almacenado">Almacenado</option>
                        <option value="instalado">Instalado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editEstadoOperativo">Estado Operativo:</label>
                    <select id="editEstadoOperativo" name="estado_operativo" class="browser-default" required>
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editFechaCompra">Fecha de Compra:</label>
                    <input type="date" id="editFechaCompra" name="fecha_compra" class="validate" required>
                </div>
                <button type="submit" class="btn waves-effect waves-light">Guardar Edición</button>
            </form>
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
    <!-- Script para manejar el[_{{{CITATION{{{_1{](https://github.com/sahandMg/charesh/tree/e86062374a342e19c618390be955bad788f61246/resources%2Fviews%2FmatchReg%2FmatchReg.blade.php)[_{{{CITATION{{{_2{](https://github.com/Ambytripathi/amby/tree/c628cae00691835860aa0a35a6f5750058a8bf2b/fuel%2Fapplication%2Fcache%2Fdwoo%2Fcompiled%2F25ee5b8a57263af2904d8671d7703303.d17.php)[_{{{CITATION{{{_3{](https://github.com/ileeds/nba_detector/tree/01b45528890d20f81617d5f2277882b2196b98ee/script.js)[_{{{CITATION{{{_4{](https://github.com/bapspatil/ExamMate/tree/2206cf65d1885a4d1134e4225aa991de518465f2/homepage.php)[_{{{CITATION{{{_5{](https://github.com/hainguyenvan6799/Sales/tree/7ce7ac2f7e1221bfe49b90c9483ead8990278586/resources%2Fviews%2Ftests%2Fmodal.blade.php)[_{{{CITATION{{{_6{](https://github.com/kanghanan/imkc/tree/ff4b198ee4bcaceba7e8383507e0ad08c098bbaf/application%2Fviews%2Fheader.php)[_{{{CITATION{{{_7{](https://github.com/tonycops/lalala/tree/f4221a6d39de4464e868bede644c2d31f4343c86/application%2Fviews%2Fhalaman%2Fadmin-product.php)[_{{{CITATION{{{_8{](https://github.com/insoftloja/competenciasdigitales/tree/42d26e4ddd617dc85b43e7f3d700132b46444ff8/RespaldoImgenesTabla.php)[_{{{CITATION{{{_9{](https://github.com/KIMOBILL/mvp/tree/c8def3aa5797ac8930faa0065b81f727dbdd7cb5/REUSAR%2Fmvpsystem%2Flayout%2Ffooter.php)[_{{{CITATION{{{_10{](https://github.com/dadiwoke/gayabaru/tree/83473ae6f6c2d5d1e0aa64b54724547fa76c4f81/resources%2Fviews%2Flayouts%2FBackend%2Fcustomers%2FcustomerPaidAdv.blade.php)[_{{{CITATION{{{_11{](https://github.com/mahendra1313/mahendra1313/tree/b7707ab42041aec2c6b3d8a628963f3b56397b1d/admin_site%2Ffeedback.php)[_{{{CITATION{{{_12{](https://github.com/dxnydlc/fondo-e-atk/tree/a43444dedcdec2323d75732f6a155286e79d5651/resources%2Fviews%2Fnoticias%2FhomeNoti.blade.php)[_{{{CITATION{{{_13{](https://github.com/wickywaqasbutt/E-Quran/tree/339828ec6d13488db0645301c1dcefb8f12961e1/resources%2Fviews%2Fprofile%2Fadmin%2Fadmin-teacher1.blade.php)[_{{{CITATION{{{_14{](https://github.com/BanderoChinoZF/Gestion_Talleristas/tree/a1620526f2bee4707aa4e3b28d04f38213415e99/resources%2Fviews%2FMaestro%2Fhome.blade.php)