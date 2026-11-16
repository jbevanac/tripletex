<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\Account;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\ListResponse;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

final class LedgerAccountsResource implements ResourceInterface
{
    private const string PATH = 'ledger/account';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanFindResource;
    use CanListResource;
    use CanCreateListResponse;

    /**
     * @throws TripletexException
     */
    public function find(int $id): Account|ErrorResponse
    {
        return $this->findResource(
            modelClass: Account::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @param array{id?: string, number?: string, isBankAccount?: bool, isInactive?: bool, from?: int, count?: int, fields?: string} $filters
     *
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Account::class,
            path: self::PATH,
            filters: $filters,
        );
    }

    /**
     * Postings reference an account by id, while the chart of accounts is known by number (e.g. 3000).
     *
     * @throws TripletexException
     */
    public function findByNumber(int $number): Account|ErrorResponse|null
    {
        $response = $this->list(['number' => (string) $number]);

        if ($response instanceof ErrorResponse) {
            return $response;
        }

        foreach ($response->values ?? [] as $account) {
            if ($account->number === $number) {
                return $account;
            }
        }

        return null;
    }
}
