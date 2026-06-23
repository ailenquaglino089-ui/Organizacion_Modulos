<?php
// ============================================================
// views/base.php - Vista genérica para páginas secundarias
// ============================================================
// Detecta automáticamente qué sección se está visitando
// según la URL y muestra el título, ícono y descripción correspondientes.
// ============================================================

// parse_url() analiza la URL actual y extrae solo el path (ruta)
// trim() saca las barras del principio y final
// explode() divide la ruta en partes separadas por /
// end() devuelve la última parte (ej: "notificaciones", "faq", etc.)
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts = explode('/', $uri);
$currentRoute = end($parts);

// Mapa de secciones: define el ícono, título y descripción de cada página
$secciones = [
    'notificaciones'    => ['icono' => '🔔', 'titulo' => 'Notificaciones', 'desc' => 'Gestioná tus notificaciones y recordatorios del sistema.'],
    'prestaciones'      => ['icono' => '🏥', 'titulo' => 'Prestaciones', 'desc' => 'Consultá todas las prestaciones médicas disponibles.'],
    'cuenta'            => ['icono' => '👤', 'titulo' => 'Mi Cuenta', 'desc' => 'Administrá los datos de tu perfil y preferencias.'],
    'faq'               => ['icono' => '❓', 'titulo' => 'Preguntas Frecuentes', 'desc' => 'Encontrá respuestas a las dudas más comunes.'],
    'buscador-farmacias' => ['icono' => '💊', 'titulo' => 'Buscador de Farmacias', 'desc' => 'Encontrá farmacias cercanas y su disponibilidad.'],
    'preguntas-frecuentes' => ['icono' => '❓', 'titulo' => 'Preguntas Frecuentes', 'desc' => 'Respuestas a las preguntas más comunes del sistema.'],
];

// ?? = null coalescing: si la ruta no está en el mapa, usa valores por defecto
$seccion = $secciones[$currentRoute] ?? ['icono' => '📄', 'titulo' => 'Página', 'desc' => ''];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- El título se genera dinámicamente según la sección -->
    <title><?php echo $seccion['titulo']; ?> - SaludWEB</title>
    <style>
        /* Estilos generales */
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; padding: 30px; margin: 0; }
        .container { max-width: 800px; margin: 0 auto; }

        /* Tarjeta contenedora */
        .card { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); text-align: center; }
        .icono { font-size: 64px; margin-bottom: 16px; }
        h1 { margin: 0 0 8px; font-size: 28px; }
        p { color: #64748b; font-size: 16px; margin: 0 0 24px; }

        /* Navegación entre páginas */
        .nav-links { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px; }
        .nav-links a { text-decoration: none; color: #4f46e5; font-weight: 700; padding: 10px 20px; border-radius: 10px; background: white; border: 2px solid #4f46e5; transition: 0.3s; }
        .nav-links a:hover { background: #4f46e5; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Barra de navegación entre las páginas principales -->
        <div class="nav-links">
            <a href="<?php echo $basePath; ?>/">🏠 Home</a>
            <a href="<?php echo $basePath; ?>/medicos">👨‍⚕️ Médicos</a>
            <a href="<?php echo $basePath; ?>/prescripciones">📄 Prescripciones</a>
            <a href="<?php echo $basePath; ?>/mis-rx">📋 Mis Rx</a>
            <a href="<?php echo $basePath; ?>/configuracion">⚙️ Ajustes</a>
        </div>

        <!-- Tarjeta con ícono, título y descripción de la sección actual -->
        <div class="card">
            <div class="icono"><?php echo $seccion['icono']; ?></div>
            <h1><?php echo $seccion['titulo']; ?></h1>
            <p><?php echo $seccion['desc']; ?></p>
            <!-- Mensaje informativo: la sección aún no tiene contenido propio -->
            <p style="color:#94a3b8; font-size:14px;">Esta sección está en construcción. Pronto estará disponible.</p>
            <a href="<?php echo $basePath; ?>/" style="display:inline-block; text-decoration:none; color:#4f46e5; font-weight:700; padding:10px 20px; border-radius:10px; background:white; border:2px solid #4f46e5;">← Volver al inicio</a>
        </div>
    </div>
</body>
</html>
