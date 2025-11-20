<?php
include __DIR__ . '/../config/database.php';

function getPublishedPosts() {
    $database = new Database();
    $db = $database->getConnection();
    
    // Consulta CORREGIDA - sin JOIN con users
    $query = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createPost($title, $content, $excerpt, $image_url) {
    $database = new Database();
    $db = $database->getConnection();
    
    // Usar el username de la sesión para el campo author
    $author = isset($_SESSION['username']) ? $_SESSION['username'] : 'Anónimo';
    
    $query = "INSERT INTO posts (title, content, excerpt, image_url, author, status) 
                VALUES (?, ?, ?, ?, ?, 'published')";
    $stmt = $db->prepare($query);
    return $stmt->execute([$title, $content, $excerpt, $image_url, $author]);
}

function getUserPosts() {
    $database = new Database();
    $db = $database->getConnection();
    
    // Consulta por autor en lugar de user_id
    $author = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $query = "SELECT * FROM posts WHERE author = ? ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([$author]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function formatDate($date) {
    return date('d M, Y', strtotime($date));
}

function getExcerpt($content, $length = 150) {
    $cleaned = strip_tags($content);
    if (strlen($cleaned) > $length) {
        return substr($cleaned, 0, $length) . '...';
    }
    return $cleaned;
}
?>