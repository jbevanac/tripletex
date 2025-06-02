<?php

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\ApiException;

/**
 * @mixin ResourceInterface
 */
trait CanCreateResource
{
    /**
     * @throws ApiException
     */
    public function createResource(ModelInterface $model, string $path): ErrorResponse|ModelInterface
    {
        $request = $this->request(
            method: Method::POST,
            url: $path,
        );

        $request = $this->attachPayLoad(
            request: $request,
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
