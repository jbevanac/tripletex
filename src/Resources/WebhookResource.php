<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Exceptions\FailedToDecodeJsonResponseException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Exceptions\SerializerException;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\ListResponse;
use Tripletex\Model\Subscription;
use Tripletex\Query\Filters\FieldsFilter;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanBulkListResource;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanDeleteResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class WebhookResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanFindResource;
    use CanUpdateResource;
    use CanCreateResource;
    use CanCreateCollection;
    use CanDeleteResource;
    use CanListResource;
    use CanBulkListResource;

    /**
     * @param array{
     *     event: string,
     *     targetUrl: string,
     *     fields: ?string,
     *     authHeaderName: ?string,
     *     authHeaderValue: ?string,
     * } $data
     * @throws TripletexException
     */
    public function create(array $data): Subscription|ErrorResponse
    {
        $subscription = Subscription::make($data);

        return $this->createResource(
            model: $subscription,
            path: ['event', 'subscription'],
        );
    }

    /**
     * @throws TripletexException
     */
    public function createList(array $data): ListResponse|ErrorResponse
    {
        $subscriptions = array_map(
            static fn (array $sub) => Subscription::make($sub),
            $data
        );

        return $this->createListResource(
            modelClass: Subscription::class,
            models: $subscriptions,
            path: ['event', 'subscription', 'list'],
        );
    }

    /**
     * @throws TripletexException
     */
    public function find(int $id, ?FieldsFilter $fieldsFilter = null): Subscription|ErrorResponse
    {
        return $this->findResource(
            modelClass: Subscription::class,
            path: ['event', 'subscription', $id],
            filters: $fieldsFilter ? [$fieldsFilter] : [],
        );
    }

    /**
     * @throws TripletexException
     */
    public function list(array $filters = []): ListResponse|ErrorResponse
    {
        return $this->listResource(
            modelClass: Subscription::class,
            path: ['event', 'subscription'],
            filters: $filters,
        );
    }

    /**
     * @throws TripletexException
     */
    public function delete(int $id): true|ErrorResponse
    {
        return $this->deleteResource(
            path: ['event', 'subscription', $id],
        );
    }

    /**
     * @throws FailedToSendRequestException
     * @throws SerializerException
     * @throws FailedToDecodeJsonResponseException
     */
    public function deleteList(array $ids): true|ErrorResponse
    {
        return $this->deleteListResource(
            path: ['event', 'subscription', 'list'],
            filters: ['ids' => $ids],
        );
    }

    /**
     * @throws TripletexException
     */
    public function update(array $data, string|int $id): Subscription|ErrorResponse
    {
        return $this->updateResource(
            model: Subscription::make($data),
            path: ['event', 'subscription', $id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function updateList(array $data): ListResponse|ErrorResponse
    {
        $subscriptions = array_map(
            static fn (array $sub) => Subscription::make($sub),
            $data
        );

        return $this->updateListResource(
            modelClass: Subscription::class,
            models: $subscriptions,
            path: ['event', 'subscription', 'list'],
        );
    }
}
