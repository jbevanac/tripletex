<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Country;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ListResponse;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class CountriesResource implements ResourceInterface
{
    private const string PATH = 'country';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;
    use CanCreateListResponse;

    /**
     * @throws TripletexException
     */
    public function find(int $id): Country|ErrorResponse
    {
        return $this->findResource(
            modelClass: Country::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Country::class,
            path: self::PATH,
            filters: $filters,
        );
    }

}
