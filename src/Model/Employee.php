<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\UserType;

final class Employee implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id,
        public ?string $url,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $displayName,
        public ?string $employeeNumber,
        public ?string $dateOfBirth,
        public ?string $email,
        public ?Country $phoneNumberMobileCountry,
        public ?string $phoneNumberMobile,
        public ?string $phoneNumberHome,
        public ?string $phoneNumberWork,
        public ?string $nationalIdentityNumber,
        public ?string $dnumber,
        public ?array $internationalId,
        public ?string $bankAccountNumber,
        public ?string $iban,
        public ?string $bic,
        public ?int $creditorBankCountryId,
        public ?bool $usesAbroadPayment,
        public ?UserType $userType,
        public ?bool $allowInformationRegistration,
        public ?bool $isContact,
        public ?bool $isProxy,
        public ?string $comments,
        public ?Address $address,
        public ?array $department,
        public ?array $employments,
        public ?array $holidayAllowanceEarned,
        public ?array $employeeCategory,
        public ?bool $isAuthProjectOverviewUrl,
        public ?int $pictureId,
        public ?int $companyId,
        public ?bool $vismaConnect2FActive,
    ) {
    }
}
