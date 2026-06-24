# Explicación Línea por Línea de los Módulos de SaludWeb Pro

Este documento contiene la explicación detallada línea por línea de los 5 archivos del sistema SaludWeb Pro que integran la administración y visualización de recursos médicos y de pacientes:

1. [configuracion.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/configuracion.php)
2. [index.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/index.php)
3. [lista_medicos.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_medicos.php)
4. [lista_prescripciones.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_prescripciones.php)
5. [mis_rx.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/mis_rx.php)

---

## 1. configuracion.php

Este archivo renderiza la interfaz gráfica para gestionar preferencias del usuario (notificaciones, seguridad 2FA, descargas de datos y soporte técnico).

### Bloque de Inicialización y Documentación PHP (Líneas 1-8)
*   **Línea 1 (`<?php`):** Apertura de la etiqueta PHP. Indica al servidor que comience a interpretar código PHP.
*   **Líneas 2 a 7 (`/** ... */`):** Comentario multilínea (PHPDoc) que documenta el propósito del archivo, especificando que es un módulo frontend de interacciones simuladas.
*   **Línea 8 (`?>`):** Cierre de la etiqueta PHP. Todo lo que sigue se envía directamente al navegador como HTML/CSS puro.

### Estructura HTML y Metadatos de Cabecera (Líneas 9-14)
*   **Línea 9 (`<!DOCTYPE html>`):** Declaración que define que el archivo contiene un documento HTML5.
*   **Línea 10 (`<html lang="es">`):** Abre la etiqueta del documento web configurándolo en idioma español.
*   **Línea 11 (`<head>`):** Apertura de la sección de metadatos y recursos del navegador (no visibles en el canvas principal).
*   **Línea 12 (`<meta charset="UTF-8">`):** Define la codificación de caracteres a UTF-8 para admitir caracteres especiales como tildes y la "ñ".
*   **Línea 13 (`<meta name="viewport" content="width=device-width, initial-scale=1.0">`):** Configuración de escala para el diseño responsivo en móviles.
*   **Línea 14 (`<title>Ajustes | SaludWEB</title>`):** Define el título de la pestaña del navegador.

### Estilos CSS (Líneas 15-82)
*   **Línea 15 (`<style>`):** Apertura del bloque de estilos internos CSS.
*   **Líneas 16-22 (Variables globales `:root`):** Declara variables CSS globales para colores corporativos: `--primary` (índigo), `--bg` (gris claro), `--text` (gris oscuro pizarra) y `--success` (verde).
*   **Líneas 23-26 (Estilos Generales):** `body` define la tipografía (`Segoe UI`), fondo, color de texto y padding, anulando márgenes. `.container` limita el ancho a 1000px y lo centra horizontalmente (`margin: 0 auto`).
*   **Líneas 27-35 (Estilo del Encabezado):** `.header` distribuye elementos a los extremos con Flexbox y permite saltos de línea. `.logo-container` agrupa icono y texto. `.logo-box` y `.logo-text` estilizan la tuerca y el título de sección. `.back-link` estiliza el enlace a "Home" como un botón blanco con borde índigo y transición suave en hover.
*   **Líneas 36-40 (Menú de Navegación):** `.nav-menu` define una cuadrícula responsiva con CSS Grid. `.nav-item` le da estilo base a las pestañas y `.nav-item:hover, .nav-item.active` les aplica fondo índigo y letras blancas al estar activa o seleccionada.
*   **Líneas 41-47 (Contenedor del Panel):** `.content` le da fondo blanco, esquinas redondeadas (16px) y una sombra sutil a la caja principal. `.section`, `.section-title` y `.section-desc` espacian y formatean los títulos y textos de cada sección de ajustes.
*   **Líneas 48-52 (Grupos de Ajustes):** `.settings-group` y `.settings-row` organizan las opciones individuales en cajas grises, distribuyendo el texto a la izquierda y los inputs/checkboxes a la derecha mediante Flexbox. `.settings-label` y `.settings-value` definen el estilo tipográfico de los textos.
*   **Líneas 53-61 (Estilos para Botones):** Define la clase base `.btn` (sin bordes, cursor manual y transición) y sus variantes `.btn-primary` (índigo con elevación en hover), `.btn-secondary` (gris claro con borde) y `.btn-danger` (rojo).
*   **Líneas 62-69 (Enlaces de Soporte):** `.contact-icons` agrupa iconos de ayuda. `.social-link` crea cajas redondas que en hover aumentan su tamaño un 15% (`scale(1.15)`) e intensifican su sombra, especializadas mediante `.whatsapp-link` (verde) y `.gmail-link` (rojo).
*   **Líneas 70-73 (Caja Informativa):** `.info-box` crea un banner azul claro con un borde izquierdo grueso color índigo para textos de cumplimiento y cifrado de datos.
*   **Líneas 74-82 (Media Queries - Responsivo):** Aplica reglas cuando el ancho de pantalla sea menor o igual a 768px. Pasa el header a vertical, acomoda la botonera de navegación en 2 columnas y coloca las opciones de configuración en formato de bloque vertical.
*   **Líneas 81-82 (`</style>` y `</head>`):** Cierran el bloque CSS y la sección de cabecera.

### Cuerpo del Documento HTML y Componentes (Líneas 83-230)
*   **Línea 83 (`<body>`):** Inicio del cuerpo visible del documento.
*   **Línea 84 (`<div class="container">`):** Abre la envoltura central limitadora.
*   **Líneas 85-94 (Cabecera Visual):** Abre el bloque `.header` renderizando el logotipo con el emoji de engranaje (`⚙️`) y el botón para volver a [lista_pacientes.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_pacientes.php).
*   **Líneas 95-107 (Navegación del Dashboard):** Crea las pestañas de navegación del dashboard, marcando la opción de Ajustes con la clase `active`. Incluye un botón rojo de cierre de sesión apuntando a `logout.php`.
*   **Línea 109 (`<div class="content">`):** Panel blanco contenedor de todas las opciones.
*   **Líneas 110-143 (Sección 1 - Notificaciones):** Bloque que lista cuatro checkboxes para gestionar las notificaciones de avisos de recetas (marcada), medicamentos (marcada), sistema y promociones.
*   **Líneas 144-161 (Sección 2 - Seguridad 2FA):** Muestra el estado de la autenticación doble ("No activado"), un botón con evento `onclick="alert('Función de 2FA')"` y una caja informativa sobre protección de cifrado.
*   **Líneas 162-179 (Sección 3 - Contacto y Canales de Soporte):** Genera los enlaces rápidos para soporte vía chat de WhatsApp o por correo electrónico, con textos adicionales indicando el horario comercial.
*   **Líneas 180-189 (Sección 4 - Centro de Ayuda):** Enlaces con estilo de botón secundario que dirigen a preguntas frecuentes o documentación.
*   **Líneas 190-200 (Sección 5 - Mis Datos):** Ofrece un botón de descarga que simula la exportación de datos en formato JSON y un botón de peligro (`btn-danger`) que pide confirmación antes de simular la eliminación permanente de la cuenta del usuario.
*   **Líneas 201-224 (Sección 6 - Información del Sistema):** Expone la versión de la aplicación ("3.0 Pro"), la fecha de última actualización y el estado del servidor pintado de color verde exitoso.
*   **Líneas 225-230 (Cierres Estructurales):** Cierran respectivamente el panel blanco, la envoltura de ancho máximo, el cuerpo de la página y el archivo HTML.

---

## 2. index.php

Este archivo sirve como punto de acceso o menú principal para los submódulos de la aplicación.

*   **Línea 1 (`<?php`):** Apertura de la etiqueta PHP. Indica al servidor que comience a procesar el código como PHP.
*   **Líneas 2 a 7 (`/** ... */`):** Comentario de bloque PHPDoc. Documenta que el archivo sirve como menú principal.
*   **Líneas 9 y 10 (`// Se incluye...`):** Comentario aclaratorio de la importación.
*   **Línea 11 (`require_once '../db.php';`):** Incluye y ejecuta exactamente una vez el archivo de base de datos ubicado en la carpeta padre. Detiene el script con un error fatal si el archivo no existe.
*   **Línea 13 (`// Renderizado...`):** Comentario sobre el encabezado del panel.
*   **Línea 14 (`echo "<h1>Panel de Módulos - SaludWeb Pro</h1>";`):** Envía al flujo de salida HTML una etiqueta `<h1>` con el título del panel.
*   **Línea 16 (`// Estructura...`):** Comentario sobre la sección de menú.
*   **Línea 17 (`echo "<ul>";`):** Abre la etiqueta de lista desordenada HTML.
*   **Línea 18 (`// Módulo de...`):** Comentario de la opción de configuración.
*   **Línea 19 (`echo "<li><a href='configuracion.php'>Configuración</a></li>";`):** Imprime el ítem de la lista con un enlace hacia [configuracion.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/configuracion.php).
*   **Línea 21 (`// Módulo de...`):** Comentario de la opción de administración médica.
*   **Línea 22 (`echo "<li><a href='lista_medicos.php'>Gestión de Médicos</a></li>";`):** Imprime un ítem enlazado a [lista_medicos.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_medicos.php).
*   **Línea 24 (`// Módulo de...`):** Comentario de la opción para recetas del paciente.
*   **Línea 25 (`echo "<li><a href='lista_prescripciones.php'>Ver Recetas</a></li>";`):** Imprime un ítem enlazado a [lista_prescripciones.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_prescripciones.php).
*   **Línea 27 (`// Centro de...`):** Comentario de la opción de centro de control digital del paciente.
*   **Línea 28 (`echo "<li><a href='mis_rx.php'>MRx Digital</a></li>";`):** Imprime un ítem enlazado a [mis_rx.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/mis_rx.php).
*   **Línea 29 (`echo "</ul>";`):** Cierra la etiqueta de lista desordenada.
*   **Línea 30 (`?>`):** Cierre de la etiqueta PHP.

---

## 3. lista_medicos.php

Este archivo permite visualizar y administrar los médicos registrados en el sistema, mostrando su estado y permitiendo habilitar o inhabilitar sus permisos.

### Lógica PHP de Servidor (Líneas 1-14)
*   **Línea 1 (`<?php`):** Apertura de la etiqueta PHP.
*   **Líneas 2 a 7 (`/** ... */`):** Comentario de bloque PHPDoc. Describe las funcionalidades del listado de médicos.
*   **Línea 9 (`// Se incluye...`):** Comentario aclaratorio.
*   **Línea 10 (`require_once __DIR__ . '/db.php';`):** Importa la conexión a la base de datos `$pdo` cargando el archivo `db.php` ubicado en la misma carpeta.
*   **Línea 12 (`// Consulta...`):** Comentario aclaratorio de la consulta SQL.
*   **Línea 13 (`$medicos = $pdo->query(...)`):** Realiza una consulta SQL a la base de datos para seleccionar todos los profesionales registrados, ordenándolos primero por estado activo (activos arriba) y luego alfabéticamente. Devuelve los resultados en un array asociativo usando `fetchAll(PDO::FETCH_ASSOC)`.
*   **Línea 14 (`?>`):** Cierre de la etiqueta PHP.

### Cabecera y Estilos CSS (Líneas 15-54)
*   **Líneas 15 a 20 (Estructura Base):** Define el tipo de documento HTML5, idioma español, codificación UTF-8, responsividad móvil y el título de la sección.
*   **Línea 21 (`<style>`):** Inicio de estilos CSS.
*   **Línea 22 (`/* Estructura... */`):** Comentario CSS.
*   **Línea 23 (`body { ... }`):** Estilo del cuerpo (fuente `Inter`, fondo gris claro y relleno de 30px).
*   **Línea 25 (`.card { ... }`):** Caja contenedora blanca con esquinas redondeadas, sombra sutil y centrado horizontal con un ancho máximo de 1000px.
*   **Línea 26 (`h1 { ... }`):** Cabecera principal: color de letra gris oscuro, elimina el margen superior y alinea el texto flex con su emoji.
*   **Línea 29 (`table { ... }`):** Configura la tabla para que ocupe todo el ancho disponible (`100%`) y colapse bordes.
*   **Línea 30 (`th { ... }`):** Estilo de cabeceras de columnas (alineación izquierda, texto gris claro, fuente pequeña, padding y mayúsculas).
*   **Línea 31 (`td { ... }`):** Celdas de datos con relleno y borde inferior fino de separación.
*   **Línea 34 (`.badge { ... }`):** Etiqueta redondeada para estados del médico con fuente pequeña y en negrita.
*   **Líneas 35-36 (`.active` y `.inactive`):** Clases que pintan de verde (activo) o rojo (inactivo) la etiqueta de estado.
*   **Línea 39 (`.btn-toggle { ... }`):** Botón plano para cambiar estado (sin bordes, cursor manual y letra negrita).
*   **Línea 40 (`.btn-back { ... }`):** Diseño del enlace de retroceso en color índigo.
*   **Líneas 43 a 50 (Reglas Responsivas):** Media Query para pantallas hasta 760px. Configura la tabla con `display: block` y `overflow-x: auto` para permitir deslizamiento horizontal sin romper la maquetación. Coloca los botones de alternancia en bloque de ancho completo.
*   **Línea 51 (`}` y `</style>` y `</head>`):** Cierre de la Media Query, bloque CSS y sección `<head>`.

### Cuerpo HTML e Iteración de Datos (Líneas 55-103)
*   **Línea 55 (`<body>`):** Inicio del cuerpo visible del documento.
*   **Línea 56 (`<div class="card">`):** Abre la tarjeta principal.
*   **Línea 58 (`<a href="lista_pacientes.php" class="btn-back">... Volver</a>`):** Enlace para regresar al panel anterior.
*   **Línea 59 (`<h1>👨⚕️ Panel de Profesionales</h1>`):** Título principal de la sección.
*   **Línea 60 (`<p>...`):** Párrafo explicativo.
*   **Líneas 63 a 74 (Estructura de la Tabla):** Cabeceras de la tabla con las columnas: Estado, Nombre, Matrícula, Especialidad y Acción.
*   **Línea 75 (`<tbody>`):** Abre el cuerpo de la tabla.
*   **Línea 76 (`<?php foreach ($medicos as $m): ?>`):** Bucle de PHP que recorre los médicos cargados en el array `$medicos`.
*   **Línea 78 (`<tr id="medico-<?php echo $m['id']; ?>">`):** Genera una fila asignándole un atributo `id` único para identificarla.
*   **Líneas 79 a 85 (Celda de Estado):** Imprime una etiqueta `.badge` con clase dinámica `active` o `inactive` y texto "OPERATIVO" o "INACTIVO" según el campo `activo` del médico.
*   **Líneas 86 y 87 (Celda de Nombre):** Muestra el nombre en negrita sanitizado con `htmlspecialchars` para evitar inyecciones XSS.
*   **Líneas 88 y 89 (Celda de Matrícula):** Escribe el código de matrícula usando la etiqueta `<code>`. Con el operador ternario abreviado (`?: 'N/A'`), si la matrícula no existe escribe "N/A".
*   **Línea 90 (Celda de Especialidad):** Muestra la especialidad. Si es nula, imprime "General" por defecto.
*   **Líneas 91 a 97 (Celda de Acción / Botón):** Botón con clase `.btn-toggle`. Su color de fondo y de texto cambia dinámicamente: si el médico está activo, el botón se ve rojo/rosado suave; si está inactivo, se tiñe de verde suave. Su evento `onclick` llama a la función JS `toggleMedico()` pasándole el ID de la base de datos y el estado inverso deseado (`0` o `1`). Muestra dinámicamente "Desactivar" o "Activar".
*   **Línea 99 (`</tr>`):** Cierre de la fila.
*   **Línea 100 (`<?php endforeach; ?>`):** Fin de la iteración.
*   **Líneas 101 a 103 (`</tbody>`, `</table>`, `</div>`):** Cierran la tabla y la tarjeta.

### Bloque de Script de API JavaScript (Líneas 104-135)
*   **Línea 104 (`<script>`):** Abre el bloque de código de scripts en el navegador.
*   **Líneas 105 a 111:** Comentarios descriptivos de la función asíncrona `toggleMedico`.
*   **Línea 112 (`async function toggleMedico(id, nuevoEstado) {`):** Declara la función asíncrona encargada de habilitar o inhabilitar al profesional.
*   **Línea 113 (`const apiUrl = ...;`):** Define el endpoint de la API agregando el identificador del profesional a la URL.
*   **Línea 115 (`try {`):** Abre bloque `try-catch` para captura de errores de conexión.
*   **Líneas 117 a 121 (`const response = await fetch(apiUrl, { ... });`):** Realiza la petición asíncrona HTTP mediante la API nativa de JavaScript `fetch` con el método **PATCH**. Envía en el cuerpo (`body`) el estado convertido a cadena JSON (`JSON.stringify({ activo: nuevoEstado })`).
*   **Líneas 124 a 128:** Si la petición es exitosa (`response.ok`), fuerza una recarga de la página con `location.reload()` para reflejar los cambios en el listado. Si falla, emite un aviso de alerta (`alert`).
*   **Líneas 129 a 132 (`} catch (error) { ... }`):** Captura excepciones de red, escribe el error en consola y alerta al usuario del fallo de conexión.
*   **Línea 133 (`</script>`):** Cierre del bloque de script.
*   **Líneas 134 y 135 (`</body>` y `</html>`):** Cierran el cuerpo del documento y el archivo HTML.

---

## 4. lista_prescripciones.php

Este archivo lista las recetas electrónicas registradas en la base de datos, soportando filtrado por estado y por paciente, traduciendo medicamentos usando un mapa JSON y permitiendo su eliminación remota.

### Lógica PHP de Servidor y Carga de Datos (Líneas 1-38)
*   **Línea 1 (`<?php`):** Abre el bloque de ejecución de PHP en el servidor.
*   **Líneas 2 a 8 (`/** ... */`):** Comentario de bloque PHPDoc. Describe las funcionalidades de listado de recetas.
*   **Líneas 10 y 11 (`require_once 'db.php';`):** Incluye y ejecuta exactamente una vez el archivo `db.php` para iniciar la conexión PDO.
*   **Línea 13 (`// Lectura...`):** Comentario explicativo.
*   **Línea 14 (`$estado = $_GET['estado'] ?? 'activa';`):** Obtiene el parámetro `estado` de la URL, usando `'activa'` por defecto.
*   **Línea 15 (`$paciente_id = $_GET['paciente_id'] ?? null;`):** Recupera la ID del paciente de la URL, guardándola como `null` si no fue enviada.
*   **Líneas 17 a 23 (Consulta SQL con Uniones):** Define la cadena SQL para recuperar los campos de la receta y los nombres del paciente y médico mediante dos `LEFT JOIN`.
*   **Líneas 25 a 27 (Filtrado por Paciente):** Si hay ID de paciente, concatena un filtro adicional a la consulta SQL. El casteo explícito `(int)` sanitiza la variable evitando ataques de inyección SQL.
*   **Línea 28 (`$sql .= " ORDER BY p.fecha_emision DESC";`):** Ordena las prescripciones mostrando primero las más recientes.
*   **Líneas 30 a 33 (Ejecución PDO):** Prepara la consulta para una ejecución segura. Ejecuta pasando el estado para rellenar el marcador `?` y obtiene todas las filas encontradas con `fetchAll(PDO::FETCH_ASSOC)`.
*   **Líneas 35 a 37 (Mapa de Medicamentos):** Consulta IDs y nombres en `medicamentos` y los recupera como un mapa simple de pares clave/valor `[id => nombre]` usando `PDO::FETCH_KEY_PAIR`. Esto permite realizar traducciones de IDs en el frontend de forma rápida.
*   **Línea 38 (`?>`):** Cierre de la etiqueta PHP.

### Cabecera y Estilos CSS (Líneas 39-93)
*   **Líneas 39 a 44 (Metadatos):** Estructura básica HTML5, idioma español, decodificación UTF-8, responsividad y título de pestaña.
*   **Línea 45 (`<style>`):** Inicio de la hoja de estilos internos.
*   **Líneas 46 a 50 (Estilos de Cuerpo):** Configura el cuerpo de la página con fuente `Segoe UI`, un fondo degradado lineal morado/azul, altura mínima de pantalla del 100% y centra la tarjeta en un contenedor de 1200px de ancho máximo.
*   **Líneas 51 a 57 (Estilos de Filtros):** Estiliza el formulario con fondo blanco, bordes redondeados y una barra superior morada de 4px. Diseña la lista desplegable (`select`) con bordes redondeados y transiciones suaves en hover y focus.
*   **Líneas 58 a 64 (Estilos de la Tabla):** Da aspecto moderno a la tabla eliminando bordes dobles, agregando bordes curvos, cabeceras con fondo degradado y filas que se sombrean al pasar el mouse por encima.
*   **Líneas 65 a 69 (Estados de Receta):** Asigna colores específicos (verde, azul, rojo y gris) para resaltar visualmente los estados de la receta (activa, dispensada, vencida y cancelada).
*   **Líneas 70 a 73 (Estilo de Botones):** Aplica a los botones un fondo rojo degradado, bordes suaves y sombra. Al pasar el mouse, el botón asciende 2px e intensifica su sombra.
*   **Líneas 74 a 78 (Estilo de Caja Legal):** Estiliza la caja de información en tonos amarillo y naranja degradados con un borde grueso izquierdo color rojo.
*   **Líneas 79 a 93 (Media Queries - Responsivo):** Si la pantalla mide menos de 840px, la tabla HTML se descompone y todas sus etiquetas se comportan como bloques (`display: block`). Se oculta la cabecera original (`thead`) y cada fila `tr` se formatea como una tarjeta independiente. Mediante `td::before { content: attr(data-label) ... }`, se inyecta el valor del atributo HTML `data-label` a la izquierda como la etiqueta del campo.

### Cuerpo HTML e Iteración de Datos (Líneas 94-169)
*   **Línea 94 (`<body>`):** Apertura de la etiqueta del cuerpo de la página.
*   **Línea 95 (`<div class="container">`):** Caja contenedora para limitar el ancho del diseño.
*   **Línea 96 (`<h1>...</h1>`):** Encabezado del sistema.
*   **Líneas 98 a 108 (Formulario de Filtrado):** Crea el selector desplegable. Su evento `onchange="this.form.submit()"` envía automáticamente el formulario al cambiar de opción. Los condicionales `if ($estado == '...') echo 'selected'` controlan qué opción permanece seleccionada.
*   **Líneas 110 a 123 (Cabecera de Tabla):** Fila contenedora de los nombres de columnas de la tabla.
*   **Línea 124 (`<tbody id="tabla-recetas">`):** Inicia el contenedor dinámico para las filas.
*   **Línea 125 (`<?php foreach ($prescripciones as $p): ?>`):** Bucle `foreach` de PHP que recorre cada receta.
*   **Línea 127 (`<tr id="fila-...`):** Genera la fila de la tabla asignándole un ID único basado en el ID de la receta (ej: `fila-12`), de modo que pueda ser eliminado del DOM con JavaScript.
*   **Líneas 128 a 132 (Datos de la Fila):** Imprime el ID, paciente y médico correspondientes sanitizados con `htmlspecialchars`. Cada celda tiene un atributo `data-label` para dar soporte al CSS responsivo.
*   **Líneas 133 a 148 (Decodificación de Medicamentos JSON):** La columna `medicamentos` se almacena serializada en la base de datos en formato JSON. `json_decode` la convierte a un array asociativo de PHP. El bucle interno recorre cada ítem, busca el nombre del medicamento en el mapa `$mapaMedicamentos` (usando su ID) y escribe el nombre en negrita junto a la dosis asignada.
*   **Línea 149 (Columna de Indicaciones):** Imprime las indicaciones médicas correspondientes sanitizadas.
*   **Línea 150 (Columna de Estado):** Imprime el estado con la primera letra en mayúscula (`ucfirst`). Le añade de forma dinámica la clase CSS de color.
*   **Líneas 151 a 155 (Columna de Acciones / Botón):** Crea el botón de eliminar. En su evento `onclick`, se llama a la función JS `eliminarReceta()` enviando como parámetro la ID de la receta.
*   **Líneas 157 a 160 (`</tr>`, `<?php endforeach; ?>`, `</tbody>`, `</table>`):** Cierran la iteración de la fila, el bucle de PHP y las etiquetas contenedoras de la tabla.
*   **Líneas 162 a 167 (Aviso Legal):** Caja informativa sobre la Resolución del Ministerio de Salud.
*   **Línea 168 (`</div>`):** Cierre del contenedor principal.

### Bloque de Script de JavaScript (Líneas 170-199)
*   **Línea 170 (`<script>`):** Abre el bloque para los scripts en el navegador.
*   **Líneas 171 a 176:** Comentarios JS explicativos para la función asíncrona `eliminarReceta`.
*   **Línea 177 (`async function eliminarReceta(id) {`):** Declara la función asíncrona de borrado.
*   **Línea 178 (`if (!confirm('...')) return;`):** Muestra un diálogo emergente de confirmación. Si el usuario cancela, detiene la ejecución inmediatamente.
*   **Línea 180 (`const apiUrl = ...;`):** Define el endpoint de la API de borrado de receta.
*   **Línea 182 (`try {`):** Bloque de detección de excepciones.
*   **Línea 184 (`const response = await fetch(apiUrl, { method: 'DELETE' });`):** Envía la petición HTTP de forma asíncrona usando el método **DELETE**.
*   **Línea 185 (`const result = await response.json();`):** Convierte el cuerpo de la respuesta a un objeto de JavaScript.
*   **Líneas 187 a 192:** Si la respuesta es correcta (`response.ok`), muestra un mensaje de confirmación y elimina la fila de la tabla del documento HTML en caliente (`document.getElementById('fila-' + id).remove()`), evitando la necesidad de recargar la página. Si falla, lanza un alert mostrando el error devuelto por el servidor.
*   **Líneas 193 a 196 (`} catch (error) { ... }`):** Captura e imprime los errores de conexión en la consola, notificando del inconveniente mediante un alert.
*   **Línea 197 (`</script>`):** Cierre del script.
*   **Líneas 198 y 199 (`</body>` y `</html>`):** Cierran las etiquetas del cuerpo del documento y del archivo.

---

## 5. mis_rx.php

Este archivo actúa como menú principal interactivo para el usuario final (paciente), permitiéndole navegar entre recetas, notificaciones, servicios prestados y buscador de farmacias.

### Cabecera PHP (Líneas 1-9)
*   **Línea 1 (`<?php`):** Abre la etiqueta de inicio para escribir código en el servidor.
*   **Líneas 2 a 8 (`/** ... */`):** Comentario de bloque PHPDoc. Describe la función de panel de control del paciente.
*   **Línea 9 (`?>`):** Cierra la sección de ejecución de PHP.

### Estructura HTML y Hojas de Estilo CSS (Líneas 10-95)
*   **Líneas 10 a 15 (Estructura Base):** Declara el tipo de documento HTML5, idioma español, codificación UTF-8, responsividad móvil y el título "Mis Rx | SaludWEB" de la pestaña del navegador.
*   **Línea 16 (`<style>`):** Apertura del bloque para colocar hojas de estilo internas.
*   **Líneas 17 a 25 (Paleta de Colores `:root`):** Define variables CSS globales para colores: `--primary` (índigo), `--bg` (gris claro), `--text` (gris pizarra oscuro), `--danger` (rojo/rosado), `--warning` (naranja) y `--success` (verde).
*   **Líneas 26 a 29 (Estilos del Contenedor Principal):** Aplica la fuente tipográfica `Segoe UI`, remueve márgenes de `body` asignando un padding de 20px, y limita el ancho del contenedor `.dashboard` a 1200px centrándolo.
*   **Líneas 30 a 36 (Diseño del Logotipo y Cabecera):** Estiliza el encabezado superior alineando sus elementos en los extremos. El logotipo se compone de una caja índigo con el emoji `✚` y el texto de la marca con el badge "PRO" en color rojo.
*   **Líneas 37 a 44 (Botones de Navegación del Header):** Estiliza los botones de la esquina superior derecha (Volver, Ajustes y Salir). Se diseñan en color índigo sobre fondo blanco con un borde de 2px, aplicando un efecto interactivo de hover que invierte los colores y los eleva 2px. El botón de salida (`.logout-link`) se tiñe de color rojo.
*   **Línea 45 (`.subtitle`):** Pone en gris e incrementa el grosor del subtítulo informativo.
*   **Líneas 46 a 52 (Grilla del Menú Principal):** Crea una cuadrícula responsiva usando CSS Grid. Las tarjetas interactúan en hover elevándose 8px verticalmente, proyectando una sombra más intensa y coloreando sus bordes de índigo.
*   **Líneas 53 a 56 (Bloques de Contenido):** Estiliza el panel contenedor de cada sección (fondo blanco, bordes redondeados y sombra suave).
*   **Líneas 57 a 61 (Grilla Informativa):** Aplica estilos para estructurar tarjetas con fondo gris y bordes curvos que muestran etiquetas en mayúsculas pequeñas e información en negrita grande.
*   **Líneas 62 a 68 (Estilos de Botones):** Estilo base de botones (`.btn`), definiendo el botón principal en índigo con elevación en hover y el botón secundario en color gris claro.
*   **Líneas 69 a 75 (Enlaces de Redes):** Diseña botones circulares para WhatsApp (color verde con incremento del 10% en hover) y Gmail (color rojo con incremento del 10% en hover).
*   **Líneas 76 a 78 (Estilos de Alertas):** Aplica un fondo azul con borde lateral a las cajas informativas (`.alert-info`).
*   **Líneas 79 a 95 (Media Queries de Responsividad):** Para pantallas menores a 768px, el encabezado se organiza en columna y el menú de navegación pasa a tener exactamente 2 columnas. Para pantallas menores a 480px, el padding exterior se reduce a 12px, y tanto el menú de tarjetas como la cuadrícula informativa pasan a ocupar una sola columna vertical (`1fr`).

### Cuerpo HTML e Interacciones (Líneas 96-195)
*   **Línea 96 (`<body>`):** Apertura del cuerpo visible del documento.
*   **Línea 97 (`<div class="dashboard">`):** Inicia el contenedor principal del panel de control del paciente.
*   **Líneas 98 a 112 (Cabecera Visual de SaludWeb PRO):** Muestra el logotipo del sistema, el título, el subtítulo y los tres accesos de la esquina superior:
    *   Botón "← Volver" que enlaza a [lista_pacientes.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_pacientes.php).
    *   Botón "⚙️ Ajustes" que enlaza a [configuracion.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/configuracion.php).
    *   Botón "🔒 Salir" que redirige al cierre de sesión en `logout.php`.
*   **Líneas 113 a 145 (Sección de Recetas y Servicios "Mis Rx"):** Abre una sección con título principal "💊 Mis Rx" y agrupa 4 tarjetas de navegación:
    *   Tarjeta 1: Enlaza a [lista_prescripciones.php](file:///c:/Users/AILEN/Documents/AILEN%20PERSONAL/PROGRAMACIÓN%203/Organizacion_Modulos/lista_prescripciones.php) para ver las recetas médicas.
    *   Tarjeta 2: Enlaza a `notificaciones.php` para revisar avisos del consultorio.
    *   Tarjeta 3: Enlaza a `prestaciones.php` para ver los servicios médicos cubiertos.
    *   Tarjeta 4: Enlaza a `buscador_farmacias.php` para encontrar farmacias cercanas adheridas.
*   **Líneas 146 a 162 (Sección de Canales de Contacto):** Muestra la sección "📞 Contacto y Soporte" con iconos interactivos para contactar mediante chat directo de WhatsApp o por correo electrónico, e incluye un botón que redirige al módulo de preguntas frecuentes `preguntas_frecuentes.php`.
*   **Líneas 163 a 183 (Sección de Información Útil del Sistema):** Dibuja la sección de diagnóstico mostrando 3 tarjetas:
    *   Estado del sistema: Con la etiqueta "✓ Activo" formateada en color verde.
    *   Última sincronización (Dinámica): **Usa PHP `<?php echo date('d/m/Y H:i'); ?>`** para consultar en el servidor la fecha y hora actuales e imprimirlas formateadas en tiempo real.
    *   Versión: Muestra la versión actual de la plataforma ("3.0").
*   **Líneas 184 a 187 (`</div>`, `</div>`, `</body>`, `</html>`):** Cierran secuencialmente el panel principal del dashboard, el cuerpo de la página y el archivo HTML.

---

## 6. db.php — Conexión a Base de Datos y Esquema

Este archivo conecta a MySQL, crea la base de datos, define todas las tablas con sus claves foráneas e inserta datos de ejemplo.

### Configuración Inicial y Conexión PDO (Líneas 1-37)
*   **Líneas 1-10 (Encabezado):** `<?php` abre la etiqueta PHP. El bloque de comentarios (`//`) describe que el archivo maneja conexión MySQL, creación de tablas y datos de ejemplo.
*   **Líneas 12-18 (Reporte de Errores):** `ini_set('display_errors', 1)` obliga a mostrar errores en pantalla. `error_reporting(E_ALL)` reporta todo tipo de errores (advertencias, notices). Esto ayuda durante el desarrollo a detectar problemas.
*   **Líneas 20-27 (Variables de Entorno):** `getenv('DB_HOST') ?: 'localhost'` lee variables de entorno del sistema operativo. El operador `?:` (Elvis) usa el valor por defecto si la variable no existe. Así se configura: `$host` (servidor), `$dbName` (nombre de BD), `$user` (usuario MySQL), `$pass` (contraseña, vacía por defecto en XAMPP).
*   **Líneas 29-37 (PDO):** `new PDO("mysql:host=$host;charset=utf8mb4", ...)` crea la conexión a MySQL sin especificar base de datos para poder crearla después. `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` hace que los errores se lancen como excepciones. `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC` devuelve resultados como arrays asociativos (`['nombre' => 'Juan']` en vez de `[0 => 'Juan']`).

### Creación de Base de Datos (Líneas 39-46)
*   **Línea 43 (`CREATE DATABASE IF NOT EXISTS ...`):** Crea la base de datos si no existe. `CHARACTER SET utf8mb4` soporta caracteres especiales (tildes, ñ, emojis). `COLLATE utf8mb4_unicode_ci` define reglas de comparación que respetan el español.
*   **Línea 46 (`USE ...`):** Selecciona la base de datos creada para que las siguientes consultas se ejecuten dentro de ella.

### Creación de Tablas (Líneas 48-131)
*   **Líneas 57-60 (obras_sociales):** `id INT AUTO_INCREMENT PRIMARY KEY` crea un identificador único auto-incremental. `nombre_obra VARCHAR(255)` almacena el nombre (OSDE, PAMI, etc.). `ENGINE=InnoDB` es necesario para usar claves foráneas (foreign keys).
*   **Líneas 65-74 (pacientes):** `UNIQUE KEY uniq_dni (dni)` impide que dos pacientes tengan el mismo DNI. `INDEX idx_nombre (nombre)` acelera las búsquedas por nombre. `TINYINT(1)` almacena un booleano (0/1) para activo/inactivo. `creado_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP` guarda la fecha de creación automáticamente.
*   **Líneas 79-86 (triages):** `FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE` crea una clave foránea: si se borra un paciente, se borran sus triages automáticamente.
*   **Líneas 89-96 (medicos):** Crea la tabla de médicos con nombre, matrícula (nullable), especialidad (nullable), activo (booleano) y fecha de creación.
*   **Líneas 99-104 (medicamentos):** Tabla simple con nombre y descripción opcional.
*   **Líneas 111-124 (prescripciones):** `medicamentos TEXT NOT NULL` almacena datos en formato JSON. `ON DELETE SET NULL` en la clave foránea de médicos: si se elimina un médico, la receta no se borra sino que queda sin médico asignado. Incluye campos para código QR y firma digital.
*   **Líneas 127-131 (auditoria):** Registra acciones realizadas en el sistema (accion y fecha).

### Inserción de Datos de Ejemplo (Líneas 133-183)
*   **Líneas 139-144 (Obras Sociales):** `SELECT COUNT(*) FROM obras_sociales` cuenta las filas existentes. `fetchColumn()` devuelve el número. Si está vacío (=== 0), inserta los valores por defecto.
*   **Líneas 147-160 (Médicos):** Usa consultas preparadas (`$pdo->prepare()`) con marcadores `?` para evitar inyección SQL. `$stmt->execute($m)` ejecuta la consulta con cada arreglo de valores. Inserta 4 médicos de ejemplo.
*   **Líneas 163-169 (Medicamentos):** Inserta 5 medicamentos comunes usando el mismo patrón de consulta preparada.
*   **Líneas 172-183 (Pacientes):** Inserta 3 pacientes con DNI, nombre y obra social.

### Manejo de Errores (Líneas 185-199)
*   **Línea 186 (`catch (PDOException $e)`):** Captura excepciones específicas de PDO (error de conexión). `http_response_code(500)` envía código HTTP 500 (Internal Server Error). `htmlspecialchars($e->getMessage())` sanitiza el mensaje de error para prevenir XSS. `exit` detiene la ejecución del script.

---

## 7. core/bootstrap.php — Archivo de Arranque (Bootstrap)

*   **Líneas 1-8 (Encabezado):** Comentarios que explican que bootstrap significa "arranque" o "inicialización". Es el primer archivo que se ejecuta y prepara todo lo necesario para la aplicación.
*   **Línea 13 (`session_start()`):** Inicia la sesión del usuario. Permite usar `$_SESSION` para guardar datos entre páginas (usuario logueado, preferencias).
*   **Línea 16 (`require_once __DIR__ . '/Router.php'`):** Carga la clase Router (enrutador de URLs). `__DIR__` es la constante mágica que contiene la ruta del directorio actual (`core/`).
*   **Línea 20 (`require_once __DIR__ . '/../db.php'`):** Carga la conexión a la base de datos. Esto ejecuta `db.php` que crea la variable `$pdo` (objeto PDO).
*   **Líneas 23-29 (require_once):** Cargan secuencialmente las capas de la arquitectura: `MedicoRepository.php` (persistencia), `MedicoService.php` (negocio) y `MedicoController.php` (controlador HTTP). El orden importa: el controlador depende del servicio, y el servicio depende del repositorio.
*   **Línea 37 (`$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')`):** Calcula la ruta base del proyecto. `$_SERVER['SCRIPT_NAME']` contiene la ruta del script actual (ej: `/Organizacion_Modulos/index.php`). `dirname()` obtiene la carpeta padre (`/Organizacion_Modulos`). `rtrim()` saca la barra del final.
*   **Línea 42 (`$router = new Router($basePath)`):** Crea el enrutador pasándole la ruta base para que pueda recortar el prefijo de las URLs y trabajar con rutas relativas.
*   **Línea 47 (`$medicoRepo = new MedicoRepository($pdo)`):** Crea el repositorio inyectándole la conexión PDO. Esto es **Inyección de Dependencias**: en lugar de crear la conexión dentro del repositorio, se la pasamos desde afuera, haciendo el código más testeable y flexible.
*   **Línea 51 (`$medicoService = new MedicoService($medicoRepo)`):** Crea el servicio inyectándole el repositorio. El servicio contiene la lógica de negocio (validaciones, reglas).
*   **Línea 54 (Nota):** Las variables `$router`, `$medicoRepo`, `$medicoService` y `$pdo` quedan disponibles en `routes.php`, que es el archivo que incluye a `bootstrap.php`.

---

## 8. routes.php — Definición de Rutas

Este archivo conecta cada URL que el usuario visita con el código que debe ejecutarse. Actúa como un "mapa" del sitio.

*   **Línea 12 (`require_once __DIR__ . '/core/bootstrap.php'`):** Carga el bootstrap que prepara sesión, conexión DB, Router, Repositorio, Servicio y Controlador. Después de esta línea están disponibles: `$router`, `$medicoRepo`, `$medicoService`, `$pdo`.

### Rutas de Páginas Web (Líneas 17-103)
*   **Líneas 17-23 (Ruta Raíz `/`):** `$router->get('/', function() { ... })` registra una ruta GET para la URL raíz. El segundo parámetro es una función anónima (closure). `header('Location: ...')` envía una redirección HTTP al navegador. `exit` detiene la ejecución para que no siga procesando.
*   **Líneas 28-32 (`/medicos`):** Redirige a `/notificaciones` (esta ruta actúa como placeholder).
*   **Líneas 37-41 (`/prescripciones`):** `function () use ($pdo)` — la palabra clave `use` pasa variables del ámbito exterior a la función anónima. `include __DIR__ . '/lista_prescripciones.php'` incluye el archivo de la vista.
*   **Líneas 46-49 (`/mis-rx`):** Incluye la página `mis_rx.php` del dashboard del paciente.
*   **Líneas 54-56 (`/configuracion`):** Incluye la página de configuración/ajustes.
*   **Líneas 64-92 (Rutas secundarias):** `/notificaciones`, `/prestaciones`, `/cuenta`, `/faq`, `/buscador-farmacias`, `/preguntas-frecuentes` — todas usan la misma vista genérica `views/base.php` que detecta la sección por la URL.
*   **Líneas 98-103 (`/logout`):** `session_destroy()` destruye todos los datos de la sesión actual. Luego redirige al inicio.

### API REST para Médicos (Líneas 105-149)
*   **Línea 112 (`GET /api/medicos`):** `$controller = new MedicoController($medicoService)` crea una instancia del controlador inyectándole el servicio. `$controller->index()` llama al método que lista todos los médicos en JSON.
*   **Línea 120 (`GET /api/medicos/{id}`):** `{id}` es un parámetro dinámico que el Router captura de la URL. `(int) $id` convierte a entero por seguridad.
*   **Línea 127 (`POST /api/medicos`):** Ruta para crear un nuevo médico. Los datos se envían en el cuerpo de la petición como JSON.
*   **Línea 133 (`PUT /api/medicos/{id}`):** Actualiza un médico completo (todos los campos).
*   **Línea 140 (`PATCH /api/medicos/{id}`):** Actualiza parcialmente un médico (se usa para cambiar el estado activo/inactivo).
*   **Línea 146 (`DELETE /api/medicos/{id}`):** Elimina un médico.
*   **Líneas 155-159 (Manejador 404):** Si ninguna ruta coincide, redirige al listado de médicos.

---

## 9. core/Router.php — Enrutador de URLs

Router es el componente que recibe la URL solicitada, la compara con las rutas registradas y ejecuta el código correspondiente.

### Propiedades de la Clase (Líneas 14-26)
*   **Línea 16 (`private array $routes = []`):** Arreglo donde se guardan todas las rutas registradas. Cada ruta tiene: método HTTP, path, handler (función controladora) y middlewares.
*   **Línea 19 (`private array $middlewares = []`):** Arreglo de middlewares globales (interceptores que se ejecutan antes de las rutas).
*   **Línea 22 (`private mixed $notFoundHandler = null`):** Función que se ejecuta cuando ninguna ruta coincide (error 404).
*   **Línea 26 (`private string $basePath = ''`):** Ruta base del proyecto (ej: `/Organizacion_Modulos`). Se usa para recortar el prefijo de las URLs.

### Constructor (Líneas 32-37)
*   `rtrim($basePath, '/')` saca la barra del final si existe. Ej: `/Organizacion_Modulos/` → `/Organizacion_Modulos`.

### Métodos para Registrar Rutas (Líneas 44-87)
*   **`get()`, `post()`, `put()`, `patch()`, `delete()`:** Cada método corresponde a un verbo HTTP. Todos llaman internamente a `addRoute()`.
*   **`middleware()` (Líneas 92-96):** Agrega un middleware global que se ejecuta en todas las rutas.
*   **`notFound()` (Líneas 100-105):** Define qué hacer cuando ninguna ruta coincide.

### Método Privado addRoute() (Líneas 114-123)
*   Recibe método HTTP, path, handler y middlewares. `strtoupper($method)` convierte el método a mayúsculas. Guarda la ruta en el arreglo `$routes[]`.

### Método dispatch() (Líneas 132-234) — El Corazón del Router
*   **Línea 137 (`parse_url($uri, PHP_URL_PATH)`):** Analiza la URL y devuelve solo el path (sin query string). Ej: `/medicos?id=1` → `/medicos`.
*   **Líneas 143-145 (Recorte del basePath):** `str_starts_with()` verifica si la URL empieza con el basePath. Si es así, `substr()` lo recorta. Ej: `/Organizacion_Modulos/medicos` → `/medicos`.
*   **Línea 149 (`preg_replace('#/index\.php$#', '', $uri)`):** Si la URL termina en `/index.php`, lo saca.
*   **Línea 153 (`rtrim($uri, '/') ?: '/'`):** Si después de todo queda vacío, usa `"/"` (la raíz).
*   **Líneas 156-219 (Búsqueda de Ruta):** Itera sobre todas las rutas registradas. Si el método HTTP coincide, llama a `matchRoute()` para comparar el path. Si hay coincidencia:
    *   **Líneas 170-181 (Middlewares):** Ejecuta los middlewares específicos de la ruta. Si algún middleware devuelve `false`, la ejecución se detiene (acceso denegado).
    *   **Líneas 191-215 (Ejecución del Handler):** Puede ser: (1) una función anónima (closure) ejecutada con `call_user_func_array()`, (2) un string `"Controlador@metodo"` separado por `explode('@', ...)`, o (3) un string con ruta de archivo incluido con `require_once`.
*   **Líneas 222-233 (Manejador 404):** Si ninguna ruta coincidió, ejecuta el manejador de no encontrado.

### Método matchRoute() (Líneas 249-285)
*   `explode('/', trim($routePath, '/'))` divide la ruta registrada en partes. Ej: `/api/medicos/{id}` → `["api", "medicos", "{id}"]`.
*   Hace lo mismo con la URL solicitada.
*   Si tienen distinta cantidad de partes, no hay match.
*   Compara parte por parte. Si una parte empieza con `{` y termina con `}`, es un parámetro dinámico y acepta cualquier valor. Si no, debe coincidir exactamente.
*   Devuelve un arreglo con los valores de los parámetros, o `null` si no hay match.

---

## 10. controllers/MedicoController.php — Controlador HTTP

Es la capa que maneja peticiones HTTP y genera respuestas JSON.

### Propiedades y Constructor (Líneas 17-30)
*   `private MedicoService $service` guarda el servicio inyectado por el constructor. Tipado fuerte (`MedicoService`): PHP obliga a que sea una instancia de esa clase.

### Métodos del Controlador (Líneas 36-116)
*   **`index()` (Líneas 36-40):** `$this->service->obtenerTodos()` llama al servicio para obtener todos los médicos. `$this->jsonResponse($medicos)` devuelve la respuesta JSON con código 200 (OK).
*   **`show(int $id)` (Líneas 48-57):** Busca un médico por ID. Si el servicio lanza `RuntimeException` (médico no encontrado), captura la excepción y devuelve error 404. Esto es **manejo de excepciones**.
*   **`store()` (Líneas 64-80):** `file_get_contents('php://input')` lee el cuerpo crudo de la petición HTTP. `php://input` es un flujo de solo lectura que contiene el body. `json_decode(..., true)` convierte el JSON a un array asociativo de PHP. Si el servicio lanza `InvalidArgumentException`, devuelve error 400 (Bad Request). Si todo sale bien, devuelve código 201 (Created).
*   **`update(int $id)` (Líneas 90-101):** Combina PUT y PATCH. Maneja dos tipos de excepción: `RuntimeException` (404, no encontrado) y `InvalidArgumentException` (400, datos inválidos).
*   **`destroy(int $id)` (Líneas 108-116):** Elimina un médico. Captura `RuntimeException` si no existe.

### Método jsonResponse() (Líneas 131-144)
*   `http_response_code($status)` establece el código de respuesta HTTP.
*   `header('Content-Type: application/json')` indica al navegador que la respuesta es JSON.
*   `json_encode($data, JSON_UNESCAPED_UNICODE)` convierte el array a JSON sin escapar caracteres Unicode (tildes, ñ). Ej: `"Médico"` en lugar de `"M\u00e9dico"`.

---

## 11. services/MedicoService.php — Capa de Negocio

Contiene la lógica de negocio: validaciones, reglas y transformaciones de datos.

### Propiedades y Constructor (Líneas 14-27)
*   `private MedicoRepository $repo` guarda el repositorio inyectado. El servicio NO tiene código SQL ni HTTP.

### Métodos del Servicio (Líneas 35-151)
*   **`obtenerTodos()` (Líneas 35-39):** Delega directamente al repositorio. Sin lógica adicional.
*   **`obtenerPorId(int $id)` (Líneas 49-58):** Si el repositorio devuelve `null` (médico no encontrado), lanza `RuntimeException` con código 404. Esto convierte un "no encontrado" de datos en una excepción que el controlador capturará.
*   **`crear(array $data)` (Líneas 68-89):** `trim($data['nombre'] ?? '')` limpia el nombre. `empty()` verifica si está vacío (null, '', false, 0, []). Si está vacío, lanza `InvalidArgumentException` con código 400. Si pasa la validación, llama al repositorio para insertar y devuelve el médico recién creado.
*   **`actualizar(int $id, array $data)` (Líneas 102-136):** Primero verifica que el médico exista (`$this->obtenerPorId($id)`). Luego filtra SOLO los campos permitidos con `isset()`. Usa el operador ternario para convertir el campo `activo` a 1 o 0. Si después de filtrar no quedó ningún campo, lanza error. Finalmente ejecuta la actualización.
*   **`eliminar(int $id)` (Líneas 145-151):** Verifica existencia antes de eliminar.

---

## 12. persistence/MedicoRepository.php — Capa de Persistencia

Es la capa encargada de acceder a los datos. Solo contiene consultas SQL.

### Propiedades y Constructor (Líneas 13-29)
*   `private $pdo` guarda la conexión PDO (PHP Data Objects). El tipado no es explícito porque se inicializa en el constructor.

### Métodos del Repositorio (Líneas 41-163)
*   **`obtenerTodos()` (Líneas 41-51):** `$this->pdo->query("SELECT * FROM medicos ORDER BY activo DESC, nombre ASC")` ejecuta la consulta directamente (sin parámetros dinámicos). `fetchAll(PDO::FETCH_ASSOC)` devuelve todas las filas como arreglo asociativo.
*   **`obtenerPorId(int $id)` (Líneas 59-77):** Usa consulta preparada con marcador `?` para prevenir inyección SQL. `$stmt->execute([$id])` ejecuta la consulta con el ID. `fetch(PDO::FETCH_ASSOC)` obtiene una sola fila. Si no hay resultados, devuelve `null` (operador `?:`).
*   **`crear(array $data)` (Líneas 85-106):** `INSERT INTO` con marcadores `?` para los valores. `$data['matricula'] ?? null` proporciona valor por defecto si la clave no existe (null coalescing operator). `$this->pdo->lastInsertId()` devuelve el ID autogenerado por AUTO_INCREMENT.
*   **`actualizar(int $id, array $data)` (Líneas 116-146):** Construye la consulta SQL dinámicamente según los campos recibidos. `array_key_exists()` verifica si la clave existe. `implode(', ', $campos)` une los campos SET con coma. La consulta resultante es algo como `UPDATE medicos SET nombre = ?, matricula = ? WHERE id = ?`.
*   **`eliminar(int $id)` (Líneas 154-163):** `DELETE FROM medicos WHERE id = ?`. `$stmt->rowCount() > 0` devuelve `true` si se eliminó alguna fila, `false` si no existía.

---

## 13. views/base.php — Vista Genérica

Esta vista se usa para todas las páginas secundarias que aún no tienen contenido propio. Detecta automáticamente la sección según la URL.

### Lógica PHP de Detección de Sección (Líneas 9-28)
*   **Línea 13 (`$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')`):** `$_SERVER['REQUEST_URI']` contiene la URL completa solicitada. `parse_url(..., PHP_URL_PATH)` extrae solo la ruta (sin query string). `trim(..., '/')` saca las barras del principio y final.
*   **Línea 14 (`$parts = explode('/', $uri)`):** Divide la ruta en partes separadas por `/`.
*   **Línea 15 (`$currentRoute = end($parts)`):** `end()` devuelve la última parte del arreglo. Ej: para `/organizacion_modulos/notificaciones`, devuelve `notificaciones`.
*   **Líneas 18-25 (Mapa de Secciones):** Array asociativo que asocia cada ruta con su ícono, título y descripción. Las claves son: `notificaciones`, `prestaciones`, `cuenta`, `faq`, `buscador-farmacias`, `preguntas-frecuentes`.
*   **Línea 28 (`$seccion = $secciones[$currentRoute] ?? [...]`):** `??` es null coalescing: si la ruta no está en el mapa, usa valores por defecto (ícono `📄`, título `Página`, descripción vacía).

### Estructura HTML (Líneas 30-76)
*   **Línea 36 (`<title><?php echo $seccion['titulo']; ?> - SaludWEB</title>`):** El título se genera dinámicamente según la sección actual.
*   **Líneas 38-52 (Estilos CSS):** Estilos inline para la tarjeta centrada con ícono grande, título, descripción y barra de navegación horizontal con enlaces estilizados.
*   **Líneas 57-63 (Nav Links):** Barra de navegación con enlaces a Home, Médicos, Prescripciones, Mis Rx y Ajustes. Usan `$basePath` para generar rutas absolutas.
*   **Líneas 66-73 (Tarjeta de Contenido):** Muestra el ícono, título y descripción de la sección actual. Incluye un mensaje informativo: "Esta sección está en construcción. Pronto estará disponible." y un enlace para volver al inicio.

---

## 14. index.php — Punto de Entrada (Front Controller)

*   **Línea 1 (`<?php`):** Apertura de la etiqueta PHP.
*   **Línea 3 (`$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')`):** Calcula la ruta base del proyecto para los enlaces.
*   **Líneas 5-7 (Head HTML):** `<!DOCTYPE html>` declara HTML5. `<html lang="es">` configura el idioma español. Meta tags para charset UTF-8 y viewport responsivo.
*   **Línea 8 (`<title>SaludWEB</title>`):** Título de la pestaña del navegador.
*   **Línea 9 (`</head>`):** Cierre de la cabecera.
*   **Línea 10 (`<body style="font-family:sans-serif;padding:30px;">`):** Cuerpo de la página con estilo inline básico (tipografía sans-serif y padding de 30px).
*   **Línea 11 (`<h1>🏥 SaludWEB</h1>`):** Encabezado principal.
*   **Línea 12 (`<p>Bienvenido al sistema de gestión de pacientes</p>`):** Mensaje de bienvenida.
*   **Línea 13 (`<hr>`):** Línea divisoria horizontal.
*   **Líneas 14-18 (Menú de Navegación):** Lista con enlaces:
    *   `lista_medicos.php` → Gestión de Médicos
    *   `lista_prescripciones.php` → Recetas Electrónicas
    *   `mis_rx.php` → Dashboard del Paciente
    *   `configuracion.php` → Configuración
*   **Línea 20 (`</body></html>`):** Cierre del documento.
