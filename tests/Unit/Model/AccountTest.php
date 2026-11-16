<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Model\Account;
use Tripletex\Tests\TestCase;

class AccountTest extends TestCase
{
    public function test_make_maps_account_with_vat_type_id(): void
    {
        $account = Account::make([
            'id' => 11,
            'number' => 3000,
            'name' => 'Salgsinntekt, avgiftspliktig',
            'vatType' => 3,
            'vatLocked' => true,
        ]);

        $this->assertSame(3000, $account->number);
        $this->assertSame(3, $account->vatType->id);
        $this->assertTrue($account->vatLocked);
    }
}
