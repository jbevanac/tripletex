<?php

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\ErrorResponse;
use Tripletex\Exceptions\ApiException;

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
     * @return ErrorResponse|ModelInterface
     * @throws ApiException
     */
    public function createResource(ModelInterface $dto, string $path): ErrorResponse|ModelInterface
    {
        $request = $this->request(
            method: Method::POST,
            url: $path,
        );

        $request = $this->attachPayLoad(
            request: $request,
            payload: $dto->toJson(),
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (201 == $response->getStatusCode()) {
            return $dto::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}
