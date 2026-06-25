<?php
$host = '127.0.0.1';
$dbName = 'pacientes';
$user = 'root';
$pass = '';

echo "Testing MySQL connection via 127.0.0.1...\n";

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Connection established!\n";
    $stmt = $pdo->query("SELECT VERSION()");
    echo "MySQL version: " . $stmt->fetchColumn() . "\n";
} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
