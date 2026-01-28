<?php

namespace Tripletex\Contracts;

interface FilterInterface
{
    public function toQuery(): array;
}
