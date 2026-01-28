<?php

namespace Tripletex\Model;

use Ramsey\Collection\Collection;

readonly class ListResponse
{
    public function __construct(
        public ?int $fullResultSize = null,
        public ?int $from = null,
        public ?int $count = null,
        public ?string $versionDigest = null,
        public ?Collection $values = null,
    ) {
    }
}
