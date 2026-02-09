# Tripletex v2 SDK for PHP
## Features

- Contact.
- Customer.
- Employee.
- Invoice.
- Orders.
- Webhook.

## Installation

Install via Composer:

```bash
composer require jbevanac/tripletex
```

## Usage

Initialize the SDK
```php
use Tripletex\TripletexSDK;
use Tripletex\Plugins\UserAgentPlugin;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

/* To avoid unnecessary authentication calls and repeated token requests */
$psr6Cache = new FilesystemAdapter('tripletex', 3600, CACHE_DIR);
$cache = new Psr16Cache($psr6Cache);

$userAgent = new UserAgentPlugin(YOUR_APP.' '.YOUR_EMAIL);

$sdk = new TripletexSDK(
    baseUrl: 'https://api-test.tripletex.tech/v2', // Or prod: https://tripletex.no/v2
    applicationKey: 'YOUR_APPLICATION_KEY',
    subscriptionKey: 'YOUR_SUBSCRIPTION_KEY',
    clientKey: 'YOUR_CLIENT_KEY',
    plugins: [$userAgent],
    cache: $cache,
    cacheKey: 'tripletex_session_token', // key under which the session token is stored
);
```
