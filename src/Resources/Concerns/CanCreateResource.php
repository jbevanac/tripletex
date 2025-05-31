<?php

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\FailedToCreateResourceException;

/**
 * @mixin ResourceInterface
 */
trait CanCreateResource
{
    /**
     * Create a resource via POST request.
     *
     * @param ModelInterface $dto
     *
     * @return ModelInterface
     * @throws FailedToCreateResourceException
     * @throws ApiException
     */
    public function create(ModelInterface $dto): ModelInterface
    {
        $request = $this->request(
            method: Method::POST,
            url: $dto::CREATE_PATH,
        );

        $request = $this->attachPayLoad(
            request: $request,
            payload: $dto->toJson(),
        );

        try {
            $response = $this->getSdk()->client()->sendRequest(
                request: $request,
            );
        } catch (\Throwable $e) {
            throw new FailedToCreateResourceException(
                message: 'Failed to create resource at ' . $dto::CREATE_PATH,
                previous: $e,
            );
        }

        try {
            $responseData = json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            );
        } catch (\JsonException $e) {
            throw new ApiException(
                message: 'Invalid JSON response from API while creating resource at ' . $dto::CREATE_PATH,
                code: $e->getCode(),
                previous: $e,
            );
        }

        $data = $responseData['value'] ?? $responseData;

        if (201 == $response->getStatusCode()) {
            return $dto::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}