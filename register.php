<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Registro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <a href="#" class="brand-logo">Crear Usuario</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </nav>
<div class="container">
  <div class="container">
    <div class="row">
      <form class="col s12" action="register.php" method="post" onsubmit="return validateForm()">
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="nombre" name='nombre' type="text" class="validate" required>
            <label for="nombre">Nombre y Apellido</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">email</i>
            <input id="email" name="email" type="email" class="validate" placeholder="usuario@fospuca.com" required>
            <label for="email">Correo Electrónico</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">lock</i>
            <input id="password" name="password" type="password" class="validate" required minlength="8">
            <label for="password">Contraseña</label>
          </div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">Registrarse
          <i class="material-icons right">send</i>
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    M.AutoInit();

    function validateForm() {
      const password = document.getElementById('password').value;
      const pattern = /^(?=.*[A-Z])(?=.*[!@#$&*])/;

      if (!pattern.test(password)) {
        alert('La contraseña debe incluir al menos una letra mayúscula y un carácter especial.');
        return false;
      }
      return true;
    }
  </script>
</body>
</html>

<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validación del lado del servidor
    if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$&*])/', $password)) {
        echo 'La contraseña debe incluir al menos una letra mayúscula y un carácter especial.';
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)');
    $stmt->execute(['nombre' => $nombre, 'email' => $email, 'password' => $password]);

    echo 'Registro exitoso. Ahora puedes <a href="login.php">iniciar sesión</a>.';
}
?>
