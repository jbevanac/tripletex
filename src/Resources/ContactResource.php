<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Contact;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ListResponse;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class ContactResource implements ResourceInterface
{
    private const string PATH = 'contact';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateResource;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;
    use CanCreateListResponse;

    /**
     * @param array{
     *     firstName: string,
     *     lastName: string,
     *     email?: string,
     *     phoneNumberMobileCountry?: int,
     *     phoneNumberMobile?: string,
     *     phoneNumberWork?: string,
     *     customer?: int,
     *     department?: int,
     *     isInactive?: bool,
     * } $data
     * @throws TripletexException
     */
    public function create(array $data): Contact|ErrorResponse
    {
        $contact = Contact::make($data);

        return $this->createResource(
            model: $contact,
            path: self::PATH,
        );
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id): Contact|ErrorResponse
    {
        return $this->findResource(
            modelClass: Contact::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Contact::class,
            path: self::PATH,
            filters: $filters,
        );
    }
}
