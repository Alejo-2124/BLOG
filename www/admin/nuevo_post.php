<?php
include '../includes/header.php';
include '../includes/functions.php';
include '../includes/auth_functions.php';

requireLogin();

$success = '';
$error = '';

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $excerpt = trim($_POST['excerpt']);
    $image_url = '';
    
    // Manejar la subida de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if (in_array($_FILES['imagen']['type'], $allowed_types)) {
            if ($_FILES['imagen']['size'] <= $max_size) {
                // Crear directorio de uploads si no existe
                $upload_dir = '../assets/images/posts/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Generar nombre único
                $file_extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '_' . time() . '.' . $file_extension;
                $file_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $file_path)) {
                    $image_url = '/assets/images/posts/' . $file_name;
                } else {
                    $error = 'Error al subir la imagen. Intenta nuevamente.';
                }
            } else {
                $error = 'La imagen es demasiado grande. Máximo 5MB permitido.';
            }
        } else {
            $error = 'Formato de imagen no válido. Usa JPG, PNG, GIF o WebP.';
        }
    }
    
    if (empty($error)) {
        if (!empty($title) && !empty($content)) {
            if (empty($excerpt)) {
                $excerpt = getExcerpt($content);
            }
            
            if (createPost($title, $content, $excerpt, $image_url)) {
                $success = '¡Post publicado exitosamente!';
                // Limpiar el formulario
                $title = $content = $excerpt = '';
            } else {
                $error = 'Error al publicar el post. Intenta nuevamente.';
            }
        } else {
            $error = 'El título y contenido son obligatorios.';
        }
    }
}
?>

<div class="admin-container">
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 2rem; color: #2c3e50;">Crear Nuevo Post</h1>
        
        <?php if ($success): ?>
            <div class="alert success" style="max-width: 800px; margin: 0 auto 2rem auto;">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert error" style="max-width: 800px; margin: 0 auto 2rem auto;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" class="post-form">
            <div class="form-group">
                <label for="title">Título del Post:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" 
                        placeholder="Escribe un título atractivo..." required>
            </div>
            
            <div class="form-group">
                <label for="excerpt">Extracto (opcional):</label>
                <textarea id="excerpt" name="excerpt" rows="3" 
                            placeholder="Un breve resumen de tu post..."><?php echo htmlspecialchars($excerpt ?? ''); ?></textarea>
                <small>Si lo dejas vacío, se generará automáticamente del contenido.</small>
            </div>
            
            <div class="form-group">
                <label for="content">Contenido del Post:</label>
                <textarea id="content" name="content" rows="12" 
                            placeholder="Escribe tu contenido aquí..." required><?php echo htmlspecialchars($content ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="imagen">Imagen Destacada:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <small>Formatos aceptados: JPG, PNG, GIF, WebP. Tamaño máximo: 5MB</small>
                
                <!-- Previsualización de imagen -->
                <div class="image-preview" id="imagePreview" style="display: none;">
                    <p>Vista previa:</p>
                    <img id="previewImage" src="" alt="Vista previa">
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <span> Publicar Post</span>
                </button>
                <a href="/index.php" class="btn-secondary">
                    <span> Volver al Blog</span>
                </a>
</div>
        </form>
    </div>
</div>

<script>
// Previsualización de imagen
document.getElementById('imagen').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.style.display = 'none';
    }
});
</script>

<?php include '../includes/footer.php'; ?>