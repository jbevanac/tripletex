<?php

namespace Tripletex\Resources;

use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\Customer;
use Tripletex\Exceptions\FailedToCreateResourceException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;

class InvoiceResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;

    public function create(Customer $customer): Customer
    {
         $request = $this->request(
            method: Method::POST,
            url: 'invoices',
        );

         $request = $this->attachPayLoad(
             request: $request,
             payload: $customer->toJson(),
         );

         try {
             $response = $this->getSdk()->client()->sendRequest(
                 request: $request,
             );
         } catch (\Throwable $e) {
            throw new FailedToCreateResourceException(
                message: 'Failed to create Invoice',
                previous: $e,
            );
         }

        return Customer::make(
            data: json_decode(
                json: $response->getBody(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            )
        );
    }
}