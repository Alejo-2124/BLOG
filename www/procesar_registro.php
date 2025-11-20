<?php 
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validaciones
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header("Location: /registro.php");
        exit();
    }

    if (strlen($password) < 6) {
        $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
        header("Location: /registro.php");
        exit();
    }

    // Verificar si el email ya existe
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "El correo electrónico ya está registrado";
        header("Location: /registro.php");
        exit();
    }
    $stmt->close();

    // Hash de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "INSERT INTO usuarios (nombre, email, telefono, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $telefono, $password_hash);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
        header("Location: /login.php");
    } else {
        $_SESSION['error'] = "Error en el registro: " . $conn->error;
        header("Location: /registro.php");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: /registro.php");
}
?>