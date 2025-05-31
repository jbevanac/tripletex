<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\Customer;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;

class InvoiceResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;

    public function create(ModelInterface $model): Customer
    {
        return $this->createResource(
            dto: $model,
            url: $model::CREATE_PATH,
            factory: fn(array $data) => $model::make(data: $data),
        );
    }
}