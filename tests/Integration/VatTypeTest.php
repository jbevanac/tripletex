<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Helpers\VatTypeNorway;
use Tripletex\Model\VatType;
use Tripletex\Tests\TestCase;

class VatTypeTest extends TestCase
{
    public function test_find_by_number_returns_vat_type(): void
    {
        $this->skipIfNoCredentials();

        $vatType = $this->sdkFromEnv()->vatTypes()->findByNumber('52');

        $this->assertInstanceOf(VatType::class, $vatType);
        $this->assertSame('52', $vatType->number);
        $this->assertEquals(0, $vatType->percentage);
    }

    public function test_find_by_number_returns_null_for_unknown_number(): void
    {
        $this->skipIfNoCredentials();

        $this->assertNull($this->sdkFromEnv()->vatTypes()->findByNumber('9999'));
    }

    public function test_helper_ids_match_tripletex(): void
    {
        $this->skipIfNoCredentials();

        $expectedNumbers = [
            'STANDARD' => '3',
            'REDUCED' => '31',
            'LOW' => '33',
            'EXPORT' => '52',
        ];

        $sdk = $this->sdkFromEnv();
        foreach (VatTypeNorway::cases() as $case) {
            $vatType = $sdk->vatTypes()->find($case->value);

            $this->assertSame($expectedNumbers[$case->name], $vatType->number, $case->name);
        }
    }
}
