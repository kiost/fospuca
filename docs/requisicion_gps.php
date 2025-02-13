
<!DOCTYPE html>
<html>
<head>
    <title>Crear Requisición GPS</title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <!-- Importar Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Estilos Personalizados -->
    
    <meta charset="utf-8" />
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
<?php include 'menu.php'; session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
} ?>
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Crear Requisición</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
<div class="container">
    <h1>Crear Requisición GPS</h1>

    <form action="requisicion_gps.php" method="POST">
        <div class="input-field">
            <input type="text" name="marcaGPS" required>
            <label for="marcaGPS">Marca del GPS</label>
        </div>
        <div class="input-field">
            <input type="text" name="imeiGPS" required>
            <label for="imeiGPS">IMEI del GPS</label>
        </div>
        <div class="input-field">
            <input type="text" name="sedeOrigen" required>
            <label for="sedeOrigen">Sede Origen</label>
        </div>
        <div class="input-field">
            <input type="text" name="sedeDestino" required>
            <label for="sedeDestino">Sede Destino</label>
        </div>
        <div class="input-field">
            <input type="text" class="datepicker" id="fechaCreacion" name="fechaCreacion" required>
            <label for="fechaCreacion">Fecha de Creación</label>
        </div>
        <button type="submit" name="create" class="btn">Guardar</button>
    </form>

    <a href="consultar_requisiciones.php" class="btn">Consultar Requisiciones</a>
</div>

<!-- Importar jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Importar Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
            var dateElems = document.querySelectorAll('.datepicker');
            var dateInstances = M.Datepicker.init(dateElems, {
                format: 'yyyy-mm-dd'
            });
        });
    </script>
</body>
</html>
