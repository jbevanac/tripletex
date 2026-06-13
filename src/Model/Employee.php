<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\UserType;

final class Employee implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?string $url = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $displayName = null,
        public ?string $employeeNumber = null,
        public ?string $dateOfBirth = null,
        public ?string $email = null,
        public ?Country $phoneNumberMobileCountry = null,
        public ?string $phoneNumberMobile = null,
        public ?string $phoneNumberHome = null,
        public ?string $phoneNumberWork = null,
        public ?string $nationalIdentityNumber = null,
        public ?string $dnumber = null,
        public ?array $internationalId = null,
        public ?string $bankAccountNumber = null,
        public ?string $iban = null,
        public ?string $bic = null,
        public ?int $creditorBankCountryId = null,
        public ?bool $usesAbroadPayment = null,
        public ?UserType $userType = null,
        public ?bool $allowInformationRegistration = null,
        public ?bool $isContact = null,
        public ?bool $isProxy = null,
        public ?string $comments = null,
        public ?Address $address = null,
        public ?array $department = null,
        public ?array $employments = null,
        public ?array $holidayAllowanceEarned = null,
        public ?array $employeeCategory = null,
        public ?bool $isAuthProjectOverviewUrl = null,
        public ?int $pictureId = null,
        public ?int $companyId = null,
        public ?bool $vismaConnect2FActive = null,
    ) {
    }
}
