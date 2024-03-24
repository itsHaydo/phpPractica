<?php
// Verificar si se ha enviado el parámetro 'nombre' en la URL
if (isset($_GET['nombre'])) {
    $nombre_archivo = $_GET['nombre'];

    // Ruta del archivo a borrar
    $ruta_archivo = 'files/' . $nombre_archivo;

    // Verificar si el archivo existe
    if (file_exists($ruta_archivo)) {
        // Intentar borrar el archivo
        if (unlink($ruta_archivo)) {
            // Respuesta exitosa
            http_response_code(204); // No Content
            exit();
        }
    }
}

// Respuesta de error si no se pudo borrar el archivo
http_response_code(500); // Internal Server Error

