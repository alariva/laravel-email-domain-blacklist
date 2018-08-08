<?php

namespace Alariva\EmailDomainBlacklist\Tests;

use Alariva\EmailDomainBlacklist\Validator;
use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    public function setUp()
    {
        // ..
    }

    /** @test */
    public function test_assert()
    {
        $validator = new Validator();

        $rejected = $validator->validate('email', 'rejectme@example.com', []);

        $this->assertTrue($rejected);
    }
}
