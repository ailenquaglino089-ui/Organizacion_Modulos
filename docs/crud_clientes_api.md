# CRUD API de Clientes

## Objetivo

SaludWEB incorpora una API REST de clientes construida con PHP, MySQL, PDO y el patrón Repository. El endpoint coordina la petición HTTP; el servicio valida las reglas; el repositorio encapsula todo el SQL; y `Response` mantiene respuestas JSON uniformes.

El flujo es:

```text
Cliente HTTP -> Router -> ClienteController -> ClienteService -> ClienteRepository -> MySQL
```

La condición principal de la práctica se cumple: `ClienteController.php` no contiene `SELECT`, `INSERT`, `UPDATE` ni `DELETE`. Las consultas CRUD están en `persistence/ClienteRepository.php`.

## Componentes

| Archivo | Responsabilidad |
|---|---|
| `db.php` | Crea la tabla `clientes` y carga dos registros de prueba si está vacía. |
| `helpers/Response.php` | Genera respuestas JSON con `ok`, `mensaje`, `data` o `errores`. |
| `persistence/ClienteRepository.php` | Único lugar de las consultas SQL CRUD de clientes. |
| `services/ClienteService.php` | Valida nombre, email, teléfono e IDs. |
| `controllers/ClienteController.php` | Lee HTTP/JSON, coordina el servicio y traduce errores a códigos HTTP. |
| `routes.php` | Registra las rutas `/api/clientes`. |
| `core/bootstrap.php` | Carga clases e inyecta PDO en las capas. |

## Modelo de datos

```sql
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  telefono VARCHAR(30) NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

`nombre` y `email` son obligatorios. `email` es único y `telefono` puede ser `NULL`. La restricción de unicidad en la base de datos complementa la validación de la API.

## Endpoints

| Método | Ruta | Código exitoso |
|---|---|---:|
| `GET` | `/api/clientes` | `200 OK` |
| `GET` | `/api/clientes/{id}` | `200 OK` |
| `POST` | `/api/clientes` | `201 Created` |
| `PUT` | `/api/clientes/{id}` | `200 OK` |
| `DELETE` | `/api/clientes/{id}` | `200 OK` |

### Listar clientes

```text
GET /Organizacion_Modulos/api/clientes
```

Respuesta:

```json
{
  "ok": true,
  "mensaje": "OK",
  "data": [
    {
      "id": 2,
      "nombre": "Luis Gómez",
      "email": "luis@demo.com",
      "telefono": "3434000002",
      "creado_en": "2026-08-20 10:30:00"
    }
  ]
}
```

### Buscar por ID

```text
GET /Organizacion_Modulos/api/clientes/1
```

Si no existe, responde `404` con `ok: false`.

### Crear

```http
POST /Organizacion_Modulos/api/clientes
Content-Type: application/json
```

```json
{
  "nombre": "María López",
  "email": "maria@demo.com",
  "telefono": "3434000003"
}
```

El servicio limpia los textos, valida el email y devuelve el recurso creado con `201 Created`.

### Actualizar

```http
PUT /Organizacion_Modulos/api/clientes/3
Content-Type: application/json
```

```json
{
  "nombre": "María López Actualizada",
  "email": "maria.actualizada@demo.com",
  "telefono": "3434000099"
}
```

El `PUT` recibe la representación completa del cliente. La implementación actual no agrega `PATCH`; si se necesita actualización parcial, se deberá definir ese contrato explícitamente.

### Eliminar

```text
DELETE /Organizacion_Modulos/api/clientes/3
```

Devuelve `200 OK` con `data: null` si el cliente fue eliminado y `404` si el ID no existe.

## Respuestas y errores

Respuesta exitosa común:

```json
{
  "ok": true,
  "mensaje": "Cliente creado correctamente",
  "data": { "id": 3 }
}
```

Respuesta de validación:

```json
{
  "ok": false,
  "mensaje": "Datos inválidos",
  "errores": {
    "nombre": "El nombre es obligatorio",
    "email": "El email no tiene un formato válido"
  }
}
```

Códigos utilizados:

- `200`: lectura, actualización o eliminación exitosa.
- `201`: creación exitosa.
- `400`: ID inválido o JSON malformado.
- `404`: cliente inexistente.
- `422`: validación fallida o email duplicado.
- `500`: error inesperado, sin exponer detalles internos.

## Pruebas manuales

Con Apache y MySQL activos en XAMPP:

```powershell
Invoke-WebRequest http://localhost/Organizacion_Modulos/api/clientes
Invoke-WebRequest http://localhost/Organizacion_Modulos/api/clientes/1
```

Para `POST`, `PUT` y `DELETE` puede utilizarse Postman, Thunder Client o `curl`. La evidencia de entrega debe mostrar las cinco operaciones y sus respuestas JSON.

Casos mínimos:

1. Listar clientes.
2. Consultar un ID existente.
3. Consultar un ID inexistente y verificar `404`.
4. Crear con email válido y verificar `201`.
5. Crear con email duplicado y verificar `422`.
6. Actualizar un cliente existente.
7. Eliminar un cliente existente.

## Decisiones y próximos pasos

- El Repository recibe PDO por inyección de dependencias y no conoce HTTP.
- El Service no contiene SQL y no lee `$_GET` ni `php://input`.
- El Controller no accede directamente a MySQL.
- `Response` evita duplicar headers y estructuras JSON.
- El esquema de clientes está en `db.php` porque el proyecto todavía inicializa su base desde ese archivo; en una migración posterior debe trasladarse a un script versionado en `sql/`.
- Se recomienda agregar pruebas automatizadas y una especificación OpenAPI cuando el contrato quede estable.
