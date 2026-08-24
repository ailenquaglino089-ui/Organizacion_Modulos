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
        return $this->repo->listar();
    }

    // Verifica el ID y garantiza que el cliente exista.
    public function buscarPorId(int $id): array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El ID debe ser un entero positivo');
        }

        $cliente = $this->repo->buscarPorId($id);
        if ($cliente === null) {
            throw new RuntimeException('Cliente no encontrado');
        }

        return $cliente;
    }

    // Valida, crea y vuelve a consultar el cliente para devolverlo completo.
    public function crear(array $datos): array
    {
        $datos = $this->validar($datos);
        $id = $this->repo->crear($datos);

        return $this->buscarPorId($id);
    }

    // Exige que el cliente exista, actualiza sus datos y devuelve el resultado.
    public function actualizar(int $id, array $datos): array
    {
        $this->buscarPorId($id);
        $datos = $this->validar($datos);
        $this->repo->actualizar($id, $datos);

        return $this->buscarPorId($id);
    }

    // Exige que el cliente exista antes de eliminarlo.
    public function eliminar(int $id): void
    {
        $this->buscarPorId($id);
        $this->repo->eliminar($id);
    }

    // Limpia campos y acumula errores de validación para responder al cliente.
    private function validar(array $datos): array
    {
        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $email = trim((string) ($datos['email'] ?? ''));
        $telefono = trim((string) ($datos['telefono'] ?? ''));
        $errores = [];

        if ($nombre === '') {
            $errores['nombre'] = 'El nombre es obligatorio';
        }

        if ($email === '') {
            $errores['email'] = 'El email es obligatorio';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errores['email'] = 'El email no tiene un formato válido';
        }

        if ($errores !== []) {
            throw new InvalidArgumentException(json_encode($errores, JSON_UNESCAPED_UNICODE));
        }

        return [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono !== '' ? $telefono : null,
        ];
    }
}
