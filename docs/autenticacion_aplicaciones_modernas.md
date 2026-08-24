# Autenticación en Aplicaciones Modernas

De las sesiones tradicionales a los tokens JWT, OAuth y buenas prácticas de seguridad para APIs desacopladas

Programación IVDesarrollo Web Backend

# Repaso: Sesiones y Cookies en Programación III

Antes de avanzar hacia los mecanismos modernos de autenticación, conviene consolidar lo que ya sabemos. En Programación III trabajamos con el modelo clásico de sesiones HTTP, que sigue siendo la base conceptual sobre la que se construyen las soluciones actuales.

#### ¿Cómo funciona una sesión?

1. El usuario envía sus credenciales (usuario y contraseña) al servidor mediante un formulario HTML.
2. El servidor valida las credenciales contra la base de datos y, si son correctas, crea una **sesión en memoria o en base de datos** con un identificador único (`session_id`).
3. Ese `session_id` se envía al navegador en forma de **cookie** mediante la cabecera HTTP `Set-Cookie`.
4. En cada petición posterior, el navegador reenvía automáticamente la cookie; el servidor la lee, busca la sesión y recupera el estado del usuario.

#### Ventajas y limitaciones

**Ventajas del modelo clásico:**

- Sencillo de implementar con frameworks como Express-session, PHP Sessions o Django.
- El servidor tiene control total: puede invalidar la sesión en cualquier momento.
- El estado del usuario vive en el servidor, no en el cliente.

**Limitaciones importantes:**

- **Escalabilidad:** si hay múltiples servidores, todos deben compartir el almacén de sesiones (Redis, base de datos compartida).
- **Acoplamiento:** el frontend y el backend deben estar en el mismo dominio o configurar correctamente las cookies con `SameSite` y `CORS`.
- **No apto para APIs consumidas por móviles o SPAs** de forma nativa, ya que las cookies no siempre se gestionan bien fuera del navegador.

El modelo de sesiones sigue siendo válido en aplicaciones monolíticas tradicionales, pero pierde eficacia en arquitecturas desacopladas.

# Login en una API Desacoplada

Cuando el frontend (React, Vue, Angular, app móvil) y el backend (API REST o GraphQL) son proyectos independientes, el flujo de autenticación cambia radicalmente. Las cookies de sesión presentan problemas de dominio cruzado, y el servidor no puede "recordar" al usuario entre peticiones sin un mecanismo explícito.

#### 1. El cliente envía credenciales

El frontend realiza una petición `POST /api/login` con el cuerpo `{ "email": "...", "password": "..." }` en formato JSON. No hay formulario HTML tradicional.

#### 2. El servidor valida y genera un token

La API comprueba las credenciales en la base de datos. Si son correctas, **genera un token firmado** (habitualmente JWT) y lo devuelve en el cuerpo de la respuesta JSON.

#### 3. El cliente almacena el token

El frontend guarda el token en `localStorage`, `sessionStorage` o en una cookie `HttpOnly`. Cada opción tiene implicaciones de seguridad distintas.

#### 4. Peticiones autenticadas

En cada llamada protegida, el cliente incluye el token en la cabecera HTTP: `Authorization: Bearer <token>`. El servidor lo verifica sin necesidad de estado.

#### Ventajas de este enfoque

- **Sin estado en el servidor** (stateless): cualquier instancia puede validar el token.
- Compatible con móviles, SPAs y microservicios.
- El token puede contener información del usuario (claims) evitando consultas adicionales.

#### Consideraciones de seguridad

- El token viaja en cada petición: usa siempre **HTTPS**.
- Si se filtra un token, el atacante puede suplantar al usuario hasta que expire.
- Implementar **refresh tokens** para renovar el acceso sin pedir credenciales de nuevo.

# ¿Qué es JWT? JSON Web Token

JWT (*JSON Web Token*) es un estándar abierto (**RFC 7519**) que define un formato compacto y autónomo para transmitir información de forma segura entre dos partes como un objeto JSON. La información puede ser verificada y de confianza porque está **firmada digitalmente**.

#### Header (Cabecera)

Contiene el tipo de token (`JWT`) y el algoritmo de firma utilizado, habitualmente `HS256` (HMAC-SHA256) o `RS256` (RSA).

```json
{ "alg": "HS256", "typ": "JWT" }
```

#### Payload (Carga útil)

Contiene los **claims**: afirmaciones sobre el usuario y metadatos. Hay claims estándar (`sub`, `iat`, `exp`) y claims personalizados.

```json
{ "sub": "42", "role": "admin", "exp": 1716239022 }
```

#### Signature (Firma)

Se genera aplicando el algoritmo al header y payload codificados en Base64URL, usando una **clave secreta** que solo conoce el servidor.

```text
HMACSHA256( base64(header) + "." + base64(payload), secret)
```

El resultado es una cadena con el formato `xxxxx.yyyyy.zzzzz`. El token puede **decodificarse** (no está cifrado por defecto), pero no puede **modificarse** sin invalidar la firma. Herramientas como [jwt.io](https://jwt.io) permiten inspeccionarlo visualmente. **Importante:** no almacenar información sensible (contraseñas, tarjetas) en el payload, ya que es legible en Base64.

# Sesión Tradicional vs. Token JWT

Entender las diferencias entre ambos modelos es clave para elegir la arquitectura correcta según el tipo de aplicación que estemos desarrollando.

#### ¿Cuándo usar sesiones?

- Aplicaciones web monolíticas (renderizado en servidor).
- Cuando necesitas revocación inmediata del acceso (banca, salud).
- Cuando el frontend y backend comparten dominio.

#### ¿Cuándo usar JWT?

- APIs REST consumidas por SPAs, apps móviles o terceros.
- Arquitecturas de microservicios donde múltiples servicios validan el token.
- Cuando la escalabilidad horizontal es un requisito.

En la práctica, muchos proyectos combinan ambos: JWT para la API y cookies HttpOnly para proteger el propio token frente a XSS.

# Rutas Públicas y Rutas Protegidas

En cualquier aplicación web o API, no todos los endpoints requieren que el usuario esté autenticado. Es fundamental distinguir claramente qué rutas son accesibles para cualquiera y cuáles requieren un token válido.

#### 🔓 Rutas públicas

Son accesibles sin autenticación. Cualquier cliente puede llamarlas sin incluir un token.

- `POST /api/auth/login` — inicio de sesión
- `POST /api/auth/register` — registro de nuevos usuarios
- `GET /api/productos` — catálogo público
- `GET /api/articulos/:id` — lectura de contenido abierto

Aunque sean públicas, deben protegerse frente a **ataques de fuerza bruta** con rate limiting y captcha.

#### 🔒 Rutas protegidas

Requieren que el cliente incluya un token válido en la cabecera `Authorization`. Si el token falta, es inválido o ha expirado, el servidor responde con `401 Unauthorized`.

- `GET /api/perfil` — datos del usuario autenticado
- `POST /api/pedidos` — crear un pedido
- `PUT /api/usuarios/:id` — editar cuenta
- `DELETE /api/admin/usuarios` — acción administrativa

#### Implementación con middleware

En Express.js, la protección se implementa como un **middleware** que se ejecuta antes del controlador de la ruta:

```javascript
function authMiddleware(req, res, next) {
 const token = req.headers.authorization?.split(' ')[1];
 if (!token) return res.status(401).json({ error: 'No token' });
 try {
 req.user = jwt.verify(token, process.env.JWT_SECRET);
 next();
 } catch {
 res.status(401).json({ error: 'Token inválido' });
 }
}
```

# Roles y Permisos

La autenticación responde a la pregunta *"¿quién eres?"*, pero la **autorización** responde a *"¿qué puedes hacer?"*. Los roles y permisos son el mecanismo que controla el acceso a funcionalidades específicas dentro de la aplicación.

#### Rol: Usuario

Acceso básico. Puede leer su propio perfil, crear y ver sus pedidos, cambiar su contraseña y gestionar sus preferencias. **No puede** acceder a datos de otros usuarios ni a paneles de administración.

#### Rol: Editor

Acceso intermedio. Además de los permisos de usuario, puede crear, editar y publicar contenido (artículos, productos). No puede gestionar cuentas de usuario ni configurar el sistema.

#### Rol: Administrador

Acceso total. Puede gestionar usuarios, asignar roles, ver logs de actividad, configurar el sistema y eliminar cualquier recurso. Debe requerir autenticación de doble factor (**2FA**).

#### Codificando el rol en el JWT

El rol del usuario se puede incluir como claim en el payload del token para evitar consultas a base de datos en cada petición:

```javascript
// Al generar el token:
const token = jwt.sign(
  { sub: user.id, role: user.role },
  process.env.JWT_SECRET,
  { expiresIn: '1h' }
);

// Middleware de autorización por rol:
function requireRole(role) {
  return (req, res, next) => {
    if (req.user.role !== role)
      return res.status(403).json({ error: 'Forbidden' });
    next();
  };
}

// Uso en la ruta:
router.delete('/usuarios/:id',
  authMiddleware,
  requireRole('admin'),
  deleteUserController
);
```

#### Mejores prácticas

- **Principio de mínimo privilegio:** asignar siempre el rol con menos permisos que sea suficiente para la tarea.
- **Validar en el servidor:** nunca confiar solo en validaciones del frontend. Un atacante puede manipular peticiones.
- **Auditoría:** registrar quién realizó acciones administrativas y cuándo.
- **Separar autenticación de autorización:** son conceptos distintos aunque vayan de la mano.
- **RBAC vs ABAC:** Role-Based Access Control es el más común; Attribute-Based Access Control es más flexible pero más complejo.

El código `403 Forbidden` significa "autenticado pero sin permiso". El `401 Unauthorized` significa "no autenticado". No confundirlos en las respuestas de la API.

# Autenticación Externa: OAuth y Proveedores de Identidad

OAuth 2.0 es un estándar de autorización que permite a una aplicación acceder a recursos de otra en nombre del usuario, sin que este tenga que compartir sus credenciales. El flujo **"Iniciar sesión con Google/GitHub/Microsoft"** es el ejemplo más habitual.

#### 1. Redirección al proveedor

El usuario hace clic en "Login con Google". La app redirige al servidor de autorización del proveedor con parámetros: `client_id`, `redirect_uri`, `scope` y un `state` aleatorio anti-CSRF.

#### 2. El usuario consiente

Google muestra una pantalla donde el usuario autentica su identidad y concede los permisos solicitados (leer email, perfil básico, etc.).

#### 3. Código de autorización

El proveedor redirige de vuelta a la app con un **código de autorización** de un solo uso en la URL. La app verifica el parámetro `state`.

#### 4. Intercambio por tokens

El servidor de la app intercambia el código por un `access_token` y un `id_token` (OpenID Connect) en una llamada segura servidor-a-servidor.

#### 5. Sesión establecida

La app usa el `id_token` para obtener los datos del usuario (email, nombre) y crea su propia sesión o genera su propio JWT interno.

#### OAuth 2.0 vs OpenID Connect (OIDC)

- **OAuth 2.0:** protocolo de *autorización*. Delega acceso a recursos sin compartir contraseña.
- **OIDC:** capa de *autenticación* sobre OAuth 2.0. Añade el `id_token` con información de identidad del usuario.
- Cuando haces "Login con Google", usas **OIDC**, no solo OAuth puro.

#### Proveedores populares

- **Google Identity:** el más extendido en aplicaciones de consumo.
- **GitHub OAuth:** ideal para herramientas dirigidas a desarrolladores.
- **Microsoft Azure AD:** estándar en entornos empresariales.
- **Auth0 / Clerk / Supabase Auth:** servicios de identidad como plataforma (IDaaS) que simplifican toda la implementación.

# Riesgos Habituales en Autenticación

La autenticación es uno de los vectores de ataque más explotados. OWASP incluye los fallos de autenticación en su **Top 10** de riesgos de seguridad web. Conocer los ataques más comunes es el primer paso para prevenirlos.

#### 🔑 Fuerza bruta y credential stuffing

Un atacante prueba millones de combinaciones de usuario/contraseña (fuerza bruta) o usa listas de credenciales filtradas de otras brechas (credential stuffing). **Mitigación:** rate limiting por IP, bloqueo temporal de cuenta tras N intentos fallidos, CAPTCHA y 2FA.

#### 🍪 Robo de tokens (XSS)

Si el JWT se almacena en `localStorage`, un ataque Cross-Site Scripting puede robar el token con `document.cookie` o accediendo al storage. **Mitigación:** almacenar tokens en cookies `HttpOnly; Secure; SameSite=Strict` para que JavaScript no pueda acceder a ellas.

#### 🔄 CSRF (Cross-Site Request Forgery)

Un sitio malicioso puede hacer que el navegador del usuario envíe peticiones autenticadas a tu API usando sus cookies. **Mitigación:** tokens CSRF, cabecera `SameSite` en cookies y validar el origen de las peticiones.

#### 🔓 Tokens sin expiración o mal configurados

Un JWT sin campo `exp` nunca caduca: si se filtra, el atacante tiene acceso indefinido. **Mitigación:** establecer tiempos de vida cortos (15-60 minutos), implementar **refresh tokens** de un solo uso y lista de revocación (blocklist) para tokens comprometidos.

#### 🛠️ Secretos débiles o expuestos

Usar `secret123` como clave de firma o subir el `.env` a GitHub son errores frecuentes con consecuencias graves. **Mitigación:** generar secretos con alta entropía (`openssl rand -base64 64`), usar variables de entorno y añadir `.env` al `.gitignore`.

#### 📧 Recuperación de contraseña insegura

Enviar la contraseña actual por email, usar tokens de reset predecibles o que no expiran son vulnerabilidades críticas. **Mitigación:** tokens de reset únicos, de un solo uso, con expiración corta (15-30 min) y enviados por canal seguro.

Nunca almacenes contraseñas en texto plano. Usa siempre algoritmos de hashing específicos para contraseñas: **bcrypt**, **Argon2** o **scrypt**. MD5 y SHA-1 no son seguros para este propósito.

# Autenticar no es solo entrar,
es proteger operaciones.

A lo largo de esta presentación hemos recorrido el camino completo: desde las sesiones clásicas que aprendimos en Programación III hasta los mecanismos modernos que demanda el desarrollo backend actual.

#### Lo que hemos aprendido

- Las sesiones y cookies siguen siendo válidas en contextos monolíticos.
- Las APIs desacopladas requieren autenticación basada en tokens.
- JWT estructura la identidad en header, payload y firma.
- Las rutas públicas y protegidas se gestionan con middleware.

#### Principios clave

- Autenticación (*¿quién eres?*) ≠ Autorización (*¿qué puedes hacer?*).
- Roles y permisos aplican el principio de mínimo privilegio.
- OAuth/OIDC delegan la identidad a proveedores de confianza.
- La seguridad no es opcional: es parte del diseño.

#### Próximos pasos

- Implementar autenticación JWT en el proyecto de prácticas.
- Explorar Auth0 o Supabase Auth para identidad como servicio.
- Estudiar OWASP Top 10 en profundidad.
- Añadir autenticación de doble factor (2FA/TOTP).

> La seguridad no es una característica que se añade al final del desarrollo. Es una disciplina que se practica desde la primera línea de código.
