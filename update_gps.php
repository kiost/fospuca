<?php
require 'db.php';

$id = $_POST['id'];
$modelo = $_POST['modelo'];
$imei = $_POST['imei'];
$condicion = $_POST['condicion'];
$estado_gps = $_POST['estado_gps'];

$query = "UPDATE dispositivos_gps SET modelo = :modelo, imei = :imei, condicion = :condicion, estado_gps = :estado_gps WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':modelo', $modelo);
$stmt->bindParam(':imei', $imei);
$stmt->bindParam(':condicion', $condicion);
$stmt->bindParam(':estado_gps', $estado_gps);

if ($stmt->execute()) {
    echo "Datos actualizados exitosamente.";
} else {
    echo "Error al actualizar los datos.";
}
?>
