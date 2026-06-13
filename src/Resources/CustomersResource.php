<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Customer;
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

final class CustomersResource implements ResourceInterface
{
    private const string PATH = 'customer';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateListResponse;
    use CanCreateResource;
    use CanUpdateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @param array{
     *     name: string,
     *     customerNumber?: int,
     *     isPrivateIndividual?: bool,
     *     email?: string,
     *     invoiceEmail?: string,
     *     overdueNoticeEmail?: string,
     *     organizationNumber?: string,
     *     phoneNumber?: string,
     *     phoneNumberMobile?: string,
     *     language?: string,
     *     invoiceSendMethod?: string,
     *     emailAttachmentType?: string,
     *     invoicesDueIn?: int,
     *     invoicesDueInType?: string,
     *     postalAddress?: array,
     *     physicalAddress?: array,
     * } $data
     * @throws TripletexException
     */
    public function create(array $data): Customer|ErrorResponse
    {
        $customer = Customer::make($data);

        return $this->createResource(
            model: $customer,
            path: self::PATH,
        );
    }

    /**
     * @param array{
     *     version?: int,
     *     name?: string,
     *     customerNumber?: int,
     *     isPrivateIndividual?: bool,
     *     email?: string,
     *     invoiceEmail?: string,
     *     overdueNoticeEmail?: string,
     *     organizationNumber?: string,
     *     phoneNumber?: string,
     *     phoneNumberMobile?: string,
     *     language?: string,
     *     invoiceSendMethod?: string,
     *     emailAttachmentType?: string,
     *     invoicesDueIn?: int,
     *     invoicesDueInType?: string,
     *     postalAddress?: array,
     *     physicalAddress?: array,
     * } $data
     * @throws TripletexException
     */
    public function update(int $id, array $data): Customer|ErrorResponse
    {
        return $this->updateResource(
            model: Customer::make($data),
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id): Customer|ErrorResponse
    {
        return $this->findResource(
            modelClass: Customer::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Customer::class,
            path: self::PATH,
            filters: $filters,
        );
    }

}
