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

