<?php

namespace Tripletex\Resources\Filters;

final readonly class Filter
{
    public function __construct(
        private string $key,
        private mixed $value,
    ) {
    }

    public function toQueryParameter(): string
    {
        return "$this->key=$this->value";
    }

    public static function make(string $key, mixed $value): self
    {
        return new self($key, $value);
    }
}
