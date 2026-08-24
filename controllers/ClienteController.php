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
            // Obtiene todos los clientes y envía una respuesta exitosa.
            Response::ok($this->service->listar());
        } catch (Throwable $e) {
            // Convierte cualquier excepción no prevista en un error controlado.
            $this->serverError($e);
        }
    }

    // Atiende GET /api/clientes/{id} y traduce ausencia a 404.
    public function show(int $id): void
    {
        try {
            // Busca el cliente solicitado y devuelve sus datos.
            Response::ok($this->service->buscarPorId($id));
        } catch (InvalidArgumentException $e) {
            // Informa que el identificador recibido no es válido.
            Response::error($e->getMessage(), 400);
        } catch (RuntimeException $e) {
            // Informa que el cliente solicitado no existe.
            Response::error($e->getMessage(), 404);
        } catch (Throwable $e) {
            // Oculta los detalles de errores inesperados.
            $this->serverError($e);
        }
    }

    // Atiende POST, lee JSON y devuelve el recurso creado con 201.
    public function store(): void
    {
        try {
            // Lee el JSON, crea el cliente y devuelve el recurso generado.
            Response::ok($this->service->crear($this->jsonBody()), 'Cliente creado correctamente', 201);
        } catch (InvalidArgumentException $e) {
            // Devuelve los errores de validación del cuerpo recibido.
            Response::error($e->getMessage(), 422, $this->validationErrors($e));
        } catch (PDOException $e) {
            // Traduce los errores producidos por la base de datos.
            $this->databaseError($e);
        } catch (Throwable $e) {
            // Gestiona cualquier fallo no contemplado.
            $this->serverError($e);
        }
    }

    // Atiende PUT, valida el cuerpo y devuelve el cliente actualizado.
    public function update(int $id): void
    {
        try {
            // Lee el JSON, actualiza el cliente y responde con el resultado.
            Response::ok($this->service->actualizar($id, $this->jsonBody()), 'Cliente actualizado correctamente');
        } catch (InvalidArgumentException $e) {
            // Devuelve los errores de validación del cuerpo recibido.
            Response::error($e->getMessage(), 422, $this->validationErrors($e));
        } catch (RuntimeException $e) {
            // Informa que el cliente a actualizar no existe.
            Response::error($e->getMessage(), 404);
        } catch (PDOException $e) {
            // Traduce los errores producidos por la base de datos.
            $this->databaseError($e);
        } catch (Throwable $e) {
            // Gestiona cualquier fallo no contemplado.
            $this->serverError($e);
        }
    }

    // Atiende DELETE y devuelve 404 cuando el cliente no existe.
    public function destroy(int $id): void
    {
        try {
            // Solicita al servicio la eliminación del cliente.
            $this->service->eliminar($id);
            // Confirma que la eliminación terminó correctamente.
            Response::ok(null, 'Cliente eliminado correctamente');
        } catch (InvalidArgumentException $e) {
            // Informa que el identificador recibido no es válido.
            Response::error($e->getMessage(), 400);
        } catch (RuntimeException $e) {
            // Informa que el cliente solicitado no existe.
            Response::error($e->getMessage(), 404);
        } catch (PDOException $e) {
            // Traduce los errores producidos por la base de datos.
            $this->databaseError($e);
        } catch (Throwable $e) {
            // Gestiona cualquier fallo no contemplado.
            $this->serverError($e);
        }
    }

    // Lee y valida que el cuerpo HTTP sea un objeto JSON representado como array.
    private function jsonBody(): array
    {
        // Lee el contenido bruto enviado en la petición HTTP.
        $body = json_decode(file_get_contents('php://input'), true);
        if (!is_array($body) || json_last_error() !== JSON_ERROR_NONE) {
            // Rechaza cuerpos vacíos, inválidos o que no representen un objeto JSON.
            throw new InvalidArgumentException('El cuerpo debe ser un JSON válido');
        }

        // Devuelve los datos decodificados para la capa de servicio.
        return $body;
    }

    // Convierte el mensaje serializado por el servicio en errores por campo.
    private function validationErrors(InvalidArgumentException $exception): array
    {
        // Intenta convertir el mensaje serializado en errores por campo.
        $errores = json_decode($exception->getMessage(), true);
        // Devuelve un array vacío cuando el mensaje no contiene errores estructurados.
        return is_array($errores) ? $errores : [];
    }

    // Traduce violaciones de integridad, como email duplicado, a 422.
    private function databaseError(PDOException $exception): void
    {
        // Comprueba si la base de datos rechazó un valor duplicado.
        if ($exception->getCode() === '23000') {
            // Expone un mensaje útil sin mostrar detalles internos de PDO.
            Response::error('El email ya está registrado', 422, ['email' => 'Debe ser único']);
        }

        // Trata cualquier otro error de base de datos como fallo interno.
        $this->serverError($exception);
    }

    // Registra el detalle internamente y oculta información sensible al cliente.
    private function serverError(Throwable $exception): void
    {
        // Registra el detalle técnico únicamente en los logs del servidor.
        error_log($exception->getMessage());
        // Devuelve un mensaje genérico para no filtrar información sensible.
        Response::error('Error interno del servidor', 500);
    }
}
