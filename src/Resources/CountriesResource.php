<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Country;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class CountriesResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @throws ApiException
     */
    public function find(int $id): Country|ErrorResponse
    {
        return $this->findResource(
            modelClass: Country::class,
            path: 'country/'.$id,
        );
    }

    /**
     * @throws ApiException
     */
    public function findRaw(int $id): array
    {
        return $this->findResource(
            modelClass: Country::class,
            path: 'country/'.$id,
            raw: true,
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Country::class,
            path: 'country',
            filters: $filters,
            page: $page
        );
    }

}
