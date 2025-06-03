<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Contact;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class ContactResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateResource;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @param array{name: string, email?: string} $data
     * @throws ApiException
     */
    public function create(array $data): Contact|ErrorResponse
    {
        $contact = Contact::make($data);

        return $this->createResource(
            model: $contact,
            path: 'contact',
        );
    }

    /**
     * @throws ApiException
     */
    public function find(int $id): Contact|ErrorResponse
    {
        return $this->findResource(
            modelClass: Contact::class,
            path: 'contact/'.$id,
        );
    }

    /**
     * @throws ApiException
     */
    public function findRaw(int $id): array
    {
        return $this->findResource(
            modelClass: Contact::class,
            path: 'contact/'.$id,
            raw: true,
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Contact::class,
            path: 'contact',
            filters: $filters,
            page: $page
        );
    }

}
