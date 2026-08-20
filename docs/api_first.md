# API First en SaludWEB

## Propósito

API First significa diseñar y acordar el contrato entre frontend y backend antes de implementar cada módulo. En SaludWEB, la API debe modelar el dominio de salud y prescripciones, no imitar las pantallas actuales. Así, la misma lógica puede ser consumida por la web, una futura aplicación mobile o una integración externa.

La API es un contrato: define recursos, rutas, métodos HTTP, datos de entrada, respuestas, errores y permisos. Si el contrato es claro, frontend y backend pueden trabajar en paralelo usando mocks y pruebas antes de que toda la persistencia esté terminada.

## Qué es REST en este proyecto

La API utiliza HTTP y JSON para operar recursos. Una URL identifica el recurso y el método HTTP expresa la operación:

- `GET` consulta sin modificar datos.
- `POST` crea un recurso.
- `PUT` reemplaza un recurso completo.
- `PATCH` modifica algunos campos.
- `DELETE` elimina o da de baja un recurso.

La separación actual ya aplica parte del modelo cliente-servidor: `MedicoController` responde JSON, `MedicoService` concentra reglas y `MedicoRepository` accede a MySQL. Sin embargo, el sistema todavía mantiene páginas PHP y consultas de prescripciones fuera de esa estructura.

## Recursos del dominio

Los recursos identificados en la base de datos son:

- `medicos`: profesionales habilitados para emitir recetas.
- `pacientes`: personas atendidas.
- `medicamentos`: catálogo de medicamentos.
- `prescripciones`: recetas emitidas para pacientes y, opcionalmente, asociadas a médicos.
- `obras-sociales`: cobertura de los pacientes.
- `triages`: clasificación de urgencia de pacientes.
- `auditorias`: registro de acciones del sistema.

Las rutas deben usar sustantivos plurales, minúsculas y una jerarquía breve. No deben representar pantallas ni acciones internas como `/crearMedico` o `/eliminarReceta`.

## Contrato actual

| Método | Endpoint | Estado actual |
|---|---|---|
| `GET` | `/api/medicos` | Implementado; devuelve la lista JSON. |
| `GET` | `/api/medicos/{id}` | Implementado; devuelve `404` si no existe. |
| `POST` | `/api/medicos` | Implementado; valida nombre y devuelve `201`. |
| `PUT` | `/api/medicos/{id}` | Implementado, pero actualmente se comporta como actualización parcial. |
| `PATCH` | `/api/medicos/{id}` | Implementado para cambios parciales, incluido `activo`. |
| `DELETE` | `/api/medicos/{id}` | Implementado; devuelve `200` con mensaje. |
| `DELETE` | `/api/prescripciones/{id}` | Implementado directamente en `routes.php`, sin servicio ni repositorio propios. |

### Ejemplo de recurso médico

```json
{
  "id": 4,
  "nombre": "Dra. Lucía Fernández",
  "matricula": "44556",
  "especialidad": "Dermatología",
  "activo": true,
  "creadoAt": "2026-08-20T10:30:00Z"
}
```

Antes de adoptar completamente este formato, el equipo debe acordar si la API usará `snake_case` para conservar los nombres actuales de MySQL o `camelCase` para el contrato público. Lo importante es elegir una convención y mantenerla en todos los recursos.

## Contrato propuesto para la siguiente etapa

### Médicos

```text
GET    /api/medicos
GET    /api/medicos/{id}
POST   /api/medicos
PATCH  /api/medicos/{id}
DELETE /api/medicos/{id}
```

El `POST` debería recibir un objeto con `nombre`, `matricula` y `especialidad`, validar los campos en el servicio y responder `201 Created` con el recurso creado. El `PATCH` debe recibir únicamente los campos modificados. La respuesta de `DELETE` puede ser `204 No Content` si no se devuelve cuerpo.

### Prescripciones

```text
GET    /api/prescripciones
GET    /api/prescripciones/{id}
POST   /api/prescripciones
PATCH  /api/prescripciones/{id}
DELETE /api/prescripciones/{id}
```

Filtros como estado o paciente deben ser parámetros de consulta, por ejemplo:

```text
GET /api/prescripciones?estado=activa&pacienteId=3
```

La pantalla no debería decidir cómo consultar tablas ni traducir el JSON de medicamentos. El backend debe devolver una representación lista para cualquier cliente:

```json
{
  "id": 18,
  "paciente": { "id": 3, "nombre": "Ana Fernández" },
  "medico": { "id": 4, "nombre": "Dra. Lucía Fernández" },
  "medicamentos": [
    { "id": 1, "nombre": "Paracetamol", "dosis": "500 mg cada 8 horas" }
  ],
  "indicaciones": "Tomar con agua",
  "fechaEmision": "2026-08-20T10:30:00Z",
  "fechaVencimiento": "2026-09-20",
  "estado": "activa"
}
```

## Respuestas y errores

El cliente debe poder tomar decisiones con el código HTTP, no buscando un texto de error dentro de una respuesta `200`.

| Situación | Código recomendado |
|---|---:|
| Consulta o modificación exitosa con contenido | `200 OK` |
| Recurso creado | `201 Created` |
| Eliminación exitosa sin contenido | `204 No Content` |
| JSON malformado o parámetros inválidos | `400 Bad Request` |
| Falta autenticación | `401 Unauthorized` |
| Usuario autenticado sin permiso | `403 Forbidden` |
| Recurso inexistente | `404 Not Found` |
| Regla de negocio incumplida | `422 Unprocessable Entity` |
| Error inesperado | `500 Internal Server Error` |

Formato de error propuesto:

```json
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "El nombre del médico es obligatorio",
    "fields": {
      "nombre": "El campo es requerido"
    }
  }
}
```

Nunca deben devolverse trazas, contraseñas, consultas SQL ni detalles internos en una respuesta pública.

## Observaciones sobre el contrato actual

1. `PUT` y `PATCH` llegan al mismo método y ambos actualizan parcialmente. Debe documentarse como decisión temporal o implementarse la diferencia semántica.
2. La eliminación de médicos devuelve `mensaje`, mientras que la de prescripciones devuelve `message`. La API necesita un único idioma y formato.
3. La ruta de eliminación de prescripciones mezcla router, SQL y respuesta HTTP. Debe migrarse a `PrescripcionController`, `PrescripcionService` y `PrescripcionRepository`.
4. Las vistas actuales consultan datos directamente para prescripciones. El endpoint debe convertirse en la única puerta de acceso del cliente a esa información.
5. Existe `session_start`, pero no un contrato de login, permisos, `401` o `403`. La autenticación debe definirse antes de exponer operaciones sensibles.
6. La API no declara versionado, paginación ni un formato común para colecciones. Son decisiones pendientes para el crecimiento del sistema.

## Diseño API First y flujo de trabajo

1. El equipo modela recursos y casos de uso del dominio.
2. Se acuerdan rutas, métodos, esquemas JSON, códigos HTTP y errores.
3. Se documenta el contrato en Markdown u OpenAPI y se revisa entre frontend y backend.
4. Frontend trabaja con mocks del contrato.
5. Backend implementa controlador, servicio y repositorio detrás del mismo contrato.
6. QA prueba casos felices, validaciones, permisos, recursos inexistentes e idempotencia.
7. Se versiona cualquier cambio incompatible antes de publicarlo.

## Hoja de ruta API First para SaludWEB

- **Paso 1:** formalizar el contrato de médicos y unificar nombres de campos y errores.
- **Paso 2:** crear la API de prescripciones y retirar SQL de `lista_prescripciones.php`.
- **Paso 3:** agregar autenticación, autorización y auditoría para operaciones sensibles.
- **Paso 4:** incorporar paginación, filtros documentados y respuestas de colección consistentes.
- **Paso 5:** escribir pruebas de endpoints y publicar una especificación OpenAPI.
- **Paso 6:** migrar progresivamente el cliente web para que consuma JSON sin depender del renderizado de PHP.

## Criterio de aceptación

Una funcionalidad estará lista cuando un cliente pueda consumirla sin conocer MySQL ni la estructura interna del backend, cuando sus respuestas sean predecibles y cuando el contrato pueda ser explicado y probado de forma independiente de la pantalla que lo utiliza.
