<?php
require_once('login_helper.php');

// Verificar si el usuario está autenticado y es administrador
if (!is_authenticated() || get_authenticated_user()['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Procesar la subida de archivos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_archivo = $_POST['nombre_archivo'] ?? '';
    $archivo_subido = $_FILES['archivo_subido'];

    // Validar que se haya seleccionado un archivo
    if ($archivo_subido['error'] === UPLOAD_ERR_OK) {
        // Validar tipo de archivo
        $permitidos = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
        if (in_array($archivo_subido['type'], $permitidos)) {
            $ruta_destino = 'files/' . ($nombre_archivo ?: $archivo_subido['name']);

            // Mover el archivo subido al directorio de archivos
            if (move_uploaded_file($archivo_subido['tmp_name'], $ruta_destino)) {
                // Redireccionar para evitar reenvío del formulario
                header('Location: index.php');
                exit();
            } else {
                $error_subida = 'Error al subir el archivo.';
            }
        } else {
            $error_subida = 'Formato de archivo no permitido. Suba imágenes (jpeg, png, gif) o archivos PDF.';
        }
    } else {
        $error_subida = 'Error al subir el archivo.';
    }
}

// Incluir la cabecera
include('header.php');
?>

<!-- Contenido de la página -->
<div class="container">
    <h1>Subir archivo</h1>
    <form method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="archivo_subido" class="form-label">Seleccione un archivo</label>
            <input type="file" class="form-control" id="archivo_subido" name="archivo_subido" accept="image/*,.pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir archivo</button>
        <?php if (isset($error_subida)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $error_subida; ?>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php include('footer.php'); ?>
