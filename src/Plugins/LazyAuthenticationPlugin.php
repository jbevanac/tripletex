<?php

namespace Tripletex\Plugins;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Tripletex\TripletexSDK;

final readonly class LazyAuthenticationPlugin implements Plugin
{
    public function __construct(
        private TripletexSDK $sdk,
    ) {
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $token = $this->sdk->loadOrCreateSessionToken();
        $token = base64_encode("0:$token");
        $request = $request->withHeader('Authorization', 'Basic ' . $token);

        return $next($request);
    }
}
