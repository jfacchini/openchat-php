<?php

namespace App\Tests\RestClient;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCase extends WebTestCase
{
    const JSON_TYPE = 'application/json';

    public static function given(): Given
    {
        return new Given(static::createClient());
    }
}
