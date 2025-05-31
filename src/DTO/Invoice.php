<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;

class Invoice implements ModelInterface
{
    use Model;

    public const string CREATE_PATH = 'invoice';
    public const string LIST_PATH = '';

    public function __construct(
        public int $id,
    ) {
    }

}