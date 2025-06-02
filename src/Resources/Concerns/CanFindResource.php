<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Model\ErrorResponse;
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
    public function findResource(string $modelClass, string $path, bool $raw = false): ModelInterface|ErrorResponse|array
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->request(
            method: Method::GET,
            url: $path,
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);

        if ($raw) {
            return $responseData;
        }

        $data = $responseData['value'] ?? $responseData;
        if (200 == $response->getStatusCode()) {
            return $modelClass::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}
