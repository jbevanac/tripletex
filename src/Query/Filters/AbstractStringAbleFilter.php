<?php

namespace Tripletex\Query\Filters;

use Tripletex\Contracts\FilterInterface;

abstract class AbstractStringAbleFilter implements FilterInterface
{
    protected array $stringAbles;

    public function __construct(int|string|array $stringAble)
    {
        $this->stringAbles = is_array($stringAble) ? $stringAble : [$stringAble];
    }

    abstract protected function name(): string;

    public function toQuery(): array
    {
        return [
            $this->name() => implode(',', $this->stringAbles),
        ];
    }
}
