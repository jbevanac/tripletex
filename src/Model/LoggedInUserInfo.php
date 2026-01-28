<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

final class LoggedInUserInfo implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $employeeId,
        public ?int $actualEmployeeId,
        public ?Employee $employee,
        public ?int $companyId = null,
        public ?array $company = null,
        public ?bool $loggedInWithConnect = null,
        public ?bool $employeeIsProxy = null,
    ) {
    }
}
