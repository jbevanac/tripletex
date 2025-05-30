<?php

namespace Tripletex\DTO;

class Invoice
{
    use Model;

    public function __construct(
        public int $id,
    ) {
    }

}