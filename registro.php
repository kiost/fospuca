<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imei = $_POST['imei'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $fecha_compra = $_POST['fechaCompra'];
    $estado = $_POST['estado'];
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $numero_unidad = isset($_POST['numeroUnidad']) ? $_POST['numeroUnidad'] : null;
    $fecha_instalacion = isset($_POST['fechaInstalacion']) ? $_POST['fechaInstalacion'] : null;
    $estado_operativo = isset($_POST['estadoOperativo']) ? $_POST['estadoOperativo'] : null;
    $motivo_no_operativo = isset($_POST['motivoNoOperativo']) ? $_POST['motivoNoOperativo'] : null;

    $sql = "INSERT INTO dispositivos_gps (imei, modelo, marca, fecha_compra, estado, placa, numero_unidad, fecha_instalacion, estado_operativo, motivo_no_operativo)
            VALUES (:imei, :modelo, :marca, :fecha_compra, :estado, :placa, :numero_unidad, :fecha_instalacion, :estado_operativo, :motivo_no_operativo)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':imei', $imei);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':fecha_compra', $fecha_compra);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':numero_unidad', $numero_unidad);
    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
    $stmt->bindParam(':estado_operativo', $estado_operativo);
    $stmt->bindParam(':motivo_no_operativo', $motivo_no_operativo);

    if ($stmt->execute()) {
        echo "<script>alert('Dispositivo registrado con éxito'); window.location.href = 'registro_gps.html';</script>";
    } else {
        echo "<script>alert('Error al registrar el dispositivo');</script>";
    }
}
?>
