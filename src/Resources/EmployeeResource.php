<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Contact;
use Tripletex\Model\Employee;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
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
    // use CanUpdateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @param array{name: string, email?: string} $data
     * @throws ApiException
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
     * @throws ApiException
     */
    public function find(int $id): Employee|ErrorResponse
    {
        return $this->findResource(
            modelClass: Employee::class,
            path: [self::PATH, $id],
        );
    }

    /**
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Employee::class,
            path: self::PATH,
            filters: $filters,
            page: $page
        );
    }

}
