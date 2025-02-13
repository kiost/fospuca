<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
include 'menu.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $condicion = $_POST['condicion'];
    $imei = $_POST['imei'];
    $estado_gps = $_POST['estado_gps'];
    $fecha_compra = $_POST['fecha_compra'];
    $ubi_gps = $_POST['ubi_gps'];

    $sql = "INSERT INTO dispositivos_gps (nombre, marca, modelo, condicion, imei, estado_gps, fecha_compra, ubi_gps)
            VALUES (:nombre, :marca, :modelo, :condicion, :imei, :estado_gps, :fecha_compra, :ubi_gps)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':condicion', $condicion);
    $stmt->bindParam(':imei', $imei);
    $stmt->bindParam(':estado_gps', $estado_gps);
    $stmt->bindParam(':fecha_compra', $fecha_compra);
    $stmt->bindParam(':ubi_gps', $ubi_gps);

    if ($stmt->execute()) {
        $id_gps = $pdo->lastInsertId();
        if ($estado_gps == 'instalado') {
            header("Location: registro_instalacion.php?id_gps=$id_gps");
            exit;
        } else {
            echo "Dispositivo registrado con éxito";
        }
    } else {
        echo "Error al registrar el dispositivo";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Registro de Dispositivos GPS</title>
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
                <a href="#" class="brand-logo">Registro de Dispositivo GPS</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h2>Registrar Dispositivo GPS</h2>
            <form id="form" action="registro_gps.php" method="POST">
                <div class="input-field">
                    <input type="text" name="nombre" id="nombre" required>
                    <label for="nombre">Nombre del Dispositivo</label>
                </div>
                <div class="input-field">
                    <input type="text" name="marca" id="marca" required>
                    <label for="marca">Marca del Dispositivo GPS</label>
                </div>
                <div class="input-field">
                    <input type="text" name="modelo" id="modelo" required>
                    <label for="modelo">Modelo del Dispositivo GPS</label>
                </div>
                <div class="input-field">
                    <select name="condicion" id="condicion">
                        <option value="nuevo">Nuevo</option>
                        <option value="usado">Usado</option>
                    </select>
    