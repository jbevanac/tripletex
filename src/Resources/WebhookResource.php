<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ErrorResponse;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Model\Subscription;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanDeleteResource;

final class WebhookResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;
    use CanCreateCollection;
    use CanDeleteResource;

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
    public function delete(int $id): true|ErrorResponse
    {
        return $this->deleteResource(
            path: ['event', 'subscription', $id],
        );
    }

}
