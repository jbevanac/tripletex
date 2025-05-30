<?php

namespace Tripletex\Resources\Concerns;

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Contracts\ResourceInterface;
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
    public function createResource(object $dto, string $url, ?callable $factory = null): object
    {
        $request = $this->request(
            method: Method::POST,
            url: $url,
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
                message: 'Failed to create resource at ' . $url,
                previous: $e,
            );
        }

        $responseData = json_decode(
            json: $response->getBody()->getContents(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        $data = $responseData['value'] ?? $responseData;

        if ($factory) {
            return $factory($data);
        }

        // Fallback if no factory provided, just return the raw data
        return $data;
    }
}