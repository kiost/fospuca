<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Consulta para obtener la cantidad de dispositivos registrados por mes
$queryDispositivos = "SELECT TO_CHAR(fecha_compra, 'YYYY-MM') as mes, COUNT(*) as total FROM dispositivos_gps GROUP BY mes";
$resultDispositivos = $pdo->query($queryDispositivos)->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener la cantidad de dispositivos en mantenimiento por mes
$queryMantenimiento = "SELECT TO_CHAR(fecha_creacion, 'YYYY-MM') as mes, COUNT(*) as total FROM mantenimientos GROUP BY mes";
$resultMantenimiento = $pdo->query($queryMantenimiento)->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener la cantidad de dispositivos con fallas por mes
$queryFallas = "SELECT TO_CHAR(fecha_reporte, 'YYYY-MM') as mes, COUNT(*) as total FROM fallas GROUP BY mes";
$resultFallas = $pdo->query($queryFallas)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <!-- Importar Bootstrap CSS desde CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Importar Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .chart-container {
            width: 100%;
            height: 400px;
            margin-bottom: 50px;
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
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">Dashboard</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <h4>Bienvenido</h4>

            <!-- Gráficos -->
            <div class="chart-container">
                <h5>Dispositivos Registrados por Mes</h5>
                <canvas id="chartDispositivosRegistrados"></canvas>
            </div>

            <div class="chart-container">
                <h5>Dispositivos en Mantenimiento por Mes</h5>
                <canvas id="chartMantenimiento"></canvas>
            </div>

            <div class="chart-container">
                <h5>Dispositivos con Fallas por Mes</h5>
                <canvas id="chartFallas"></canvas>
            </div>
        </div>
    </div>

    <!-- Importar jQuery desde CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Importar Bootstrap JS desde CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Script para inicializar los gráficos -->
    <script>
        $(document).ready(function() {
            // Preparar datos para el gráfico de líneas de dispositivos registrados
            var labelsDispositivos = [];
            var dataDispositivos = [];
            <?php foreach ($resultDispositivos as $row) { ?>
                labelsDispositivos.push('<?php echo $row['mes']; ?>');
                dataDispositivos.push(<?php echo $row['total']; ?>);
            <?php } ?>

            // Gráfico de líneas para dispositivos registrados
            var ctxDispositivosRegistrados = document.getElementById('chartDispositivosRegistrados').getContext('2d');
            var chartDispositivosRegistrados = new Chart(ctxDispositivosRegistrados, {
                type: 'line',
                data: {
                    labels: labelsDispositivos,
                    datasets: [{
                        label: 'Dispositivos Registrados',
                        data: dataDispositivos,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Dispositivos Registrados por Mes'
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Cantidad'
                            }
                        }
                    }
                }
            });

            // Preparar datos para el gráfico de líneas de dispositivos en mantenimiento
            var labelsMantenimiento = [];
            var dataMantenimiento = [];
            <?php foreach ($resultMantenimiento as $row) { ?>
                labelsMantenimiento.push('<?php echo $row['mes']; ?>');
                dataMantenimiento.push(<?php echo $row['total']; ?>);
            <?php } ?>

            // Gráfico de líneas para dispositivos en mantenimiento
            var ctxMantenimiento = document.getElementById('chartMantenimiento').getContext('2d');
            var chartMantenimiento = new Chart(ctxMantenimiento, {
                type: 'line',
                data: {
                    labels: labelsMantenimiento,
                    datasets: [{
                        label: 'Dispositivos en Mantenimiento',
                        data: dataMantenimiento,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Dispositivos en Mantenimiento por Mes'
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Cantidad'
                            }
                        }
                    }
                }
            });

            // Preparar datos para el gráfico de líneas de dispositivos con fallas
            var labelsFallas = [];
            var dataFallas = [];
            <?php foreach ($resultFallas as $row) { ?>
                labelsFallas.push('<?php echo $row['mes']; ?>');
                dataFallas.push(<?php echo $row['total']; ?>);
            <?php } ?>

            // Gráfico de líneas para dispositivos con fallas
            var ctxFallas = document.getElementById('chartFallas').getContext('2d');
            var chartFallas = new Chart(ctxFallas, {
                type: 'line',
                data: {
                    labels: labelsFallas,
                    datasets: [{
                        label: 'Dispositivos con Fallas',
                        data: dataFallas,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Dispositivos con Fallas por Mes'
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Cantidad'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
