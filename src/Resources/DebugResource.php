<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\FailedToDecodeJsonResponseException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Model\Customer;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class DebugResource
{
    use CanAccessSDK;
    use CanCreateRequest;

    /**
     * @throws ApiException
     */
    public function getDebugData(string $url): array
    {
        $request = $this->request(
            method: Method::GET,
            url: $url,
        );

        $response = $this->sendRequest($request);
        return $this->decodeJsonResponse($response);
    }
}
