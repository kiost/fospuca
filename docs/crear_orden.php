<!DOCTYPE html>
<html>
<head>
    <title>Orden de Mantenimiento de Dispositivo GPS</title>
    <!-- Importar CSS de Materialize -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Estilos Personalizados -->
    <style>
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
        /* Estilo del pop-up */
        .popup-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #4caf50;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['message'])) {
        echo "<div class='card-panel green lighten-4 green-text text-darken-4 message-popup' id='message-popup'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    if (!isset($_SESSION['user_name'])) {
        header('Location: login.php');
        exit;
    }
    include 'menu.php';
    ?>
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Crear orden de Mantenimiento</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h3>Orden de Mantenimiento de Dispositivo GPS</h3>
            <form action="insertar_mantenimiento.php" method="POST">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="imei" name="imei" type="text" required>
                        <label for="imei">IMEI del Dispositivo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="empresa" name="empresa" type="text" required>
                        <label for="empresa">Empresa que Realiza el Mantenimiento</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="fecha_creacion" name="fecha_creacion" type="text" class="datepicker" required>
                        <label for="fecha_creacion">Fecha de Creación de la Orden</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="fecha_entrega" name="fecha_entrega" type="text" class="datepicker" required>
                        <label for="fecha_entrega">Fecha de Entrega del Dispositivo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="descripcion" name="descripcion" class="materialize-textarea" required></textarea>
                        <label for="descripcion">Descripción del Mantenimiento</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="user_name" name="user_name" type="text" value="<?php echo $_SESSION['user_name']; ?>" readonly>
                        <label for="user_name">Nombre del Usuario</label>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Guardar
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>

    <!-- Importar JavaScript de Materialize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.datepicker');
            var instances = M.Datepicker.init(elems, {
                format: 'yyyy-mm-dd'
            });
            
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

<?php
// insertar_mantenimiento.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imei = $_POST['imei'];
    $empresa = $_POST['empresa'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $descripcion = $_POST['descripcion'];
    $user_name = $_POST['user_name'];

    $stmt = $pdo->prepare('INSERT INTO mantenimientos (imei, empresa, fecha_creacion, fecha_entrega, descripcion, user_name) VALUES (:imei, :empresa, :fecha_creacion, :fecha_entrega, :descripcion, :user_name)');
    $stmt->execute(['imei' => $imei, 'empresa' => $empresa, 'fecha_creacion' => $fecha_creacion, 'fecha_entrega' => $fecha_entrega, 'descripcion' => $descripcion, 'user_name' => $user_name]);

    $_SESSION['message'] = 'Orden de mantenimiento creada con éxito.';
    header('Location: crear_orden_mantenimiento.php');
}
?>
