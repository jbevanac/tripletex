<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;

class Invoice implements ModelInterface
{
    use DTOTrait;

    public function __construct(
        public int $id,
    ) {
    }

}