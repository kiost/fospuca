<!DOCTYPE html>
<html>
<head>
    <title>Consultar Requisiciones GPS</title>
    <link rel="stylesheet" href="css/materialize.min.css">
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
<?php include 'menu.php'; ?>
    <div class="main-content">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Consultar Requisiciones</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
<div class="container">
    <h1>Consultar Requisiciones GPS</h1>

    <table>
        <thead>
            <tr>
                <th>Marca GPS</th>
                <th>IMEI GPS</th>
                <th>Sede Origen</th>
                <th>Sede Destino</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('db.php');
            $stmt = $pdo->query('SELECT * FROM requisiciones');
            $requisiciones = $stmt->fetchAll();

            foreach ($requisiciones as $requisicion) : ?>
                <tr>
                    <form action="consultar_requisiciones.php" method="POST">
                        <td>
                            <input type="text" name="marcaGPS" value="<?= $requisicion['marcagps'] ?>">
                        </td>
                        <td>
                            <input type="text" name="imeiGPS" value="<?= $requisicion['imeigps'] ?>">
                        </td>
                        <td>
                            <input type="text" name="sedeOrigen" value="<?= $requisicion['sedeorigen'] ?>">
                        </td>
                        <td>
                            <input type="text" name="sedeDestino" value="<?= $requisicion['sededestino'] ?>">
                        </td>
                        <td>
                            <input type="text" class="datepicker" name="fechaCreacion" value="<?= $requisicion['fechacreacion'] ?>">
                        </td>
                        <td>
                            <input type="hidden" name="id" value="<?= $requisicion['id'] ?>">
                            <button type="submit" name="update" class="btn">Guardar</button>
                            <button type="submit" name="delete" class="btn">Eliminar</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="card-panel <?= $_SESSION['mensaje_tipo']; ?>">
            <?= $_SESSION['mensaje']; ?>
            <?php unset($_SESSION['mensaje']); unset($_SESSION['mensaje_tipo']); ?>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, { format: 'yyyy-mm-dd' });
    });
</script>
</body>
</html>
