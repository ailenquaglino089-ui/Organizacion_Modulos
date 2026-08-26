# Autenticación JWT

La API usa `firebase/php-jwt` para emitir tokens firmados con HS256.

## Instalación

Desde la carpeta del proyecto:

```powershell
C:\xampp\php\php.exe composer.phar install
```

Copia `.env.example` como `.env` y configura `JWT_SECRET` con una cadena aleatoria de al menos 32 caracteres. Apache debe exponer esas variables de entorno; este proyecto no lee `.env` automáticamente para evitar añadir otra dependencia.

## Crear el primer usuario

Genera un hash sin guardar la contraseña en el repositorio:

```powershell
C:\xampp\php\php.exe -r "echo password_hash('CAMBIA_ESTA_CLAVE', PASSWORD_DEFAULT), PHP_EOL;"
```

Inserta el hash resultante en MySQL:

```sql
INSERT INTO users (email, password_hash, rol)
VALUES ('admin@demo.com', 'PEGA_AQUI_EL_HASH', 'admin');
```

## Flujo de uso

1. `POST /Organizacion_Modulos/api/login` con `email` y `password` en JSON.
2. Guarda el campo `data.token` de la respuesta.
3. Envía `Authorization: Bearer <token>` en `GET /api/me` y en las rutas CRUD protegidas.

Los tokens duran 15 minutos por defecto. Cambia `JWT_TTL` solo mediante la configuración del entorno.