<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST['placa'];
    $numero_unidad = $_POST['numero_unidad'];
    $fecha_instalacion = $_POST['fecha_instalacion'];
    $gps_operativo = $_POST['gps_operativo'];
    $id_gps = $_POST['id_gps'];

    $sql = "UPDATE dispositivos_gps SET placa = :placa, numero_unidad = :numero_unidad, fecha_instalacion = :fecha_instalacion, gps_operativo = :gps_operativo WHERE id = :id_gps";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':numero_unidad', $numero_unidad);
    $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
    $stmt->bindParam(':gps_operativo', $gps_operativo);
    $stmt->bindParam(':id_gps', $id_gps);

    if ($stmt->execute()) {
        echo "<script>
                alert('Información de instalación registrada con éxito');
                window.location.href = 'registro_gps.php';
              </script>";
    } else {
        echo "Error al registrar la información de instalación";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Registro de Instalación GPS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Registrar Instalación GPS</h2>
        <form action="registro_instalacion.php" method="POST">
            <input type="hidden" name="id_gps" id="id_gps" value="<?php echo $_GET['id_gps']; ?>" required>
            <div class="input-field">
                <input type="text" name="placa" id="placa" required>
                <label for="placa">Placa</label>
            </div>
            <div class="input-field">
                <input type="text" name="numero_unidad" id="numero_unidad" required>
                <label for="numero_unidad">Número de Unidad</label>
            </div>
            <div class="input-field">
                <input type="text" class="datepicker" name="fecha_instalacion" id="fecha_instalacion" required>
                <label for="fecha_instalacion">Fecha de Instalación</label>
            </div>
            <div class="input-field">
                <select name="gps_operativo" id="gps_operativo">
                    <option value="si">Sí</option>
                    <option value="no">No</option>
                </select>
                <label for="gps_operativo">¿GPS Operativo?</label>
            </div>
            <button type="submit" class="btn">Guardar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.datepicker');
            var instances = M.Datepicker.init(elems, {
                format: 'yyyy-mm-dd'
            });
            var selectElems = document.querySelectorAll('select');
            var selectInstances = M.FormSelect.init(selectElems);
        });
    </script>
</body>
</html>
