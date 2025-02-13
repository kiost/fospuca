<?php
// insertar_mantenimiento.php
require 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imei = $_POST['imei'];
    $empresa = $_POST['empresa'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $descripcion = $_POST['descripcion'];
    $user_name = $_POST['user_name'];

    // Depuración: Mostrar valores recibidos
    echo "IMEI: $imei<br>";
    echo "Empresa: $empresa<br>";
    echo "Fecha de Creación: $fecha_creacion<br>";
    echo "Fecha de Entrega: $fecha_entrega<br>";
    echo "Descripción: $descripcion<br>";
    echo "Nombre de Usuario: $user_name<br>";

    $stmt = $pdo->prepare('INSERT INTO mantenimientos (imei, empresa, fecha_creacion, fecha_entrega, descripcion, user_name) VALUES (:imei, :empresa, :fecha_creacion, :fecha_entrega, :descripcion, :user_name)');
    $stmt->execute([
        'imei' => $imei,
        'empresa' => $empresa,
        'fecha_creacion' => $fecha_creacion,
        'fecha_entrega' => $fecha_entrega,
        'descripcion' => $descripcion,
        'user_name' => $user_name
    ]);

    $_SESSION['message'] = 'Orden de mantenimiento creada con éxito.';
    header('Location: crear_orden.php');
    exit;
}
