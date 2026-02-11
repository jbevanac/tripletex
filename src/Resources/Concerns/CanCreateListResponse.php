<?php

namespace Tripletex\Resources\Concerns;

use Ramsey\Collection\Collection;
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
trait CanCreateListResponse
{
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

        if (201 == $response->getStatusCode()) {
            return $this->createListResponse(
                modelClass: $modelClass,
                data: $data
            );
        }

        return ErrorResponse::make(data: $data);
    }

    /**
     * @throws SerializerException
     * @throws FailedToSendRequestException
     * @throws FailedToDecodeJsonResponseException
     */
    public function deleteListResource(array|string $path, array $filters): true|ErrorResponse
    {
        $request = $this->request(
            method: Method::DELETE,
            url: $path,
            filters: $filters,
            headers: ['Content-Type' => 'application/json; charset=utf-8'],
        );

        $response = $this->sendRequest($request);
        $status = $response->getStatusCode();

        if (204 === $status) {
            return true;
        }

        $responseData = $this->decodeJsonResponse($response);

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

        if (200 == $response->getStatusCode()) {
            return $this->createListResponse(
                modelClass: $modelClass,
                data: $data
            );
        }

        return ErrorResponse::make(data: $data);
    }

    public function createListResponse(string $modelClass, array $data): ListResponse
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $values = $data['values'] ?? [];

        return new ListResponse(
            fullResultSize: $data['fullResultSize'] ?? null,
            from: $data['from'] ?? null,
            count: $data['count'] ?? null,
            versionDigest: $data['versionDigest'] ?? null,
            values: new Collection(
                collectionType: $modelClass,
                data: array_map(
                    fn (array $item): ModelInterface => $modelClass::make($item),
                    $values
                )
            )
        );
    }

    /**
     * @throws SerializerException
     */
    private function modelsToPayLoad(array $models): string
    {
        try {
            return json_encode(
                array_map(
                    static fn ($model) => json_decode($model->toJson(), true, 512, JSON_THROW_ON_ERROR),
                    $models
                ),
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            throw new SerializerException('Serialization failed: '.$e->getMessage(), 0, $e);
        }
    }
}
