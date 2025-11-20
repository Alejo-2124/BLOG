<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sesion.css">
    <title>Registro</title>
</head>
<body>
    <div class="contenedor">
        <h1>Registrarse</h1>
        <br>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form action="/procesar_registro.php" method="POST">
            <label for="">
                Nombre completo:
            </label>
            <input type="text" name="nombre" placeholder="Ingrese su nombre completo" required>

            <label for="">
                Correo electrónico:
            </label>
            <input type="email" name="email" placeholder="Ingrese su correo electrónico" required>
            
            <label for="">
                Número de teléfono:
            </label>
            <input type="number" name="telefono" placeholder="Ingrese su número telefónico" required>

            <label for="">
                Contraseña:
            </label>
            <input type="password" name="password" placeholder="Ingrese su contraseña" required>

            <label for="">
                Confirmar Contraseña:
            </label>
            <input type="password" name="confirm_password" placeholder="Confirme su contraseña" required>

            <input type="submit" class="button" value="Registrarse">

            <div class="contenedor-enlace">
                <p class="texto-enlace"> ¿Ya estás registrado?
                    <a href="/login.php" class="enlace-registro">Inicia Sesión aquí</a>
                </p>
            </div>   
        </form>
    </div>
</body>
</html>