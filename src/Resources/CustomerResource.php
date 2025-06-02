<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\Customer;
use Tripletex\DTO\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

final class CustomerResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @throws ApiException
     */
    public function create(array $data): Customer|ErrorResponse
    {
        $customer = Customer::make($data);

        return $this->createResource(
            dto: $customer
        );
    }

    /**
     * @throws ApiException
     */
    public function find(int $id): Customer|ErrorResponse
    {
        return $this->findResource(
            modelClass: Customer::class,
            id: $id,
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Customer::class,
            filters: $filters,
            page: $page
        );
    }

}
