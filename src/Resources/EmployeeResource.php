<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Employee;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ListResponse;
use Tripletex\Query\Filters\FieldsFilter;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateListResponse;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class EmployeeResource implements ResourceInterface
{
    private const string PATH = 'employee';

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
     *     employeeNumber?: string,
     *     dateOfBirth?: string,
     *     email?: string,
     *     phoneNumberMobileCountry?: int,
     *     phoneNumberMobile?: string,
     *     phoneNumberHome?: string,
     *     phoneNumberWork?: string,
     *     nationalIdentityNumber?: string,
     *     dnumber?: string,
     *     bankAccountNumber?: string,
     *     iban?: string,
     *     bic?: string,
     *     creditorBankCountryId?: int,
     *     usesAbroadPayment?: bool,
     *     userType?: string,
     *     allowInformationRegistration?: bool,
     *     isContact?: bool,
     *     isProxy?: bool,
     *     comments?: string,
     *     address?: array,
     *     department?: array,
     *     employments?: array,
     * } $data
     * @throws TripletexException
     */
    public function create(array $data): Employee|ErrorResponse
    {
        $employee = Employee::make($data);

        return $this->createResource(
            model: $employee,
            path: self::PATH,
        );
    }

    /**
     * @param array{
     *     version?: int,
     *     firstName?: string,
     *     lastName?: string,
     *     employeeNumber?: string,
     *     dateOfBirth?: string,
     *     email?: string,
     *     phoneNumberMobileCountry?: int,
     *     phoneNumberMobile?: string,
     *     phoneNumberHome?: string,
     *     phoneNumberWork?: string,
     *     nationalIdentityNumber?: string,
     *     dnumber?: string,
     *     bankAccountNumber?: string,
     *     iban?: string,
     *     bic?: string,
     *     creditorBankCountryId?: int,
     *     usesAbroadPayment?: bool,
     *     userType?: string,
     *     allowInformationRegistration?: bool,
     *     isContact?: bool,
     *     isProxy?: bool,
     *     comments?: string,
     *     address?: array,
     *     department?: array,
     *     employments?: array,
     * } $data
     * @throws TripletexException
     */
    public function update(int $id, array $data): Employee|ErrorResponse
    {
        return $this->updateResource(
            model: Employee::make($data),
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id, ?FieldsFilter $fieldsFilter = null): Employee|ErrorResponse
    {
        return $this->findResource(
            modelClass: Employee::class,
            path: [self::PATH, $id],
            filters: $fieldsFilter ? [$fieldsFilter] : [],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Employee::class,
            path: self::PATH,
            filters: $filters,
        );
    }

}
