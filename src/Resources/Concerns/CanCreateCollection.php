<?php

namespace Tripletex\Resources\Concerns;

use JustSteveKing\Tools\Http\Enums\Method;
use Ramsey\Collection\Collection;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\FailedToSendRequestException;

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

        return new Collection(
            collectionType: $modelClass,
            data: array_map(
                fn (array $item): ModelInterface => $modelClass::make($item),
                $data
            )
        );
    }

}
