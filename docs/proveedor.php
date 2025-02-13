<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Proveedor</title>
    <!-- Importar CSS de Materialize -->
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
    include 'menu.php';
    session_start();
    if (isset($_SESSION['message'])) {
        echo "<div class='popup-message'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    ?>
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Registro Proveedor</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h3>Formulario de Proveedor</h3>
            <form action="insertar_proveedor.php" method="POST">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="nombre_contacto" name="nombre_contacto" type="text" required>
                        <label for="nombre_contacto">Nombre de Contacto</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="telefono" name="telefono" type="text" required>
                        <label for="telefono">Teléfono</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="empresa" name="empresa" type="text" required>
                        <label for="empresa">Empresa</label>
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
    <!-- Script para mostrar y ocultar el pop-up -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popup = document.querySelector('.popup-message');
            if (popup) {
                popup.style.display = 'block';
                setTimeout(function() {
                    popup.style.display = 'none';
                }, 5000); // 5 segundos
            }
        });
    </script>
</body>
</html>
