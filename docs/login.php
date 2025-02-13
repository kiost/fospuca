<?php
require 'db.php';
session_start();

// Inicializar la variable de mensaje de error
$error_message = '';

// Asegurarse de que el formulario haya sido enviado y los valores existan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar las credenciales
    $query = "SELECT id, nombre, password FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($password == $user['password']) {
            // Si la autenticación es exitosa, almacenar el ID y el nombre del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = 'Contraseña incorrecta.';
        }
    } else {
        $error_message = 'No se encontró un usuario con ese correo electrónico.';
    }
}

echo <<<EOT
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!-- Importar CSS de Materialize -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Importar Iconos de Materialize -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="center">Inicio de Sesión</h3>
    <div class="row">
        <form class="col s12" action="login.php" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" class="validate" required>
                    <label for="email">Correo Electrónico</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate" required>
                    <label for="password">Contraseña</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Iniciar Sesión
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a href="register.php">Registrarse</a>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col s12 center">
                <p style="color: red;">$error_message</p>
            </div>
        </div>
    </div>
</div>
<!-- Importar JavaScript de Materialize -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
EOT;
?>
