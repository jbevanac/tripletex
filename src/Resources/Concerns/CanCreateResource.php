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
trait CanCreateResource
{
    /**
     * @throws TripletexException
     */
    public function createResource(ModelInterface $model, array|string $path): ErrorResponse|ModelInterface
    {
        $request = $this->attachPayLoad(
            request: $this->request(
                method: Method::POST,
                url: $path,
                headers: ['Content-Type' => 'application/json; charset=utf-8']
            ),
            payload: $model->toJson(),
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (201 == $response->getStatusCode()) {
            return $model::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}
