<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
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

final class CustomersResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateResource;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @throws ApiException
     */
    public function create(array $data): Customer|ErrorResponse
    {
        $customer = Customer::make($data);

        return $this->createResource(
            model: $customer,
            path: 'customer',
        );
    }

    /**
     * @throws ApiException
     */
    public function find(int $id): Customer|ErrorResponse
    {
        return $this->findResource(
            modelClass: Customer::class,
            path: 'customer/'.$id,
        );
    }

    /**
     * @throws ApiException
     */
    public function findRaw(int $id): array
    {
        return $this->findResource(
            modelClass: Customer::class,
            path: 'customer/'.$id,
            raw: true,
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Customer::class,
            path: 'customer',
            filters: $filters,
            page: $page
        );
    }

}
