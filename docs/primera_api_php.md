# Primera API en PHP: SaludWEB

## Objetivo

Este documento aplica el recorrido de la primera API REST al proyecto SaludWEB. La API utiliza PHP, PDO, MySQL y JSON para que la información de médicos y prescripciones pueda ser consumida por una web, una aplicación mobile u otro servicio.

Una API no es solo una lista de URLs: es el contrato que define cómo un cliente solicita recursos y cómo el backend responde. Por eso cada endpoint debe tener una responsabilidad clara, usar el método HTTP correcto, devolver JSON válido y comunicar el resultado mediante códigos HTTP.

## Estructura real del backend

```text
Organizacion_Modulos/
├── index.php                    # Front Controller
├── .htaccess                    # Reescritura hacia index.php
├── routes.php                   # Rutas web y API
├── core/
│   ├── bootstrap.php            # Inicialización y dependencias
│   └── Router.php               # Despacho de rutas
├── controllers/
│   └── MedicoController.php     # Respuestas HTTP de médicos
├── services/
│   └── MedicoService.php        # Reglas de negocio
├── persistence/
│   └── MedicoRepository.php     # Consultas SQL de médicos
└── db.php                       # PDO, esquema y datos iniciales
```

`index.php` es el punto de entrada del navegador. Apache redirige las URLs amigables mediante `.htaccess`; `routes.php` registra las rutas y `Router` recorta la ruta base antes de despacharlas. El backend actual usa una estructura por capas, aunque todavía debe extraer prescripciones desde la vista hacia sus propias capas.

## Configuración con PDO

La conexión actual toma los valores desde variables de entorno y usa valores locales por defecto:

```text
DB_HOST   = localhost
DB_NAME   = pacientes
DB_USER   = root
DB_PASS   =
```

PDO está configurado con `ERRMODE_EXCEPTION` y `FETCH_ASSOC`. Las consultas con parámetros usan `prepare()` y `execute()`, lo que separa los datos de la estructura SQL. En un entorno productivo también debe mantenerse desactivada la emulación de prepares (`PDO::ATTR_EMULATE_PREPARES => false`) y nunca deben versionarse credenciales.

El siguiente paso de infraestructura es separar `db.php` en conexión, migraciones y datos de prueba. Actualmente ese archivo realiza las tres tareas y además genera HTML cuando falla la conexión.

## Endpoint de salud

Se incorporó el endpoint:

```text
GET /Organizacion_Modulos/api/health
```

La ruta relativa para el Router es `/api/health`. Su respuesta no depende de una pantalla ni de una consulta de negocio:

```json
{
  "status": "ok",
  "message": "API funcionando",
  "timestamp": "2026-08-20T10:30:00-03:00",
  "version": "1.0.0"
}
```

Este endpoint permite comprobar rápidamente que:

- Apache está recibiendo la petición.
- PHP puede cargar el Front Controller y el Router.
- La ruta se resuelve correctamente.
- La respuesta se envía como `application/json`.
- El servidor puede informar una versión y una marca de tiempo.

El endpoint confirma disponibilidad de la aplicación. No reemplaza un monitoreo completo ni una prueba de base de datos; para eso se puede agregar más adelante un chequeo controlado de dependencias.

## Respuestas JSON

Todas las respuestas de una API deben indicar el tipo de contenido antes de escribir el cuerpo:

```php
http_response_code(200);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data, JSON_UNESCAPED_UNICODE);
```

La API de médicos ya centraliza esta tarea en `MedicoController::jsonResponse()`. Para mantener un contrato consistente, los endpoints nuevos deberían adoptar una única convención para colecciones, recursos y errores. La propuesta del proyecto está detallada en [api_first.md](api_first.md).

Formato recomendado para errores:

```json
{
  "error": {
    "code": "RESOURCE_NOT_FOUND",
    "message": "Médico no encontrado"
  }
}
```

Nunca se deben enviar trazas, consultas SQL, contraseñas ni rutas internas al cliente. Los detalles técnicos deben registrarse internamente y la respuesta pública debe ser segura y útil.

## Endpoints implementados

| Método | Endpoint | Resultado |
|---|---|---|
| `GET` | `/api/health` | Estado básico de la API. |
| `GET` | `/api/medicos` | Lista de médicos en JSON. |
| `GET` | `/api/medicos/{id}` | Médico individual o `404`. |
| `POST` | `/api/medicos` | Crea un médico y devuelve `201`. |
| `PUT` / `PATCH` | `/api/medicos/{id}` | Actualiza datos del médico. |
| `DELETE` | `/api/medicos/{id}` | Elimina un médico. |
| `DELETE` | `/api/prescripciones/{id}` | Elimina una receta; pendiente de extraer a capas propias. |

## Cómo probar la primera API

Con Apache y MySQL activos en XAMPP, abrir en el navegador:

```text
http://localhost/Organizacion_Modulos/api/health
```

También puede probarse con PowerShell:

```powershell
Invoke-WebRequest http://localhost/Organizacion_Modulos/api/health | Select-Object StatusCode, Content
```

La comprobación esperada es un código `200` y un cuerpo JSON con `status` igual a `ok`. Para probar médicos:

```powershell
Invoke-WebRequest http://localhost/Organizacion_Modulos/api/medicos | Select-Object StatusCode, Content
```

Postman, Thunder Client o cualquier cliente HTTP permiten guardar estas peticiones y convertirlas luego en una colección de pruebas del equipo.

## Códigos HTTP utilizados

- `200 OK`: lectura o modificación exitosa con contenido.
- `201 Created`: recurso creado correctamente.
- `400 Bad Request`: entrada inválida.
- `404 Not Found`: ruta o recurso inexistente.
- `500 Internal Server Error`: error inesperado.

Antes de publicar la API deben agregarse `401 Unauthorized` y `403 Forbidden` para autenticación y permisos. También conviene definir si las eliminaciones exitosas responderán `200` con mensaje o `204 No Content`, y usar la misma convención en todos los recursos.

## Próximos pasos

1. Crear `PrescripcionController`, `PrescripcionService` y `PrescripcionRepository`.
2. Reemplazar el SQL de `lista_prescripciones.php` por consumo de `/api/prescripciones`.
3. Unificar el formato de errores y el idioma de los campos (`mensaje`/`message`).
4. Agregar autenticación y autorización antes de proteger operaciones sensibles.
5. Incorporar pruebas automatizadas para salud, médicos, validaciones y errores.
6. Publicar el contrato en OpenAPI cuando las decisiones de nombres y respuestas estén estabilizadas.

La primera API ya no se mide solo por devolver datos. Se considera lista cuando sus respuestas son predecibles, seguras, documentadas y reutilizables por más de un cliente.
