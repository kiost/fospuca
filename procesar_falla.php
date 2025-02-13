<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imei = $_POST['imei'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $fecha_reporte = $_POST['fecha_reporte'];
    $usuario = $_POST['usuario'];
    $descripcion = $_POST['descripcion'];

    // Verificar si el IMEI ya existe en la tabla
    $sql_check = "SELECT COUNT(*) FROM fallas WHERE imei = :imei";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':imei', $imei);
    $stmt_check->execute();
    $imei_exists = $stmt_check->fetchColumn();

    if ($imei_exists) {
        echo "<script>alert('El IMEI ya está reportado.'); window.location.href = 'reporte_fallas.php';</script>";
        exit;
    }

    $sql = "INSERT INTO fallas (imei, marca, modelo, fecha_reporte, usuario, descripcion)
            VALUES (:imei, :marca, :modelo, :fecha_reporte, :usuario, :descripcion)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':imei', $imei);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':fecha_reporte', $fecha_reporte);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':descripcion', $descripcion);

    if ($stmt->execute()) {
        echo "<script>alert('Falla registrada con éxito'); window.location.href = 'reporte_fallas.php';</script>";
    } else {
        echo "<script>alert('Error al registrar la falla');</script>";
    }
}
?>
