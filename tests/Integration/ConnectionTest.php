<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\LoggedInUserInfo;
use Tripletex\Tests\TestCase;

class ConnectionTest extends TestCase
{
    public function test_who_am_i_returns_logged_in_user_info(): void
    {
        $this->skipIfNoCredentials();

        $info = $this->sdkFromEnv()->whoAmI();

        $this->assertInstanceOf(LoggedInUserInfo::class, $info);
    }
}
