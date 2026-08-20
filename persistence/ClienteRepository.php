<?php

// ClienteRepository encapsula todo el SQL de la entidad clientes.
// No conoce HTTP, sesiones ni JSON: recibe datos PHP y devuelve resultados.
class ClienteRepository
{
    // PDO llega por inyección de dependencias desde el bootstrap.
    private PDO $pdo;

    // Guarda la conexión que utilizarán las consultas del repositorio.
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Obtiene todos los clientes ordenados del más nuevo al más antiguo.
    public function listar(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nombre, email, telefono, creado_en
             FROM clientes
             ORDER BY id DESC'
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca un cliente por ID y devuelve null cuando no existe.
    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nombre, email, telefono, creado_en
             FROM clientes
             WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cliente ?: null;
    }

    // Inserta un cliente y devuelve el ID generado por AUTO_INCREMENT.
    public function crear(array $datos): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO clientes (nombre, email, telefono)
             VALUES (:nombre, :email, :telefono)'
        );
        $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':email' => $datos['email'],
            ':telefono' => $datos['telefono'] ?? null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    // Actualiza la representación completa de un cliente existente.
    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE clientes
             SET nombre = :nombre,
                 email = :email,
                 telefono = :telefono
             WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $datos['nombre'],
            ':email' => $datos['email'],
            ':telefono' => $datos['telefono'] ?? null,
        ]);
    }

    // Elimina un cliente y devuelve si alguna fila fue afectada.
    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM clientes WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
