<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sesion.css">
    <title>Iniciar sesión</title>
</head>
<body>
    <div class="contenedor">
        <h1>Iniciar sesión</h1>
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

        <form action="/procesar_login.php" method="POST">
            <label for="">
                Correo electrónico:
            </label>
            <input 
                type="email" 
                name="email"
                placeholder="Ingrese su correo electrónico"
                required
            >

            <label for="">
                Contraseña:
            </label>
            <input 
                type="password" 
                name="password"
                placeholder="Ingrese su contraseña"
                required
            >
            
            <input 
                type="submit" 
                class="button" 
                value="Ingresar"
            >

            <div class="contenedor-enlace">
                <p class="texto-enlace">¿No tienes una cuenta?
                    <a href="/registro.php" class="enlace-registro">Regístrate aquí</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>