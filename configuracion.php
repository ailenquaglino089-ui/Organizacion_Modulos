<?php
// Calcula la ruta base del proyecto para los enlaces
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes | SaludWEB</title>
    <style>
        /* ================================================================
           ESTILOS CSS - Página de configuración / ajustes
           ================================================================ */

        /* Variables de diseño y paleta de colores */
        :root {
            --primary: #4f46e5;   /* Color principal: Índigo */
            --bg: #f8fafc;        /* Color de fondo */
            --text: #1e293b;      /* Color del texto */
            --success: #10b981;   /* Color para estados operacionales */
        }

        /* Estilos generales */
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); padding: 20px; margin: 0; }
        .container { max-width: 1000px; margin: 0 auto; }

        /* Encabezado con logotipo y botón de retorno */
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .logo-container { display: flex; align-items: center; gap: 10px; }
        .logo-box { background: var(--primary); color: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 20px; font-weight: bold; }
        .logo-text { font-size: 24px; font-weight: 800; }
        .back-link { text-decoration: none; color: var(--primary); font-weight: 800; padding: 10px 20px; border-radius: 12px; background: white; border: 2px solid var(--primary); }

        /* Menú de navegación con pestañas */
        .nav-menu { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; margin-bottom: 30px; }
        .nav-item { padding: 12px 16px; border-radius: 10px; background: white; text-decoration: none; color: var(--text); font-weight: 700; text-align: center; border: 2px solid #e2e8f0; }
        .nav-item:hover, .nav-item.active { background: var(--primary); color: white; }  /* active = página actual */

        /* Contenido principal con secciones */
        .content { background: white; border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
        .section { margin-bottom: 32px; }
        .section-title { font-size: 20px; font-weight: 800; margin: 0 0 16px 0; display: flex; align-items: center; gap: 10px; }

        /* Grupos de configuración (filas con toggles) */
        .settings-group { background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 12px; border: 2px solid #e2e8f0; }
        .settings-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; }
        .settings-label { font-weight: 700; }

        /* Botones genéricos */
        .btn { display: inline-block; padding: 12px 20px; border-radius: 10px; border: none; cursor: pointer; font-weight: 800; text-decoration: none; font-size: 14px; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: #f1f5f9; color: #1e293b; border: 2px solid #cbd5e1; }
        .btn-danger { background: #ef4444; color: white; }

        /* Iconos de contacto (WhatsApp / Email) */
        .contact-icons { display: flex; gap: 12px; margin-top: 16px; }
        .social-link { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 24px; border: 2px solid #e2e8f0; }
        .whatsapp-link { background: #25d366; color: white; }
        .gmail-link { background: #ea4335; color: white; }

        /* Caja informativa */
        .info-box { background: #eef2ff; border-left: 4px solid var(--primary); padding: 14px 16px; border-radius: 12px; }

        /* Responsive */
        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; }
            .nav-menu { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
<div class="container">

    <!-- ============================================================
    ENCABEZADO
    ============================================================ -->
    <div class="header">
        <div class="logo-container">
            <div class="logo-box">⚙️</div>
            <div class="logo-text">Ajustes</div>
        </div>
        <div class="header-actions">
            <a href="<?php echo $basePath; ?>/" class="back-link">← Home</a>
        </div>
    </div>

    <!-- Menú de navegación principal -->
    <div class="nav-menu">
        <a href="<?php echo $basePath; ?>/" class="nav-item">🏠 Home</a>
        <a href="<?php echo $basePath; ?>/prescripciones" class="nav-item">📄 Prescripciones</a>
        <a href="<?php echo $basePath; ?>/prestaciones" class="nav-item">🏥 Prestaciones</a>
        <a href="<?php echo $basePath; ?>/notificaciones" class="nav-item">🔔 Notificaciones</a>
        <a href="<?php echo $basePath; ?>/configuracion" class="nav-item active">⚙️ Ajustes</a>
        <a href="<?php echo $basePath; ?>/cuenta" class="nav-item">👤 Cuenta</a>
        <a href="<?php echo $basePath; ?>/faq" class="nav-item">❓ FAQ</a>
        <a href="<?php echo $basePath; ?>/logout" class="nav-item" style="border-color:#ef4444; color:#ef4444;">🔒 Salir</a>
    </div>

    <!-- ============================================================
    CONTENIDO PRINCIPAL: secciones de configuración
    ============================================================ -->
    <div class="content">

        <!-- Sección: Notificaciones - Configuración de alertas del sistema -->
        <div class="section">
            <h2 class="section-title">🔔 Notificaciones</h2>
            <!-- Grupo: activar/desactivar avisos de nuevas prescripciones -->
            <div class="settings-group">
                <div class="settings-row">
                    <span class="settings-label">Avisos de prescripciones</span>
                    <input type="checkbox" checked>
                </div>
            </div>
            <!-- Grupo: activar/desactivar recordatorios de toma de medicamentos -->
            <div class="settings-group">
                <div class="settings-row">
                    <span class="settings-label">Recordatorios de medicamentos</span>
                    <input type="checkbox" checked>
                </div>
            </div>
        </div>

        <!-- Sección: Privacidad y Seguridad - 2FA y control de acceso -->
        <div class="section">
            <h2 class="section-title">🔒 Privacidad y Seguridad</h2>
            <!-- Grupo: muestra estado actual de la autenticación de dos factores -->
            <div class="settings-group">
                <div class="settings-row">
                    <span class="settings-label">Autenticación de dos factores</span>
                    <span class="settings-value">No activado</span>
                </div>
            </div>
            <!-- Botón para activar 2FA (simulado con alerta) -->
            <button class="btn btn-primary" onclick="alert('Función de 2FA')">🔐 Activar 2FA</button>
        </div>

        <!-- Sección: Contacto y Soporte - canales de comunicación -->
        <div class="section">
            <h2 class="section-title">📞 Contacto y Soporte</h2>
            <!-- Iconos de contacto: WhatsApp y correo electrónico -->
            <div class="contact-icons">
                <a href="https://wa.me/541234567890" target="_blank" class="social-link whatsapp-link" title="WhatsApp">💬</a>
                <a href="mailto:soporte@saludweb.com" class="social-link gmail-link" title="Email">✉️</a>
            </div>
            <!-- Texto alternativo con los datos de contacto -->
            <p style="color: #64748b;">WhatsApp: +54 9 11 1234-5678 | Email: soporte@saludweb.com</p>
        </div>

        <!-- Sección: Centro de Ayuda - recursos de documentación -->
        <div class="section">
            <h2 class="section-title">❓ Centro de Ayuda</h2>
            <!-- Enlace a preguntas frecuentes -->
            <a href="<?php echo $basePath; ?>/faq" class="btn btn-secondary">📖 Ver Preguntas Frecuentes</a>
            <!-- Enlace a documentación completa (placeholder) -->
            <a href="#" class="btn btn-secondary">📚 Ver Documentación</a>
        </div>

        <!-- Sección: Administración de datos - gestión de cuenta -->
        <div class="section">
            <h2 class="section-title">📊 Mis Datos</h2>
            <!-- Botón de peligro: eliminar cuenta con confirmación previa -->
            <button class="btn btn-danger" onclick="if(confirm('¿Deseas eliminar tu cuenta?')) { alert('Cuenta eliminada'); }">🗑️ Eliminar Cuenta</button>
        </div>

    </div>

</div>
</body>
</html>
