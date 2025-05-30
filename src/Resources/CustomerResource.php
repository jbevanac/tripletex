<?php

namespace Tripletex\Resources;

use JustSteveKing\Tools\Http\Enums\Method;
use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\Customer;
use Tripletex\Enum\Sort;
use Tripletex\Exceptions\FailedToCreateResourceException;
use Tripletex\Exceptions\FailedToFetchResourceException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;

final class CustomerResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;

    public function create(Customer $customer): Customer
    {
        $request = $this->request(
            method: Method::POST,
            url: 'customer',
        );

        $request = $this->attachPayLoad(
            request: $request,
            payload: $customer->toJson(),
        );

        try {
            $response = $this->getSdk()->client()->sendRequest(
                request: $request,
            );
        } catch (\Throwable $e) {
            throw new FailedToCreateResourceException(
                message: 'Failed to create Invoice',
                previous: $e,
            );
        }

        $responseData = json_decode(
            json: $response->getBody()->getContents(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        return Customer::make(
            data: $responseData['value'] ?? $responseData
        );
    }

    /**
     * @throws FailedToFetchResourceException
     * @throws \JsonException
     */
    public function list(array $filters = [], ?Sort $sort = null, ?string $direction = null, ?int $page = null): Collection
    {
        $request = $this->applyFilters(
            request: $this->request(
                method: Method::GET,
                url: 'customers',
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

        try {
            $response = $this->sdk->client()->sendRequest(
                request: $request,
            );
        } catch (\Throwable $exception) {
            throw new FailedToFetchResourceException(
                message: 'Failed to fetch customer list from the API.',
                previous: $exception
            );
        }

        return new Collection(
            collectionType: Customer::class,
            data: array_map(
                callback: static fn (array $data): Customer => Customer::make(
                    data: $data,
                ),
                array: (array) json_decode(
                    json: $response->getBody()->getContents(),
                    associative: true,
                    flags: JSON_THROW_ON_ERROR,
                )
            )
        );
    }
}