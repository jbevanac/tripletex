<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

class Invoice implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public int $id,
    ) {
    }
}
