<?php
session_start();

$host = '127.0.0.1';
$db = 'FOSPUCA';
$user = 'postgres';
$pass = 'Zuleta99@';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono'];
    $empresa = $_POST['empresa'];

    // Insertar los datos en la tabla proveedores
    $sql = "INSERT INTO proveedores (nombre_contacto, telefono, empresa) VALUES (:nombre_contacto, :telefono, :empresa)";
    $stmt = $pdo->prepare($sql);
    
    // Asignar los valores a los parámetros
    $stmt->bindParam(':nombre_contacto', $nombre_contacto);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':empresa', $empresa);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Proveedor insertado exitosamente.";
    } else {
        $_SESSION['message'] = "Error al insertar el proveedor.";
    }

} catch (PDOException $e) {
    $_SESSION['message'] = 'Conexión fallida: ' . $e->getMessage();
}

header('Location: proveedor.php');
exit();
?>
