
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .status-pendiente {
            color: orange;
        }
        .status-exitoso {
            color: green;
        }
        .button-container {
            margin-bottom: 20px;
            border: 2px solid blue;
            padding: 10px;
            display: flex;
            gap: 10px;
        }
        .button-container a {
            text-decoration: none;
            padding: 10px 20px;
            color: white;
            background-color: blue;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="citas_pendientes.php">citas pendientes</a>
        <a href="agendar_cita.php">agendar cita</a>
        <a href="historial.php">historial</a>
    </div>
<html lang="es">
<?php
require_once('config/config.php');

// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'psicologo') {
    header("Location: login.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Crear el valor de fecha y hora completo
    $fecha_hora = $fecha . ' ' . $hora;

    // Obtener los nombres y apellidos del paciente
    $nombre_parts = explode(' ', $nombre_completo);
    $nombre = $nombre_parts[0];  // Primer nombre
    $apellido_paterno = isset($nombre_parts[1]) ? $nombre_parts[1] : ''; // Apellido Paterno
    $apellido_materno = isset($nombre_parts[2]) ? $nombre_parts[2] : ''; // Apellido Materno

    // Insertar el paciente como usuario en la tabla usuarios
    $insert_usuario_sql = "INSERT INTO usuarios (nombre, usuario, password, tipo) VALUES (?, ?, ?, ?)";
    $usuario = strtolower($nombre . '.' . $apellido_paterno); // Crear un nombre de usuario (puedes adaptarlo)
    $password = password_hash('default_password', PASSWORD_DEFAULT); // Establecer una contraseña predeterminada
    $tipo = 'paciente';  // Establecer el tipo de usuario como paciente
    $stmt_usuario = $conn->prepare($insert_usuario_sql);
    $stmt_usuario->bind_param("ssss", $nombre_completo, $usuario, $password, $tipo);
    $stmt_usuario->execute();
    $usuario_id = $stmt_usuario->insert_id; // Obtener el ID del usuario recién insertado
    $stmt_usuario->close();

    // Ahora insertamos al paciente en la tabla pacientes
    $insert_paciente_sql = "INSERT INTO pacientes (id, nombre, apellido_paterno, apellido_materno) VALUES (?, ?, ?, ?)";
    $stmt_paciente = $conn->prepare($insert_paciente_sql);
    $stmt_paciente->bind_param("isss", $usuario_id, $nombre, $apellido_paterno, $apellido_materno);
    $stmt_paciente->execute();
    $stmt_paciente->close();

    // Insertar la cita en la base de datos
    $psicologo_id = $_SESSION['id'];  // ID del psicólogo que está autenticado
    $estatus = 'pendiente';

    $insert_cita_sql = "INSERT INTO citas (psicologo_id, paciente_id, fecha, estatus) VALUES (?, ?, ?, ?)";
    $stmt_cita = $conn->prepare($insert_cita_sql);
    $stmt_cita->bind_param("iiss", $psicologo_id, $usuario_id, $fecha_hora, $estatus);
    
    if ($stmt_cita->execute()) {
        echo "<p>Cita agendada con éxito.</p>";
    } else {
        echo "<p>Error al agendar la cita: " . $stmt_cita->error . "</p>";
    }
    $stmt_cita->close();
    $conn->close();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            padding: 8px;
            margin: 5px 0;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Agendar Cita</h1>

    <form action="agendar_cita.php" method="POST">
        <label for="nombre_completo">Nombre Completo del Paciente:</label>
        <input type="text" name="nombre_completo" placeholder="Ej. Juan Pérez García" required>
        <br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>
        <br>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" required>
        <br>

        <button type="submit">Agendar Cita</button>
    </form>

</body>
</html>


