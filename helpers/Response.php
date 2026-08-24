<?php
// Formato común para las respuestas JSON de la API.

// Response centraliza el formato de todas las respuestas JSON de la API.
// Así los clientes reciben siempre las mismas claves de éxito y error.
class Response
{
    // Genera una respuesta exitosa con datos opcionales y código HTTP configurable.
    public static function ok(mixed $data = null, string $mensaje = 'OK', int $status = 200): void
    {
        self::json([
            'ok' => true,
            'mensaje' => $mensaje,
            'data' => $data,
        ], $status);
    }

    // Genera una respuesta de error con un mensaje y errores por campo opcionales.
    public static function error(string $mensaje, int $status = 400, array $errores = []): void
    {
        self::json([
            'ok' => false,
            'mensaje' => $mensaje,
            'errores' => $errores,
        ], $status);
    }

    // Envía headers, serializa el cuerpo como JSON y detiene la petición.
    private static function json(array $cuerpo, int $status): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
