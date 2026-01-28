<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;

/**
 * @mixin ResourceInterface
 */
trait CanFindResource
{
    /**
     *
     * @throws TripletexException
     */
    public function findResource(string $modelClass, array|string $path, array $filters = []): ModelInterface|ErrorResponse|array
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->applyFilters(
            request: $this->request(
                method: Method::GET,
                url: $path,
            ),
            filters: $filters,
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);

        $data = $responseData['value'] ?? $responseData;
        if (200 == $response->getStatusCode()) {
            return $modelClass::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}
