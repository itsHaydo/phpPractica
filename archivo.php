<?php
// Obtener el nombre del archivo de la URL
if (isset($_GET['nombre'])) {
    $nombre_archivo = $_GET['nombre'];
    $ruta_archivo = 'files/' . $nombre_archivo;

    // Verificar si el archivo existe
    if (file_exists($ruta_archivo)) {
        // Mostrar el archivo
        header('Content-Type: ' . mime_content_type($ruta_archivo));
        readfile($ruta_archivo);
        exit();
    } else {
        echo 'Archivo no encontrado.';
    }
} else {
    echo 'Nombre de archivo no especificado.';
}
?>
