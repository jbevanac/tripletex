<?php

namespace Tripletex\Resources\Concerns;

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\ErrorResponse;
use Tripletex\Exceptions\FailedToCreateResourceException;

/**
 * @mixin ResourceInterface
 */
trait CanCreateResource
{
    /**
     * Create a resource via POST request.
     *
     * @param object $dto
     * @param string $url
     * @param callable|null $factory A factory to create the DTO from API response data
     * @return object
     *
     * @throws FailedToCreateResourceException
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

        $responseData = json_decode(
            json: $response->getBody()->getContents(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        $data = $responseData['value'] ?? $responseData;

        if (201 == $response->getStatusCode()) {
            return $dto::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}