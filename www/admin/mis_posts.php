<?php
include '../includes/header.php';
include '../includes/functions.php';
include '../includes/auth_functions.php';

requireLogin();

$user_posts = getUserPosts();
?>

<div class="admin-container">
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 2rem; color: #2c3e50;">Mis Posts</h1>
        
        <div class="admin-actions">
            <a href="nuevo_post.php" class="btn-primary">
                <span> Nuevo Post</span>
            </a>
            <a href="/index.php" class="btn-secondary">
                <span> Volver al Blog</span>
            </a>
        </div>
        
        <?php if (count($user_posts) > 0): ?>
            <div class="posts-list">
                <?php foreach ($user_posts as $post): ?>
                    <div class="post-item">
                        <div class="post-item-content">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                            <div class="post-meta">
                                <span>📅 Publicado: <?php echo formatDate($post['created_at']); ?></span>
                                <span>🔍 Estado: 
                                    <span style="color: <?php echo $post['status'] == 'published' ? '#27ae60' : '#f39c12'; ?>;">
                                        <?php echo $post['status'] == 'published' ? 'Publicado' : 'Borrador'; ?>
                                    </span>
                                </span>
                            </div>
                            <?php if (!empty($post['excerpt'])): ?>
                                <p style="color: #666; margin: 0.5rem 0;"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="post-actions">
                            <a href="/post/post.php?id=<?php echo $post['id']; ?>" class="btn-view" target="_blank">
                                <span> Ver Post</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3 style="color: #6c757d; margin-bottom: 1rem;">No has publicado ningún post aún</h3>
                <p>Comienza compartiendo tus ideas con el mundo.</p>
                <a href="nuevo_post.php" class="btn-primary">Crear mi primer post</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>