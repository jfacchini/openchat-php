<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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

    public static function when(): When
    {
        return new When(static::createClient(), '');
    }

    protected function setUp()
    {
        $container = static::bootKernel([])->getContainer();

        $filePath = $container->getParameter('users_db_filepath');
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
