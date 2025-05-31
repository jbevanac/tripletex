<?php

namespace Tripletex\Contracts;

interface ModelInterface
{
    public const string CREATE_PATH = '';
    public const string LIST_PATH = '';

    public function toJson(): string;

    public static function make(array $data): self;
}
