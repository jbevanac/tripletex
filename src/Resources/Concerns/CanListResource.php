<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Model\ListResponse;

/**
 * @mixin ResourceInterface
 */
trait CanListResource
{
    /**
     * @throws FailedToSendRequestException
     * @throws TripletexException
     */
    public function listResource(string $modelClass, array|string $path, array $filters = []): ErrorResponse|ListResponse
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->request(
            method: Method::GET,
            url: $path,
            filters: $filters,
        );

        $response = $this->sendRequest($request);
        $data = $this->decodeJsonResponse($response);

        if (200 !== $response->getStatusCode()) {
            return ErrorResponse::make(data: $data);
        }

        return $this->createListResponse($modelClass, $data);
    }

}
