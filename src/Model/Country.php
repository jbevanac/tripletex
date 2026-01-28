<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

final class Country implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?string $url = null,
        public ?string $name = null,
        public ?string $displayName = null,
        public ?string $isoAlpha2Code = null,
        public ?string $isoAlpha3Code = null,
        public ?string $isoNumericCode = null,
    ) {
    }
}
