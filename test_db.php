<?php
// Prueba aislada de conexión PDO sin cargar el esquema completo de la aplicación.
try {
    // Usa la configuración local de XAMPP para abrir una conexión a MySQL.
    $pdo = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Informa que la conexión fue creada correctamente.
    echo 'DB connected OK';
} catch (Exception $e) {
    // Muestra el error de diagnóstico para corregir el entorno local.
    echo 'Error: ' . $e->getMessage();
}
