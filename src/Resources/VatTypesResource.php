<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\ListResponse;
use Tripletex\Model\VatType;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

final class VatTypesResource implements ResourceInterface
{
    private const string PATH = 'ledger/vatType';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanFindResource;
    use CanListResource;
    use CanCreateListResponse;

    /**
     * @throws TripletexException
     */
    public function find(int $id): VatType|ErrorResponse
    {
        return $this->findResource(
            modelClass: VatType::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: VatType::class,
            path: self::PATH,
            filters: $filters,
        );
    }

    /**
     * Order lines reference a vat type by id, while accountants talk about its number (e.g. "52").
     *
     * @throws TripletexException
     */
    public function findByNumber(string $number): VatType|ErrorResponse|null
    {
        $response = $this->list(['number' => $number]);

        if ($response instanceof ErrorResponse) {
            return $response;
        }

        foreach ($response->values ?? [] as $vatType) {
            if ($vatType->number === $number) {
                return $vatType;
            }
        }

        return null;
    }
}
