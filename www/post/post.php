<?php
session_start();
include '../includes/header.php';
include '../includes/functions.php';


// Obtener el ID del post desde la URL
$post_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($post_id) {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM posts WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si no se encuentra el post, mostrar mensaje
if (!$post) {
    echo "<div class='container' style='margin-top: 100px; padding: 2rem;'>";
    echo "<h2>Post no encontrado</h2>";
    echo "<p>El post que buscas no existe o ha sido eliminado.</p>";
    echo "<a href='/index.php' class='back-to-blog'>Volver al Blog</a>";
    echo "</div>";
    include '../includes/footer.php';
    exit;
}
?>

<article class="post-single">
    <div class="container">
        <header class="post-header">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <div class="post-meta">
                <span class="post-date"><?php echo formatDate($post['created_at']); ?></span>
                <span class="post-author">Por: <?php echo htmlspecialchars($post['author']); ?></span>
            </div>
        </header>
        
        <?php if (!empty($post['image_url'])): ?>
            <div class="post-image-single">
                <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
            </div>
        <?php endif; ?>
        
        <div class="post-content-single">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
        </div>
        
        <div class="post-navigation">
            <a href="/index.php" class="back-to-blog">← Volver al inicio</a>
        </div>
    </div>
</article>

<?php include '../includes/footer.php'; ?>