<?php

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Ramsey\Collection\Collection;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\FailedToSendRequestException;

/**
 * @mixin ResourceInterface
 */
trait CanListResource
{
    /**
     * @throws FailedToSendRequestException
     * @throws ApiException
     */
    public function listResource(string $modelClass, string $path, array $filters = [], ?int $page = null): ModelInterface|Collection
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $request = $this->applyFilters(
            request: $this->request(
                method: Method::GET,
                url: $path,
            ),
            filters: $filters
        );

        if (null !== $page) {
            $uri = $request->getUri()->withQuery(
                query: "page=$page",
            );
            $request = $request->withUri(
                uri: $uri,
                preserveHost: true,
            );
        }

        $response = $this->sendRequest($request);
        $data = $this->decodeJsonResponse($response);

        if (200 !== $response->getStatusCode()) {
            return ErrorResponse::make(data: $data);
        }

        return $this->createCollection($modelClass, $data);

    }

}
