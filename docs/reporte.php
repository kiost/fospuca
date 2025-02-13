<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
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
            text-align: center;
        }
        .btn-table {
            margin: 10px;
        }
        .table-icon {
            vertical-align: middle;
            margin-right: 5px;
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
    <div class="btn-table">
        <a href="descargar_pdf2.php?tabla=usuarios" class="btn">
            <i class="material-icons table-icon">person</i> Usuarios
        </a>
    </div>
    <div class="btn-table">
        <a href="descargar_pdf2.php?tabla=requisiciones" class="btn">
            <i class="material-icons table-icon">assignment</i> Requisiciones
        </a>
    </div>
    <div class="btn-table">
        <a href="descargar_pdf2.php?tabla=dispositivos_gps" class="btn">
            <i class="material-icons table-icon">devices</i> Dispositivos
        </a>
    </div>
    <div class="btn-table">
        <a href="descargar_pdf3.php?tabla=mantenimientos" class="btn">
            <i class="material-icons table-icon">build</i> Mantenimientos
        </a>
    </div>
    
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
