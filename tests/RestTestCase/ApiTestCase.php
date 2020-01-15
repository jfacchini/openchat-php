<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCase extends WebTestCase
{
    const JSON_TYPE = 'application/json';

    private ?KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::$kernel->getContainer();

        $filePath = $container->getParameter('users_db_filepath');
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
    }


    public function given(): Given
    {
        return new Given($this->client);
    }

    public function when(): When
    {
        return new When($this->client, '');
    }
}

function is($expected): callable
{
    return function ($value) use ($expected) {
        if (is_object($value) || is_callable($value)) {
            Assert::assertEquals($expected, $value);
        } else {
            Assert::assertSame($expected, $value);
        }
    };
}

function uuid(): callable
{
    return function (string $uuid) {
        Assert::assertTrue(Uuid::isValid($uuid), "Expected a valid UUID. Got '$uuid'");
    };
}
