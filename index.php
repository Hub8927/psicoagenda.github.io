<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psicoagenda</title>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .content {
            padding: 20px;
            background-color: #fff;
        }
        .margin-top {
            background-color: rgb(168, 7, 231);
            padding: 80px 0 0 0; /* Incrementa el borde superior y quita el borde inferior */
            display: flex;
            align-items: flex-start; /* Cambia el texto a la parte superior */
            justify-content: center;
        }
        .margin-top{
            background-color: rgb(168, 7, 231);
            padding: 80;
        }

        h1 {
            color: rgb(7, 105, 105);
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="margin-top"></div>
        <div class="content">
            <h1>Bienvenida Psicologa</h1>
        </div>
    </div>
    <div class="background"></div>

    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK9pIsCYx9Z9wPHyN-qDcqJMUALTYV0phaxw&s" alt="primera imagen" class="login"> 

</div>
<style>
    .login{
        padding: 0;
        margin: 0;
        transform: translateX(250%);
    }
</style>
<style>
  
    
    .background {
        position: fixed; /* La imagen se mantiene fija al hacer scroll */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUx7hPjutE2fOmXsYmGmjXvHX05Payxe0x-Q&s'); /* Imagen de fondo */
        background-size: cover;
        background-position: center;
        filter: blur(2px); /* Aplica el difuminado */
        z-index: -1;
        opacity: 0.5;
    }
    .content {
        position: static;
        z-index: auto;
        text-align: center;
        color: rgb(0, 0, 0);
        padding-top: 50px;
    }

    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box; /* Para unificar el modelo de cajas */
    }
    
    
    .content {
        padding: 20px;
        background-color: transparent; /* Si hay fondo blanco, cámbialo a transparente */
        margin: 0 auto;
        border: none; /* Elimina bordes si hay */
        box-shadow: none; /* Elimina sombras si hay */
    }
    
    form {
        margin: 0;
        padding: 0;
        border: none;
        text-align: center;
    }
    
    
    
</style>


</body>
</html>
<div class="content">
    <form action="/psicoagenda2/login.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Iniciar Sesión</button>
    </form>
            <!-- Mostrar el mensaje de error si existe -->
            <?php
            // Iniciar la sesión para acceder al parámetro de error
            session_start();
            
            // Verificar si hay un mensaje de error en la URL
            if (isset($_GET['error'])) {
                // Mostrar el mensaje de error
                echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
            ?>
    <style>
        form {
            text-align: center;
        }
    </style>

    
</div>