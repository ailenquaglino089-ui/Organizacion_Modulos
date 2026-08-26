<?php

// Importa las clases de firebase/php-jwt instaladas por Composer.
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Excepción específica para errores de autenticación.
class AuthenticationException extends RuntimeException
{
}

// Centraliza la emisión y validación de tokens JWT de la API.
class Auth
{
    // Devuelve un token firmado para el usuario autenticado.
    public static function issue(array $user): string
    {
        // Obtiene la clave desde el entorno y evita iniciar con una clave insegura.
        $secret = self::secret();
        // Define el instante de emisión y la expiración del token.
        $issuedAt = time();
        $expiresAt = $issuedAt + (int) (getenv('JWT_TTL') ?: 900);
        // Construye únicamente claims no sensibles del usuario.
        $payload = [
            'iss' => getenv('JWT_ISSUER') ?: 'Organizacion_Modulos',
            'iat' => $issuedAt,
            'exp' => $expiresAt,
            'sub' => (string) $user['id'],
            'email' => $user['email'],
            'rol' => $user['rol'],
        ];

        // Firma el token usando exclusivamente HS256.
        return JWT::encode($payload, $secret, 'HS256');
    }

    // Valida el Bearer token de la petición y devuelve sus claims.
    public static function requireUser(): array
    {
        // Lee las cabeceras de forma compatible con Apache y CGI.
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $authorization = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        // Comprueba que la cabecera use el formato estándar Bearer.
        if (!is_string($authorization) || !preg_match('/^Bearer\s+(.+)$/i', $authorization, $matches)) {
            throw new AuthenticationException('Token no proporcionado');
        }

        try {
            // firebase/php-jwt verifica firma, algoritmo y expiración.
            return (array) JWT::decode($matches[1], new Key(self::secret(), 'HS256'));
        } catch (Throwable $exception) {
            // No se filtran detalles internos del token al cliente.
            throw new AuthenticationException('Token inválido o expirado');
        }
    }

    // Devuelve un middleware que transforma fallos de autenticación en HTTP 401.
    public static function middleware(): callable
    {
        // La closure permite reutilizar la protección directamente en Router.
        return static function (): bool {
            try {
                // Valida el token antes de permitir que continúe la ruta.
                self::requireUser();
                return true;
            } catch (AuthenticationException $exception) {
                // Responde sin exponer detalles criptográficos al cliente.
                Response::error($exception->getMessage(), 401);
                return false;
            }
        };
    }

    // Obtiene la clave secreta y exige una longitud mínima razonable.
    private static function secret(): string
    {
        // getenv permite configurar el secreto fuera del repositorio.
        $secret = (string) getenv('JWT_SECRET');
        // Una clave ausente o corta no debe permitir emitir tokens.
        if (strlen($secret) < 32) {
            throw new RuntimeException('JWT_SECRET debe tener al menos 32 caracteres');
        }

        // Devuelve la clave validada al emisor o verificador.
        return $secret;
    }
}