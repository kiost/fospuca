<?php
session_start();
require 'db.php';

$fecha_reporte = $_POST['fecha_reporte'];
$imei = $_POST['imei'];
$empresa_mantenimiento = $_POST['empresa_mantenimiento'];
$usuario_reporte = $_SESSION['user_name'];
$tipo_falla = $_POST['tipo_falla'];
$empresa_encargada = $_POST['empresa_encargada'];

$query = "INSERT INTO fallas (fecha_reporte, imei, empresa_mantenimiento, usuario_reporte, tipo_falla, empresa_encargada) VALUES (:fecha_reporte, :imei, :empresa_mantenimiento, :usuario_reporte, :tipo_falla, :empresa_encargada)";
$stmt = $pdo->prepare($query);

$stmt->bindParam(':fecha_reporte', $fecha_reporte);
$stmt->bindParam(':imei', $imei);
$stmt->bindParam(':empresa_mantenimiento', $empresa_mantenimiento);
$stmt->bindParam(':usuario_reporte', $usuario_reporte);
$stmt->bindParam(':tipo_falla', $tipo_falla);
$stmt->bindParam(':empresa_encargada', $empresa_encargada);

if ($stmt->execute()) {
    $_SESSION['message'] = "Falla reportada exitosamente.";
} else {
    $_SESSION['message'] = "Error al reportar la falla.";
}

header('Location: reporte_fallas.php');
exit();
?>
