<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Blog Personal</title>
    <link rel="stylesheet" href="/assets/css/estilos.css">
    <link rel="stylesheet" href="/assets/css/posts.css">

</head>
<body>
    <header class="main-header fixed-header">
        <div class="container">
            <h1 class="logo">Mi Blog</h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="/index.php">Inicio</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Menú para usuarios logueados -->
                        <li><a href="/admin/nuevo_post.php">Nuevo Post</a></li>
                        <li><a href="/admin/mis_posts.php">Mis Posts</a></li>
                        <li><a href="/logout.php">Cerrar Sesión (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
                    <?php else: ?>
                        <!-- Menú para visitantes -->
                        <li><a href="/login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">