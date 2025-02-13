<?php
require 'db.php';

$imei = $_GET['imei'];

$sql = "SELECT imei, marca, modelo, estado_operativo FROM dispositivos_gps WHERE imei = :imei";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':imei', $imei);
$stmt->execute();
$dispositivo = $stmt->fetch(PDO::FETCH_ASSOC);

$response = [];

if ($dispositivo) {
    $response['encontrado'] = true;
    $response['marca'] = $dispositivo['marca'];
    $response['modelo'] = $dispositivo['modelo'];
    $response['estado_operativo'] = $dispositivo['estado_operativo'];
} else {
    $response['encontrado'] = false;
}

echo json_encode($response);
?>
