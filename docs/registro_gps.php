<?php
require 'db.php';
session_start();
include 'menu.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$edit = false;
$device = [
    'imei' => '',
    'modelo' => '',
    'marca' => '',
    'fecha_compra' => '',
    'estado' => '',
    'placa' => '',
    'numero_unidad' => '',
    'fecha_instalacion' => '',
    'estado_operativo' => '',
    'motivo_no_operativo' => ''
];

if (isset($_GET['id'])) {
    $edit = true;
    $query = "SELECT * FROM dispositivos_gps WHERE id = :id";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $_GET['id']]);
        $device = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: No se pudo ejecutar la consulta. ' . $e->getMessage();
        exit;
    }
}
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Dispositivos GPS</title>
    <!-- Importar Materialize CSS -->
    <link href="css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="fonts/material-icons.css" rel="stylesheet">
    <!-- Importar CSS de Materialize -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .hidden { display: none; }
        .form-group { margin-bottom: 15px; }
        .message-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1001;
            display: none;
        }
        
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
   
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Registro de Dispositivo GPS</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
    <div class="container">

    <h2>Registro de Dispositivo GPS</h2>

        <form id="gpsForm" action="registro.php" method="POST">
            <div class="form-group">
                <label for="imei">IMEI:</label>
                <input type="text" id="imei" name="imei" class="validate" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="validate" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="validate" required>
            </div>
            <div class="form-group">
                <label for="fechaCompra">Fecha de Compra:</label>
                <input type="date" id="fechaCompra" name="fechaCompra" class="validate" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado del Dispositivo:</label>
                <select id="estado" name="estado" class="browser-default" required>
                    <option value="almacenado">Almacenado</option>
                    <option value="instalado">Instalado</option>
                </select>
            </div>
            
            <div id="instaladoFields" class="hidden">
                <h3>Información Adicional:</h3>
                <div class="form-group">
                    <label for="placa">Placa:</label>
                    <input type="text" id="placa" name="placa" class="validate">
                </div>
                <div class="form-group">
                    <label for="numeroUnidad">Número de Unidad:</label>
                    <input type="text" id="numeroUnidad" name="numeroUnidad" class="validate">
                </div>
                <div class="form-group">
                    <label for="fechaInstalacion">Fecha de Instalación:</label>
                    <input type="date" id="fechaInstalacion" name="fechaInstalacion" class="validate">
                </div>
                <div class="form-group">
                    <label for="estadoOperativo">Estado Operativo:</label>
                    <select id="estadoOperativo" name="estadoOperativo" class="browser-default">
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div id="motivoNoOperativoField" class="form-group hidden">
                    <label for="motivoNoOperativo">Motivo No Operativo:</label>
                    <input type="text" id="motivoNoOperativo" name="motivoNoOperativo" class="validate" maxlength="2">
                </div>
            </div>

            <button type="submit" class="btn waves-effect waves-light">Registrar Dispositivo</button>
        </form>
        <div id="message" class="hidden"></div>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datepickerElems = document.querySelectorAll('.datepicker');
            M.Datepicker.init(datepickerElems, { format: 'yyyy-mm-dd' });

            document.getElementById('estado').addEventListener('change', function() {
                const instaladosFields = document.getElementById('instaladoFields');
                if (this.value === 'instalado') {
                    instaladosFields.classList.remove('hidden');
                } else {
                    instaladosFields.classList.add('hidden');
                }
            });

            document.getElementById('estadoOperativo').addEventListener('change', function() {
                const motivoNoOperativoField = document.getElementById('motivoNoOperativoField');
                if (this.value === 'no') {
                    motivoNoOperativoField.classList.remove('hidden');
                } else {
                    motivoNoOperativoField.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
