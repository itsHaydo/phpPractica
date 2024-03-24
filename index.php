<?php
require_once('login_helper.php');

// Verificar si el usuario está autenticado
if (!is_authenticated()) {
    header('Location: login.php');
    exit();
}

// Verificar si el usuario es administrador
$usuario = get_authenticated_user();
$es_admin = ($usuario['role'] === 'admin');

// Obtener archivos de la carpeta files
$archivos = glob('files/*.*');

// Incluir la cabecera
include('header.php');
?>

<!-- Contenido de la página -->
<div class="container">
    <h1>Administración de archivos</h1>
    <?php if ($es_admin) : ?>
        <a href="uploadFile.php" class="btn btn-primary">Subir archivo</a>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre del archivo</th>
                <th>Tamaño (KB)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($archivos as $archivo) : ?>
                <?php
                $nombre_archivo = basename($archivo);
                $tamaño_archivo = round(filesize($archivo) / 1024, 2);
                ?>
                <tr>
                    <td><a href="archivo.php?nombre=<?php echo urlencode($nombre_archivo); ?>" target="_blank"><?php echo $nombre_archivo; ?></a></td>
                    <td><?php echo $tamaño_archivo; ?></td>
                    <td>
                        <?php if ($es_admin) : ?>
                            <button class="btn btn-danger" onclick="eliminarArchivo('<?php echo $nombre_archivo; ?>')">Borrar</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function eliminarArchivo(nombreArchivo) {
        if (confirm(`¿Está seguro que desea borrar ${nombreArchivo}?`)) {
            // Realizar una petición AJAX para borrar el archivo
            fetch(`eliminar_archivo.php?nombre=${encodeURIComponent(nombreArchivo)}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    // Actualizar la tabla después de borrar el archivo
                    location.reload();
                } else {
                    alert('Error al intentar borrar el archivo.');
                }
            })
            .catch(error => {
                console.error('Error al realizar la petición:', error);
                alert('Error al intentar borrar el archivo.');
            });
        }
    }
</script>



<?php include('footer.php'); ?>
