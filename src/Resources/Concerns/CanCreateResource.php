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
        $request = $this->request(
            method: Method::POST,
            url: $path,
            body: $model->toJson(),
            headers: ['Content-Type' => 'application/json; charset=utf-8']
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
