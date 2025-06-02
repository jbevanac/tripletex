<?php

namespace Tripletex\Resources\Concerns;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;

/**
 * @mixin ResourceInterface
 */
trait CanCreateCollection
{
    public function createCollection(string $modelClass, array $data): Collection
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $data = $data['values'] ?? $data;

        return new Collection(
            collectionType: $modelClass,
            data: array_map(
                fn (array $item): ModelInterface => $modelClass::make($item),
                $data
            )
        );
    }

}
