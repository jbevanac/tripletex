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
trait CanFindResource
{
    /**
     *
     * @throws ApiException
     */
    public function findResource(string $modelClass, int $id): ModelInterface|ErrorResponse
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->request(
            method: Method::GET,
            url: $modelClass::CREATE_PATH.'/'.$id,
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (201 == $response->getStatusCode()) {
            return $modelClass::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}
