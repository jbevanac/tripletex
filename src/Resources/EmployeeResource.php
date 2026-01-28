<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\Employee;
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
     * @param array{name: string, email?: string} $data
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
     * @throws TripletexException
     */
    public function find(int $id): Employee|ErrorResponse
    {
        return $this->findResource(
            modelClass: Employee::class,
            path: [self::PATH, $id],
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
