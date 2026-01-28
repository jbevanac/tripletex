<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Customer;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
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
     * @param array{name: string, email?: string, organizationNumber?: string, invoiceEmail?: string} $data
     * @throws TripletexException
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
     * @throws TripletexException
     */
    public function update(array $data): Customer|ErrorResponse
    {
        /** @var Customer $customer */
        $customer = Customer::make($data);

        return $this->updateResource(
            model: $customer,
            path: 'customer/'.$customer->id,
        );
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id): Customer|ErrorResponse
    {
        return $this->findResource(
            modelClass: Customer::class,
            path: 'customer/'.$id,
        );
    }

    /**
     * @throws TripletexException
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
