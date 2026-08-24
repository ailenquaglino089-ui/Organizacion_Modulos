# Comentario de todos los archivos del proyecto

Esta guía explica la función de cada archivo de Organización Módulos (SaludWEB). Los archivos PHP también incluyen un comentario inicial de propósito. Los archivos Markdown se explican aquí porque ya son documentación: agregar comentarios dentro de ellos solo agregaría ruido visual.

## Flujo comentado de una solicitud

1. **Cliente HTTP:** inicia la solicitud desde el navegador, una app móvil o un consumidor de la API.
2. **Router y controlador:** reciben la petición, identifican la ruta y delegan la operación al controlador correspondiente.
3. **Servicio:** valida la entrada y aplica las reglas de negocio.
4. **Repository:** ejecuta consultas preparadas mediante PDO y accede a MySQL.
5. **MySQL:** almacena o consulta la información y devuelve el resultado.
6. **Respuesta:** el controlador devuelve JSON y un código HTTP para que el cliente actualice su interfaz.

## Archivos PHP de la raíz

| Archivo | Función |
|---|---|
| `index.php` | Punto de entrada principal: carga la configuración, las rutas y despacha la petición HTTP. |
| `routes.php` | Registra las rutas HTML y los endpoints JSON de médicos, clientes y prescripciones. |
| `db.php` | Conecta con MySQL y prepara el esquema y los datos iniciales para desarrollo. |
| `configuracion.php` | Renderiza la pantalla de configuración y preferencias del sitio. |
| `lista_medicos.php` | Muestra médicos y usa `fetch` para las operaciones del CRUD mediante la API. |
| `lista_prescripciones.php` | Lista y filtra prescripciones; conserva acceso SQL directo pendiente de migración. |
| `mis_rx.php` | Renderiza el panel visual de recetas del paciente. |
| `helpers/Response.php` | Centraliza la estructura de las respuestas JSON de la API. |
| `controllers/MedicoController.php` | Traduce peticiones HTTP de médicos a llamadas del servicio y respuestas JSON. |
| `controllers/ClienteController.php` | Controla las operaciones HTTP del CRUD de clientes. |
| `services/MedicoService.php` | Aplica validaciones y reglas de negocio de médicos. |
| `services/ClienteService.php` | Aplica validaciones y reglas de negocio de clientes. |
| `persistence/MedicoRepository.php` | Ejecuta las consultas PDO de persistencia de médicos. |
| `persistence/ClienteRepository.php` | Ejecuta las consultas PDO de persistencia de clientes. |
| `core/bootstrap.php` | Inicia la aplicación, carga dependencias y prepara PDO para las rutas. |
| `core/Router.php` | Compara método y URL, extrae parámetros y ejecuta el handler correspondiente. |
| `views/base.php` | Plantilla para renderizar secciones comunes de la interfaz web. |
| `test_simple.php` | Comprueba que PHP pueda ejecutarse correctamente en Apache. |
| `test_session.php` | Comprueba la creación y lectura de sesiones PHP. |
| `test_phpinfo.php` | Muestra información del entorno PHP para diagnóstico local. |
| `test_db.php` | Prueba de forma aislada la conexión PDO con MySQL. |
| `test_db2.php` | Diagnostica la conexión usando `127.0.0.1` y consulta la versión de MySQL. |
| `test_bootstrap.php` | Comprueba que el bootstrap y sus dependencias puedan cargarse. |

## `repositorio_backend`

| Archivo | Función |
|---|---|
| `index.php` | Punto de entrada de la copia independiente del backend. |
| `routes.php` | Registra las rutas disponibles para la API de esta variante. |
| `db.php` | Prepara la conexión, el esquema y los datos iniciales del backend. |
| `core/bootstrap.php` | Inicializa las dependencias mínimas del backend separado. |
| `core/Router.php` | Enrutador HTTP de la copia del backend. |
| `controllers/MedicoController.php` | Controlador JSON de médicos del backend separado. |
| `services/MedicoService.php` | Reglas de negocio de médicos en la variante backend. |
| `persistence/MedicoRepository.php` | Acceso PDO a médicos en la variante backend. |
| `README.md` | Explica cómo usar y entender el repositorio backend. |

## `repositorio_web`

| Archivo | Función |
|---|---|
| `configuracion.php` | Copia de la pantalla web de configuración. |
| `lista_medicos.php` | Copia de la vista de médicos y su consumo de la API. |
| `lista_prescripciones.php` | Copia de la vista de prescripciones, todavía con acceso SQL local. |
| `mis_rx.php` | Copia del panel visual del paciente. |
| `views/base.php` | Copia de la plantilla de secciones web. |
| `README.md` | Explica la estructura y el propósito del cliente web. |

## `repositorio_mobile`

| Archivo | Función |
|---|---|
| `README.md` | Describe el futuro cliente móvil y su integración prevista con la API. |
| `src/` | Directorio reservado para la implementación futura de la aplicación móvil. |

## Documentación Markdown

| Archivo | Función |
|---|---|
| `guia_estudio.md` | Guía didáctica general sobre PHP, SQL, CSS, JavaScript y arquitectura. |
| `explicacion_ingles_saludweb.md` | Glosario de términos técnicos en inglés usados por el proyecto. |
| `explicacion_linea_por_linea.md` | Explicación detallada de las vistas y su código. |
| `docs/arquitectura.md` | Describe las capas, responsabilidades y evolución arquitectónica. |
| `docs/api_first.md` | Documenta el contrato actual y propuesto de la API REST. |
| `docs/acceso_profesional_datos_php.md` | Explica PDO, consultas preparadas, Repository y validación. |
| `docs/autenticacion_aplicaciones_modernas.md` | Explica sesiones, JWT, OAuth/OIDC, roles y seguridad. |
| `docs/crud_clientes_api.md` | Documenta el CRUD de clientes con MySQL, PDO y Repository. |
| `docs/diagnostico_proyecto_base.md` | Registra el diagnóstico técnico y los pendientes del proyecto. |
| `docs/evolucion_profesional.md` | Explica la transición desde un monolito hacia una API desacoplada. |
| `docs/primera_api_php.md` | Guía para construir y probar la primera API PHP. |
| `repositorio_backend/README.md` | Documentación específica del backend separado. |
| `repositorio_web/README.md` | Documentación específica de la interfaz web. |
| `repositorio_mobile/README.md` | Documentación del cliente móvil futuro. |

## Relación entre las copias

La raíz es la versión integrada del proyecto. `repositorio_backend` separa la API y sus capas de servidor, mientras que `repositorio_web` conserva las vistas del cliente. Son copias de trabajo y pueden divergir: los cambios nuevos deben compararse con la raíz antes de replicarse. `repositorio_mobile` todavía funciona como espacio reservado para el futuro cliente móvil.

## Precauciones de desarrollo

Los archivos `db.php`, `test_phpinfo.php` y los archivos `test_*.php` están orientados al entorno local. No deben exponerse sin protección en producción porque pueden modificar el esquema, revelar información del servidor o mostrar detalles de conexión.
