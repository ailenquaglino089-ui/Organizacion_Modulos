# Acceso profesional a datos en PHP

#### PDO, Repository y arquitectura limpia
En Programación III aprendimos a hacer que el sistema **funcione**. En Programación IV buscamos que el sistema pueda **mantenerse, probarse, escalarse y defenderse técnicamente**. Este módulo marca el salto de escribir código que resuelve el problema, a escribir código del que podamos estar orgullosos profesionalmente.

#### 🔧 Prog. III
SQL + HTML + lógica en un mismo archivo. Funciona.

#### 🏗️ Prog. IV
Capas separadas, código limpio, arquitectura mantenible.

#### 🎯 Objetivo
PDO, consultas preparadas, patrón Repository y separación de responsabilidades.

# Cuando todo está mezclado

#### El problema heredado de Programación III
En muchos proyectos iniciales encontramos archivos PHP que intentan hacer demasiado al mismo tiempo. Un único archivo puede recibir datos del formulario, ejecutar SQL, aplicar reglas de negocio, imprimir HTML, mostrar errores y redirigir al usuario. Esto **funciona**, pero genera una deuda técnica que crece con el tiempo.

#### Un archivo típico de Prog. III hace todo esto:

Recibe datos del formulario (`$_POST`)

Ejecuta SQL directamente con `mysqli_query()`

Aplica reglas de negocio mezcladas con presentación

Imprime HTML con `echo` dentro del código PHP

Muestra errores de base de datos directamente en pantalla

Redirige al usuario con `header()`

#### Código ilustrativo — todo en uno:

```php
<?php
// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "tienda");

// Mostrar error de conexión en pantalla
if (!$conn) {
    die("Error: " . mysqli_connect_error());
}

// Recepción de datos del formulario
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

// Consulta SQL concatenando el valor directamente
$sql = "INSERT INTO productos (nombre, precio)
        VALUES ('" . $nombre . "', " . $precio . ")";

// Ejecutar la consulta con mysqli
$resultado = mysqli_query($conn, $sql);

// Mostrar error de SQL en pantalla
if (!$resultado) {
    echo "Error SQL: " . mysqli_error($conn);
}

// Regla de negocio mezclada con presentación
if ($precio > 1000) {
    echo "<p>Producto de alta gama registrado.</p>";
}

// Imprimir HTML con echo
echo "<h2>Producto guardado correctamente</h2>";
echo "<p>Nombre: " . $nombre . "</p>";

// Redirección con header()
header("Location: lista.php");
exit;
?>
```

Este código puede funcionar, pero mezcla presentación, acceso a datos y seguridad en un único lugar. Cualquier cambio afecta todo.

# SQL directo en vistas y controladores

#### Riesgos del SQL mezclado
Cuando el código SQL vive disperso entre archivos de presentación y lógica de negocio, los problemas no son solo estéticos: afectan directamente la **seguridad, la mantenibilidad y la calidad del proyecto**. A continuación, los riesgos más críticos que debemos conocer y evitar.

#### 🔁 SQL repetido
La misma consulta aparece copiada en múltiples archivos. Si cambia la tabla, hay que buscar y modificar en todos lados. El riesgo de olvidar alguno es muy alto.

#### 🔓 SQL Injection
Concatenar datos del usuario en consultas SQL es la vulnerabilidad más explotada en aplicaciones web. Un atacante puede leer, modificar o borrar toda la base de datos.

#### 🧪 Imposible de testear
Un archivo que mezcla HTML, SQL y lógica no puede probarse de forma automática. Para verificar que funciona hay que ejecutar el sistema completo.

#### 💸 Alto costo de modificación
Cada cambio en la base de datos puede romper vistas, formularios y redirecciones al mismo tiempo. El costo de mantenimiento crece de forma exponencial.

#### 🐛 Errores ocultos
Los mensajes de error de MySQL impresos directamente en HTML revelan información interna del sistema y dificultan el diagnóstico correcto.

#### 📉 Deuda técnica
El problema no es solo técnico. En una defensa de proyecto, un sistema con SQL mezclado en las vistas refleja falta de madurez arquitectónica.

# Separar responsabilidades

#### Qué buscamos en Programación IV
Una arquitectura profesional distribuye el trabajo entre capas bien definidas. Cada componente tiene **una única razón para cambiar**. Esto facilita el mantenimiento, las pruebas y la evolución del sistema sin romper lo que ya funciona.

El flujo simplificado es: **Cliente → Controlador → Servicio → Repository → MySQL → JSON de respuesta**. Cada flecha representa una responsabilidad clara y una frontera entre capas.

#### Controlador
Interpreta la petición HTTP. No sabe nada de SQL.

#### Servicio
Aplica las reglas de negocio. No sabe nada de HTML.

#### Repository
Habla con la base de datos. No sabe nada de la petición HTTP.

#### Base de datos
Almacena los datos. No sabe nada del sistema que la consulta.

# PDO y consultas preparadas

#### La base del acceso seguro a datos en PHP moderno
PDO (*PHP Data Objects*) es la extensión nativa de PHP para trabajar con bases de datos de forma más segura, ordenada y flexible. A diferencia de `mysqli_*`, PDO permite cambiar de motor de base de datos con mínimo esfuerzo y ofrece una API consistente para manejar errores y resultados.

#### Inicialización correcta de PDO:

```php
$dsn = "mysql:host=localhost;"
     . "dbname=programacion_iv;"
     . "charset=utf8mb4";

$opciones = [
  PDO::ATTR_ERRMODE
    => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE
    => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES
    => false
];

$pdo = new PDO(
  $dsn,
  $usuario,
  $password,
  $opciones
);
```

#### ¿Qué hace cada opción?

#### ERRMODE_EXCEPTION
Lanza una excepción (`PDOException`) ante cualquier error. Permite capturarlos con `try/catch` en lugar de comprobar manualmente cada resultado.

#### FETCH_ASSOC
Devuelve cada fila como un array asociativo (`['nombre' => 'Ana']`) en lugar de duplicar datos con índices numéricos.

#### EMULATE_PREPARES = false
Fuerza consultas preparadas reales en el motor MySQL cuando es posible, en lugar de emularlas en PHP. Mayor seguridad y rendimiento.

PDO mejora la seguridad y el manejo de errores, pero por sí solo no garantiza buena arquitectura. Necesitamos también el patrón Repository.

# SQL Injection: cuando el dato se convierte en código

#### La vulnerabilidad más común y más peligrosa del desarrollo web
La inyección SQL ocurre cuando **concatenamos datos del usuario directamente dentro de una consulta SQL**. El motor de base de datos no distingue entre la estructura de la consulta y el dato insertado: si el dato contiene fragmentos de SQL, los ejecuta.

#### ❌ Código vulnerable — no hacer esto:

```php
$email = $_POST['email'];

$sql = "SELECT * FROM usuarios
        WHERE email = '$email'";
```

Si el usuario ingresa el siguiente valor en el formulario:

```text
' OR '1'='1
```

La consulta resultante queda:

```sql
SELECT * FROM usuarios
WHERE email = '' OR '1'='1'
```

Como `'1'='1'` siempre es verdadero, devuelve **todos los registros de la tabla**, sin importar el email.

#### ¿Qué puede hacer un atacante?

#### Leer datos privados
Contraseñas, correos, datos personales de todos los usuarios del sistema.

#### Saltarse la autenticación
Acceder como administrador sin conocer ninguna contraseña real.

#### Modificar o borrar datos
Ejecutar `UPDATE` o `DELETE` masivos sobre la base de datos.

Nunca concatenar datos del usuario dentro de una consulta SQL. Sin excepción.

# Separar SQL de los datos

#### Consultas preparadas: la solución correcta
Una consulta preparada divide el proceso en dos etapas independientes: primero se envía la **estructura de la consulta** al motor de base de datos; luego se envían los **valores por separado**. El motor nunca mezcla ambas cosas, por lo que un valor malicioso no puede modificar la lógica SQL.

#### ✅ Código seguro con PDO:

```php
$email = $_POST['email'];

$stmt = $pdo->prepare(
  "SELECT * FROM usuarios
   WHERE email = :email"
);

$stmt->execute([
  ":email" => $email
]);

$usuario = $stmt->fetch();
```

#### ¿Por qué es seguro?

#### prepare()
Envía la estructura de la consulta al motor. El parámetro `:email` es un marcador de posición, no un valor real todavía.

#### execute([])
Envía los valores por separado. El motor los trata siempre como datos literales, nunca como código SQL.

#### fetch()
Recupera el resultado como array asociativo, gracias a la opción `FETCH_ASSOC` configurada al crear el PDO.

El dato del usuario ya no puede modificar la estructura de la consulta. La inyección SQL queda neutralizada.

# Repository: una puerta ordenada hacia los datos

#### El patrón que centraliza todo el acceso a la base de datos
El **patrón Repository** propone una clase dedicada exclusivamente a encapsular el acceso a datos de una entidad del sistema. En lugar de dispersar consultas SQL por controladores, formularios o vistas, toda la comunicación con la base de datos pasa por un único punto de contacto bien definido.

#### Ejemplos de Repositories en un sistema real:

#### ClienteRepository
Gestiona altas, bajas, consultas y modificaciones de clientes.

#### ProductoRepository
Accede a catálogos, precios y existencias.

#### UsuarioRepository
Maneja credenciales, roles y autenticación.

#### PedidoRepository
Controla el ciclo de vida de cada pedido.

#### Un Repository solo debe:

#### ✅ Hablar con la base de datos
Ejecutar `SELECT`, `INSERT`, `UPDATE`, `DELETE` a través de PDO.

#### ✅ Devolver datos al servicio
Retornar arrays, objetos o `null`. Nunca HTML ni JSON directamente.

#### Un Repository nunca debe:

#### ❌ Imprimir HTML
No usa `echo` ni genera respuestas visuales.

#### ❌ Leer `$_POST`
No accede directamente a la superglobal de formularios.

#### ❌ Decidir HTTP
No llama a `header()` ni define códigos de estado.

# Contrato de acceso a datos

#### La interfaz del Repository: definir operaciones sin implementarlas
En PHP podemos definir una **interfaz** que actúa como contrato: declara qué operaciones existen sobre una entidad, sin revelar todavía cómo se implementan. El controlador depende de ese contrato, no de una clase concreta. Esto nos permite cambiar la implementación (PDO, Eloquent, un mock para tests) sin tocar el controlador.

#### Interfaz del Repository de clientes:

```php
interface ClienteRepositoryInterface
{
    public function listar(): array;

    public function buscarPorId(
        int $id
    ): ?array;

    public function crear(
        array $datos
    ): int;

    public function actualizar(
        int $id,
        array $datos
    ): bool;

    public function eliminar(
        int $id
    ): bool;
}
```

#### ¿Qué significa cada método?

#### listar(): array
Devuelve todos los clientes. El tipo de retorno `array` garantiza que siempre habrá una colección, aunque esté vacía.

#### buscarPorId(): ?array
El signo `?` indica que puede devolver `null` si no existe el cliente. Obliga al controlador a manejar ese caso.

#### crear(): int
Devuelve el ID generado por la base de datos tras el `INSERT`, lo que permite referencias inmediatas.

#### actualizar() / eliminar(): bool
Devuelven `true` si la operación afectó al menos una fila, `false` en caso contrario.

El controlador debería depender de operaciones de negocio, no de consultas SQL concretas.

# Repository implementado con PDO

#### El SQL queda centralizado en un único punto de contacto
La clase concreta implementa la interfaz usando PDO. El controlador solo conoce los métodos del contrato: nunca ve una línea de SQL. Si mañana cambiamos el motor de base de datos o la forma de acceder, **el controlador no cambia**.

#### Implementación de `buscarPorId`:

```php
class PdoClienteRepository
  implements ClienteRepositoryInterface
{
  public function __construct(
    private PDO $pdo
  ) {}

  public function buscarPorId(
    int $id
  ): ?array {
    $stmt = $this->pdo->prepare(
      "SELECT id, nombre, email,
              telefono
       FROM clientes
       WHERE id = :id"
    );
    $stmt->execute([":id" => $id]);
    $cliente = $stmt->fetch();
    return $cliente ?: null;
  }
}
```

#### Ventajas de esta estructura:

#### Inyección de dependencia
El objeto `PDO` se pasa al constructor. Esto permite proveer un mock en tests sin modificar la clase.

#### SQL en un único lugar
Todas las consultas de clientes viven en esta clase. Un cambio en la tabla se resuelve aquí, no en diez archivos distintos.

#### Consulta preparada real
El parámetro `:id` garantiza que el valor entero nunca modifique la estructura SQL.

#### Retorno limpio
El operador `?: null` convierte el `false` de PDO en `null` semántico, más fácil de manejar para el controlador.

# La validación no se delega al navegador

#### El servidor siempre debe validar, aunque el frontend ya lo haga
La validación del lado del cliente (HTML5 o JavaScript) mejora la experiencia del usuario, pero puede desactivarse o saltarse con facilidad. **El servidor es la última línea de defensa**: si no valida, datos incorrectos o maliciosos pueden llegar a la base de datos.

#### Función de validación en servidor:

```php
function validarCliente(
  array $datos
): array {
  $errores = [];

  if (empty(trim(
    $datos["nombre"] ?? ""
  ))) {
    $errores["nombre"] =
      "El nombre es obligatorio";
  }

  if (!filter_var(
    $datos["email"] ?? "",
    FILTER_VALIDATE_EMAIL
  )) {
    $errores["email"] =
      "El email no es válido";
  }

  return $errores;
}
```

Si `$errores` está vacío, los datos son válidos y podemos continuar con el Repository. En caso contrario, devolvemos los errores al cliente.

#### Principios de una buena validación:

#### Validar antes de persistir
Nunca llamar al Repository con datos sin validar. La validación ocurre en la capa de servicio, antes del acceso a datos.

#### Usar filtros nativos de PHP
`filter_var()` con constantes como `FILTER_VALIDATE_EMAIL`, `FILTER_VALIDATE_INT` o `FILTER_SANITIZE_STRING` reduce el riesgo de errores propios.

#### Devolver todos los errores a la vez
Acumular errores en un array y devolverlos todos juntos es mejor que lanzar una excepción al primer fallo: el usuario ve todos los problemas en un solo intento.

#### No exponer errores internos
Los mensajes para el usuario deben ser informativos pero nunca revelar rutas, nombres de tablas o detalles internos del sistema.

La validación del cliente mejora la experiencia. La validación del servidor protege el sistema.

# La base de datos no debe estar pegada a la pantalla

#### Reglas de oro para el desarrollo profesional en Programación IV

#### No mezclar SQL con HTML
Las consultas pertenecen al Repository, no a las vistas ni a los formularios.

#### PDO con consultas preparadas
Siempre separar estructura SQL de los datos del usuario. Sin excepción.

#### Centralizar en Repositories
Todo acceso a la base de datos pasa por una clase dedicada con interfaz definida.

#### Separar capas
Controlador, Servicio y Repository tienen responsabilidades distintas y no se mezclan.

#### Validar siempre en servidor
El frontend puede ayudar, pero el servidor es quien decide si el dato es aceptable.

#### Respuestas consistentes
Devolver JSON estructurado con códigos HTTP apropiados. No exponer errores internos.

> El código que escribimos hoy lo va a leer alguien mañana. Una arquitectura limpia es una forma de respeto hacia ese futuro mantenimiento.
