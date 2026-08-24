<?php
// Controlador HTTP que coordina el CRUD de clientes.

// ClienteController traduce peticiones HTTP a llamadas del servicio.
// No contiene SQL: coordina JSON, códigos HTTP y respuestas públicas.
class ClienteController
{
    // Servicio que concentra las reglas de negocio de clientes.
    private ClienteService $service;

    // Recibe el servicio mediante inyección de dependencias.
    public function __construct(ClienteService $service)
    {
        $this->service = $service;
    }

    // Atiende GET /api/clientes y devuelve la colección completa.
    public function index(): void
    {
        try {
            Response::ok($this->service->listar());
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    // Atiende GET /api/clientes/{id} y traduce ausencia a 404.
    public function show(int $id): void
    {
        try {
            Response::ok($this->service->buscarPorId($id));
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), 400);
        } catch (RuntimeException $e) {
            Response::error($e->getMessage(), 404);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    // Atiende POST, lee JSON y devuelve el recurso creado con 201.
    public function store(): void
    {
        try {
            Response::ok($this->service->crear($this->jsonBody()), 'Cliente creado correctamente', 201);
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), 422, $this->validationErrors($e));
        } catch (PDOException $e) {
            $this->databaseError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    // Atiende PUT, valida el cuerpo y devuelve el cliente actualizado.
    public function update(int $id): void
    {
        try {
            Response::ok($this->service->actualizar($id, $this->jsonBody()), 'Cliente actualizado correctamente');
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), 422, $this->validationErrors($e));
        } catch (RuntimeException $e) {
            Response::error($e->getMessage(), 404);
        } catch (PDOException $e) {
            $this->databaseError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    // Atiende DELETE y devuelve 404 cuando el cliente no existe.
    public function destroy(int $id): void
    {
        try {
            $this->service->eliminar($id);
            Response::ok(null, 'Cliente eliminado correctamente');
        } catch (InvalidArgumentException $e) {
            Response::error($e->getMessage(), 400);
        } catch (RuntimeException $e) {
            Response::error($e->getMessage(), 404);
        } catch (PDOException $e) {
            $this->databaseError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    // Lee y valida que el cuerpo HTTP sea un objeto JSON representado como array.
    private function jsonBody(): array
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!is_array($body) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('El cuerpo debe ser un JSON válido');
        }

        return $body;
    }

    // Convierte el mensaje serializado por el servicio en errores por campo.
    private function validationErrors(InvalidArgumentException $exception): array
    {
        $errores = json_decode($exception->getMessage(), true);
        return is_array($errores) ? $errores : [];
    }

    // Traduce violaciones de integridad, como email duplicado, a 422.
    private function databaseError(PDOException $exception): void
    {
        if ($exception->getCode() === '23000') {
            Response::error('El email ya está registrado', 422, ['email' => 'Debe ser único']);
        }

        $this->serverError($exception);
    }

    // Registra el detalle internamente y oculta información sensible al cliente.
    private function serverError(Throwable $exception): void
    {
        error_log($exception->getMessage());
        Response::error('Error interno del servidor', 500);
    }
}
