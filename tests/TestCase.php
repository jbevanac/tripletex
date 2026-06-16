<?php

namespace Tripletex\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tripletex\TripletexSDK;

abstract class TestCase extends BaseTestCase
{
    private function env(string $key, string $default = ''): string
    {
        return $_ENV[$key] ?? (getenv($key) ?: $default);
    }

    protected function sdkFromEnv(): TripletexSDK
    {
        return new TripletexSDK(
            baseUrl: $this->env('TRIPLETEX_URL', 'https://api-test.tripletex.tech/v2'),
            consumerToken: $this->env('TRIPLETEX_CONSUMER_TOKEN'),
            employeeToken: $this->env('TRIPLETEX_EMPLOYEE_TOKEN'),
        );
    }

    protected function skipIfNoCredentials(): void
    {
        if (empty($this->env('TRIPLETEX_CONSUMER_TOKEN')) || empty($this->env('TRIPLETEX_EMPLOYEE_TOKEN'))) {
            $this->markTestSkipped('TRIPLETEX_CONSUMER_TOKEN and TRIPLETEX_EMPLOYEE_TOKEN must be set in .env');
        }
    }
}
