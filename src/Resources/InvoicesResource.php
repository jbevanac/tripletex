<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\ErrorResponse;
use Tripletex\DTO\Invoice;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

class InvoicesResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @throws ApiException
     */
    public function create(array $data): Invoice|ErrorResponse
    {
        $invoice = Invoice::make($data);

        return $this->createResource(
            dto: $invoice
        );
    }

    /**
     * @throws ApiException
     */
    public function find(int $id): Invoice|ErrorResponse
    {
        return $this->findResource(
            modelClass: Invoice::class,
            id: $id,
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Invoice::class,
            filters: $filters,
            page: $page
        );
    }
}
