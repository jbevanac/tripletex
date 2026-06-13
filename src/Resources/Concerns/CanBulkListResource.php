<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\FailedToDecodeJsonResponseException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Exceptions\SerializerException;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\ListResponse;

/**
 * @mixin ResourceInterface
 */
trait CanBulkListResource
{
    use CanCreateListResponse;

    /**
     * @param ModelInterface[] $models
     * @throws FailedToSendRequestException
     * @throws FailedToDecodeJsonResponseException
     * @throws SerializerException
     */
    public function createListResource(string $modelClass, array $models, array|string $path): ErrorResponse|ListResponse
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->request(
            method: Method::POST,
            url: $path,
            body: $this->modelsToPayLoad($models),
            headers: ['Content-Type' => 'application/json; charset=utf-8'],
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (201 === $response->getStatusCode()) {
            return $this->createListResponse(
                modelClass: $modelClass,
                data: $data
            );
        }

        return ErrorResponse::make(data: $data);
    }

    /**
     * @throws FailedToSendRequestException
     * @throws FailedToDecodeJsonResponseException
     */
    public function deleteListResource(array|string $path, array $filters): true|ErrorResponse
    {
        $request = $this->request(
            method: Method::DELETE,
            url: $path,
            filters: $filters,
        );

        $response = $this->sendRequest($request);

        if (204 === $response->getStatusCode()) {
            return true;
        }

        $body = (string) $response->getBody();
        if ($body === '') {
            return ErrorResponse::make([]);
        }

        try {
            $responseData = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new FailedToDecodeJsonResponseException('Invalid JSON response from API', $e->getCode(), $e);
        }

        return ErrorResponse::make($responseData);
    }

    /**
     * @throws SerializerException
     * @throws FailedToSendRequestException
     * @throws FailedToDecodeJsonResponseException
     */
    public function updateListResource(string $modelClass, array $models, array|string $path): ListResponse|ErrorResponse
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->request(
            method: Method::PUT,
            url: $path,
            body: $this->modelsToPayLoad($models),
            headers: ['Content-Type' => 'application/json; charset=utf-8'],
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (200 === $response->getStatusCode()) {
            return $this->createListResponse(
                modelClass: $modelClass,
                data: $data
            );
        }

        return ErrorResponse::make(data: $data);
    }

    /**
     * @throws SerializerException
     */
    private function modelsToPayLoad(array $models): string
    {
        try {
            return json_encode(
                array_map(
                    static function ($model): array {
                        if (!$model instanceof ModelInterface) {
                            throw new \InvalidArgumentException('Expected ModelInterface, got '.get_debug_type($model));
                        }

                        return json_decode($model->toJson(), true, 512, JSON_THROW_ON_ERROR);
                    },
                    $models
                ),
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            throw new SerializerException('Serialization failed: '.$e->getMessage(), 0, $e);
        }
    }
}
