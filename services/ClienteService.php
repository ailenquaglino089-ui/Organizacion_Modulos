<?php
// Reglas de negocio y validaciones de clientes.

// ClienteService contiene las reglas de negocio del CRUD de clientes.
// El servicio valida y normaliza datos antes de delegar en el repositorio.
class ClienteService
{
    // Repositorio utilizado para persistir y consultar clientes.
    private ClienteRepository $repo;

    // Recibe el repositorio desde afuera para mantener la clase testeable.
    public function __construct(ClienteRepository $repo)
    {
        $this->repo = $repo;
    }

    // Delega el listado al repositorio.
    public function listar(): array
    {
        // Solicita al repositorio la lista de clientes persistidos.
        return $this->repo->listar();
    }

    // Verifica el ID y garantiza que el cliente exista.
    public function buscarPorId(int $id): array
    {
        // Comprueba que el identificador sea utilizable antes de consultar.
        if ($id <= 0) {
            throw new InvalidArgumentException('El ID debe ser un entero positivo');
        }

        // Consulta el cliente mediante la capa de persistencia.
        $cliente = $this->repo->buscarPorId($id);
        if ($cliente === null) {
            // Informa que no existe un registro con ese identificador.
            throw new RuntimeException('Cliente no encontrado');
        }

        // Devuelve el registro encontrado.
        return $cliente;
    }

    // Valida, crea y vuelve a consultar el cliente para devolverlo completo.
    public function crear(array $datos): array
    {
        // Normaliza y valida los datos recibidos.
        $datos = $this->validar($datos);
        // Persiste el cliente y conserva el identificador generado.
        $id = $this->repo->crear($datos);

        // Recupera el registro completo después de insertarlo.
        return $this->buscarPorId($id);
    }

    // Exige que el cliente exista, actualiza sus datos y devuelve el resultado.
    public function actualizar(int $id, array $datos): array
    {
        // Verifica que exista el cliente que se desea modificar.
        $this->buscarPorId($id);
        // Normaliza y valida la nueva representación.
        $datos = $this->validar($datos);
        // Envía los datos validados al repositorio.
        $this->repo->actualizar($id, $datos);

        // Devuelve el registro actualizado.
        return $this->buscarPorId($id);
    }

    // Exige que el cliente exista antes de eliminarlo.
    public function eliminar(int $id): void
    {
        // Evita eliminar identificadores inexistentes.
        $this->buscarPorId($id);
        // Solicita al repositorio borrar el registro.
        $this->repo->eliminar($id);
    }

    // Limpia campos y acumula errores de validación para responder al cliente.
    private function validar(array $datos): array
    {
        // Limpia los campos de texto recibidos.
        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $email = trim((string) ($datos['email'] ?? ''));
        $telefono = trim((string) ($datos['telefono'] ?? ''));
        // Prepara el contenedor de errores por campo.
        $errores = [];

        // Comprueba que el nombre tenga contenido.
        if ($nombre === '') {
            $errores['nombre'] = 'El nombre es obligatorio';
        }

        // Comprueba que el correo exista y tenga formato válido.
        if ($email === '') {
            $errores['email'] = 'El email es obligatorio';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errores['email'] = 'El email no tiene un formato válido';
        }

        // Interrumpe la operación cuando existe al menos un error.
        if ($errores !== []) {
            throw new InvalidArgumentException(json_encode($errores, JSON_UNESCAPED_UNICODE));
        }

        // Devuelve los datos limpios con el teléfono opcional normalizado.
        return [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono !== '' ? $telefono : null,
        ];
    }
}
