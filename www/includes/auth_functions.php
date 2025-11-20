<?php
// Función para verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Función para verificar permisos de administrador (si aplica)
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
}

// Función para redirigir si no está logueado
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

// Función para redirigir si ya está logueado
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: /index.php');
        exit();
    }
}
?>