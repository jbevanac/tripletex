<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\Invoice;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

class InvoicesResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
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
            model: $invoice,
            path: 'invoice',
        );
    }

    /**
     * @throws ApiException
     */
    public function find(int $id): Invoice|ErrorResponse
    {
        return $this->findResource(
            modelClass: Invoice::class,
            path: 'invoice/'.$id,
        );
    }


    /**
     * @throws ApiException
     */
    public function findRaw(int $id): array
    {
        return $this->findResource(
            modelClass: Invoice::class,
            path: 'invoice/'.$id,
            raw: true,
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Invoice::class,
            path: 'invoice',
            filters: $filters,
            page: $page
        );
    }
}
