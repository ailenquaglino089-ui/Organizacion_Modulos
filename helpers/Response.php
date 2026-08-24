<?php
// Formato común para las respuestas JSON de la API.

// Response centraliza el formato de todas las respuestas JSON de la API.
// Así los clientes reciben siempre las mismas claves de éxito y error.
class Response
{
    // Genera una respuesta exitosa con datos opcionales y código HTTP configurable.
    public static function ok(mixed $data = null, string $mensaje = 'OK', int $status = 200): void
    {
        // Construye la estructura estándar para operaciones exitosas.
        self::json([
            'ok' => true,
            'mensaje' => $mensaje,
            'data' => $data,
        ], $status);
    }

    // Genera una respuesta de error con un mensaje y errores por campo opcionales.
    public static function error(string $mensaje, int $status = 400, array $errores = []): void
    {
        // Construye la estructura estándar para operaciones fallidas.
        self::json([
            'ok' => false,
            'mensaje' => $mensaje,
            'errores' => $errores,
        ], $status);
    }

    // Envía headers, serializa el cuerpo como JSON y detiene la petición.
    private static function json(array $cuerpo, int $status): void
    {
        // Establece el código HTTP que recibirá el cliente.
        http_response_code($status);
        // Declara que el cuerpo de la respuesta está codificado como JSON.
        header('Content-Type: application/json; charset=utf-8');
        // Serializa y envía el cuerpo de la respuesta.
        echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // Detiene la ejecución después de enviar la respuesta.
        exit;
    }
}
