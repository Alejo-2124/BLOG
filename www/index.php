<?php
session_start();
include 'includes/header.php';
include 'includes/functions.php';

// Obtener posts desde la base de datos
$posts = getPublishedPosts();
?>

<section class="hero">
    <div class="container">
        <h2>Explora el Mundo Tecnológico</h2>
        <p>Descubre artículos innovadores sobre desarrollo, tendencias tech y las últimas tecnologías.</p>
    </div>
</section>

<section class="posts-grid">
    <div class="container">
        <h2>Últimas Publicaciones</h2>
        <div class="grid">
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        
                        <div class="post-image">
                            <?php if (!empty($post['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <?php else: ?>
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                                📝 Sin imagen
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="post-content">
                            <h3><?php echo $post['title']; ?></h3>
                            <p class="post-excerpt"><?php echo $post['excerpt']; ?></p>
                            <div class="post-meta">
                                <span class="post-date"><?php echo formatDate($post['created_at']); ?></span>
                                <span class="post-author">Por: <?php echo $post['author']; ?></span>
                            </div>
                            <a href="post/post.php?id=<?php echo $post['id']; ?>" class="read-more">Leer más</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay publicaciones aún.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>