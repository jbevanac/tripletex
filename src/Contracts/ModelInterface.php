<?php

namespace Tripletex\Contracts;

interface ModelInterface
{
    public function toJson(): string;

    public static function make(array $data): self;
}
