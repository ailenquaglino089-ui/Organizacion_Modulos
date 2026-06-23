# Documentación del Proyecto - Organización Módulos (SaludWEB)

## Arquitectura por Capas

El proyecto sigue una arquitectura en **3 capas + router + controlador**:

```
[Usuario/Navegador]
       ↓  (fetch / URL)
    Router (routes.php)
       ↓
  Controlador (MedicoController)
       ↓
   Servicio - Capa de Negocio (MedicoService)
       ↓
  Repositorio - Capa de Persistencia (MedicoRepository)
       ↓
   Base de Datos MySQL
```

---

## Glosario Inglés → Español

### Conceptos Generales

| Inglés | Español | Explicación |
|--------|---------|-------------|
| **Router** | Enrutador / Ruteador | Clase que asocia cada URL (ruta) con el código que debe ejecutarse |
| **Controller** | Controlador | Capa que maneja las peticiones HTTP (request/response) |
| **Service** | Servicio | Capa de negocio con validaciones y reglas de la aplicación |
| **Repository** | Repositorio | Capa que solo accede a la base de datos (consultas SQL) |
| **CRUD** | ABM (Alta, Baja, Modificación) | Create (POST), Read (GET), Update (PUT/PATCH), Delete (DELETE) |
| **REST API** | API REST | Arquitectura de APIs que usa verbos HTTP para operar recursos |
| **Middleware** | Intermediario | Código que se ejecuta antes de llegar al controlador (ej: seguridad) |
| **Handler** | Manejador | Función que se ejecuta cuando una ruta coincide |
| **Dispatch** | Despachar | Proceso de buscar y ejecutar la ruta correspondiente a una URL |
| **Bootstrap** | Arranque / Inicialización | Archivo que prepara todo antes de ejecutar la aplicación |
| **Front Controller** | Controlador Frontal | Un solo punto de entrada (index.php) que recibe todas las peticiones |

### JavaScript

| Inglés | Español | Explicación |
|--------|---------|-------------|
| **fetch()** | Solicitud HTTP | Función para hacer peticiones al servidor sin recargar la página |
| **async / await** | Asíncrono / Esperar | Sintaxis para trabajar con promesas (operaciones que tardan) |
| **try / catch** | Intentar / Capturar | Bloque para manejar errores |
| **JSON** | Formato JSON | JavaScript Object Notation - formato de texto para intercambiar datos |
| **JSON.stringify()** | Convertir a JSON | Convierte un objeto JavaScript a string JSON |
| **response.ok** | Respuesta correcta | true si el status HTTP está entre 200 y 299 |
| **event.preventDefault()** | Prevenir comportamiento | Evita que un formulario recargue la página al enviarse |
| **confirm()** | Confirmar | Muestra un cuadro de diálogo con Aceptar / Cancelar |
| **console.error()** | Error en consola | Muestra un mensaje de error en la consola del navegador |
| **addEventListener()** | Agregar evento | Asocia una función a un evento del DOM (click, submit, etc.) |
| **classList.add() / .remove()** | Agregar/Quitar clase | Manipula las clases CSS de un elemento HTML |
| **DOM** | Árbol HTML | Document Object Model - estructura de la página web |
| **trim()** | Recortar | Elimina espacios en blanco al inicio y final de un string |
| **location.reload()** | Recargar página | Recarga la página actual en el navegador |

### PHP

| Inglés | Español | Explicación |
|--------|---------|-------------|
| **PDO** | PHP Data Objects | Extensión de PHP para conectar a bases de datos de forma segura |
| **query()** | Consultar | Ejecuta una consulta SQL directa (sin parámetros) |
| **prepare()** | Preparar | Prepara una consulta SQL con marcadores `?` para prevenir inyección SQL |
| **execute()** | Ejecutar | Ejecuta una consulta preparada con los valores reales |
| **fetch()** | Obtener fila | Obtiene una sola fila del resultado de una consulta |
| **fetchAll()** | Obtener todas | Obtiene TODAS las filas del resultado como un arreglo |
| **fetchColumn()** | Obtener columna | Obtiene la primera columna de la primera fila |
| **rowCount()** | Contar filas | Cantidad de filas afectadas por la consulta (INSERT, UPDATE, DELETE) |
| **lastInsertId()** | Último ID | ID autogenerado por AUTO_INCREMENT en la última inserción |
| **htmlspecialchars()** | Escapar HTML | Convierte `< > & "` en entidades HTML (seguridad contra XSS) |
| **parse_url()** | Analizar URL | Descompone una URL en sus partes (protocolo, host, path, query) |
| **implode()** | Unir array | Une los elementos de un array en un string con un separador |
| **explode()** | Dividir string | Divide un string en un array usando un separador |
| **trim()** | Recortar | Elimina espacios en blanco al inicio y final |
| **str_starts_with()** | Empieza con | Verifica si un string empieza con otro string |
| **str_ends_with()** | Termina con | Verifica si un string termina con otro string |
| **array_key_exists()** | Existe clave | Verifica si una clave existe en un array (incluso si es null) |
| **isset()** | Está definido | Verifica si una variable existe y no es null |
| **empty()** | Vacío | Verifica si está vacío (null, '', false, 0, []) |
| **require_once** | Incluir una vez | Incluye un archivo PHP solo si no fue incluido antes |
| **include** | Incluir | Incluye y evalúa un archivo PHP |
| **session_start()** | Iniciar sesión | Inicia o reanuda una sesión de usuario |
| **session_destroy()** | Destruir sesión | Elimina todos los datos de la sesión actual |
| **header()** | Cabecera HTTP | Envía una cabecera HTTP (redirección, content-type, etc.) |
| **http_response_code()** | Código de respuesta | Establece el código HTTP de la respuesta (200, 404, 500, etc.) |
| **json_encode()** | Codificar JSON | Convierte un array/objeto PHP a string JSON |
| **json_decode()** | Decodificar JSON | Convierte un string JSON a array/objeto PHP |
| **file_get_contents()** | Leer archivo | Lee el contenido de un archivo o flujo (php://input) |
| **call_user_func_array()** | Llamar función | Llama a una función pasándole un array como argumentos |
| **is_callable()** | Es llamable | Verifica si una variable es una función o método invocable |
| **is_string()** | Es string | Verifica si una variable es de tipo texto |
| **getenv()** | Variable de entorno | Lee una variable del entorno del sistema operativo |
| **dirname()** | Directorio padre | Obtiene el nombre del directorio padre de una ruta |
| **rtrim()** | Recortar por derecha | Elimina caracteres del final de un string |

### Base de Datos y SQL

| Inglés | Español | Explicación |
|--------|---------|-------------|
| **AUTO_INCREMENT** | Auto-incremental | Columna que se incrementa automáticamente con cada nueva fila |
| **PRIMARY KEY** | Clave primaria | Identificador único de cada fila en una tabla |
| **FOREIGN KEY** | Clave foránea | Referencia a la clave primaria de otra tabla (relación) |
| **ON DELETE CASCADE** | Eliminar en cascada | Si se borra el padre, se borran los hijos automáticamente |
| **ON DELETE SET NULL** | Poner null al borrar | Si se borra el padre, la referencia de los hijos se pone null |
| **UNIQUE** | Único | No permite valores duplicados en esa columna |
| **INDEX** | Índice | Acelera las búsquedas en esa columna |
| **LEFT JOIN** | Unión izquierda | Une dos tablas manteniendo todas las filas de la izquierda |
| **ORDER BY** | Ordenar por | Ordena los resultados (ASC = ascendente, DESC = descendente) |
| **WHERE** | Donde | Filtra las filas que cumplen una condición |
| **INSERT INTO** | Insertar en | Agrega una nueva fila a la tabla |
| **UPDATE** | Actualizar | Modifica filas existentes |
| **DELETE FROM** | Eliminar de | Borra filas de la tabla |
| **SELECT** | Seleccionar | Obtiene datos de la tabla |
| **InnoDB** | Motor InnoDB | Motor de MySQL que soporta transacciones y claves foráneas |
| **utf8mb4** | Codificación UTF-8 | Codificación que soporta caracteres especiales (tildes, ñ, emojis) |

### HTTP

| Inglés | Español | Explicación |
|--------|---------|-------------|
| **GET** | Obtener | Verbo HTTP para solicitar datos (leer) |
| **POST** | Crear | Verbo HTTP para crear un recurso (alta) |
| **PUT** | Actualizar | Verbo HTTP para actualizar un recurso completo |
| **PATCH** | Modificar | Verbo HTTP para actualizar parcialmente un recurso |
| **DELETE** | Eliminar | Verbo HTTP para borrar un recurso |
| **200 OK** | 200 Correcto | La petición fue exitosa |
| **201 Created** | 201 Creado | El recurso se creó exitosamente |
| **400 Bad Request** | 400 Solicitud Incorrecta | Los datos enviados son inválidos |
| **404 Not Found** | 404 No Encontrado | El recurso solicitado no existe |
| **500 Internal Server Error** | 500 Error Interno | Error inesperado en el servidor |
| **Content-Type** | Tipo de contenido | Indica el formato de los datos (application/json) |
| **Location** | Ubicación | Cabecera usada en redirecciones (header Location) |
| **Query String** | Cadena de consulta | Parámetros en la URL después del `?` (ej: ?id=5) |

### CSS

| Inglés | Español | Explicación |
|--------|---------|-------------|
| **box-shadow** | Sombra de caja | Agrega una sombra alrededor de un elemento |
| **border-radius** | Borde redondeado | Redondea las esquinas de un elemento |
| **flex-wrap** | Envolver flex | Permite que los elementos flexibles pasen a la siguiente línea |
| **justify-content** | Justificar contenido | Distribuye el espacio entre elementos flexibles |
| **align-items** | Alinear elementos | Alinea los elementos en el eje transversal |
| **z-index** | Índice Z | Controla qué elemento se superpone a otro |
| **position: fixed** | Posición fija | El elemento queda fijo en la pantalla aunque se scrollee |
| **display: none** | No mostrar | Oculta el elemento de la página |
| **display: flex** | Mostrar como flex | Activa el modo de caja flexible |
| **overflow-x** | Desborde horizontal | Controla cómo se muestra el contenido que desborda |
| **transition** | Transición | Animación suave entre dos estados de un elemento |
| **hover** | Al pasar el mouse | Estado de un elemento cuando el mouse está encima |
| **media query** | Consulta de medios | Regla CSS que se aplica según el tamaño de pantalla |
| **responsive** | Adaptable | Diseño que se adapta a diferentes tamaños de pantalla |
| **gradient (linear-gradient)** | Degradado | Transición suave entre dos o más colores |

---

## Explicación de las Capas

### 1. Capa de Presentación (Frontend)

Archivos: `lista_medicos.php`, `lista_prescripciones.php`, `mis_rx.php`, `configuracion.php`, `views/base.php`

- Contiene HTML, CSS y JavaScript
- Se comunica con el backend mediante **fetch()** (JavaScript asíncrono)
- Las URLs se construyen dinámicamente con `$basePath` para que funcionen desde cualquier subdirectorio
- Los datos se cargan inicialmente desde el servidor (PHP) y las operaciones CRUD se hacen vía API (fetch)

### 2. Router (Enrutador)

Archivos: `core/Router.php`, `routes.php`

- Toma la URL que el usuario visita y decide qué código ejecutar
- Soporta parámetros dinámicos: `/medicos/{id}` captura el ID de la URL
- Soporta los 5 verbos HTTP: GET, POST, PUT, PATCH, DELETE
- Si ninguna ruta coincide, ejecuta el manejador 404 (que redirige al inicio)

### 3. Capa de Controlador (HTTP)

Archivos: `controllers/MedicoController.php`

- Recibe la petición HTTP (datos JSON del body, parámetros de la URL)
- Llama al Servicio (capa de negocio)
- Devuelve la respuesta JSON con el código HTTP adecuado
- NO contiene lógica de negocio ni consultas SQL

### 4. Capa de Negocio (Service)

Archivos: `services/MedicoService.php`

- Contiene todas las **reglas de negocio** y validaciones
- Valida que el nombre sea obligatorio antes de crear
- Verifica que un médico exista antes de actualizar o eliminar
- Limpia y prepara los datos antes de enviarlos al repositorio
- NO tiene código SQL ni código HTTP

### 5. Capa de Persistencia (Repository)

Archivos: `persistence/MedicoRepository.php`

- Solo contiene consultas SQL
- Se conecta a MySQL usando PDO con consultas preparadas (seguridad)
- Métodos: obtenerTodos, obtenerPorId, crear, actualizar, eliminar
- NO tiene lógica de negocio
- Usa **marcadores `?`** en las consultas para prevenir inyección SQL

### 6. Bootstrap (Inicialización)

Archivos: `core/bootstrap.php`

- Se ejecuta al inicio de cada petición
- Carga todos los archivos necesarios (require_once)
- Crea las instancias de Router, Repositorio, Servicio
- Conecta a la base de datos

---

## Patrones de Diseño Utilizados

### Front Controller (Controlador Frontal)
- `index.php` es el único punto de entrada del proyecto
- Todas las peticiones pasan por él gracias al `.htaccess`
- Ventaja: centraliza la lógica de routing, seguridad, logging

### Inyección de Dependencias
- Las dependencias se pasan desde afuera en lugar de crearse adentro
- `MedicoController` recibe `MedicoService`
- `MedicoService` recibe `MedicoRepository`
- `MedicoRepository` recibe `PDO`
- Ventaja: código más testeable, flexible y desacoplado

### Repository Pattern (Patrón Repositorio)
- Separa la lógica de acceso a datos del resto de la aplicación
- Centraliza todas las consultas SQL en un solo lugar
- Facilita cambiar de base de datos en el futuro

### RESTful API
- Usa los verbos HTTP para representar operaciones CRUD
- GET = leer, POST = crear, PUT/PATCH = actualizar, DELETE = borrar
- Las respuestas son en formato JSON

---

## Códigos de Estado HTTP

| Código | Significado | Uso |
|--------|-------------|-----|
| 200 | OK (Correcto) | GET, PUT, PATCH, DELETE exitosos |
| 201 | Created (Creado) | POST exitoso (recurso creado) |
| 302 | Found (Redirección) | Redirección a otra URL |
| 400 | Bad Request | Datos inválidos enviados por el cliente |
| 404 | Not Found | Recurso no encontrado |
| 500 | Internal Server Error | Error interno del servidor |

---

## Estructura del Proyecto

```
Organizacion_Modulos/
├── index.php                 → Punto de entrada (Front Controller)
├── .htaccess                 → Reescribe URLs hacia index.php
├── routes.php                → Definición de rutas
├── db.php                    → Conexión MySQL y creación de tablas
│
├── core/
│   ├── bootstrap.php         → Inicialización del sistema
│   └── Router.php            → Clase enrutadora de URLs
│
├── controllers/
│   └── MedicoController.php  → Controlador HTTP de médicos
│
├── services/
│   └── MedicoService.php     → Lógica de negocio de médicos
│
├── persistence/
│   └── MedicoRepository.php  → Consultas SQL de médicos
│
├── views/
│   └── base.php             → Vista genérica para páginas secundarias
│
├── lista_medicos.php         → Vista: listado y CRUD de médicos
├── lista_prescripciones.php  → Vista: listado de recetas
├── mis_rx.php                → Vista: dashboard del paciente
├── configuracion.php         → Vista: ajustes del usuario
│
└── docs/
    └── arquitectura.md       → Este documento
```
