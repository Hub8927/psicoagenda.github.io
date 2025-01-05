<?php
require_once('config/config.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener email y contraseña del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];


    // Verificar si el email existe
    $sql = "SELECT id, nombre, password, tipo FROM usuarios WHERE usuario = ? AND tipo = 'psicologo'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario); // Enlazar el email al parámetro SQL
    $stmt->execute();
    $result = $stmt->get_result();

    }
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Comparar la contraseña ingresada con el hash en la base de datos
        if ($password === $user['password']) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['tipo'] = $user['tipo'];
            // Redirigir al panel de psicólogo o a la página principal
            header("Location: citas_pendientes.php");
        } else {
            header("Location: /psicoagenda2/index.php? error=usuario invalido");
        }
    } else {
        header("Location: /psicoagenda2/index.php? error=Contraseña incorrecta");
    }

    $stmt->close();
    $conn->close();

?>
