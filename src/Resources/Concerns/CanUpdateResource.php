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
trait CanUpdateResource
{
    /**
     * @throws ApiException
     */
    public function updateResource(ModelInterface $model, string $path): ErrorResponse|ModelInterface
    {
        $request = $this->request(
            method: Method::PUT,
            url: $path,
        );

        $request = $this->attachPayLoad(
            request: $request,
            payload: $model->toJson(),
        );

        $response = $this->sendRequest($request);
        $responseData = $this->decodeJsonResponse($response);
        $data = $responseData['value'] ?? $responseData;

        if (200 == $response->getStatusCode()) {
            return $model::make(data: $data);
        }

        return ErrorResponse::make(data: $data);
    }
}
