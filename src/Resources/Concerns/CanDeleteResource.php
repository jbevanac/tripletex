<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;

/**
 * @mixin ResourceInterface
 */
trait CanDeleteResource
{
    /**
     *
     * @throws TripletexException
     */
    public function deleteResource(array|string $path): true|ErrorResponse
    {
        $request = $this->request(
            method: Method::DELETE,
            url: $path,
            headers: ['Content-Type' => 'application/json; charset=utf-8']
        );

        $response = $this->sendRequest($request);
        $status = $response->getStatusCode();

        if (204 === $status) {
            return true;
        }

        $responseData = $this->decodeJsonResponse($response);

        return ErrorResponse::make($responseData);
    }
}
