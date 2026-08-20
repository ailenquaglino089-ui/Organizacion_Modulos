# Diagnóstico del Proyecto Base

**Práctica:** Programación IV · Sesión de análisis y planificación inicial  
**Sistema:** SaludWEB / Organización de Módulos  
**Fecha:** 2026-08-20  
**Estado:** Línea base previa a la próxima etapa de refactorización

## 1. Descripción general del sistema

SaludWEB es una aplicación web para organizar información de salud y recetas electrónicas. Permite consultar y administrar médicos, visualizar prescripciones, filtrar recetas y eliminar registros. El dominio identificado es **gestión de profesionales, pacientes, medicamentos y prescripciones médicas**.

### Tecnologías observadas

- **Backend y presentación:** PHP con Apache y `mod_rewrite`.
- **Base de datos:** MySQL.
- **Acceso a datos:** PDO y consultas preparadas en varias operaciones.
- **Cliente:** HTML, CSS y JavaScript del navegador.
- **Comunicación:** páginas renderizadas por PHP y endpoints REST que devuelven JSON.
- **Estado del repositorio:** rama `main`; último commit observado: `d9e9808`, `Separación de los tres repositorios`.

El proyecto se encuentra en una **etapa híbrida**. Cuenta con una separación por capas y una API para médicos, pero algunas pantallas todavía consultan MySQL y construyen HTML directamente. Esta observación es importante: la base ya contiene decisiones de Programación IV, aunque aún conserva responsabilidades del sistema tradicional.

**Captura de la interfaz principal:** pendiente de incorporar por el equipo al momento de ejecutar el sistema en el entorno local.

## 2. Mapa de componentes

| Componente | Archivo o carpeta | Responsabilidad identificada |
|---|---|---|
| Punto de entrada | `index.php` | Recibe las peticiones y delega el despacho al router. |
| Reescritura | `.htaccess` | Envía URLs que no son archivos o carpetas reales a `index.php`. |
| Inicialización | `core/bootstrap.php` | Inicia sesión, carga dependencias, conecta la aplicación y crea las capas. |
| Enrutamiento | `core/Router.php`, `routes.php` | Asocia método y URL con vistas o controladores. |
| Vista de médicos | `lista_medicos.php` | Renderiza el listado, formularios y acciones del panel de médicos. |
| Vista de recetas | `lista_prescripciones.php` | Renderiza filtros, tabla y acciones de prescripciones. También contiene consultas SQL. |
| Lógica de negocio | `services/MedicoService.php` | Valida nombre, existencia, campos permitidos y estado del médico. |
| Controlador HTTP | `controllers/MedicoController.php` | Lee JSON, invoca el servicio y genera respuestas JSON. |
| Persistencia | `persistence/MedicoRepository.php` | Ejecuta consultas de médicos mediante PDO. |
| Base de datos | `db.php` | Abre la conexión, crea base/tablas, ajusta claves e inserta datos iniciales. |
| Cliente asíncrono | JavaScript en `lista_medicos.php` | Consume la API de médicos con `fetch` para crear, editar, activar y eliminar. |
| Sesión | `core/bootstrap.php`, `routes.php` | Inicia la sesión y expone una ruta de logout. No se identificó un módulo completo de login/autorización. |

Además, el repositorio contiene `repositorio_backend/`, `repositorio_web/` y `repositorio_mobile/` como separación de responsabilidades o preparación para clientes independientes. Debe definirse en una próxima etapa si serán repositorios desplegables separados o módulos mantenidos dentro del mismo repositorio.

## 3. Problemas de diseño detectados

### 3.1 Vista con acceso directo a datos

- **Evidencia:** `lista_prescripciones.php`, líneas 18–38.
- **Tipo de mezcla:** Vista + DAL/persistencia.
- **Descripción:** la página construye el `SELECT`, aplica filtros, prepara la consulta, obtiene prescripciones y consulta el mapa de medicamentos mediante `$pdo`.
- **Impacto:** cambiar la fuente de datos o probar la consulta requiere cargar una vista web completa. También se duplica el patrón si otra interfaz necesita las mismas recetas.
- **Propuesta:** crear `PrescripcionRepository`, `PrescripcionService` y `PrescripcionController`; la vista debería recibir datos ya preparados o consumir `/api/prescripciones`.

### 3.2 Vista con transformación de dominio

- **Evidencia:** `lista_prescripciones.php`, línea 137 y bloque siguiente.
- **Tipo de mezcla:** Vista + lógica de aplicación.
- **Descripción:** la vista interpreta el JSON de medicamentos, busca nombres en un mapa y decide cómo representar dosis y datos faltantes.
- **Impacto:** las reglas de transformación quedan ligadas al HTML y no son reutilizables por el cliente mobile o por otra salida de datos.
- **Propuesta:** mover la normalización de medicamentos al servicio o a un DTO/transformador de prescripciones. La vista solo debería iterar una estructura lista para mostrar.

### 3.3 Ruta con SQL directo para prescripciones

- **Evidencia:** `routes.php`, líneas 156–173.
- **Tipo de mezcla:** Router + DAL + respuesta HTTP.
- **Descripción:** la ruta `DELETE /api/prescripciones/{id}` prepara SQL, ejecuta la eliminación, decide el código HTTP y construye el JSON.
- **Impacto:** el router conoce detalles de persistencia y la operación no puede reutilizarse limpiamente desde otro controlador o servicio.
- **Propuesta:** mover la consulta a `PrescripcionRepository`, la regla de eliminación a `PrescripcionService` y la respuesta a `PrescripcionController`.

### 3.4 Inicialización, esquema y datos de prueba concentrados

- **Evidencia:** `db.php`, líneas 1–218 aproximadamente.
- **Tipo de mezcla:** Infraestructura + migraciones + seed + presentación de errores.
- **Descripción:** el mismo archivo configura errores, conecta a MySQL, crea la base, crea tablas, modifica claves, inserta datos iniciales y genera HTML si falla la conexión.
- **Impacto:** cada arranque puede modificar el esquema; los despliegues y las pruebas quedan acoplados a la base local; el backend termina con una respuesta HTML de error mezclada con la configuración.
- **Propuesta:** separar configuración, migraciones versionadas, seed de desarrollo y un manejador de errores HTTP/JSON.

### 3.5 Autenticación incompleta o no centralizada

- **Evidencia:** `core/bootstrap.php`, línea 13, inicia sesión; `routes.php`, líneas 97–102, solo implementa logout.
- **Tipo de mezcla o ausencia:** sesión sin módulo de autenticación/autorización verificable.
- **Impacto:** no queda documentado quién puede consultar, crear, modificar o eliminar información médica. Es un riesgo funcional y de seguridad antes de publicar la API.
- **Propuesta:** definir casos de uso de autenticación, middleware de autorización, roles y política de sesión o tokens. Proteger especialmente las operaciones de escritura y eliminación.

## 4. Composición del equipo y dominio

### Dominio acordado

**SaludWEB: gestión de profesionales y prescripciones médicas electrónicas.** Entidades principales: `pacientes`, `medicos`, `medicamentos`, `prescripciones`, `obras_sociales`, `triages` y `auditoria`.

### Roles

Completar con los nombres reales del equipo antes de entregar:

| Integrante | Rol | Responsabilidad |
|---|---|---|
| `[Nombre]` | Tech Lead | Decisiones arquitectónicas, revisión e integración. |
| `[Nombre]` | Dev Backend | Servicios, repositorios, API y reglas de negocio. |
| `[Nombre]` | Dev Frontend | Vistas, navegación y consumo de la API. |
| `[Nombre]` | QA / Documentador | Pruebas, checklist, documentación y evidencias. |

En equipos de 2 o 3 personas, los roles pueden compartirse, pero cada tarea debe tener una persona responsable.

**URL pública del repositorio:** pendiente de completar.  
**Ruta local analizada:** `c:\xampp\htdocs\Organizacion_Modulos`

## 5. Plan preliminar de mejora

La primera prioridad será extraer prescripciones de las vistas y completar su API REST, manteniendo el contrato JSON documentado. Luego se separarán configuración, migraciones y datos de prueba de `db.php`. En paralelo se definirá autenticación y autorización para proteger operaciones sensibles. Después se migrarán las pantallas para cargar datos mediante `fetch`, reduciendo la dependencia del renderizado PHP. Cada paso deberá acompañarse con pruebas de repositorio, servicio y endpoints, además de una actualización del diagrama y del README.

## Checklist de cierre

- [x] Se identificaron las tecnologías y el dominio del sistema.
- [x] Se listaron componentes de vistas, negocio, datos y sesión.
- [x] Se documentaron más de 3 mezclas concretas con archivo, línea, impacto y propuesta.
- [x] Se identificó la rama `main` y el commit actual del repositorio.
- [ ] El sistema fue ejecutado correctamente en un entorno del equipo.
- [ ] Se incorporó una captura de la interfaz principal.
- [ ] Se completaron nombres y roles reales.
- [ ] Se agregó la URL pública del repositorio.
- [ ] Se creó o verificó un `README.md` con integrantes y tecnologías.
- [ ] Se creó o verificó un `.gitignore` adecuado para PHP, Apache y archivos sensibles.
- [ ] Se confirmó que no hay credenciales sensibles ni archivos binarios versionados.
- [ ] El equipo acordó canal de comunicación y responsables.

## Conclusión

El sistema tiene una base válida para profesionalizarse: ya aplica Front Controller, Router, inyección de dependencias, Service, Repository y una API REST parcial. El principal riesgo actual es la coexistencia de SQL, reglas de transformación y HTML en las pantallas de prescripciones, junto con la falta de una autenticación verificable. Este diagnóstico establece una línea base concreta para refactorizar sin perder la funcionalidad existente.
