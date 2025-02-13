<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Fallas</title>
    <!-- Importar Materialize CSS -->
    <link href="css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
   
        .hidden { display: none; }
    </style>
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
                <a href="#" class="brand-logo">Registro de Falla</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
</head>
<body>
    <div class="container">
        <h1>Registro de Fallas</h1>
        <form id="failForm" action="procesar_falla.php" method="POST">
            <div class="input-field">
                <input type="text" id="imei" name="imei" class="validate" required>
                <label for="imei">IMEI:</label>
            </div>
            <button type="button" class="btn waves-effect waves-light" onclick="consultarDispositivo()">Consultar</button>
            
            <div id="resultados" class="hidden">
                <div class="input-field">
                    <input type="text" id="marca" name="marca" class="validate" readonly>
                    <label for="marca">Marca:</label>
                </div>
                <div class="input-field">
                    <input type="text" id="modelo" name="modelo" class="validate" readonly>
                    <label for="modelo">Modelo:</label>
                </div>
                <div class="input-field">
                    <input type="text" class="datepicker" id="fecha_reporte" name="fecha_reporte" required>
                    <label for="fecha_reporte">Fecha de Reporte:</label>
                </div>
                <div class="input-field">
                    <input type="text" id="usuario" name="usuario" class="validate" value="<?php echo $_SESSION['user_name']; ?>" readonly>
                    <label for="usuario">Usuario:</label>
                </div>
                <div class="input-field">
                    <textarea id="descripcion" name="descripcion" class="materialize-textarea" required></textarea>
                    <label for="descripcion">Descripción de la Falla:</label>
                </div>
                <button type="submit" class="btn waves-effect waves-light">Registrar Falla</button>
            </div>
            <div id="mensaje"></div>
        </form>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.Datepicker.init(document.querySelectorAll('.datepicker'), { format: 'yyyy-mm-dd' });
            M.textareaAutoResize(document.querySelectorAll('textarea'));
        });

        function consultarDispositivo() {
            const imei = document.getElementById('imei').value;

            fetch('consultar_dispositivo.php?imei=' + imei)
                .then(response => response.json())
                .then(data => {
                    if (data.encontrado) {
                        if (data.estado_operativo === 'no') {
                            document.getElementById('marca').value = data.marca;
                            document.getElementById('modelo').value = data.modelo;
                            document.getElementById('resultados').classList.remove('hidden');
                            M.updateTextFields();
                        } else {
                            document.getElementById('mensaje').innerHTML = '<p>No hay dispositivos para reportar fallas.</p>';
                        }
                    } else {
                        document.getElementById('mensaje').innerHTML = '<p>Dispositivo no encontrado.</p>';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
