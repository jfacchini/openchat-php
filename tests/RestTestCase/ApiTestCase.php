<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCase extends WebTestCase
{
    const JSON_TYPE = 'application/json';

    public static function given(): Given
    {
        return new Given(static::createClient());
    }

    public static function is($expected): callable
    {
        return function ($value) use ($expected) {
            if (is_object($value) || is_callable($value)) {
                Assert::assertEquals($expected, $value);
            } else {
                Assert::assertSame($expected, $value);
            }
        };
    }

    public static function uuid(): callable
    {
        return function (string $uuid) {
            Assert::assertTrue(Uuid::isValid($uuid), "Expected a valid UUID. Got '$uuid'");
        };
    }
}
