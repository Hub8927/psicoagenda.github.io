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
        <a href="citas_pendientes.php">Citas Pendientes</a>
        <a href="agendar_cita.php">Agendar Cita</a>
        <a href="historial.php">Historial</a>
    </div>

    <h1>Agenda de Citas</h1>

    <?php
    require_once('config/config.php');

    // Verificar si el usuario está autenticado
    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'psicologo') {
        header("Location: login.php");
        exit();
    }

    // Procesar la actualización de estatus
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cita_id']) && isset($_POST['nuevo_estatus'])) {
        $cita_id = $_POST['cita_id'];
        $nuevo_estatus = $_POST['nuevo_estatus'];

        // Si el estatus es 'confirmada', agregar la hora confirmada
        if ($nuevo_estatus == 'confirmada') {
            $hora_confirmada = date('Y-m-d H:i:s'); // Establecer la hora actual
        } else {
            $hora_confirmada = null; // Si no es confirmada, no asignamos hora
        }

        // Actualizar el estatus y la hora confirmada si corresponde
        $update_estatus_sql = "UPDATE citas SET estatus = ?, hora_confirmada = ? WHERE id = ?";
        $stmt_estatus = $conn->prepare($update_estatus_sql);
        $stmt_estatus->bind_param("ssi", $nuevo_estatus, $hora_confirmada, $cita_id);

        if ($stmt_estatus->execute()) {
            echo "<p>El estatus de la cita se ha actualizado correctamente.</p>";
        } else {
            echo "<p>Error al actualizar el estatus: " . $stmt_estatus->error . "</p>";
        }

        $stmt_estatus->close();
    }

    // Consultar las citas
    $psicologo_id = $_SESSION['id'];  // ID del psicólogo autenticado
    $select_citas_sql = "SELECT citas.id, usuarios.nombre, citas.fecha, citas.estatus, citas.hora 
                         FROM citas
                         JOIN usuarios ON citas.paciente_id = usuarios.id
                         WHERE citas.psicologo_id = ?";
    $stmt_citas = $conn->prepare($select_citas_sql);
    $stmt_citas->bind_param("i", $psicologo_id);
    $stmt_citas->execute();
    $result = $stmt_citas->get_result();

    if ($result->num_rows > 0) {
        echo "<table><thead><tr><th>Paciente</th><th>Fecha</th><th>Estatus</th><th>Hora Confirmada</th><th>Acciones</th></tr></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            $cita_id = $row['id'];
            $nombre_paciente = $row['nombre'];
            $fecha = $row['fecha'];
            $estatus = $row['estatus'];
            $hora = $row['hora'];

            echo "<tr>";
            echo "<td>" . htmlspecialchars($nombre_paciente) . "</td>";
            echo "<td>" . htmlspecialchars($fecha) . "</td>";
            echo "<td>" . htmlspecialchars($estatus) . "</td>";
            echo "<td>" . ($hora ? htmlspecialchars($hora) : 'No confirmada') . "</td>";
            echo "<td>
                    <form action='citas_pendientes.php' method='POST'>
                        <input type='hidden' name='cita_id' value='$cita_id'>
                        <select name='nuevo_estatus'>
                            <option value='pendiente' " . ($estatus == 'pendiente' ? 'selected' : '') . ">Pendiente</option>
                            <option value='confirmada' " . ($estatus == 'confirmada' ? 'selected' : '') . ">Confirmada</option>
                            <option value='cancelada' " . ($estatus == 'cancelada' ? 'selected' : '') . ">Cancelada</option>
                            <option value='completada' " . ($estatus == 'completada' ? 'selected' : '') . ">Completada</option>
                        </select>
                        <button type='submit'>Cambiar Estatus</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No hay citas disponibles.</p>";
    }

    $stmt_citas->close();
    $conn->close();
    ?>

</body>
</html>
