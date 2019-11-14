<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCase extends WebTestCase
{
    const JSON_TYPE = 'application/json';

    protected function setUp(): void
    {
        $container = static::bootKernel([])->getContainer();

        $filePath = $container->getParameter('users_db_filepath');
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public static function given(): Given
    {
        return new Given(static::createClient());
    }

    public static function when(): When
    {
        return new When(static::createClient(), '');
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

function given(): Given
{
    return ApiTestCase::given();
}

function when(): When
{
    return ApiTestCase::when();
}

function is($expected): callable
{
    return ApiTestCase::is($expected);
}

function uuid(): callable
{
    return ApiTestCase::uuid();
}
