# Guía de Traducción y Explicación de Código (SaludWeb)

Esta guía explica en detalle todos los términos, conceptos y palabras en inglés que aparecen en el proyecto **SaludWeb - Organización de Módulos**, además de resumir el propósito y funcionamiento clave de cada archivo. Está diseñada para ayudarte a estudiar y entender cómo se conecta el código con la teoría de programación web (PHP, JavaScript, CSS y bases de datos).

---

## 🗺️ Índice de Archivos
1. [index.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACI%C3%93N%203/Organizacion_Modulos/index.php) - Menú de Entrada
2. [configuracion.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACI%C3%93N%203/Organizacion_Modulos/configuracion.php) - Ajustes y Configuración
3. [lista_medicos.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACI%C3%93N%203/Organizacion_Modulos/lista_medicos.php) - Gestión de Profesionales
4. [lista_prescripciones.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACI%C3%93N%203/Organizacion_Modulos/lista_prescripciones.php) - Recetario Digital
5. [mis_rx.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACI%C3%93N%203/Organizacion_Modulos/mis_rx.php) - Dashboard del Paciente
6. [guia_estudio.md](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACI%C3%93N%203/Organizacion_Modulos/guia_estudio.md) - Resumen Teórico

---

## 1. `index.php` (Menú Principal)
### 📋 ¿Qué hace y por qué es importante?
Es el punto de entrada o "home" del módulo. Su función principal es redirigir al usuario hacia las diferentes pantallas del sistema (Configuración, Médicos, Prescripciones y MRx Digital). 

### 🔤 Explicación de términos en inglés:
* **`require_once`** (en español: *requiere una vez*): Instrucción de PHP que importa un archivo externo (en este caso, la conexión a la base de datos `../db.php`). Si el archivo no existe, el programa se detiene inmediatamente con un error. La palabra `once` asegura que no se importe el archivo más de una vez para evitar errores de duplicación de funciones.
* **`echo`** (en español: *hacer eco / mostrar*): Comando de PHP que sirve para imprimir o renderizar texto e instrucciones HTML en la pantalla del usuario.
* **`Pro`** (en español: *Profesional*): Abreviatura de "Professional", utilizada en el título para denotar una versión avanzada de la aplicación.
* **`ul`** (*Unordered List* / Lista desordenada) y **`li`** (*List Item* / Elemento de lista): Etiquetas HTML para crear listas con viñetas.
* **`a href`** (*Anchor Hypertext Reference* / Referencia de hipertexto de ancla): Etiqueta HTML que define un enlace o hipervínculo hacia otra página.

---

## 2. `configuracion.php` (Ajustes de Usuario)
### 📋 ¿Qué hace y por qué es importante?
Permite al usuario gestionar su cuenta: activar notificaciones, habilitar seguridad de doble factor (2FA), descargar sus datos personales o contactar con soporte. Es un módulo frontend que simula interacciones interactivas.

### 🔤 Explicación de términos en inglés:
#### En Estilos (CSS):
* **`:root`** (en español: *raíz*): Pseudo-clase CSS que hace referencia al elemento raíz del documento (normalmente la etiqueta `<html>`). Se utiliza para declarar variables globales que se pueden reutilizar en todo el diseño.
* **`--primary`, `--bg`, `--text`, `--success`**: Nombres de variables CSS creadas por el programador.
  * `primary` = primario (color azul/índigo principal).
  * `bg` = background (color de fondo de la pantalla).
  * `text` = texto (color del texto general).
  * `success` = éxito (color verde para estados activos u operacionales).
* **`display: flex` / `justify-content` / `align-items` / `flex-wrap` / `gap`**: Propiedades de **Flexbox** (caja flexible), un modelo de diseño que organiza elementos en filas o columnas de forma dinámica.
  * `flex-wrap: wrap` = permite que los elementos salten a la siguiente línea si no caben.
  * `gap` = espacio o separación entre los elementos dentro de la caja.
* **`display: grid` / `grid-template-columns: repeat(auto-fit, minmax(120px, 1fr))`**: Propiedades de **CSS Grid** (rejilla). Define una cuadrícula responsiva donde las columnas se adaptan automáticamente (`auto-fit`) midiendo como mínimo `120px` y como máximo una fracción del espacio disponible (`1fr`).
* **`box-shadow`** (en español: *sombra de caja*): Agrega efectos de sombra alrededor de un elemento para darle profundidad visual.
* **`@media (max-width: 768px)`** (*Media Query* / Consulta de medios): Regla CSS que aplica estilos específicos cuando la pantalla mide `768 píxeles` de ancho o menos (generalmente teléfonos celulares o tabletas).

#### En Clases HTML (Class Names):
* **`container`** = contenedor.
* **`header` / `header-actions`** = cabecera / acciones de la cabecera.
* **`back-link`** = enlace de retorno o enlace para volver atrás.
* **`nav-menu` / `nav-item` / `active`** = menú de navegación / ítem o pestaña de navegación / elemento activo o seleccionado.
* **`btn-primary` / `btn-secondary` / `btn-danger`** = botones de estilo primario (azul), secundario (gris) o de peligro/alerta (rojo).

#### En Interacción (JavaScript / Conceptos):
* **`2FA`** (*Two-Factor Authentication* / Autenticación de dos factores): Medida de seguridad que requiere un segundo paso para verificar la identidad (ej. un código enviado al celular).
* **`JSON`** (*JavaScript Object Notation* / Notación de Objetos de JavaScript): Formato liviano para almacenar e intercambiar datos estructurados en forma de texto.
* **`onclick`** (en español: *al hacer clic*): Atributo HTML que ejecuta una función de JavaScript cuando el usuario hace clic sobre el elemento.
* **`alert`** (en español: *alerta*): Función de JavaScript que muestra un cuadro con un mensaje emergente en el navegador.
* **`confirm`** (en español: *confirmar*): Función que muestra una pregunta emergente con botones de "Aceptar" y "Cancelar", devolviendo un valor verdadero o falso según la respuesta del usuario.
* **`FAQ`** (*Frequently Asked Questions* / Preguntas Frecuentes).
* **`logout.php`** (en español: *cerrar sesión*): Script de PHP encargado de destruir la sesión del usuario.

---

## 3. `lista_medicos.php` (Gestión de Profesionales)
### 📋 ¿Qué hace y por qué es importante?
Muestra a los médicos registrados. Permite habilitar o inhabilitar su estado mediante un botón que interactúa asíncronamente con una API (sin recargar la pantalla completa).

### 🔤 Explicación de términos en inglés:
#### Base de Datos (SQL):
* **`SELECT * FROM medicos ORDER BY activo DESC, nombre ASC`**:
  * `SELECT *` = selecciona todas las columnas de la tabla.
  * `FROM medicos` = desde la tabla llamada `medicos`.
  * `ORDER BY` = ordena las filas según los criterios especificados.
  * `activo DESC` = ordena la columna `activo` de forma descendente (de mayor a menor: los valores `1`/Activo primero, luego los `0`/Inactivo).
  * `nombre ASC` = ordena alfabéticamente por la columna `nombre` de forma ascendente (de la A a la Z).
* **`fetchAll(PDO::FETCH_ASSOC)`**:
  * `fetchAll` = obtener todos los registros que coincidieron con la búsqueda.
  * `PDO::FETCH_ASSOC` = formato de recuperación de datos como un **array asociativo**, donde los nombres de las columnas de la base de datos se convierten en las claves del array (ej. `$medico['nombre']`).

#### Estructura y Estilos CSS:
* **`card`** = tarjeta (un recuadro blanco para agrupar el contenido).
* **`badge`** = insignia o etiqueta pequeña (usada para el estado OPERATIVO o INACTIVO).
* **`white-space: nowrap`** = impide que los textos de la tabla se dividan en varios renglones, manteniéndolos en una sola línea continua.
* **`overflow-x: auto`** = activa una barra de desplazamiento horizontal en celulares si la tabla es demasiado ancha para la pantalla.
* **`N/A`** (*Not Available* / No disponible o no aplica): Valor por defecto cuando un médico no tiene matrícula cargada.

#### Lógica Asíncrona (JavaScript / Fetch):
* **`async function toggleMedico(id, nuevoEstado)`**:
  * `async` (asíncrona) = declara que la función contiene código que no se ejecuta inmediatamente (operaciones de red que toman tiempo). Permite el uso del operador `await`.
  * `toggle` (alternar) = término usado para cambiar entre dos estados opuestos (como prender y apagar).
* **`fetch(apiUrl, { method: 'PATCH', ... })`**:
  * `fetch` = función moderna de JS para realizar peticiones HTTP en segundo plano (AJAX).
  * `PATCH` = método HTTP que indica que queremos actualizar o modificar **parcialmente** un recurso en el servidor (en este caso, solo el campo `activo` del médico).
* **`headers: { 'Content-Type': 'application/json' }`**:
  * `headers` = cabeceras HTTP. Proveen información adicional sobre la petición.
  * `Content-Type` = tipo de contenido. Indica que los datos que enviamos están formateados como texto JSON.
* **`body: JSON.stringify(...)`**:
  * `body` = el cuerpo del mensaje de la petición.
  * `JSON.stringify` = convierte un objeto de JavaScript en una cadena de texto plana con formato JSON para que el servidor PHP pueda leerlo.
* **`response.ok`**: Propiedad que verifica si el servidor respondió con éxito (código de estado HTTP entre 200 y 299).
* **`location.reload()`**: Función que recarga la página actual para actualizar visualmente la lista.
* **`try / catch`** (en español: *intentar / capturar*): Estructura para el manejo de excepciones. Intenta ejecutar un bloque de código y, si ocurre un error (por ejemplo, si se corta internet), lo captura en la sección `catch` para evitar que la aplicación falle silenciosamente.

---

## 4. `lista_prescripciones.php` (Recetario Digital)
### 📋 ¿Qué hace y por qué es importante?
Permite filtrar recetas médicas por estado (Activas, Dispensada, Vencidas, Canceladas). Decodifica medicamentos guardados en formato JSON y permite eliminarlos de forma asíncrona mediante el método HTTP `DELETE`.

### 🔤 Explicación de términos en inglés:
#### Lógica PHP y SQL:
* **`LEFT JOIN`** (en español: *Unión por la izquierda*): Operación SQL que une la tabla principal (`prescripciones` a la izquierda) con tablas secundarias (`pacientes` y `medicos` a la derecha) usando claves foráneas (`id_paciente`, `id_medico`). Devuelve todos los registros de la izquierda, incluso si no tienen una correspondencia exacta en las tablas de la derecha.
* **`PDO::FETCH_KEY_PAIR`**: Modo de PDO que genera un array de dos columnas donde la primera columna actúa como clave (*key*) y la segunda como valor (*value*). Esto crea un diccionario rápido para buscar medicamentos por su ID (ej. `[1 => 'Aspirina']`).
* **`json_decode($p['medicamentos'], true)`**:
  * `json_decode` = función de PHP que convierte un texto JSON en un array u objeto nativo de PHP para poder recorrerlo con código.
  * `true` = le dice a PHP que convierta el JSON en un array asociativo.
* **`foreach`** (en español: *para cada uno*): Bucle de PHP especializado en recorrer arrays elemento por elemento.

#### Conceptos de la Interfaz:
* **`MRx Digital`**: El nombre comercial del módulo.
  * **`Rx`**: Abreviatura internacional para recetas médicas o prescripciones. Proviene del latín *recipe* (que significa "toma esto").
* **`estado-dispensada`**:
  * `dispensada` = se refiere a que la receta ya fue presentada y entregada (dispensada) con éxito en la farmacia.

#### JavaScript y DOM:
* **`method: 'DELETE'`**: Método HTTP que indica la intención de eliminar permanentemente un recurso en el servidor.
* **`response.json()`**: Método asíncrono que lee la respuesta del servidor y la decodifica de formato JSON a un objeto JavaScript.
* **`document.getElementById('fila-' + id).remove()`**:
  * `document.getElementById` = busca un elemento en el documento HTML usando su identificador único (`id`).
  * `remove()` = método que elimina ese elemento HTML directamente del DOM, haciendo que desaparezca de la pantalla inmediatamente sin necesidad de recargar la página entera.

---

## 5. `mis_rx.php` (Dashboard del Paciente)
### 📋 ¿Qué hace y por qué es importante?
Es el panel o menú gráfico que utiliza el paciente. Contiene tarjetas para navegar hacia las recetas, notificaciones, prestaciones médicas y buscadores de farmacias. También provee datos de contacto técnico y estados de diagnóstico de la plataforma.

### 🔤 Explicación de términos en inglés:
* **`dashboard`** (en español: *panel de control*): Interfaz gráfica que resume la información y accesos principales del sistema.
* **`date('d/m/Y H:i')`**: Función de PHP para obtener la fecha y hora.
  * `d` = day (día con dos dígitos).
  * `m` = month (mes con dos dígitos).
  * `Y` = year (año con cuatro dígitos).
  * `H` = hour (hora en formato de 24 horas).
  * `i` = minutes (minutos con ceros iniciales).
* **`alert-info`** = estilo CSS diseñado para dar formato visual de color azul a cuadros de alerta informativa.

---

## 6. `guia_estudio.md` (Diagramas y Resumen Teórico)
### 📋 ¿Qué hace y por qué es importante?
Este es un archivo Markdown redactado en español que sirve como material de estudio. Contiene explicaciones de los módulos y conceptos de PHP, JavaScript y bases de datos.

### 🔤 Explicación de términos en inglés:
* **`graph TD`** (*Mermaid Diagram*): Sintaxis de la biblioteca Mermaid para generar diagramas. `graph` define que es un grafo y `TD` significa *Top-Down* (diseño vertical, de arriba hacia abajo).
* **`Inyección SQL`** (*SQL Injection*): Vulnerabilidad de seguridad informática en la que un atacante puede insertar código SQL malicioso en los campos de entrada de un formulario para manipular o robar información de la base de datos.
* **`ON DELETE CASCADE`** (en español: *Al borrar, borrar en cascada*): Regla de integridad en bases de datos relacionales. Si se elimina un registro principal (ej. un paciente), se borrarán de manera automática todos sus registros relacionados (ej. sus recetas médicas asociadas), evitando dejar datos huérfanos.

---

## 💡 Resumen Rápido para Exámenes: Conceptos Clave del Proyecto
Para tus exámenes de programación, recuerda estas equivalencias e ideas esenciales:

1. **AJAX (Asynchronous JavaScript and XML)**: Técnica que permite actualizar partes de una página web cargando datos desde el servidor en segundo plano utilizando `fetch()`, sin necesidad de recargar la pantalla completa (como se hace al activar médicos o eliminar recetas).
2. **Métodos HTTP**:
   * **`GET`**: Solicita información al servidor (ej. cuando filtramos recetas en `lista_prescripciones.php`).
   * **`PATCH`**: Actualiza parcialmente un recurso (ej. cambiar solo el estado de operativo/inactivo de un médico).
   * **`DELETE`**: Borra un recurso (ej. eliminar permanentemente una receta).
3. **PDO (PHP Data Objects)**: Capa de abstracción segura para bases de datos en PHP.
   * **`prepare()` + `execute()`**: Sentencias preparadas. Separan las variables del código SQL, anulando por completo las amenazas de inyección de código SQL malicioso.
