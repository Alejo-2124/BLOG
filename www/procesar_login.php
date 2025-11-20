<?php 
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Buscar usuario
    $sql = "SELECT id, nombre, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nombre, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {

            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $nombre; 
            $_SESSION['user_email'] = $email;
            
            header("Location: /index.php");
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta";
            header("Location: /login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No existe una cuenta con ese correo electrónico";
        header("Location: /login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: /login.php");
}
?>