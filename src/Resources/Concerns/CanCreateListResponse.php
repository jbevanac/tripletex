<?php

namespace Tripletex\Resources\Concerns;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ListResponse;

/**
 * @mixin ResourceInterface
 */
trait CanCreateListResponse
{
    public function createListResponse(string $modelClass, array $data): ListResponse
    {
        if (!is_subclass_of($modelClass, ModelInterface::class)) {
            throw new \InvalidArgumentException("$modelClass must implement ModelInterface");
        }

        $values = $data['values'] ?? [];

        return new ListResponse(
            fullResultSize: $data['fullResultSize'] ?? null,
            from: $data['from'] ?? null,
            count: $data['count'] ?? null,
            versionDigest: $data['versionDigest'] ?? null,
            values: new Collection(
                collectionType: $modelClass,
                data: array_map(
                    fn (array $item): ModelInterface => $modelClass::make($item),
                    $values
                )
            )
        );
    }
}
