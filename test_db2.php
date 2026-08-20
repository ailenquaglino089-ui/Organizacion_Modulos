<?php
// Segunda prueba de conexión: utiliza 127.0.0.1 y consulta la versión de MySQL.
$host = '127.0.0.1';
$dbName = 'pacientes';
$user = 'root';
$pass = '';

// Mensaje inicial para identificar qué configuración se está probando.
echo "Testing MySQL connection via 127.0.0.1...\n";

try {
    // Crea una conexión PDO con excepciones y resultados asociativos.
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Connection established!\n";
    // Consulta información básica del servidor para confirmar la comunicación.
    $stmt = $pdo->query("SELECT VERSION()");
    echo "MySQL version: " . $stmt->fetchColumn() . "\n";
} catch (PDOException $e) {
    // Captura errores específicos de PDO, como credenciales o servidor apagado.
    echo "PDO Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    // Captura cualquier otro error de ejecución del diagnóstico.
    echo "Error: " . $e->getMessage() . "\n";
}
